<?php
require_once utils_root.'utilsHelp.php';
require_once utils_root.'error_log.php';
require_once models_root.'catalogos/usuario.php';
require_once models_root.'catalogos/estatus.php';
require_once models_root.'catalogos/documento_norma.php';
require_once models_root.'sistemas/solicitud_servicio.php';
require_once models_root.'catalogos/equipo_computo.php';

class sistemasController {

    public function solicitudes() {
        Utils::noLoggin();
         $idEst = null;
         $solicitud = new SolicitudServicio();
          if(isset($_GET['idEst'])){
           $idEst = (int)$_GET['idEst'];
       }
       $solicitudes = $solicitud->getByEstatusId($idEst);
        require_once views_root . 'sistemas/lista_solicitudes_sistemas.php';
    }

    public function solicitudServicio() {
        Utils::noLoggin();
        $usuario = new Usuario();
        if (isset($_SESSION['usuario'])) {
            $user = $usuario->getById($_SESSION['usuario']->id);
        } else {
            header('Location:' . root_url . '?controller=Error&action=noLoggin');
        }
        $usuariosSistemas = $usuario->getUsuariosByDepartamento(1); // 1 Departamento Sistemas;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $solicitudServicio = new SolicitudServicio();
             $solicitud = $solicitudServicio->getSolicitudById($id);
        }
     
