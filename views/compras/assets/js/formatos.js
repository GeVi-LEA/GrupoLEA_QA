var firmado = 0;

$(document).ready(function () {
	const serv =
		typeof __url__ !== "undefined" && __url__
			? __url__
			: localStorage.getItem("_URL_"); //"http://localhost/GrupoLEA/";
	$("#firmas").on("click", "#clear", function () {
		var div = $(this).parent();
		var firma = div.find("#imgFirma");
		var radio = div.find("#radioFirma");
		var input = div.find("#valorFirma");

		$(this).hide();
		firma.remove();
		radio.attr("hidden", false);
		input.attr("value", "0");
	});
	if (firmado == 1) {
		goToByScroll("firmas");
		firmado = 0;
	}
	$(":radio").change(function () {
		$("#btnFirma").submit().click();
		firmado = 1;
		setTimeout(() => {
			goToByScroll("firmas");
		}, 2000);
	});

	var estaturReq = $("#estatusReq").val();
	if (estaturReq == 5) {
		$("#firmas").find(".icons").addClass("hidden");
	}

	$("#btnFirma").click(function (e) {
		try {
			// window.opener.location.reload();
		} catch (error) {}
	});

	$("#edit").click(function () {
		$(this).hide(800);
		$("#acept").hide(1000);
		$("#save").removeClass("hidden");
		$("#tablaOrden")
			.find("input, textarea")
			.attr("disabled", false)
			.css({ background: "#fff", border: "1px solid" });
		$("#checkIva").removeClass("hidden");
		$("#checkIsr").removeClass("hidden");
		$("#refresh").removeClass("hidden");
		$("#addCuota").removeClass("hidden");
		$("#notaCredito").removeAttr("disabled");
		var iva = parseInt(quitarComasNumero($("#iva").html()));
		if (iva > 0) {
			$("#checkIva").prop("checked", true);
		} else {
			$("#otroIva").hide();
		}
		var isr = parseInt(quitarComasNumero($("#isr").html()));
		if (isr > 0) {
			$("#checkIsr").prop("checked", true);
		}
	});

	$("#tablaOrden").on("blur", "#descuento", function () {
		var descuento = parseFloat($(this).val());
		var imp = parseFloat(quitarComasNumero($("#importe").html()));
		var importe = imp - descuento;
		var imporHtml = htmlNum(importe);
		$("#importe").html(imporHtml);
		if ($("#checkIva").prop("checked") == true) {
			calcularImpuestos(importe);
		} else {
			$("#subtotal").html(imporHtml);
			$("#total").html(imporHtml);
		}
	});

	$("#pagos").blur(function () {
		descuentoPago();
	});

	function quitarComasNumero(value) {
		const regex = /,/g;
		if (value != "") {
			var num = value.replace(regex, "");
			return num;
		} else {
			return 0;
		}
	}

	$("#refresh").click(function () {
		location.reload();
	});

	$("#checkIva").change(function () {
		if ($(this).prop("checked") == true) {
			$("#otroIva").show();
		} else {
			$("#iva").html("0.00");
			$("#checkIsr").prop("checked", false);
			var importe = $("#importe").html();
			$("#subtotal").html(importe);
			$("#total").html(importe);
			$("#retencion").html("");
			$("#isr").html("");
			$("#otroIva").hide();
			descuentoPago();
		}
	});

	$("#otroIva").blur(function () {
		if ($(this).val != "") {
			var imp = parseFloat(quitarComasNumero($("#importe").html()));
			calcularImpuestos(imp);
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content: "¿Desea agregar ISR?",
				type: "orange",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Si",
						btnClass: "btn btn-warning",
						action: function () {
							$("#checkIsr").prop("checked", true);
							$("#divIsr").removeClass("hidden");
							calcularImpuestos(imp);
						},
					},
					No: function () {
						$("#divIsr").addClass("hidden");
						sinRetencion(imp);
					},
				},
			});
		}
	});

	$("#checkIsr").change(function () {
		var imp = parseFloat(quitarComasNumero($("#importe").html()));
		if ($(this).prop("checked") == true) {
			calcularImpuestos(imp);
			$("#divIsr").removeClass("hidden");
			$("#checkIva").prop("checked", true);
		} else {
			$("#divIsr").addClass("hidden");
			sinRetencion(imp);
		}
	});

	$("#btnIsr").click(function () {
		if ($("#addIsr").val() != "") {
			var importe = parseFloat(quitarComasNumero($("#importe").html()));
			calcularImpuestos(importe);
			$("#retencion").html("");
			$("#retText").html("");
		}
	});

	function descuentoPago() {
		var pago = parseFloat(quitarComasNumero($("#pagos").val()));
		if (pago > 0) {
			var total = parseFloat(quitarComasNumero($("#total").html()) - pago);
			$("#total").html(htmlNum(total));
		}
	}

	function sinRetencion(imp) {
		var sub = getIva(imp);
		$("#total").html(htmlNum(sub));
		$("#retencion").html("");
		$("#isr").html("");
		descuentoPago();
	}

	function calcularImpuestos(importe) {
		var sub = getIva(importe);
		$("#subtotal").html(htmlNum(sub));
		var retencion = calcularRetencion(importe);
		var total = sub - retencion;
		$("#total").html(htmlNum(total));
		descuentoPago();
	}

	function getIva(importe) {
		var otroIva = parseFloat($("#otroIva").val().trim());
		var porcentIva = otroIva / 100;
		var iva = importe * porcentIva;
		$("#iva").html(htmlNum(iva));
		var sub = importe + iva;
		$("#subtotal").html(htmlNum(sub));
		return sub;
	}

	function calcularRetencion(importe) {
		var solicitud = $("#solicitud").val();
		var totalRet = 0;
		if ($("#checkIsr").prop("checked") == true) {
			var isr = 0;
			if ($("#addIsr").val() != "") {
				var imp = $("#addIsr").val();
				$("#isrText").html("RETENCIÓN " + imp + "%");
				var isr = importe * (parseFloat(imp) / 100);
				totalRet = isr;
			} else {
				if (solicitud == "Transporte") {
					isr = quitarComasNumero($("#servicioFletePrecio").val()) * 0.04;
					totalRet = isr;
				} else if (solicitud == "Honorarios") {
					var retencion = importe * 0.1067;
					isr = importe * 0.1;
					totalRet = isr + retencion;
					$("#retencion").html(htmlNum(retencion));
				}
			}
			$("#isr").html(htmlNum(isr));
		}
		return totalRet;
	}

	function htmlNum(num) {
		return Number(num).toLocaleString("en");
	}

	// Editar orden de compra

	$("#save").click(function () {
		var estatusOrden = $("#estatusId").val();
		if (estatusOrden == 5) {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content:
					"la orden de compra esta <b>Finalizada</b>. Se cambiara a estado en proceso y de tendra que volver a finalizar.",
				type: "orange",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Aceptar",
						btnClass: "btn btn-warning",
						action: function () {
							editarOrdenCompra();
						},
					},
					Cancelar: function () {},
				},
			});
		} else {
			editarOrdenCompra();
		}
	});

	function editarOrdenCompra() {
		var id = $("#id").val();
		var ids = $("#tablaOrden").find("input").filter("#idDetalle");
		var iva = $("#checkIva").prop("checked") == true ? 1 : 0;
		var isr = $("#checkIsr").prop("checked") == true ? 1 : 0;
		var otroIva = $("#otroIva").val().trim();
		var cuota = $("#checkCuota").prop("checked") == true ? 1 : 0;
		var nota =
			$("#notaCredito").val() != undefined
				? quitarComasNumero($("#notaCredito").val())
				: 0;
		var pagos = quitarComasNumero($("#pagos").val());
		var addIsr = 0;
		var observaciones = $("#observaciones").val();
		if (isr == 1) {
			var addIsr = $("#addIsr").val() == "" ? 0 : $("#addIsr").val();
		}
		var descuentos = [];
		var idsDesc = [];
		ids.each(function () {
			var descuento = quitarComasNumero(
				$(this).closest("div").find("#descuento").val()
			);
			idsDesc.push($(this).val());
			descuentos.push(descuento);
		});

		var datosForm = new FormData();
		datosForm.append("id", id);
		datosForm.append("iva", iva);
		datosForm.append("isr", isr);
		datosForm.append("cuota", cuota);
		datosForm.append("notaCredito", nota);
		datosForm.append("pagos", pagos);
		datosForm.append("addIsr", addIsr);
		datosForm.append("otroIva", otroIva);
		datosForm.append("descuentos", descuentos);
		datosForm.append("ids", idsDesc);
		datosForm.append("coments", observaciones);

		$.ajax({
			data: datosForm,
			processData: false,
			contentType: false,
			url: "?ajax&controller=Compras&action=editarOrdenCompra",
			type: "POST",
			dataType: "json",
			success: function (r) {
				mensajeCorrecto("Orden de compra editada.");
			},
			error: function (r) {
				console.log(r);
				mensajeError(
					"Algo salio mal, no se pudo editar la orden de compra, verifique los datos."
				);
			},
		});
	}

	$("#acept").click(function () {
		$.confirm({
			title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
			content:
				"Se actualizara orden de compra, ya no se podra editar, ¿Desea continuar?",
			type: "orange",
			typeAnimated: true,
			animation: "zoom",
			closeAnimation: "right",
			backgroundDismiss: false,
			backgroundDismissAnimation: "shake",
			buttons: {
				tryAgain: {
					text: "Aceptar",
					btnClass: "btn btn-warning",
					action: function () {
						//Estado 3 = En proceso
						updateEstatus(3);
					},
				},
				Cancelar: function () {},
			},
		});
	});

	$("#delete").click(function () {
		$.confirm({
			title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
			content: "¿Seguro que quiere eliminar la orden de compra?",
			type: "orange",
			typeAnimated: true,
			animation: "zoom",
			closeAnimation: "right",
			backgroundDismiss: false,
			backgroundDismissAnimation: "shake",
			buttons: {
				tryAgain: {
					text: "Aceptar",
					btnClass: "btn btn-warning",
					action: function () {
						//Estado 2 = Cancelada
						updateEstatus(2);
					},
				},
				Cancelar: function () {},
			},
		});
	});

	function updateEstatus(est) {
		var id = $("#id").val();
		if (id != "") {
			var datosForm = new FormData();
			datosForm.append("id", id);
			datosForm.append("estado", est);
			$.ajax({
				data: datosForm,
				processData: false,
				contentType: false,
				url: "?ajax&controller=Compras&action=updateEstadoOrdenCompra",
				type: "POST",
				dataType: "json",
				success: function (r) {
					if (est === 2) {
						window.opener.location.reload();
						mensajeCorrecto("Se elimino orden de compra.");
					} else {
						window.opener.location.reload();
						mensajeCorrecto("Se cambio estado de orden de compra.");
					}
				},
				error: function (r) {
					if (est === 2) {
						mensajeError(
							"Algo salio mal, no se pudo eliminar Orden de compra."
						);
					} else {
						mensajeError("Algo salio mal, no se pudo actualizar estado.");
					}
				},
			});
		}
	}

	function mensajeCorrecto(mnsj) {
		$.confirm({
			title: "<span class='material-icons i-correcto'>check_circle_outline</span><span>¡Correcto!<span>",
			content: mnsj,
			type: "green",
			typeAnimated: true,
			draggable: true,
			buttons: {
				tryAgain: {
					text: "Ok",
					btnClass: "btn-success",
					action: function () {
						if (window.opener != null) {
							window.opener.location.reload();
						}
						location.reload();
					},
				},
			},
		});
	}

	function mensajeError(mnsj) {
		$.confirm({
			title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
			content: mnsj,
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
						if (window.opener != null) {
							window.opener.location.reload();
						}
						location.reload();
					},
				},
			},
		});
	}

	$("#imprimirOrden").on("click", function () {
		var id = $("#id").val();
		window.open(
			serv + "?controller=Compras&action=imprimirOrdenCompra&&idOrden=" + id,
			"Imprimir Orden de Compra",
			"width=1300,height=600"
		);
	});

	//boton enviar Orden
	$("#enviarOrden").on("click", function () {
		var folio = $("#folio").text();
		var correo = $("#correoProveedor").text();
		$("#folioOrden").text(folio);
		$("#correoModal").val(correo);
		if ($("#archivoCotizacion").length == 0) {
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

	$("#enviarOrdenModal").on("click", "#eliminarCorreo", function () {
		$(this)
			.parent()
			.hide(1000, function () {
				$(this).remove();
			});
	});

	//funcion enviar Orden de compra por correo
	$("#enviarCorreoOrden").click(function () {
		$(this).attr("disabled", true);
		var valid = true;
		var id = $("#id").val();
		var folio = $("#folio").text();
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

	$("#agregarCorreo").on("click", function () {
		var label =
			'<div class="div-labl-correo text-right mr-1"><label>CC:</label></div>';
		var input =
			'<div class="ui-widget"><input type="text" name="correoModal[]" id="fillCorreo" class="item-correo correo-user"></div>';
		var icono =
			'<span title="Eliminar correo" class="material-icons icons i-delete p-1" id="eliminarCorreo">delete_forever</span>';
		$("#correo1").after(
			'<div class="row mb-2">' + label + input + icono + "</div>"
		);
	});

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
					"Algo salio mal, no se encontro cliente, contacte al administrador del sistema"
				);
			},
		});
		return directorio;
	}

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
			title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>!",
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
	$("#showCotizacion").click(function () {
		var cotizacion = $("#archivoCotizacion").html();
		$("#tituloCotizacion").html("Cotización: " + cotizacion);
		var url = serv + "views/compras/uploads/cotizaciones/" + cotizacion;
		$("#viewCot").append(
			'<object class="view-cot" id="objCot" data=""></object>'
		);
		$("#objCot").attr("data", url);
		$("#modalCotizacion").modal("show");
	});

	$("#modalCotizacion").on("hidden.bs.modal", function () {
		$("#objCot").remove();
	});

	//Calcular cuota exenta
	$("#checkCuota").change(function () {
		var imp = parseFloat(quitarComasNumero($("#importe").html()));
		if ($(this).prop("checked") == true) {
			$("#checkIva").prop("checked", true);
			var cantidad = parseFloat(
				quitarComasNumero($("#cantidadTotal").val())
			);
			var exent = cantidad * 1000 * 0.374675;
			var impIva = imp - exent;
			var iva = impIva * 0.16;
			$("#iva").html(htmlNum(iva));
			var sub = imp + iva;
			$("#subtotal").html(htmlNum(sub));
			$("#subtotal").html(htmlNum(sub));
			$("#total").html(htmlNum(sub));
			descuentoPago();
		} else {
			$("#divIsr").addClass("hidden");
			calcularImpuestos(imp);
		}
	});

	$("#imprimirReq").on("click", function () {
		var id = $("#idReq").val();
		window.open(
			serv + "?controller=Compras&action=imprimirRequisicion&idReq=" + id,
			"Imprimir Requisición",
			"width=1300,height=600"
		);
	});

	//función finalizar orden
	$("#cerrarOrden").click(function () {
		var id = $("#id").val();
		var folio = $("#folio").html();
		if (id != "") {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content:
					"Cerrar orden de compra <strong>" +
					folio +
					"</strong> a la orden de compra?",
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

	$("#imprimirEvaluacion").on("click", function () {
		var idProv = $("#idProv").val();
		var fechaIni = $("#fechaInicio").val();
		var fechaFin = $("#fechaFin").val();
		window.open(
			"?controller=Catalogo&action=evaluarProveedor&idProv=" +
				idProv +
				"&fechaIni=" +
				fechaIni +
				"&fechaFin=" +
				fechaFin +
				"&imprimir",
			"Evaluación proveedor",
			"width=1300,height=650"
		);
	});
});

function goToByScroll(id) {
	// Remove "link" from the ID
	id = id.replace("link", "");
	// Scroll
	$("html,body").animate(
		{
			scrollTop: $("#" + id).offset().top - 80,
		},
		"slow"
	);
}
