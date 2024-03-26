<?php
$_pattern = '/(.*[\/\x5C]src[\/\x5C]).*/';
$_root    = str_replace('\\', '/', preg_replace($_pattern, '$1', root));
$base     = substr($_root, 0, strpos($_root, 'GrupoLEA_QA')) . 'GrupoLEA_QA';
define('AMBIENTE', 'QA');
define('APP_NAME', 'GrupoLEA ERP');
define('base', $base);
define('root_url', 'http://192.168.0.32/GrupoLEA_QA/');
define('URL', 'http://192.168.0.32/GrupoLEA_QA/');
define('idioma', 'spanish');
define('BD_CAMIONERA', 'MToledoCam');
define('BD_FERRO', 'MToledo');
define('assets_root', base . '/assets/');
define('config_root', base . '/config/');
define('models_root', base . '/models/');
define('utils_root', base . '/utils/');
define('views_root', base . '/views/');
define('controller_root', base . '/controllers/');
define('controller_default_catalogos', 'CatalogoController');
define('action_default', 'index');
define('catalogosUrl', root_url . 'views/catalogos/');
define('comprasUrl', root_url . 'views/compras/');
// define('principalUrl', root_url . 'views/principal/');
define('principalUrl', root_url . 'views/master/');
define('loginUrl', root_url . 'views/views/login/');
define('controller_login', 'LoginController');
define('controller_principal', 'PrincipalController');

define('SALT', 'SALT');

ini_set('display_errors', 1);

define('GLM', array('id'                  => 1,                                  'clave'   => 'GLM',     'nombre' => 'GRUPO LEA DE MÉXICO S. DE R.L. DE C.V.',             'direccion' => 'CARRETERA  A  COLOMBIA KM.  30.2',
                    'estado'              => 'SALINAS VICTORIA,  N.L.  MEXICO',  'cp'      => '65500',   'rfc'    => 'GLM990803MX3',                                       'tel'       => '81587400', 'folio' => 'GLM'));
define('LEADER', array('id'               => 2,                                  'clave'   => 'LEADER',  'nombre' => 'LEADER DE LUBRICANTES DE MÉXICO S. DE R.L. DE C.V.', 'direccion' => 'CARRETERA  A  COLOMBIA KM.  30.2',
                       'estado'           => 'SALINAS VICTORIA,  N.L.  MEXICO',  'cp'      => '65500',   'rfc'    => 'LLM030923EJ0',                                       'tel'       => '81587400', 'folio' => 'LLM'));
define('SIVAD', array('id'                => 3,                                  'clave'   => 'SIVAD',   'nombre' => 'SIVAD COMBUSTIBLES DE MÉXICO S. DE R.L. DE C.V.',    'direccion' => 'CARRETERA  A  COLOMBIA KM.  30.2',
                      'estado'            => 'SALINAS VICTORIA,  N.L.  MEXICO',  'cp'      => '65500',   'rfc'    => 'SCM1605204G9',                                       'tel'       => '81587400', 'folio' => 'SCM'));
define('PESO', array('clave'              => 'MX',                               'nombre'  => 'Pesos',   'letra'  => 'MX.',                                                'nomMayus'  => 'PESOS'));
define('DOLLAR', array('clave'            => 'USD',                              'nombre'  => 'Dolares', 'letra'  => 'USD.',                                               'nomMayus'  => 'DOLARES'));
define('empresas', array(1                => GLM,                                2         => LEADER,    3        => SIVAD));
define('monedas', array(1                 => PESO,                               2         => DOLLAR));
define('compras_fletes', array('nombre'   => 'Sonia Arredondo',                  'correo'  => 'sarredondo@leademexico.com', 'telefono' => '8120360621'));
define('compras', array('nombre'          => 'Liliana Garza',                    'correo'  => 'lgarza@leademexico.com',     'telefono' => '8181587418'));
define('gerencia', array('nombre'         => 'Celestino Perez',                  'correo'  => 'cperez@leademexico.com'));
define('usuarios', array('compras_fletes' => compras_fletes,                     'compras' => compras,          'gerencia' => gerencia));
define('impuestos', array('iva'           => 0.16,                               'ret_iva' => 0.106666,         'isr_hon'  => 0.1, 'isr_trans' => 0.04));
define('tipoFlete', array(1               => 'Pre-pagado por LEA International', 2         => 'Pagado por GLM', 3          => 'Pagado por el Cliente'));
define('rfc_cuotaExenta', array('EIN971103LZ1'));
define('ubicaciones_kansas', array(1 => 'Laredo, Tx.', 11 => 'Matamoros', 2 => 'Sanchez', 3 => 'Monterrey', 4 => 'Escobedo', 5 => 'Leal', 6 => 'Salinas', 7 => 'Grupo LEA', 8 => 'Hermosillo', 9 => 'Mexicali', 10 => 'Liberado'));

// Sistemas
define('prioriodades', array(1          => 'Alta',         2 => 'Media',          3 => 'Baja'));
define('tipoSolicitud', array(1         => 'Preventivo',   2 => 'Correctivo',     3 => 'Configuración', 4 => 'Instalación', 5=> 'Desarrollo'));
define('requerimientos', array(1        => 'Aplicaciones', 2 => 'Equipo cómputo', 3 => 'Red' ,  4 => 'Programación'));
define('marcas_sistemas', array(1       => 'HP',           2 => 'Dell',           3 => 'Lenovo', 4 => 'ASUS',      5 => 'APPLE', 6 => 'Brother'));
define('equipos_sistemas', array(1      => 'Laptop',       2 => 'PC',             3 => 'Movil',  4 => 'Impresora', 5 => 'Servidor'));
define('aplicaciones_sistemas', array(1 => 'WIN PRO',      2 => 'Office 365',     3 => 'Antivirus'));

// Servicios
define('tipo_tarimas', array(1 => 'Tratada', 2 => 'Normal'));
                                    
//Laboratorio
define('unidades_medida', array(1 => '&deg;C', 2 => '%', 3 =>'&deg;API', 4 => 'cm/in', 5 =>'cm&#713;&#185;', 6 =>'Color ASTM',
        7 =>'ft/min', 8 =>'g', 9 =>'g/cm&sup3;', 10 =>'hPa/&deg;C/%HR', 11 =>'Kg', 12 =>'KV', 13 =>'L/min', 14 =>'mm&sup2;/s',
        15 =>'mN/m', 16 =>'&deg;C/%HR', 17 =>'p.p.m', 18 =>'s'));

define('estatus_equipos', array(1 => 'Activo', 2 =>'Inactivo', 3 => 'Baja'));        