        require_once views_root . 'sistemas/solicitud_servicio.php';
    }
    
    public function generarSolicitudServicio(){
      if (isset($_POST['idUsuario'])) {
          $id = isset($_POST['id']) ? $_POST['id'] : null;  
          $usuarioId = $_POST['idUsuario'];
          $usuarioSistemasId = $_POST['usuarioSistemasId'];
          $idEquipo = $_POST['idEquipo'];
          $empresa = $_POST['empresa'];
          $tipoRequerimiento = $_POST['tipoRequerimiento'];
          $tipoSolicitud = $_POST['tipoSolicitud'];
          $prioridad = $_POST['prioridad'];
          $descripcion = $_POST['descripcion'];
          $observaciones = $_POST['observaciones'];
          $solucion = $_POST['solucion'];

            $solicitud = new SolicitudServicio();
            $solicitud->setEmpresa($empresa);
            $solicitud->setUsuarioId($usuarioId);
            $solicitud->setUsuarioSistemasId($usuarioSistemasId);
            $solicitud->setEquipoId($idEquipo != "" ? $idEquipo : "null");
            $solicitud->setTipoSolicitud($tipoSolicitud);
            $solicitud->setTipoRequerimiento($tipoRequerimiento);
            $solicitud->setPrioridad($prioridad);
            $solicitud->setDescripcion($descripcion);
            $solicitud->setObservaciones($observaciones);
            $solicitud->setSolucion($solucion);

            if ($id == null) {
                //estatus 1 
                $solicitud->setEstatusId(1);
                $emp = empresas[intval($empresa)];
                $ultimasolicitud = $solicitud->ultimaSolicitudByEmpresa($empresa);
                $folio = $ultimasolicitud->folio != null ? $ultimasolicitud->folio : $emp['folio'] . "-0";
                $ultimoFolio = substr($folio, strrpos($folio, "-", 1) + 1);
                $sigFolio = $emp['folio'] . '-SIS-' . ($ultimoFolio + 1);
                $solicitud->setFolio($sigFolio);
                $saveSolicitud = $solicitud->save();
                if($saveSolicitud){
                require_once utils_root . 'email/email.php';
                $mail = new Mail();
                $usuario = new Usuario();
                $userSistemas = $usuario->getById($usuarioSistemasId);           
                $mail->setCorreo1($userSistemas->correo);
                $mail->setNombre1($userSistemas->nombres. " " . $userSistemas->apellidos);
                $mail->setSubject("Solicitud de servicio ". $sigFolio);
                $mail->setBody("<p>Se genero la solicitud con el folio: ".$sigFolio."</p><p>Descripción: ".$solicitud->getDescripcion()."</p>");
                $send = Mail::enviarCorreoSolicitudSistemas($mail);
                echo $solicitud->getFolio();
                }
                
            } else {
                $solicitud->setId($id);
                $saveSol = $solicitud->edit();
                echo $saveSol;
            }
        }
    }
    
    public function iniciarSolicitudServicio(){
        if (isset($_POST['id'])) {
            $id = $_POST['id'];  
            $solicitud = new SolicitudServicio();
            $solicitud->setId($id);   
            $solicitud->setEstatusId(3); //estatus en proceso;   
            $save = $solicitud->iniciarSolicitud();
            echo $save; 
        }
    }
    
     public function eliminarSolicitudServicio(){
         if (isset($_POST['idSolicitud'])) {
            $id = $_POST['idSolicitud'];  
            $solicitud = new SolicitudServicio();
            $solicitud->setId($id);   
            $solicitud->setEstatusId(2); //estatus cancelada;   
            $save = $solicitud->deleteSolicitud();
            echo $save; 
        }
    }
    
         public function finalizarSolicitudServicio(){
         if (isset($_POST['idSolicitud'])) {
            $id = $_POST['idSolicitud'];
            $solucion = $_POST['solucionSolicitud'];
            $solicitud = new SolicitudServicio();
            $solicitud->setId($id);   
            $solicitud->setEstatusId(5); //estatus finalizada;  
            $solicitud->setSolucion($solucion);
            $save = $solicitud->finalizarSolicitud();
            if($save){
               $sol = $solicitud->getSolicitudById($id);  
               if($sol['equipo_id'] != null && ($sol['tipo_solicitud'] == 2 || $sol['tipo_solicitud'] == 1)){
               $equipo = new EquipoComputo();
               $equipo->setId($sol['equipo_id']);
               $save = $equipo->mantenimientoEquipo();
               }
               require_once utils_root . 'email/email.php';
                $mail = new Mail();
                $usuario = new Usuario();
                $user = $usuario->getById($sol['usuario_id']);           
                $mail->setCorreo1($user->correo);
                $mail->setNombre1($user->nombres. " " . $user->apellidos);
                $mail->setSubject("Solicitud de servicio ". $sol['folio']);
                $mail->setBody("<p>Se finalizo la solicitud con el folio: ".$sol['folio']."</p><p>Descripción: ".$sol['descripcion']."</p><p><b>Solución:</b> ".$sol['solucion']."</p>");
                $send = Mail::enviarCorreoSolicitudSistemas($mail);
            }         
                 print_r(json_encode($save));
        }
    }
    
        public function imprimirSolicitud(){
        if (isset($_GET['idSolicitud']) && $_GET['idSolicitud'] != "") {
            $id = $_GET['idSolicitud'];
           }
           if($id != null){
            require_once utils_root .'toPDF/pdf.php';
            $s = new SolicitudServicio();
            $solicitud = $s->getSolicitudById($id);
                      
              $documentoNorma = new DocumentoNorma();
              $doc = $documentoNorma->getByCodigo('FO-SI-001');
            
              PDF::crearPdfSolictudServicio($solicitud, $doc);
           }
    }
    
        public function mantenimientos() {
        Utils::noLoggin();
         $equipo = new EquipoComputo();
         $equiposMant = $equipo->getEquiposMantenimiento();
         $equipos = array();
         
         if(!empty($equiposMant)){
         $solicitud = new SolicitudServicio();
         
        foreach ($equiposMant as $e) {
             $s = $solicitud->getSolicitudByEquipoIdSolicitudActiva($e->id);                
              if(!empty($s)){
               $e->folio = $s[0]['folio'];
               $e->solicitud = true;
              }else{
              $e->solicitud = false;
              }
               array_push($equipos, $e);
         }
         }
        require_once views_root . 'sistemas/lista_mantenimiento_equipo.php';
    }
    
    public function generarSolicitudServicioByEquipo(){
         if (isset($_POST['idEquipo'])){         
          $idEquipo = $_POST['idEquipo']; 
          $equipo = new EquipoComputo();
          $e = $equipo->getEquipoById($idEquipo)[0];
            $solicitud = new SolicitudServicio();
            $solicitud->setEmpresa(2); //Leader
            $solicitud->setUsuarioId($e->usuario_id != null ? $e->usuario_id : $_SESSION['usuario']->id );
            $solicitud->setUsuarioSistemasId($_SESSION['usuario']->id);
            $solicitud->setEquipoId($idEquipo);
            $solicitud->setTipoSolicitud(1); // preventivo;
            $solicitud->setTipoRequerimiento(2); //equipo_computo;
            $solicitud->setPrioridad(2);
            $fecha = $e->fecha_mantenimiento != null ? "Fecha ultimo mantenimiento: ". (date('d/m/Y', strtotime($e->fecha_mantenimiento))) : "";           
            $solicitud->setDescripcion("Equipo con más de 6 meses sin mantenimiento. ".$fecha);
            $solicitud->setEstatusId(1); 
            $emp = empresas[intval(2)];
            $ultimasolicitud = $solicitud->ultimaSolicitudByEmpresa(2);
            $folio = $ultimasolicitud->folio != null ? $ultimasolicitud->folio : $emp['folio'] . "-0";
            $ultimoFolio = substr($folio, strrpos($folio, "-", 1) + 1);
            $sigFolio = $emp['folio'] . '-SIS-' . ($ultimoFolio + 1);
            $solicitud->setFolio($sigFolio);
            $saveSolicitud = $solicitud->save();
                if($saveSolicitud){
                require_once utils_root . 'email/email.php';
                $mail = new Mail();
                $usuario = new Usuario();
                $userSistemas = $usuario->getById($_SESSION['usuario']->id);           
                $mail->setCorreo1($userSistemas->correo);
                $mail->setNombre1($userSistemas->nombres. " " . $userSistemas->apellidos);
                $mail->setSubject("Solicitud de servicio ". $sigFolio);
                $mail->setBody("<p>Se genero la solicitud con el folio: ".$sigFolio."</p><p>Descripción: ".$solicitud->getDescripcion()."</p>");
                $send = Mail::enviarCorreoSolicitudSistemas($mail);
                $msn = $sigFolio;
                }else{
                     $msn = false;  
                }
         }
                   print_r(json_encode($msn));
       }
       
       public function buscarSolicitudesServicio(){
            Utils::noLoggin();
             $solicitud= new SolicitudServicio();
            $folio = isset($_POST['folio']) && $_POST['folio'] != '' ? $_POST['folio'] : null;
            $fechaIni = isset($_POST['fechaInicio']) && $_POST['fechaInicio'] != '' ? $_POST['fechaInicio'] : null;
            $fechaFin = isset($_POST['fechaFin']) && $_POST['fechaFin'] != '' ? $_POST['fechaFin'] : null;
            $usuario = isset($_POST['usuario']) && $_POST['usuario'] != '' ? $_POST['usuario'] : null;
            $fechaInicio = null;
             $fechaFinal = null;
            if($fechaIni != null){
              $fechaInicio = date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($fechaIni)));
            }
            
             if($fechaFin != null){
              $fechaFinal = date('Y-m-d', strtotime(UtilsHelp::covertDatetoDateSql($fechaFin)));
            }
            $idEst = null;
      
        $solicitudes = $solicitud->getSolicitudesByFolioUsuarioFechas($folio, $usuario, $fechaInicio, $fechaFinal);

        require_once views_root.'sistemas/lista_solicitudes_sistemas.php';
      }
      
            public function indicadoresCalidadSolicitudes(){
             Utils::noLoggin();
             $pdf = $_POST['pdf'] == 1 ? true : false;      
             $fechaInicio = isset($_POST['fechaInicioExp']) && $_POST['fechaInicioExp'] != '' ? date('Y-m-d 00:00:00', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaInicioExp']))) : null;
             $fechaFinal = isset($_POST['fechaFinExp']) && $_POST['fechaFinExp'] != '' ? date('Y-m-d 23:59:59', strtotime(UtilsHelp::covertDatetoDateSql($_POST['fechaFinExp']))) : null;

              $solicitud = new SolicitudServicio();

              $solicitudes = $solicitud->getSolicitudesByFechaSolucionFinalizadas($fechaInicio, $fechaFinal);
              require_once utils_root . 'toExcel/excel.php';
              Excel::generarReporteIndicadorServicio($solicitudes, $pdf);
            
      }
      
  
}
