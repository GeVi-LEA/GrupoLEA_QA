$(document).ready(function () {
	$("#secForm").hide();
	$("#save").hide();
	$("tr").filter("#tbDatos").hide();

	var undefined = "undefined";
	var catalogo = $("#valor").text();
	var tabla = $("#tabla" + catalogo);

	$("#mostrarForm").on("click", function () {
		$("#secForm").fadeIn(2000);
		$(this).hide(1000);
	});

	$("input").on("click", function () {
		$(this).removeClass("required");
	});

	$("select").on("click", function () {
		$(this).removeClass("required");
	});

	//Unidad de medida catalogo laboratorio

	$("#unidadMedida").change(function () {
		var unidad = $("#unidadMedida option:selected").text();
		$("form").find(".unidadMed").text(unidad);
	});

	//Función boton editar con mas de una fila
	tabla.on("click", "#edit", function () {
		var trSelect = $(this).parent().closest("tr");
		var trDatos = trSelect.next("tr");
		if (trDatos.prop("id") != "tbDatos") {
			trDatos = trSelect;
		}
		tabla.find("tr").removeClass("selected");
		$("input, select").removeClass("required");
		$("#secForm").fadeIn(1000);
		$("#id").val(trDatos.find("#idTabla").html());
		$("#nombre") == undefined ? null : $("#nombre").val(trDatos.find("#nombreTabla").html());
		$("#producto") == undefined ? null : $("#producto").val(trDatos.find("#nombreTabla").html());
		$("#clave") == undefined ? null : $("#clave").val(trDatos.find("#claveTabla").html());
		$("#peso_sugerido") == undefined ? null : $("#peso_sugerido").val(trDatos.find("#pesosugeridoTabla").html());

		/**	$("#cap_maxima") == undefined
			? null
			: $("#cap_maxima").val(
					trDatos
						.find("#cap_maximaTabla")
						.html()
						.replace(",", "")
						.replace(" KGs/LTs", "")
			  );   */
		$("#descripcion") == undefined ? null : $("#descripcion").val(trDatos.find("#descripcionTabla").html());
		$("#pais") == undefined ? null : $("#pais").val(trDatos.find("#paisIdTabla").html());
		$("#estado") == undefined ? null : $("#estado").val(trDatos.find("#estadoIdTabla").html());
		$("#tipoCompras") == undefined ? null : $("#tipoCompras").val(trDatos.find("#tipoCompraIdTabla").html());
		$("#tipoServicio") == undefined ? null : $("#tipoServicio").val(trDatos.find("#tipoServicioIdTabla").html());
		$("#clasificacion") == undefined ? null : $("#clasificacion").val(trDatos.find("#clasificacionTabla").html());
		$("#contacto") == undefined ? null : $("#contacto").val(trDatos.find("#contactoTabla").html());
		$("#correo") == undefined ? null : $("#correo").val(trDatos.find("#correoTabla").html());
		$("#correo1") == undefined ? null : $("#correo1").val(trDatos.find("#correo1Tabla").html());
		$("#correo2") == undefined ? null : $("#correo2").val(trDatos.find("#correo2Tabla").html());
		$("#correo3") == undefined ? null : $("#correo3").val(trDatos.find("#correo3Tabla").html());
		$("#telefono") == undefined ? null : $("#telefono").val(trDatos.find("#telefonoTabla").html());
		$("#celular") == undefined ? null : $("#celular").val(trDatos.find("#celularTabla").html());
		$("#direccion") == undefined ? null : $("#direccion").val(trDatos.find("#direccionTabla").html());
		$("#ciudad") == undefined ? null : $("#ciudad").val(trDatos.find("#ciudadIdTabla").html());
		$("#codigoPostal") == undefined ? null : $("#codigoPostal").val(trDatos.find("#codPostalTabla").html());
		$("#rfc") == undefined ? null : $("#rfc").val(trDatos.find("#rfcTabla").html());
		$("#cuenta") == undefined ? null : $("#cuenta").val(trDatos.find("#cuentaTabla").html());
		$("#certificado") == undefined ? null : $("#certificado").val(trDatos.find("#certificacionTabla").html());
		$("#fechaAlta") == undefined ? null : $("#fechaAlta").val(trDatos.find("#fechaAltaTabla").html());
		$("#fechaLiberacion") == undefined ? null : $("#fechaLiberacion").val(trDatos.find("#fechaLibTabla").html());
		$("#fechaEvaluacion") == undefined ? null : $("#fechaEvaluacion").val(trDatos.find("#fechaEvaluacionTabla").html());
		$("#fechaProximaEvaluacion") == undefined ? null : $("#fechaProximaEvaluacion").val(trDatos.find("#fechaProxEvaTabla").html());
		$("#fechaVigencia") == undefined ? null : $("#fechaVigencia").val(trDatos.find("#fechaVigenciaTabla").html());
		$("#calificacion") == undefined ? null : $("#calificacion").val(trDatos.find("#calificacionTabla").html());
		$("#activo") == undefined ? null : $("#activo").val(trDatos.find("#activoTabla").html());
		$("#bascula") == undefined ? null : $("#bascula").val(trDatos.find("#basculaTabla").html());
		$("#puertas") == undefined ? null : $("#puertas").val(trDatos.find("#puertasTabla").html());
		$("#apellido") == undefined ? null : $("#apellido").val(trDatos.find("#apellidoTabla").html());
		$("#departamento") == undefined ? null : $("#departamento").val(trDatos.find("#departamentoIdTabla").html());
		$("#tipoPermiso") == undefined ? null : $("#tipoPermiso").val(trDatos.find("#permisoIdTabla").html());
		$("#puesto") == undefined ? null : $("#puesto").val(trDatos.find("#puestoTabla").html());
		$("#extension") == undefined ? null : $("#extension").val(trDatos.find("#extensionTabla").html());
		$("#user") == undefined ? null : $("#user").val(trDatos.find("#userTabla").html());
		$("#password") == undefined ? null : $("#password").val(trDatos.find("#passwordTabla").html()).attr("readOnly", "true");
		$("#revision") == undefined ? null : $("#revision").val(trDatos.find("#revisionTabla").html());
		$("#estatus") == undefined ? null : $("#estatus").val(trDatos.find("#estatusIdTabla").html());
		$("#numero") == undefined ? null : $("#numero").val(trDatos.find("#numeroTabla").html());
		$("#moneda") == undefined ? null : $("#moneda").val(trDatos.find("#monedaTabla").val());
		$("#usuario") == undefined ? null : $("#usuario").val(trDatos.find("#usuarioIdTabla").html());
		$("#costo") == undefined ? null : $("#costo").val(trDatos.find("#costoTabla").html());
		$("#ciudadDestino") == undefined ? null : $("#ciudadDestino").val(trDatos.find("#ciudadDesIdTabla").html());
		$("#transporte") == undefined ? null : $("#transporte").val(trDatos.find("#tipoTransIdTabla").html());
		$("#proveedor") == undefined ? null : $("#proveedor").val(trDatos.find("#proveedorIdTabla").html());
		$("#refineria") == undefined ? null : $("#refineria").val(trDatos.find("#refineriaIdTabla").html());
		$("#marca") == undefined ? null : $("#marca").val(trDatos.find("#marcaTabla").html());
		$("#tipoEquipo") == undefined ? null : $("#tipoEquipo").val(trDatos.find("#tipoEquipoTabla").html());
		$("#modelo") == undefined ? null : $("#modelo").val(trDatos.find("#modeloTabla").html());
		$("#serie") == undefined ? null : $("#serie").val(trDatos.find("#serieTabla").html());
		$("#procesador") == undefined ? null : $("#procesador").val(trDatos.find("#procesadorTabla").html());
		$("#ram") == undefined ? null : $("#ram").val(trDatos.find("#ramTabla").html());
		$("#discoDuro") == undefined ? null : $("#discoDuro").val(trDatos.find("#discoDuroTabla").html());
		$("#departamentoUser") == undefined ? null : $("#departamentoUser").val(trDatos.find("#departamentoUserTabla").html());
		$("#factura") == undefined ? null : $("#factura").val(trDatos.find("#facturaTabla").html());
		$("#licencia") == undefined ? null : $("#licencia").val(trDatos.find("#licenciaTabla").html());
		$("#ine") == undefined ? null : $("#ine").val(trDatos.find("#ineTabla").html());
		$("#transportista") == undefined ? null : $("#transportista").val(trDatos.find("#idTransportistaTabla").html());
		$("#macEthernet") == undefined ? null : $("#macEthernet").val(trDatos.find("#macEthernetTabla").html());
		$("#macWifi") == undefined ? null : $("#macWifi").val(trDatos.find("#macWifiTabla").html());
		$("#observaciones") == undefined ? null : $("#observaciones").val(trDatos.find("#observacionesTabla").html());
		$("#fechaMantTabla") == undefined ? null : $("#fechaMantenimiento").val(trDatos.find("#fechaMantTabla").html());
		$("#usuarioId") == undefined ? null : $("#usuarioId").val(trDatos.find("#usuarioIdTabla").html());
		$("#objDoc") == undefined ? null : $("#objDoc").attr("data", trDatos.find("#documentoTabla").attr("data"));
		$("#tipoProducto") == undefined ? null : $("#tipoProducto").val(trDatos.find("#tipoProductoTabla").html());

		$("#spanDocumento") == undefined ? null : $("#spanDocumento").html(trDatos.find("#nombreDocumentoTabla").html());
		var permisos = $("#permisos") == undefined ? null : $("#permisos").find("input");
		if (permisos != null) {
			$(permisos).attr("checked", false);
			var permisosUser = trDatos.find("#permisosTabla").text();
			if (permisosUser != "" && permisosUser.length > 2) {
				var permisosJson = JSON.parse(permisosUser);
				for (var i = 0; i < permisos.length; i++) {
					for (var j = 0; j < permisosJson.length; j++) {
						if ($(permisos[i]).val() == permisosJson[j]) {
							$(permisos[i]).attr("checked", true);
						}
					}
				}
			}
		}

		if ($("#imgThumb") != undefined) {
			var img = trDatos.find("#imagenTabla");
			if (img.length === 0) {
				$("#deleteImagen").hide();
				var src = trDatos.find("#imagenTablaDef").attr("src");
				$("#imgThumb").attr("src", src);
				$("#subirImagen").show(1000);
				$("#spanImg").html("");
			} else {
				var src = trDatos.find("#imagenTabla").attr("src");
				$("#imgThumb").attr("src", src);
				$("#deleteImagen").show();
				$("#subirImagen").hide(1000);
				$("#spanImg").html("");
				$("#deleteImagen").attr("hidden", false);
			}
		}
		if ($("#imgFirmaThumb") != undefined) {
			var img = trDatos.find("#imgFirmaTabla");
			if (img.length === 0) {
				$("#subirFirma").show(1000);
				$("#deleteFirma").attr("hidden", true);
				$("#imgFirmaThumb").attr("hidden", true);
				$("#spanImgFirma").html("");
			} else {
				var src = trDatos.find("#imgFirmaTabla").attr("src");
				$("#imgFirmaThumb").attr("src", src);
				$("#deleteFirma").attr("hidden", false);
				$("#imgFirmaThumb").attr("hidden", false);
				$("#subirFirma").hide(1000);
				$("#spanImgFirma").html("");
			}
		}
		$("#btnAgregar").hide();
		$("#mostrarForm").hide(1000);
		$("#save").show(1000);
		$("#cancel").show(1000);
		$("#error").hide(500);
		trSelect.toggleClass("selected");
	});

	//Función boton cancelar
	$("#cancel").on("click", function () {
		$("#secForm").hide(1000);
		$('input[type="hidden"]').val("");
		$('input[type="text"], select').val("");
		$('input[type="file"]').val("");
		$('input[type="password"]').val("").removeAttr("readOnly");
		$("textarea").val("");
		$("#imgThumb").attr("src", "../../assets/img/user.jpg");
		$("#imgFirmaThumb").attr("src", "");
		$("#spanImg, #spanImgFirma, #spanDocumento").text("");
		$("#btnAgregar").show(1000);
		$("#mostrarForm").show(500);
		$("#objDoc").attr("data", "");
		$("#save").hide(200);
		$("input, select").removeClass("required");
		$("tr").removeClass("selected");
		$("#error").hide();
	});

	//Función boton show
	tabla.on("click", "#show", function () {
		var trDatos = $(this).parent().parent().next("tr");
		tabla.find("thead").hide();
		trDatos.prevAll("tr").hide();
		trDatos.nextAll("tr").hide();
		trDatos.show(1000);
	});

	//Función boton clear
	tabla.on("click", "#clear", function () {
		var trDatos = $(this).parent().closest("tr");
		tabla.find("thead").show();
		tabla.find("tr").show();
		trDatos.prevAll("tr").filter("#tbDatos").hide();
		trDatos.nextAll("tr").filter("#tbDatos").hide();
		trDatos.toggle();
	});

	//Función boton evaluar proveedor
	tabla.on("click", "#evaluarProveedor", function () {
		var trDatos = $(this).parent().parent().closest("tr").next();
		var idProveedor = trDatos.find("#idTabla").html();
		var nombreProveedor = trDatos.find("#nombreTabla").html();
		$("#idProveedorModal").val(idProveedor);
		$("#proveedorModal").val(nombreProveedor);
		$("#evaluarProveedorModal").modal("show");
	});

	function validarModalProveedor() {
		var inputs = $("#evaluarProveedorModal").find("input");
		var valid = true;
		inputs.each(function () {
			if ($(this).val() == null || $(this).val() == "") {
				$(this).addClass("required");
				valid = false;
			}
		});
		return valid;
	}

	$("#evaluarProveedorModal").on("hidden.bs.modal", function () {
		$("#formEvaluarProveedor").trigger("reset");
	});

	//Funcion boton save
	$("#save").on("click", function () {
		$("#error").show();
	});

	$("#fechaAlta, #fechaLiberacion, #fechaEvaluacion,  #fechaInicioEvaluacion,  #fechaFinEvaluacion,  #fechaVigencia").datepicker({
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		buttonText: "<span class='fas fa-calendar-alt i-calendar'></span>",
	});

	//Funcion boton delete
	tabla.on("click", "#delete", function (e) {
		var seleccionado = $(this).parent().find("a");
		$.confirm({
			title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
			content: "¿Seguro desea eliminar?",
			type: "red",
			typeAnimated: true,
			animation: "zoom",
			closeAnimation: "right",
			backgroundDismiss: false,
			backgroundDismissAnimation: "shake",
			buttons: {
				tryAgain: {
					text: "Eliminar",
					btnClass: "btn-red",
					action: function () {
						seleccionado.click(function () {
							location.href = this.href;
						});
						seleccionado.click();
					},
				},
				Cancelar: function () {},
			},
		});
	});

	//Función boton guardar up/down
	$("#i-slideUp").on("click", function () {
		$("#secDoc").slideUp(1000, function () {
			$("#i-slideUp").hide();
		});
	});

	$("#showDoc").click(function () {
		if ($("#objDoc").attr("data")) {
			$("#i-slideUp").show(100, function () {
				$("#secDoc").slideDown(1000);
			});
		} else {
			mensajeError("NO tiene documento");
		}
	});

	$("#activo").blur(function () {
		if ($(this).val() == "N") {
			mensajeError("Valor activo <b>NO</b>, se dara de baja el " + catalogo);
			$(this).addClass("required");
		}
	});

	$("#password").click(function () {
		if ($(this).attr("readOnly")) {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content: "¿Desea cambiar la contraseña?",
				type: "orange",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Cambiar",
						btnClass: "btn btn-warning",
						action: function () {
							$("#password").val("").removeAttr("readOnly").addClass("required");
							$("#cambioPass").val("S");
						},
					},
					Cancelar: function () {},
				},
			});
		}
	});

	//Validar input imagenes
	$("#imagen ,#firma").change(function () {
		var input = $(this);
		var tipoArchivo = $(this).prop("files")[0].name.toLowerCase();
		if (tipoArchivo.includes(".jpg") || tipoArchivo.includes(".png") || tipoArchivo.includes(".gif") || tipoArchivo.includes(".jpeg")) {
			mensajeCorrecto("Imagen agregada");
		} else {
			$.confirm({
				title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
				content: "Formato de imagen Incorrecto <br/>Archivo: <strong>" + tipoArchivo + "</strong> <br/> Formatos aceptados: <strong>.jpg, .gif, .png, .jpeg. </strong>",
				type: "red",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Entendido",
						btnClass: "btn-red",
						action: function () {
							input.val("");
							input.next("span").html("");
						},
					},
				},
			});
		}
	});

	//Validar input archivos
	$("#documento").change(function () {
		var input = $(this);
		var span = input.parent().next("div").find("span");
		var tipoArchivo = $(this).prop("files")[0].name;
		if (tipoArchivo.toLowerCase().includes(".pdf")) {
			mensajeCorrecto("Archivo agregado");
		} else {
			$.confirm({
				title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
				content: "Formato invalido de Documento <br/>Archivo: <strong>" + tipoArchivo + "</strong> <br/> Formatos aceptados: <strong>.pdf. </strong>",
				type: "red",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Entendido",
						btnClass: "btn-red",
						action: function () {
							input.val("");
							span.html("");
						},
					},
				},
			});
		}
	});

	//eliminar imagen
	$("#deleteImagen").on("click", function () {
		if ($("#id").val() != "") {
			$.confirm({
				title: "¡Atención!",
				content: "Se eliminara la imagen del usuario",
				type: "orange",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
						btnClass: "btn btn-warning",
						action: function () {
							var id = $("#id").val();
							$.ajax({
								data: { idUser: id },
								url: "?ajax&controller=Catalogo&action=eliminarImagenUsuario",
								type: "POST",
								success: function (r) {
									mensajeCorrecto(r);
									$("#subirImagen").show(1000);
									$("#imgThumb").hide(500);
									$("#deleteImagen").hide(500);
								},
								error: function () {
									alert("Algo salio mal, contacte al administrador del sistema");
								},
							});
						},
					},
					Cancelar: function () {},
				},
			});
		}
	});

	//eliminar firma
	$("#deleteFirma").on("click", function () {
		if ($("#id").val() != "") {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content: "Se eliminara la firma del usuario",
				type: "orange",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Entendido",
						btnClass: "btn btn-warning",
						action: function () {
							var id = $("#id").val();
							$.ajax({
								data: { idUser: id },
								url: "?ajax&controller=Catalogo&action=eliminarFirmaUsuario",
								type: "POST",
								success: function (r) {
									mensajeCorrecto(r);
									$("#subirFirma").show(1000);
									$("#imgFirmaThumb").hide(1000);
									$("#deleteFirma").hide(500);
								},
								error: function () {
									alert("Algo salio mal, contacte al administrador del sistema");
								},
							});
						},
					},
					Cancelar: function () {},
				},
			});
		}
	});

	$("#exportarInventarioExcel").click(function () {
		$("#formato").val(0);
		$("#formExportarInventario").submit();
	});

	$("#usuarioId").change(function () {
		var usuarioId = $(this).val();
		if (usuarioId != "") {
			$.ajax({
				data: { id: usuarioId },
				url: "?ajax&controller=Catalogo&action=getUsuarioById",
				type: "POST",
				dataType: "json",
				success: function (r) {
					$("#departamentoUser").val(r.departamento);
				},
				error: function () {
					alert("Algo salio mal al buscar al usuario, contacte al administrador del sistema");
				},
			});
		} else {
			$("#departamentoUser").val("");
		}
	});

	function mensajeCorrecto(result) {
		$.confirm({
			title: "<span class='material-icons i-correcto'>check_circle_outline</span><span>¡Correcto!<span>",
			content: result,
			type: "green",
			typeAnimated: true,
			draggable: true,
			buttons: {
				tryAgain: {
					text: "Ok",
					btnClass: "btn-success",
					action: function () {},
				},
			},
		});
	}

	function mensajeError(result) {
		$.confirm({
			title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
			content: result,
			type: "red",
			typeAnimated: true,
			animation: "zoom",
			closeAnimation: "right",
			backgroundDismiss: false,
			backgroundDismissAnimation: "shake",
			buttons: {
				tryAgain: {
					text: "Entendido",
					btnClass: "btn-red",
					action: function () {},
				},
			},
		});
	}

	$.datepicker.regional["es"] = {
		closeText: "Cerrar",
		prevText: "< Ant",
		nextText: "Sig >",
		currentText: "Hoy",
		monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
		monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
		dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
		dayNamesShort: ["Dom", "Lun", "Mar", "Mié", "Juv", "Vie", "Sáb"],
		dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
		weekHeader: "Sm",
		dateFormat: "dd/mm/yy",
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: "",
	};
	$.datepicker.setDefaults($.datepicker.regional["es"]);
});
