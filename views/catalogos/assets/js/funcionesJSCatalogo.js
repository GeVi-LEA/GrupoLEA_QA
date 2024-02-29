(function () {

    const btnClose = document.getElementById('i-close');
    const btnSave = document.getElementById('save');
    const catalogo = document.getElementById('valor') == undefined ? null : document.getElementById('valor').textContent;
    const form = document.getElementById('formulario' + catalogo);
    const tabla = document.getElementById('tabla' + catalogo);
    const error = document.getElementById('error');
    const buscador = document.querySelector('#buscador');
    if (form != null) {
        var nombre = form.nombre === undefined ? null : form.nombre,
            clave = form.clave === undefined ? null : form.clave,
            pais = form.pais === undefined ? null : form.pais,
            estado = form.estado === undefined ? null : form.estado,
            tipoCompra = form.tipoCompras === undefined ? null : form.tipoCompras,
            tipoServicio = form.tipoServicio === undefined ? null : form.tipoServicio,
            clasificacion = form.clasificacion === undefined ? null : form.clasificacion,
            contacto = form.contacto === undefined ? null : form.contacto,
            correo = form.correo === undefined ? null : form.correo,
            telefono = form.telefono === undefined ? null : form.telefono,
            celular = form.celular === undefined ? null : form.celular,
            ciudad = form.ciudad === undefined ? null : form.ciudad,
            direccion = form.direccion === undefined ? null : form.direccion,
            cuenta = form.cuenta === undefined ? null : form.cuenta,
            apellidos = form.apellido === undefined ? null : form.apellido,
            codigoPostal = form.codigoPostal === undefined ? null : form.codigoPostal,
            departamento = form.departamento === undefined ? null : form.departamento,
            tipoPermiso = form.tipoPermiso === undefined ? null : form.tipoPermiso,
            puesto = form.puesto === undefined ? null : form.puesto,
            extension = form.extension === undefined ? null : form.extension,
            usuario = form.user === undefined ? null : form.user,
            password = form.password === undefined ? null : form.password,
            revision = form.revision === undefined ? null : form.revision,
            responsable = form.usuario === undefined ? null : form.usuario,
            estatus = form.estatus === undefined ? null : form.estatus,
            proveedor = form.proveedor === undefined ? null : form.proveedor,
            ciudadDestino = form.ciudadDestino === undefined ? null : form.ciudadDestino,
            costo = form.costo === undefined ? null : form.costo,
            transporte = form.transporte === undefined ? null : form.transporte,
            refineria = form.refineria === undefined ? null : form.refineria,
            numero = form.numero === undefined ? null : form.numero,
            tipoEquipo = form.tipoEquipo === undefined ? null : form.tipoEquipo,
            serie = form.serie === undefined ? null : form.serie,
            modelo = form.modelo  === undefined ? null : form.modelo,
            marca = form.marca  === undefined ? null : form.marca;
            transportista = form.transportista  === undefined ? null : form.transportista;
    }

    function cerrarVentana(e) {
        e.preventDefault();
        window.close();
    }

    function enviar(e) {
        validarForm(e);
        validarExiste(e);
    }

    function editar(e) {
        e.preventDefault();
        var validar = validarForm(e);
        if (validar) {
            form.submit();
        }
    }

    function validarForm(e) {
        error.innerHTML = "";
        var validar = true;
        if(nombre != null){
        if (nombre.value === "" || nombre.value === null) {
            form.nombre.classList.add('required');
            error.style.display = 'block';
            error.innerHTML += '<li>Por favor, Ingrea el <b>nombre</b> de ' + catalogo.toLowerCase() + '</li>';
            e.preventDefault();
            validar = false;
        } else {
            error.style.display = 'none';
        }
    }
        if (clave != null) {
            if (clave.value === "" || clave.value === null) {
                form.clave.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, Ingrea la <b>clave</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }
        if (pais != null) {
            if (pais.value === "" || pais.value === null) {
                form.pais.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>país</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (estado != null) {
            if (estado.value === "" || estado.value === null) {
                form.estado.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>estado</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (ciudad != null) {
            if (ciudad.value === "" || ciudad.value === null) {
                form.ciudad.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona una <b>ciudad</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (tipoCompra != null) {
            if (tipoCompra.value === "" || tipoCompra.value === null) {
                form.tipoCompras.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>Tipo de compra</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (tipoPermiso != null) {
            if (tipoPermiso.value === "" || tipoPermiso.value === null) {
                form.tipoPermiso.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>Tipo de permiso</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (tipoServicio != null) {
            if (tipoServicio.value === "" || tipoServicio.value === null) {
                form.tipoServicio.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>Tipo de servicio</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (refineria != null) {
            if (refineria.value === "" || refineria.value === null) {
                form.refineria.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona una <b>Refinería</b></li>';
                e.preventDefault();
                validar = false;
            }
        }
        if (clasificacion != null) {
            if (clasificacion.value === "" || clasificacion.value === null) {
                form.clasificacion.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona una <b>Clasificación</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (estatus != null) {
            if (estatus.value === "" || estatus.value === null) {
                form.estatus.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona una <b>Estatus</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (responsable != null) {
            if (responsable.value === "" || responsable.value === null) {
                form.usuario.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>Responsable</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (contacto != null) {
            if (contacto.value === "" || contacto.value === null) {
                form.contacto.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa un <b>Contacto</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }
        if (numero != null) {
            if (numero.value === "" || numero.value === null) {
                form.numero.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa un <b>número de carro tanque</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

      if (transportista != null) {
            if (transportista.value === "" || transportista.value === null) {
                form.transportista.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa un <b>transportista</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (direccion != null) {
            if (direccion.value === "" || direccion.value === null) {
                form.direccion.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa la <b>dirección</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (cuenta != null) {
            if (cuenta.value === "" || cuenta.value === null) {
                form.cuenta.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa la <b>cuenta interna</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }
        if (apellidos != null) {
            if (apellidos.value === "" || apellidos.value === null) {
                form.apellido.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, Ingrea el <b>apellido</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (correo != null) {
            if (correo.value === "" || correo.value === null) {
                form.correo.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa un <b>correo</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            } else if (!correo.value.includes('@') || !correo.value.includes('.')) {
                form.correo.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa un <b>correo</b> valido, debe de incluir @ y dominio</li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (telefono != null) {
            if (telefono.value === "" || telefono.value === null) {
                form.telefono.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa un <b>teléfono</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            } else if (!Number.isInteger(Number(telefono.value)) || telefono.value.length < 10) {
                form.telefono.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa un <b>teléfono</b> valido. Minimo 10 digitos </li>';
                e.preventDefault();
                validar = false;
            }
        }
        if (extension != null) {
            if (extension.value != "") {
                if (!Number.isInteger(Number(extension.value)) || extension.value.length < 4) {
                    form.extension.classList.add('required');
                    error.style.display = 'block';
                    error.innerHTML += '<li>Por favor, ingresa un <b>celular</b> valido. Minimo 4 digitos </li>';
                    e.preventDefault();
                    validar = false;
                }
            }
        }

        if (celular != null) {
            if (celular.value != "") {
                if (!Number.isInteger(Number(celular.value)) || celular.value.length < 10) {
                    form.celular.classList.add('required');
                    error.style.display = 'block';
                    error.innerHTML += '<li>Por favor, ingresa un <b>celular</b> valido. Minimo 10 digitos </li>';
                    e.preventDefault();
                    validar = false;
                }
            }
        }
        if (codigoPostal != null) {
            if (codigoPostal.value != "") {
                if (!Number.isInteger(Number(codigoPostal.value)) || codigoPostal.value.length < 5) {
                    form.codigoPostal.classList.add('required');
                    error.style.display = 'block';
                    error.innerHTML += '<li>El <b>codigo postal</b> debe de ser numerico. Minimo 5 digitos </li>';
                    e.preventDefault();
                    validar = false;
                }
            }
        }

        if (costo != null) {
            if (costo.value != "") {
                    if (isNumeric(costo.value)) {
                        costo.classList.add('required');
                        error.style.display = 'block';
                        error.innerHTML += '<li>El <b>precio</b> debe de ser numerico. </li>';
                        e.preventDefault();
                        validar = false;
                }
            }
        }

        if (revision != null) {
            if (revision.value != "") {
                if (!Number.isInteger(Number(revision.value))) {
                    form.revision.classList.add('required');
                    error.style.display = 'block';
                    error.innerHTML += '<li>La <b>revisión</b> debe de ser numerico.  </li>';
                    e.preventDefault();
                    validar = false;
                }
            }
        }

        if (departamento != null) {
            if (departamento.value === "" || departamento.value === null) {
                form.departamento.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>Departamento</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (transporte != null) {
            if (transporte.value === "" || transporte.value === null) {
                form.transporte.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>transporte</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (proveedor != null) {
            if (proveedor.value === "" || proveedor.value === null) {
                form.proveedor.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>proveedor</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (ciudad != null && ciudadDestino != null) {
            if (ciudad.value === "" || ciudad.value === null || ciudadDestino.value === "" || ciudadDestino.value === null) {
                form.ciudad.classList.add('required');
                form.ciudadDestino.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona las <b>ciudades</b></li>';
                e.preventDefault();
                validar = false;
            }
        }
        if (puesto != null) {
            if (puesto.value === "" || puesto.value === null) {
                form.puesto.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, ingresa la <b>extensión</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }
        if (usuario != null) {
            if (usuario.value === "" || usuario.value === null) {
                form.user.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, registra un <b>Usuario</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }
        if (password != null) {
            if (password.value === "" || password.value === null) {
                form.password.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, registra una <b>contraseña</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }
        if (serie != null) {
            if (serie.value === "" || serie.value === null) {
                form.serie.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, registra el <b>Número de serie</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (tipoEquipo != null) {
            if (tipoEquipo.value === "" || tipoEquipo.value === null) {
                form.tipoEquipo.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, selecciona un <b>Tipo de equipo</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (modelo != null) {
            if (modelo.value === "" || modelo.value === null) {
                form.modelo.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, registra el <b>Modelo</b> de ' + catalogo.toLowerCase() + '</li>';
                e.preventDefault();
                validar = false;
            }
        }

        if (marca != null) {
            if (marca.value === "" || marca.value === null) {
                form.marca.classList.add('required');
                error.style.display = 'block';
                error.innerHTML += '<li>Por favor, seleccionala la <b>Marca</b></li>';
                e.preventDefault();
                validar = false;
            }
        }

        return validar;
    }

    function validarExiste(e) {
        if (tabla != null) {
            if (nombre != null) {
            var nom = nombre.value.toLowerCase().trim();
            var itms = document.querySelectorAll('#nombreTabla');
            itms.forEach(function (it) {
                var dato = it.textContent.toLowerCase().trim();
                if (dato === nom) {
                    error.style.display = 'block';
                    form.nombre.classList.add('required');
                    error.innerHTML += '<li>El <b>nombre</b> de ' + catalogo.toLowerCase() + ' ya existe</li>';
                    e.preventDefault();
                }
            });
        }
        if (clave != null) {
            var cla = clave.value.toLowerCase().trim();
            var itms = document.querySelectorAll('#claveTabla');
            itms.forEach(function (it) {
                var dato = it.textContent.toLowerCase().trim();
                if (dato === cla) {
                    error.style.display = 'block';
                    form.clave.classList.add('required');
                    error.innerHTML += '<li>La <b>clave</b> de ' + catalogo.toLowerCase() + ' ya existe</li>';
                    e.preventDefault();
                }
            });
        }

        if (correo != null) {
            var mail = correo.value.toLowerCase().trim();
            var itms = document.querySelectorAll('#correoTabla');
            itms.forEach(function (it) {
                var dato = it.textContent.toLowerCase().trim();
                if (dato === mail) {
                    error.style.display = 'block';
                    form.correo.classList.add('required');
                    error.innerHTML += '<li>El <b>Correo</b> de ' + catalogo.toLowerCase() + ' ya existe</li>';
                    e.preventDefault();
                }
            });
        }
        if (cuenta != null) {
            var c = cuenta.value.toLowerCase().trim();
            var itms = document.querySelectorAll('#cuentaTabla');
            itms.forEach(function (it) {
                var dato = it.textContent.toLowerCase().trim();
                if (dato === c) {
                    error.style.display = 'block';
                    form.cuenta.classList.add('required');
                    error.innerHTML += '<li>La <b>cuenta</b> de ' + catalogo.toLowerCase() + ' ya existe</li>';
                    e.preventDefault();
                }
            });
        }
        if (usuario != null) {
            var u = usuario.value.toLowerCase().trim();
            var itms = document.querySelectorAll('#userTabla');
            itms.forEach(function (it) {
                var dato = it.textContent.toLowerCase().trim();
                if (dato === u) {
                    error.style.display = 'block';
                    form.usuario.classList.add('required');
                    error.innerHTML += '<li>El <b>usuario</b> de ' + catalogo.toLowerCase() + ' ya existe</li>';
                    e.preventDefault();
                }
            });
        }
        if (numero != null) {
            var u = numero.value.toLowerCase().trim();
            var itms = document.querySelectorAll('#numeroTabla');
            itms.forEach(function (it) {
                var dato = it.textContent.toLowerCase().trim();
                if (dato === u) {
                    error.style.display = 'block';
                    form.usuario.classList.add('required');
                    error.innerHTML += '<li>El <b>usuario</b> de ' + catalogo.toLowerCase() + ' ya existe</li>';
                    e.preventDefault();
                }
            });
        }
    }
}

buscador == null ? null : buscador.addEventListener('input', buscarDatos);
btnClose == null ? null : btnClose.addEventListener('click', cerrarVentana);
btnSave == null ? null : btnSave.addEventListener('click', editar);
form == null ? null : form.addEventListener('submit', enviar);
}())

function cambiarInputFile(id, span) {
    var pdrs = document.getElementById(id).files[0].name;
    document.getElementById(span).innerHTML = pdrs;
}

function buscarDatos(e){
         const dato = new RegExp(e.target.value.toLowerCase()),
          registros = document.querySelectorAll('tbody .tr ');
          registros.forEach(registro => {
            registro.style.display = 'none';
              if(registro.childNodes[3].textContent.toLowerCase().replace(/\s/g, " ").search(dato) != -1){
               registro.style.display = 'table-row';
              }

          })

}

function isNumeric(value) {
    const regex = /,/g;
    var num = value.replace(regex, "");
    var valid = isNaN(Number(num));
    return valid;
}

