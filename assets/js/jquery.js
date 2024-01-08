$(document).ready(function () {
	if (typeof __url__ !== "undefined" && __url__) {
		// vriable is set and isnt falsish so it can be used;
	} else {
		__url__ = localStorage.getItem("_URL_");
	}
	const serv = __url__;

	// if (typeof Scrollbar !== typeof null) {
	// if (document.querySelectorAll(".data-scrollbar").length) {
	// Scrollbar = window.Scrollbar;
	// Scrollbar.init(document.querySelector(".data-scrollbar"), {
	// continuousScrolling: false,
	// });
	// }
	// }

	if ($("#id").val() != "") {
		$("#proveedor").prop("disabled", false);
		if ($("#numDetalles").val() > 0) {
			$("#divEspecificacion").hide();
			$("#i-slideUp").toggleClass("rotar");
		}
		$("#spanDocumento").html() == "" ? $("#deleteCotizacion").hide() : "";
	} else {
		$("#proveedor").prop("disabled", true);
		$("#n").prop("checked", true);
		$("#deleteCotizacion").hide();
	}
	$("#imprimirReq, #enviarReq").hide();
	$("#imprimirOrden, #enviarOrden").hide();

	$(".tr").on("click", function () {
		$("#tablaRegistros").find("tr").removeClass("selected");
		$(this).addClass("selected");
		var estatus = $(this).find("#estatus").text();
		if (estatus == "Generada" || estatus == "Cancelada") {
			$("#imprimirReq, #enviarReq").hide(500);
			$("#imprimirOrden, #enviarOrden").hide(500);
		} else {
			$("#imprimirReq, #enviarReq").show(500);
			$("#imprimirOrden, #enviarOrden").show(500);
		}
		if (estatus == "Aceptada") {
			$("#generarOrden").removeAttr("hidden", false);
		} else {
			$("#generarOrden").attr("hidden", true);
		}
	});

	//Generar Orden de compra
	$("#generarOrden").click(function (e) {
		var id = $(".selected").find("#idTabla").html();
		var solicitud = $(".selected").find("#compra").html();
		var proveedor = $(".selected")
			.find("#proveedorTabla")
			.html()
			.toLowerCase();
		var iva = 0;
		if (solicitud === "Producto") {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content: "¿Agregar <strong>IVA</strong> a la orden de compra?",
				type: "orange",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Sí",
						btnClass: "btn btn-warning",
						action: function () {
							generarOrdenCompra(1, id);
						},
					},
					No: function () {
						generarOrdenCompra(iva, id);
					},
				},
			});
		} else {
			if (proveedor.includes("kansas city")) {
				generarOrdenCompra(iva, id);
			} else {
				generarOrdenCompra(1, id);
			}
		}
	});

	function generarOrdenCompra(iva, id) {
		var datosForm = new FormData();
		datosForm.append("iva", iva);
		datosForm.append("idReq", id);

		$.ajax({
			data: datosForm,
			enctype: "multipart/form-data",
			processData: false,
			contentType: false,
			url: "?ajax&controller=Compras&action=generarOrdenCompra",
			type: "POST",
			dataType: "json",
			success: function (r) {
				mensajeCorrecto("Se genero orden de compra", true);
			},
			error: function () {
				mensajeError("Algo salio mal, no se genero orden de compra.");
			},
		});
	}

	//Transito
	$("#tablaRegistros").on("change", "#ubicacion", function () {
		var tr = $(this).closest("tr");
		var ubicacion = $(this).val();
		var dias = $(tr).find("#diasTransito").html();
		var unidad = $(tr).find("#unidadTabla").html();
		if (dias == "") {
			if (
				ubicacion == 7 ||
				ubicacion == 8 ||
				ubicacion == 9 ||
				ubicacion == 10
			) {
				if (ubicacion == 10) {
					$("#fechaLiberacion").html("Fecha liberación: ");
				}
				$("#unidadFinalizar").val(unidad);
				$("#finalizarEmbarqueModal").modal("show");
			} else {
				$("#unidad").val(unidad);
				$("#transitoModal").modal("show");
			}
		} else {
			var id = $(tr).find("#idFlete").html();
			if (ubicacion != "") {
				$.confirm({
					title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
					content: "¿Desea actualizar ubicación?",
					type: "orange",
					typeAnimated: true,
					animation: "zoom",
					closeAnimation: "right",
					backgroundDismiss: false,
					backgroundDismissAnimation: "shake",
					buttons: {
						tryAgain: {
							text: "Actualizar",
							btnClass: "btn btn-warning",
							action: function () {
								if (
									ubicacion == 7 ||
									ubicacion == 8 ||
									ubicacion == 9 ||
									ubicacion == 10
								) {
									if (ubicacion == 10) {
										$("#fechaLiberacion").html("Fecha liberación: ");
									}
									$("#unidadFinalizar").val(unidad);
									$("#finalizarEmbarqueModal").modal("show");
								} else {
									guardarMovimiento(ubicacion, id);
								}
							},
						},
						Cancelar: function () {},
					},
				});
			}
		}
	});

	$("#tablaRegistros").on("click", "#infoCarro", function (e) {
		e.preventDefault();
		var unidad = $(this).html();
		for (var i = 0; i <= unidad.length; i++) {
			var char = unidad.charAt(i);
			if (!isNumeric(char)) {
				var numero = unidad.substring(i);
				var inicial = unidad.substring(0, i);
				break;
			}
		}
		window.open(
			"https://mykcs.kcsouthern.com/MyKCS/CarSearchActivity.do?ini1=" +
				inicial +
				"&num1=" +
				numero,
			"Kansas",
			"width=1300,height=650"
		);
	});

	$("#tablaRegistros").on("click", "#editTransito", function () {
		var tr = $(".selected");
		var unidad = $(tr).find("#unidadTabla").html();
		var fecha = $(this).prev().html();
		$("#unidad").val(unidad);
		$("#fechaTransito").val(fecha);
		$("#transitoModal").modal("show");
	});

	$("#btnTransito").click(function () {
		var id = $(".selected").find("#idFlete").html();
		var fecha = $("#fechaTransito").val();
		var ubicacion = $(".selected").find("#ubicacion").val();
		if (fecha != "") {
			var datosForm = new FormData();
			datosForm.append("id", id);
			datosForm.append("fecha", fecha);
			$.ajax({
				data: datosForm,
				enctype: "multipart/form-data",
				processData: false,
				contentType: false,
				url: "?ajax&controller=Compras&action=embarqueEnTransito",
				type: "POST",
				dataType: "json",
				success: function (r) {
					guardarMovimiento(ubicacion, id);
				},
				error: function (r) {
					mensajeError(
						"Algo salio mal, verifique los datos o contacte al admin. del sistema."
					);
				},
			});
		} else {
			mensajeError("Agregue fecha tránsito.");
		}
	});

	function guardarMovimiento(ubicacion, id) {
		var datosForm = new FormData();
		datosForm.append("id", id);
		datosForm.append("ubicacion", ubicacion);
		$.ajax({
			data: datosForm,
			enctype: "multipart/form-data",
			processData: false,
			contentType: false,
			url: "?ajax&controller=Almacen&action=guardarUbicacionTransito",
			type: "POST",
			dataType: "json",
			success: function (r) {
				mensajeCorrecto("Se guardo ubicación de embarque", true);
			},
			error: function (r) {
				mensajeError(
					"Algo salio mal, verifique los datos o contacte al admin. del sistema."
				);
			},
		});
	}

	$("#tablaRegistros").on("click", "#deleteMovimineto", function () {
		var tr = $(this).closest("tr");
		var id = $(tr).find("#idMovimiento").html();
		var tabla = tr.parents("#tablaMovimientos");
		var embarque = $("#tablaRegistros").find(".selected");
		$.confirm({
			title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
			content: "¿Seguro desea eliminar movimiento?",
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
						$.ajax({
							data: { idMov: id },
							url: "?ajax&controller=Almacen&action=elminarMovimientoEmbarque",
							type: "POST",
							success: function (r) {
								tr.hide();
								tr.remove();
								$(embarque)
									.find("#ubicacion")
									.val(tabla.find("#idUbicacion").html());
							},
							error: function () {
								alert("Algo salio mal, no se logro eliminar");
							},
						});
					},
				},
				Cancelar: function () {},
			},
		});
	});

	$("#btnFinalizarEmbarque").click(function () {
		var id = $(".selected").find("#idFlete").html();
		var ubicacion = $(".selected").find("#ubicacion").val();
		var fecha = $("#fechaLlegada").val();
		if (fecha != "") {
			var datosForm = new FormData();
			datosForm.append("id", id);
			datosForm.append("fecha", fecha);
			datosForm.append("ubicacion", ubicacion);
			$.ajax({
				data: datosForm,
				enctype: "multipart/form-data",
				processData: false,
				contentType: false,
				url: "?ajax&controller=Almacen&action=embarqueEnTerminal",
				type: "POST",
				dataType: "json",
				success: function (r) {
					mensajeCorrecto("Se actualizo embarque", true);
				},
				error: function (r) {
					mensajeError(
						"Algo salio mal, verifique los datos o contacte al admin. del sistema."
					);
				},
			});
		} else {
			mensajeError("Agregue fecha de llegada.");
		}
	});

	$("select, input, #divEspecificacion, #enviarReqModal").on(
		"click",
		function () {
			$(this).removeClass("required");
		}
	);

	$("#btnAgregar").on("click", function () {
		$("#tablaDescripcion").addClass("mostrar");
	});

	//funcion eliminar requisición
	$("#tablaRegistros").on("click", "#deleteReq", function () {
		var tr = $(this).closest("tr");
		var id = tr.find("#idTabla").html();
		if (id != "") {
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
							$.ajax({
								data: { idReq: id },
								url: "?ajax&controller=Compras&action=deleteRequision",
								type: "POST",
								success: function (r) {
									tr.hide();
									tr.remove();
								},
								error: function () {
									alert("Algo salio mal, no se logro eliminar");
								},
							});
						},
					},
					Cancelar: function () {},
				},
			});
		}
	});

	//funcion mostrar requisicion
	$("#tablaRegistros").on("click", "#showReq", function () {
		var tr = $(this).closest("tr");
		var id = tr.find("#idTabla").html();
		if (id != "") {
			window.open(
				serv + "?controller=Compras&action=showRequisicion&idReq=" + id,
				"Requisición",
				"width=1300,height=650"
			);
		}
	});

	//funcion mostrar requisicion
	$("#tablaRegistros").on("click", "#showReqOrden", function () {
		var tr = $(this).closest("tr");
		var id = tr.find("#idTablaReq").html();
		if (id != "") {
			window.open(
				serv + "?controller=Compras&action=showRequisicion&idReq=" + id,
				"Requisición",
				"width=1300,height=650"
			);
		}
	});

	//funcion mostrar orden de compra
	$("#tablaRegistros, #tablaOrdenCompra").on(
		"click",
		"#showOrden",
		function () {
			var tr = $(this).closest("tr");
			var id = tr.find("#idTabla").html();
			if (id != "") {
				window.open(
					serv +
						"?controller=Compras&action=showOrdenCompra&idOrden=" +
						id,
					"Orden de compra",
					"width=1300,height=650"
				);
			}
		}
	);

	//funcion recepción
	$("#tablaRegistros").on("click", "#recibir", function () {
		var tr = $(this).closest("tr");
		var id = tr.find("#idTabla").html();
		if (id != "") {
			window.open(
				serv + "?controller=Compras&action=recepcionCompras&idOrden=" + id,
				"Recepción",
				"width=1150,height=600"
			);
		}
	});

	$("#tablaRegistros, #tablaEmbarques").on(
		"click",
		"#showFlete",
		function (e) {
			var tr = $(this).closest("tr");
			var idOrden = $(tr).find("#idOrden").html();
			e.preventDefault();
			var id = tr.find("#idFlete").html();
			if (id != "") {
				window.open(
					serv +
						"?controller=Compras&action=recepcionCompras&idOrden=" +
						idOrden +
						"&embarque=" +
						id,
					"Recepción",
					"width=1300,height=700"
				);
			}
		}
	);

	//función finalizar orden
	$("#tablaRegistros").on("click", "#cerrarOrden", function () {
		var tr = $(this).closest("tr");
		var id = tr.find("#idTabla").html();
		var folio = tr.find("#folioTabla").html();
		if (id != "") {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content:
					"¿Finalizar orden de compra <strong>" + folio + "</strong>?",
				type: "orange",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Finalizar",
						btnClass: "btn btn-warning",
						action: function () {
							finalizarOrdenCompra(id);
						},
					},
					Cancelar: function () {},
				},
			});
		}
	});

	function finalizarOrdenCompra(id) {
		$.ajax({
			data: { idOrden: id },
			url: "?ajax&controller=Compras&action=finalizarOrdenCompra",
			type: "POST",
			success: function (r) {
				mensajeCorrecto("Se finalizo orden de compra.", true);
			},
			error: function () {
				mensajeError("Algo salio mal, no se logro eliminar");
			},
		});
	}

	$("#imprimirReq").on("click", function () {
		var id = $(".selected").find("#idTabla").html();
		window.open(
			serv + "?controller=Compras&action=imprimirRequisicion&&idReq=" + id,
			"Imprimir Requsición",
			"width=1300,height=600"
		);
	});

	$("#imprimirOrden").on("click", function () {
		var id = $(".selected").find("#idTabla").html();
		window.open(
			serv + "?controller=Compras&action=imprimirOrdenCompra&&idOrden=" + id,
			"Imprimir Orden de Compra",
			"width=1300,height=600"
		);
	});

	//boton enviar Req
	$("#enviarReq").on("click", function () {
		var folio = $(".selected").find("#folioTabla").text();
		var correo = $(".selected").find("#correoTabla").text();
		$("#folioReq").text(folio);
		$("#correoModal").val(correo);
		if ($(".selected").find("#showCotizacion").length == 0) {
			$("#adjuntarCot").hide();
			$("#adjuntarCot").next("label").css("color", "transparent");
		}
		$("#enviarReqModal").modal("show");
	});

	$("#enviarReqModal").on("hidden.bs.modal", function () {
		$("#formEnviar").trigger("reset");
		$("#adjuntarCot").show();
		$("#adjuntarCot").next("label").css("color", "#0000");
	});

	$("#enviarReqModal, #enviarOrdenModal").on(
		"click",
		"#eliminarCorreo",
		function () {
			$(this)
				.parent()
				.hide(1000, function () {
					$(this).remove();
				});
		}
	);

	//funcion enviar requisición por correo
	$("#enviarCorreo").click(function () {
		$(this).attr("disabled", true);
		var valid = true;
		var id = $(".selected").find("#idTabla").text();
		var folio = $(".selected").find("#folioTabla").text();
		var inputsCorreos = $("#enviarReqModal").find("input[name*='correo']");
		var cuerpo = $("#cuerpoCorreo").val();
		var rechazar = $("#rechazarReq").prop("checked") == true ? 1 : 0;
		var adjReq = $("#ajuntarReq").prop("checked") == true ? 1 : 0;
		var adjCot = $("#adjuntarCot").prop("checked") == true ? 1 : 0;
		valid = validarInputsCorreo(inputsCorreos);
		if (valid) {
			if (cuerpo == "") {
				$("#enviarCorreo").attr("disabled", false);
				var msnj = "Cuerpo de correo vacio, agregue comentario.";
				mensajesValidacion(msnj);
			} else {
				var correos = Array();
				inputsCorreos.each(function () {
					if ($(this).val() != "") {
						correos.push($(this).val().trim());
					}
				});
				var datosForm = new FormData();
				datosForm.append("folio", folio);
				datosForm.append("correos", JSON.stringify(correos));
				datosForm.append("cuerpo", cuerpo);
				datosForm.append("rechazar", rechazar);
				datosForm.append("adjReq", adjReq);
				datosForm.append("adjCot", adjCot);
				datosForm.append("idReq", id);

				$("#enviarReqModal").modal("hide");
				$.ajax({
					data: datosForm,
					enctype: "multipart/form-data",
					processData: false,
					contentType: false,
					url: "?ajax&controller=Compras&action=enviarCorreoRequisicion",
					type: "POST",
					dataType: "json",
					success: function (r) {
						mensajeCorrecto("Se envio correo correctamente.");
					},
					error: function (r) {
						$("#enviarCorreo").attr("disabled", false);
						mensajeError(
							"Algo salio mal, verifique los datos o contacte al admin. del sistema."
						);
					},
				});
			}
		} else {
			var msnj = "Verifique que el correo este bien escrito.";
			$("#enviarCorreo").attr("disabled", false);
			mensajesValidacion(msnj);
		}
	});

	//boton enviar Req
	$("#enviarReq").on("click", function () {
		var folio = $(".selected").find("#folioTabla").text();
		var correo = $(".selected").find("#correoTabla").text();
		$("#folioReq").text(folio);
		$("#correoModal").val(correo);
		if ($(".selected").find("#showCotizacion").length == 0) {
			$("#adjuntarCot").hide();
			$("#adjuntarCot").next("label").css("color", "transparent");
		}
		$("#enviarReqModal").modal("show");
	});

	$("#enviarReqModal").on("hidden.bs.modal", function () {
		$("#formEnviar").trigger("reset");
		$("#adjuntarCot").show();
		$("#adjuntarCot").next("label").css("color", "#0000");
	});

	$("#agregarCorreo").on("click", function () {
		var label =
			'<div class="div-labl-correo text-right mr-1 "><label>CC:</label></div>';
		var input =
			'<div class="ui-widget"><input type="text" id="fillCorreo" name="correoModal[]" class="item-correo correo-user "></div>';
		var icono =
			'<span title="Eliminar correo" class="material-icons i-delete p-1" id="eliminarCorreo">delete_forever</span>';
		$("#correo1").after(
			'<div class="row mb-2">' + label + input + icono + "</div>"
		);
	});

	//boton enviar Orden
	$("#enviarOrden").on("click", function () {
		var folio = $(".selected").find("#folioTabla").text();
		var correo = $(".selected").find("#correoTabla").text();
		$("#folioOrden").text(folio);
		$("#correoModal").val(correo);
		if ($(".selected").find("#showCotizacion").length == 0) {
			$("#adjuntarCot").hide();
			$("#adjuntarCot").next("label").css("color", "transparent");
		}
		$("#enviarOrdenModal").modal("show");
	});

	$("#enviarOrdenModal").on("hidden.bs.modal", function () {
		$("#formEnviar").trigger("reset");
		$("#adjuntarCot").show();
		$("#adjuntarCot").next("label").css("color", "#0000");
	});

	//funcion enviar Orden de compra por correo
	$("#enviarCorreoOrden").click(function () {
		$(this).attr("disabled", true);
		var valid = true;
		var id = $(".selected").find("#idTabla").text();
		var folio = $(".selected").find("#folioTabla").text();
		var inputsCorreos = $("#enviarOrdenModal").find("input[name*='correo']");
		var asunto = $("#asunto").val();
		var cuerpo = $("#cuerpoCorreo").val();
		var adjorden = $("#ajuntarOrden").prop("checked") == true ? 1 : 0;
		var adjCot = $("#adjuntarCot").prop("checked") == true ? 1 : 0;
		valid = validarInputsCorreo(inputsCorreos);
		if (valid) {
			if (cuerpo == "") {
				$("#enviarCorreoOrden").attr("disabled", false);
				var msnj = "Cuerpo de correo vacio, agregue comentario.";
				mensajesValidacion(msnj);
			} else {
				var correos = Array();
				inputsCorreos.each(function () {
					if ($(this).val() != "") {
						correos.push($(this).val().trim());
					}
				});
				var datosForm = new FormData();
				datosForm.append("folio", folio);
				datosForm.append("asunto", asunto);
				datosForm.append("correos", JSON.stringify(correos));
				datosForm.append("cuerpo", cuerpo);
				datosForm.append("adjOrden", adjorden);
				datosForm.append("adjCot", adjCot);
				datosForm.append("idOrden", id);

				$("#enviarOrdenModal").modal("hide");
				$.ajax({
					data: datosForm,
					enctype: "multipart/form-data",
					processData: false,
					contentType: false,
					url: "?ajax&controller=Compras&action=enviarCorreoOrdenCompra",
					type: "POST",
					dataType: "json",
					success: function (r) {
						$("#enviarCorreoOrden").attr("disabled", false);
						mensajeCorrecto("Se envio correo correctamente.", true);
					},
					error: function (r) {
						$("#enviarCorreoOrden").attr("disabled", false);
						console.log(r);
						mensajeError(
							"Algo salio mal, verifique los datos o contacte al admin. del sistema."
						);
					},
				});
			}
		} else {
			valid = false;
			$("#enviarCorreoOrden").attr("disabled", false);
			var msnj = "Verifique que el correo este bien escrito.";
			mensajesValidacion(msnj);
		}
	});

	function mensajeCorrecto(result, reload = false) {
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
					action: function () {
						if (reload) {
							location.reload();
						}
					},
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

	function validarInputsCorreo(inputsCorreos) {
		var valid = true;
		inputsCorreos.each(function () {
			var mail = $(this).val();
			if (mail == "" || mail.indexOf("@") == -1 || mail.indexOf(".") == -1) {
				$(this).addClass("required");
				valid = false;
			} else {
				$(this).removeClass("required");
			}
		});
		return valid;
	}

	function mensajesValidacion(mensaje) {
		$.confirm({
			title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
			content: mensaje,
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
					action: function () {},
				},
			},
		});
	}

	//funcion mostrar cotizacion
	$("#tablaRegistros, #tablaOrdenCompra").on(
		"click",
		"#showCotizacion",
		function () {
			var cotizacion = $(this)
				.closest("tr")
				.find("#archivoCotizacion")
				.html();
			$("#tituloCotizacion").html("Cotización: " + cotizacion);
			var url = "../../views/compras/uploads/cotizaciones/" + cotizacion;
			$("#viewCot").append(
				'<object class="view-cot" id="objCot" data=""></object>'
			);
			$("#objCot").attr("data", url);
			$("#modalCotizacion").modal("show");
		}
	);

	$("#modalCotizacion").on("hidden.bs.modal", function () {
		$("#objCot").remove();
	});

	$("#tablaRegistros").on(
		"click",
		"#showEmbarque, #showRecepcionFlete, #showServiciosNave",
		function () {
			$(this).toggleClass("rotar");
			var tr = $(this).closest("tr").next("tr");
			$(tr).attr("hidden", function (i, attr) {
				if (attr === "hidden") {
					$(tr).removeAttr("hidden").removeClass("transparent", 1500);
				} else {
					$(tr).addClass("transparent").attr("hidden", true);
				}
			});
		}
	);

	//Función boton editar
	$("#seccionDescripcion").on("click", "#edit", function () {
		var padres = $(this).parents();
		$("#formRequisicion input, select, textarea").attr("disabled", true);
		$(padres[1]).find("input, select").removeAttr("disabled");
		$(padres[1]).find("#save").show(1000).removeAttr("hidden");
		$(padres[1]).find("#delete").hide(1000);
		$(padres[1]).find("#edit").hide(1000);
		$("#btnAgregar").hide(1000);
		$("#btnGenerar").hide(1000);
		$("#tablaDescripcion #edit").hide(1000);
		$(padres[1]).find("#edit").attr("hidden", false);
		$(padres[1]).find("input, select").addClass("seleccion");
		$("#seccionDatos, #seccionComentarios").addClass("opaco");
	});

	//Función boton eliminar detalle
	$("#seccionDescripcion").on("click", "#delete", function () {
		var inputsTabla = $("#seccionDescripcion").find("input");
		var detalle = $(this).closest("#tablaDescripcion");
		var id = $(detalle).find('[id^="idDetalle"]').val();
		if (inputsTabla.length == 4) {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content: "No se puede eliminar, debe tener al menos un detalle",
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
						action: function () {},
					},
				},
			});
		} else if (id != "") {
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
							$.ajax({
								data: { idReq: id },
								url: "?ajax&controller=Compras&action=deleteDetalle",
								type: "POST",
								dataType: "json",
								success: function () {
									$(detalle).slideUp(1000, function () {
										$(detalle).find("input, select").remove();
									});
								},
								error: function () {
									alert(
										"Algo salio mal, no se pudo eliminar, contacte al administrador del sistema"
									);
								},
							});
						},
					},
					Cancelar: function () {},
				},
			});
		} else {
			$(detalle).slideUp(1000, function () {
				$(detalle).find("input, select").remove();
			});
		}
	});

	if ($("#empresaReq").val() != "") {
		$("#empresaReq").attr("disabled", true);
	}

	//Función boton guardar
	$("#seccionDescripcion").on("click", "#save", function () {
		var padres = $(this).parents();
		var items = $(padres[1]).find("input, select");
		var desc = items[0],
			unidad = items[1],
			cantidad = items[2],
			precio = items[3];
		var valid = true;
		var validNum = true;
		if (desc.value === "" || desc.value === null) {
			$(desc).addClass("required");
			valid = false;
		}
		if (unidad.value === "" || unidad.value === null) {
			$(unidad).addClass("required");
			valid = false;
		}
		if (cantidad.value === "" || cantidad.value === null) {
			$(cantidad).addClass("required");
			valid = false;
		} else {
			if (!validarNumerico(cantidad)) {
				valid = false;
				validNum = false;
			}
		}
		if (precio.value === "" || precio.value === null) {
			$(precio).addClass("required");
			valid = false;
		} else {
			if (!validarNumerico(precio)) {
				valid = false;
				validNum = false;
			}
		}
		if (!validNum) {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content:
					"<strong>Cantidades y precios</strong> deben de ser valores numericos",
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
						action: function () {},
					},
				},
			});
		}
		if (valid) {
			$("#formRequisicion input, select, textarea").removeAttr("disabled");
			$(padres[2]).find("input, select").attr("disabled", true);
			$(padres[1]).find("#save").hide(1000).attr("hidden");
			$(padres[1]).find("#delete").show(1000);
			$(padres[1]).find("#edit").show(1000);
			$("#btnAgregar").show(1000);
			$("#btnGenerar").show(1000);
			$("#tablaDescripcion #edit").show(1000);
			$(padres[1]).find("input, select").removeClass("seleccion");
			$("#seccionDatos, #seccionComentarios").removeClass("opaco");
		}
	});

	//Función boton up/down
	$("#slideUp").on("click", function () {
		rotarOcultarEsp();
	});

	function rotarOcultarEsp() {
		$("#divEspecificacion").slideToggle(1000, function () {
			$("#i-slideUp").toggleClass("rotar");
		});
		return false;
	}

	$("#solicitud").change(function () {
		buscarProveedores();
	});

	if ($("#solicitud").val() != "" && $("#solicitud").val() != undefined) {
		buscarProveedores();
	}

	function buscarProveedores() {
		var proveedor = $("#proveedor");
		var idProv = $(proveedor).val();
		var solicitud = $("#solicitud");
		var opcion = $("#solicitud option:selected").text();
		if (opcion === "Transporte") {
			$("#proyecto")
				.html("Entregar a:")
				.next("input")
				.removeClass("item-small")
				.addClass("item-medium");
			$("#descProyecto").html("Domicilio:");
			$("#urgente").html("Urgente:");
			$("#descProducto").attr("hidden", true);
		} else if (opcion === "Materia Prima") {
			$("#proyecto")
				.html("Entregar a:")
				.next("input")
				.removeClass("item-small")
				.addClass("item-medium");
			$("#descProyecto").html("Domicilio:");
			$("#urgente").html("Urgente:");
			$("#descProducto").attr("hidden", false);
			$("#descRuta").attr("hidden", true);
		} else {
			$("#proyecto")
				.html("Proyecto:")
				.next("input")
				.removeClass("item-medium")
				.addClass("item-small")
				.val("");
			$("#descProyecto").html("Nombre proyecto:").next("input").val("");
			$("#urgente").html("Compra urgente:");
			$("#descRuta").attr("hidden", true);
			$("#descProducto").attr("hidden", true);
			$("#descEspecif").attr("readOnly", false);
		}
		if ($(solicitud).val() != "") {
			$.ajax({
				data: { idServicio: solicitud.val() },
				url: "?ajax&controller=Catalogo&action=proveedoresByServicio",
				type: "POST",
				dataType: "json",
				success: function (r) {
					proveedor.prop("disabled", false);
					proveedor.find("option").not(":first").remove();
					$(r).each(function (i, v) {
						// indice, valor
						proveedor.append(
							'<option value="' + v.id + '">' + v.nombre + "</option>"
						);
					});
					$(proveedor).val(idProv);
				},
				error: function () {
					alert(
						"Algo salio mal, no se encontro proveedor, contacte al administrador del sistema"
					);
				},
			});
		} else {
			proveedor.find("option").remove();
			proveedor.prop("disabled", true);
		}
	}

	$("#proveedor").change(function () {
		if ($("#solicitud option:selected").text() === "Transporte") {
			$("#descRuta").attr("hidden", false);
		}
	});

	if ($("#solicitud option:selected").text() === "Transporte") {
		$("#descRuta").attr("hidden", false);
	}

	$("#rutaProducto").change(function () {
		$("#idRuta").val($(this).val());
	});

	$("#aduana").change(function () {
		$("#idAduana").val($(this).val());
	});

	$("#transporteRuta").change(function () {
		$("#ruta").removeAttr("disabled").val("");
		buscarRuta();
	});

	function buscarRuta() {
		$("#descRuta").removeAttr("hidden");
		var ruta = $("#ruta");
		var proveedor = $("#proveedor");
		var transporte = $("#transporteRuta");
		var solicitud = $("#solicitud option:selected").text();
		if (solicitud == "Transporte") {
			if (proveedor.val() != "") {
				$.ajax({
					data: {
						idProveedor: proveedor.val(),
						idTransporte: transporte.val(),
					},
					url: "?ajax&controller=Catalogo&action=rutasByProveedorTransporte",
					type: "POST",
					dataType: "json",
					success: function (r) {
						ruta.find("option").not(":first").remove();
						if (r.length != 0) {
							$(r).each(function (i, v) {
								// indice, valor
								ruta.append(
									'<option value="' +
										v.id +
										'">' +
										v.ciudad_or +
										" - " +
										v.ciudad_des +
										"</option>"
								);
							});
						} else {
							ruta.append(
								'<option value="" disabled>No hay rutas registradas</option>'
							);
						}
					},
					error: function () {
						alert(
							"Algo salio mal al buscar ruta, contacte al administrador del sistema"
						);
					},
				});
			}
		}
	}

	if ($("#solicitud option:selected").text() === "Transporte") {
		$("#proyecto")
			.html("Entregar a:")
			.next("input")
			.removeClass("item-small")
			.addClass("item-medium");
		$("#descProyecto").html("Domicilio:");
		$("#urgente").html("Urgente:");
		var idCliente = $("#idCliente").val();
		if (idCliente != "") {
			buscarCliente(idCliente);
		}
	}

	$("#ruta").change(function () {
		var idRuta = $(this).val();
		var ruta = $("#ruta option:selected").text();
		var transporte = $("#transporteRuta option:selected").text();
		if (idRuta != "") {
			$.ajax({
				data: { idRuta: idRuta },
				url: "?ajax&controller=Catalogo&action=validarFechaVencimientoPrecio",
				type: "POST",
				dataType: "json",
				success: function (r) {
					var today = new Date();
					var vencimiento = new Date(r[0].fecha_vencimiento);
					if (vencimiento > today) {
						$("#idRuta").val(idRuta);
						var desc = $("#tablaDescripcion").find(
							"input[id='descripcion[1]'"
						);
						if ($(desc).val() != "") {
							$(desc)
								.val("Flete: " + transporte + " - " + ruta)
								.attr("readOnly", true);
							$("#tablaDescripcion")
								.find("input[name='precioUnitario[1]'")
								.val(parseFloat(r[0].precio));
						} else {
							$("#descEspecif")
								.val("Flete: " + transporte + " - " + ruta)
								.attr("readOnly", true);
							var unidades = $("#unidadEspecif").children();
							unidades.each(function () {
								if (this.text === "Servicio") {
									$(this).attr("selected", true);
									$("#cantidadEsp").val("1");
									$("#precioEspecif").val(parseFloat(r[0].precio));
								}
							});
						}
						$("#costo")
							.val(parseFloat(r[0].precio))
							.attr("disabled", true);
					} else {
						$("#idRuta").val("");
						$("#descEspecif").val("").attr("readOnly", false);
						$("#unidadEspecif").val("");
						$("#cantidadEsp").val("");
						$("#precioEspecif").val("");
						$("#costo").val("");
						mensajeError(
							"Precio de la ruta vencido, vaya a catalogos o solicite que se actualice."
						);
						$("#rutaModal").modal("hide");
					}
				},
				error: function () {
					alert(
						"Algo salio mal, no se encontro ruta, contacte al administrador del sistema"
					);
				},
			});
		}
	});

	$("#rutaProducto").change(function () {
		validarPrecioRuta($(this).val());
	});

	function validarPrecioRuta(idRuta) {
		if (idRuta != "") {
			$.ajax({
				data: { idRuta: idRuta },
				url: "?ajax&controller=Catalogo&action=validarFechaVencimientoPrecio",
				type: "POST",
				dataType: "json",
				success: function (r) {
					var today = new Date();
					var vencimiento = new Date(r[0].fecha_vencimiento);
					if (vencimiento > today) {
						$("#idRuta").val(idRuta);
					} else {
						$("#idRuta").val("");
						$("#rutaProducto").val(0);
						mensajeError(
							"Precio de la ruta vencido, vaya a catalogos o solicite que se actualice."
						);
					}
				},
				error: function () {
					alert(
						"Algo salio mal, no se encontro ruta, contacte al administrador del sistema"
					);
				},
			});
		}
	}

	$("#btnProducto").click(function (e) {
		if (validarFormProductos()) {
			var producto = $("#producto option:selected").text();
			var transporte = $("#transporteProducto:checked").next("label").html();
			var cantidad = $("#cantidadPro").val();
			if (!isNumeric(cantidad)) {
				var desc = $("#tablaDescripcion").find("input[id='descripcion[1]'");
				if ($(desc).val() != "") {
					$(desc)
						.val("(" + cantidad + " " + transporte + ") " + producto)
						.attr("readOnly", true);
				} else {
					$("#descEspecif")
						.val("(" + cantidad + " " + transporte + ") " + producto)
						.attr("readOnly", true);
				}
				$("#idProducto").val($("#producto").val());
				$("#idTransporte").val($("#transporteProducto:checked").val());
				$("#flete").val($("#tipoFlete").val());
				$("#cantidadFlete").val(cantidad);
				$(this).attr("data-dismiss", "modal");
			} else {
				$(this).removeAttr("data-dismiss", "modal");
				mensajeError("Cantidad debe ser numero");
			}
		} else {
			$(this).removeAttr("data-dismiss", "modal");
			mensajeError("Debe completar todos los datos.");
		}
	});

	if ($("#transporteProducto:checked").val() == 1) {
		$("#divRutaProducto").addClass("hide");
		$("#divAduanaProducto").addClass("hide");
	} else {
		$("#divRutaProducto").removeClass("hide");
		$("#divAduanaProducto").removeClass("hide");
	}

	$("input[type=radio][id=transporteProducto]").change(function () {
		if ($(this).val() == 1) {
			$("#divRutaProducto").addClass("hide");
			$("#divAduanaProducto").addClass("hide");
			$("#rutaProducto").val("0");
			$("#aduana").val("0");
			$("#idRuta").val("");
			$("#idAduana").val("");
		} else {
			$("#divRutaProducto").removeClass("hide");
			$("#divAduanaProducto").removeClass("hide");
		}
	});

	function validarFormProductos() {
		var inputs = $("#formProducto").find("select, input");
		var valid = true;
		inputs.each(function () {
			if ($(this).val() == null || $(this).val() == "") {
				$(this).addClass("required");
				valid = false;
			}
		});
		return valid;
	}

	if ($("#idCliente").val() != "") {
		$("#clienteProd").val($("#idCliente").val());
		$("#cliente").val($("#idCliente").val());
		$("#proyectoEntregar").val("");
		$("#proyectoDomicilio").val("");
	}

	if ($("#idRuta").val() != "") {
		$("#rutaProducto").val($("#idRuta").val());
		$("#ruta").val($("#idRuta").val());
		$("#costo").val(
			$("#tablaDescripcion").find("input[name='precioUnitario[1]'").val()
		);
	}

	if ($("#idAduana").val() != "") {
		$("#aduana").val($("#idAduana").val());
	}

	if ($("#idProducto").val() != "") {
		$("#producto").val($("#idProducto").val());
	}

	if ($("#idTransporte").val() != "") {
		$("#transporteRuta").val($("#idTransporte").val());
	}

	if ($("#cantidadFlete").val() != "") {
		$("#cantidadPro").val($("#cantidadFlete").val());
	}

	if ($("#flete").val() != "") {
		$("#tipoFlete").val($("#flete").val());
	}

	$("#cliente").change(function () {
		var idCliente = $(this).val();
		if (!(idCliente != 0 || $("#idCliente") != "")) {
			buscarCliente(idCliente);
		} else {
			$("#idCliente").val("");
			$("#proyectoEntregar").val("");
			$("#proyectoDomicilio").val("");
		}
	});

	$("#clienteProd").change(function () {
		var idCliente = $(this).val();
		if (idCliente != 0) {
			buscarCliente(idCliente);
		} else {
			$("#idCliente").val("");
			$("#proyectoEntregar").val("");
			$("#proyectoDomicilio").val("");
		}
	});

	if (
		$("#solicitud option:selected").text() === "Transporte" &&
		!(
			$("#idCliente") != null ||
			$("#idCliente") != 0 ||
			$("#idCliente") != ""
		)
	) {
		var idCliente = $("#idCliente").val();
		buscarCliente(idCliente);
	}

	if (
		$("#solicitud option:selected").text() === "Materia Prima" &&
		!(
			$("#idCliente") != null ||
			$("#idCliente") != 0 ||
			$("#idCliente") != ""
		)
	) {
		var idCliente = $("#idCliente").val();
		buscarCliente(idCliente);
	}

	function buscarCliente(idCliente) {
		if (idCliente != 0 || idCliente != "") {
			$.ajax({
				data: { idCliente: idCliente },
				url: "?ajax&controller=Catalogo&action=getClienteById",
				type: "POST",
				dataType: "json",
				success: function (r) {
					$("#idCliente").val(r[0].id);
					$("#proyectoEntregar").val(r[0].nombre).attr("disabled", true);
					$("#proyectoDomicilio")
						.val(r[0].direccion + " " + r[0].ciudad_completa)
						.attr("disabled", true);
				},
				error: function () {
					alert(
						"Algo salio mal, no se encontro cliente, contacte al administrador del sistema"
					);
				},
			});
		}
	}

	//Validar input archivos
	$("#documento").change(function () {
		var input = $(this);
		var tipoArchivo = $(this).prop("files")[0].name;
		if (tipoArchivo.toLowerCase().includes(".pdf")) {
			$.confirm({
				title: "<span class='material-icons i-correcto'>check_circle_outline</span><span>¡Correcto!<span>",
				content: "Archivo agregado",
				type: "green",
				typeAnimated: true,
				draggable: true,
				buttons: {
					tryAgain: {
						text: "Ok",
						btnClass: "btn-success",
						action: function () {
							$("#deleteCotizacion").show();
						},
					},
				},
			});
		} else {
			$.confirm({
				title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
				content:
					"Formato invalido de Documento <br/>Archivo: <strong>" +
					tipoArchivo +
					"</strong> <br/> Formatos aceptados: <strong>.pdf. </strong>",
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
							$("#spanDocumento").html("");
						},
					},
				},
			});
		}
	});

	//borrar cotización
	$("#deleteCotizacion").click(function () {
		if ($("#id").val() != "") {
			var cotizacion = $("#spanDocumento").html();
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content:
					"Se eliminara la cotización: <strong>" +
					cotizacion +
					"</strong>",
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
								data: { idReq: id, cotizacionReq: cotizacion },
								url: "?ajax&controller=Compras&action=eliminarCotizacion",
								type: "POST",
								success: function (r) {
									$("#documento").val("");
									$("#spanDocumento").html("");
									$("#deleteCotizacion").hide(500);
								},
								error: function () {
									alert(
										"Algo salio mal, no se pudo borrar cotización, contacte al administrador del sistema"
									);
								},
							});
						},
					},
					Cancelar: function () {},
				},
			});
		} else {
			$("#documento").val("");
			$("#spanDocumento").html("");
			$(this).hide(500);
		}
	});

	$(
		"#fechaRequerida, #fechaSolicitud, #fechaInicio, #fechaFin, #fechaFinExp, #fechaInicioExp, #fechaTransito, #fechaLlegada"
	).datepicker({
		showOn: "button",
		buttonText:
			'<span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-calendar"></i></span>', //"<span class='fas fa-calendar-alt i-calendar'></span>",
	});
	// buscar req
	$("#buscarReq").click(function () {
		$("#proveedor").prop("disabled", true);
		$("#buscarRequisicion").modal("show");
	});

	$("#buscarRequisicion").on("hidden.bs.modal", function () {
		$("#formBuscar").trigger("reset");
	});

	//buscar orden
	$("#buscarOrden").click(function () {
		$("#proveedor").prop("disabled", true);
		$("#buscarOrdenCompra").modal("show");
	});

	$("#buscarOrdenCompra").on("hidden.bs.modal", function () {
		$("#formBuscar").trigger("reset");
	});

	$("#exportar").click(function () {
		$("#exportarModal").modal("show");
	});

	$("#exportarModal").on("hidden.bs.modal", function () {
		$("#formExportar").trigger("reset");
	});

	$("#descRuta").click(function (e) {
		e.preventDefault();
		$("#rutaModal").modal("show");
	});

	$("#descProducto").click(function (e) {
		e.preventDefault();
		$("#productoModal").modal("show");
	});

	$("#btnExportar").click(function () {
		$("#pdf").val(0);
		validarFormExportar();
	});

	$("#btnPdfExportar").click(function () {
		$("#pdf").val(1);
		validarFormExportar();
	});

	function validarFormExportar() {
		var fechaIni = $("#fechaInicioExp").val() == "" ? true : false;
		var fechaFin = $("#fechaFinExp").val() == "" ? true : false;
		var prov = $("#proveedorExp").val() == "" ? true : false;
		var prod = $("#productoExp").val() == "" ? true : false;
		var adu = $("#aduanaExp").val() == "" ? true : false;
		if (fechaIni && fechaFin && prov && prod && adu) {
			mensajeError("Debe de agregar un campo de busqueda");
		} else {
			$("#formExportar").submit();
			$("#exportarModal").modal("hide");
		}
	}

	$("#btnBuscar").click(function () {
		var fechaIni = $("#fechaInicio").val();
		var fechaFin = $("#fechaFin").val();
		var folio = $("#folioBuscar").val();
		var prov = $("#proveedor").val();
		var solicitud = $("#solicitud").val();
		if (
			fechaIni == "" &&
			fechaFin == "" &&
			folio == "" &&
			prov == null &&
			solicitud == null
		) {
			mensajeError("Debe de agregar un filtro.");
		} else {
			$("#formBuscar").submit();
		}
	});

	//boton enviar orden
	$("#enviarOrden").on("click", function () {
		var folio = $(".selected").find("#folioTabla").text();
		var correo = $(".selected").find("#correoTabla").text();
		$("#folioReq").text(folio);
		$("#correoModal").val(correo);
		if ($(".selected").find("#showCotizacion").length == 0) {
			$("#adjuntarCot").hide();
			$("#adjuntarCot").next("label").css("color", "transparent");
		}
		$("#enviarReqModal").modal("show");
	});

	$("#modalDocumento").on("hidden.bs.modal", function () {
		$("#objDoc").remove();
	});

	$("#tablaRegistros, #tablaEmbarques").on(
		"click",
		"#showFactura",
		function () {
			var factura = $(this).closest("tr").find("#factura").val();
			$("#tituloDocumento").html("Factura: " + factura);
			var url = "../../views/compras/uploads/facturas/" + factura;
			$("#viewDoc").append(
				'<object class="view-doc" id="objDoc" data=""></object>'
			);
			$("#objDoc").attr("data", url);
			$("#modalDocumento").modal("show");
		}
	);

	$("#tablaRegistros, #tablaEmbarques").on("click", "#showXml", function () {
		var factura = $(this).closest("tr").find("#xml").val();
		var url = "../../views/compras/uploads/xml/" + factura;
		window.open(url, factura, "width=1300,height=600");
	});

	// Directorio
	$("#abrirDirectorio").click(function (e) {
		e.preventDefault();
		// $("#modalDirectorio").modal("show");
		Swal.fire({
			html: $("#modalDirectorio")
				.html()
				.replace("tablaDirectorio", "tablaDirectorioS"),
			showCloseButton: true,
			width: "80vw",
			imageheight: "600",
			didOpen: () => {
				new DataTable("#tablaDirectorioS", {
					dom: "Bfrtip",
					retrieve: true,
					language: {
						url: __url__ + "assets/libs/datatables/es-MX.json",
					},
					buttons: [
						"print",
						{
							extend: "excelHtml5",
							// className: 'btn btnExcel',
							title: `Directorio ${formatDate(new Date())}`,
						},
						"pdf",
					],
				});
			},
		});
	});

	//funcion mostrar cotizacion
	$("#tablaRegistros, #tablaEmbarques").on(
		"click",
		"#showPedimento",
		function () {
			var pedimento = $(this).closest("tr").find("#pedimento").val();
			$("#tituloDocumento").html("Pedimento: " + pedimento);
			var url = "../../views/compras/uploads/pedimentos/" + pedimento;
			$("#viewDoc").append(
				'<object class="view-doc" id="objDoc" data=""></object>'
			);
			$("#objDoc").attr("data", url);
			$("#modalDocumento").modal("show");
		}
	);

	$("#tablaRegistros, #tablaEmbarques").on(
		"click",
		"#showRemision",
		function () {
			var factura = $(this).closest("tr").find("#remision").val();
			$("#tituloDocumento").html("Remisión: " + factura);
			var url = "../../views/compras/uploads/remisiones/" + factura;
			$("#viewDoc").append(
				'<object class="view-doc" id="objDoc" data=""></object>'
			);
			$("#objDoc").attr("data", url);
			$("#modalDocumento").modal("show");
		}
	);

	var directorioGlobal = new Array();

	function getDirectorio() {
		var directorio = new Array();
		$.ajax({
			url: "?ajax&controller=Catalogo&action=getDirectorio",
			type: "POST",
			dataType: "json",
			success: function (r) {
				$(r).each(function (i, v) {
					// indice, valor
					directorio.push(v.correo);
				});
			},
			error: function () {
				alert(
					"Algo salio mal, no se cargo directorio, contacte al administrador del sistema"
				);
			},
		});
		return directorio;
	}

	$("#enviarReqModal").on(
		"keypress",
		"#fillCorreo, #correoModal",
		function () {
			if (directorioGlobal.length === 0) {
				var directorio = getDirectorio();
				directorioGlobal = directorio;
			}
			$(this).autocomplete({
				source: directorioGlobal,
			});
		}
	);

	$("#enviarOrdenModal").on(
		"keypress",
		"#fillCorreo, #correoModal",
		function () {
			if (directorioGlobal.length === 0) {
				var directorio = getDirectorio();
				directorioGlobal = directorio;
			}
			$(this).autocomplete({
				source: directorioGlobal,
			});
		}
	);

	$("#aside").on("click", "#dropMenu", function () {
		$(this).toggleClass("rotar90");
		var li = $(this).closest("li");
		$(li).toggleClass("li-drop");
		var ul = $(li).next("ul");
		$(ul).toggleClass("transparent", 1000);
		$(ul).toggleClass("hidden");
	});

	$.datepicker.regional["es"] = {
		closeText: "Cerrar",
		prevText: "< Ant",
		nextText: "Sig >",
		currentText: "Hoy",
		monthNames: [
			"Enero",
			"Febrero",
			"Marzo",
			"Abril",
			"Mayo",
			"Junio",
			"Julio",
			"Agosto",
			"Septiembre",
			"Octubre",
			"Noviembre",
			"Diciembre",
		],
		monthNamesShort: [
			"Ene",
			"Feb",
			"Mar",
			"Abr",
			"May",
			"Jun",
			"Jul",
			"Ago",
			"Sep",
			"Oct",
			"Nov",
			"Dic",
		],
		dayNames: [
			"Domingo",
			"Lunes",
			"Martes",
			"Miércoles",
			"Jueves",
			"Viernes",
			"Sábado",
		],
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

// function erpalert(
//   tipo = "",
//   title = "Hecho!",
//   texto = "",
//   time = "3500",
//   show = "slideDown",
//   hide = "slideUp"
// ) {
//   if (tipo == "") {
//     tipo = "success";
//   }
//   // console.log("tipo ", tipo);
//   let Toast = Swal.mixin({
//     toast: true,
//     position: "top-right",
//     iconColor: "white",
//     customClass: {
//       popup: "colored-toast",
//     },
//     text: texto,
//     showConfirmButton: false,
//     timer: time,
//     timerProgressBar: true,
//     icon: tipo,
//     title: title,
//   }).fire();
// }
function erpalert(
	tipo = "",
	title = "Hecho!",
	texto = "",
	time = "3500",
	show = "slideDown",
	hide = "slideUp"
) {
	if (tipo == "") {
		tipo = "success";
	}
	let color = "#18c400";
	switch (tipo) {
		case "warning":
			color = "#f19212";
			break;
		case "error":
			color = "#d10000";
			break;
		case "info":
			color = "#12e7f1";
			break;

		default:
			break;
	}

	toastr.options = {
		closeButton: false,
		debug: false,
		newestOnTop: true,
		progressBar: true,
		positionClass: "toast-top-right",
		preventDuplicates: false,
		onclick: null,
		showDuration: "300",
		hideDuration: "1000",
		timeOut: time,
		extendedTimeOut: "1000",
		showEasing: "pulse",
		hideEasing: "linear",
		showMethod: "fadeIn",
		hideMethod: "fadeOut",
	};

	toastr[tipo](texto, title);
	//   $.toast({
	//     title: title,
	//     subtitle: subtitle,
	//     content: texto,
	//     type: tipo,
	//     delay: time,

	//     // pause delay on hover
	//     pauseDelayOnHover: true,
	//     dismissible: true,
	//   });
	// $.toast({
	// heading: `<strong>${title}</strong>`,
	// text: texto,
	// position: "top-right",
	// icon: tipo,
	// showHideTransition: "plain",
	// stack: 5,
	// hideAfter: time,
	// textAlign: "center", // Text alignment i.e. left, right or center
	// loader: true,
	// bgColor: color,
	// textColor: "white",
	// loaderBg: "rgb(64, 64, 223, 0.5)",
	// });
}
//

//
function numero2Decimales(str = "", $decimales = false, $numDecimales = 2) {
	// console.log("str: ", str);
	if ($decimales) {
		$int = parseFloat(str);
		// return number_format($int, $numDecimales);
		return $int.toLocaleString("us", {
			minimumFractionDigits: $numDecimales,
			maximumFractionDigits: $numDecimales,
		});
	} else {
		// console.log("str: ", str);
		$strArray = str.toString().split("/[.]/");
		if (parseInt($strArray[1]) == 0) {
			$int = parseInt(str);
			return number_format($int);
			return $int.toLocaleString("us", {
				minimumFractionDigits: 0,
				maximumFractionDigits: 0,
			});
		} else {
			$int = parseFloat(str);
			return $int.toLocaleString("us", {
				minimumFractionDigits: $numDecimales,
				maximumFractionDigits: $numDecimales,
			});
			// return number_format($int, $numDecimales);
		}
	}
}

function getColorTheme() {
	var colorestheme = {
		bgcolor: $("body").css("background-color"),
		fontcolor: $("body").css("color"),
	};
	// switch ($("html").attr("data-theme")) {
	// 	case "light":
	// 		colorestheme["bgcolor"] = "";
	// 		break;
	// 	case "dark":
	// 		break;
	// 	default:
	// 		break;
	// }
	return colorestheme;
}
