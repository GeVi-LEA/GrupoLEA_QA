$(document).ready(function () {
	let serv = ""; // = __url__; //"http://localhost/GrupoLEA/";
	if (typeof __url__ != "undefined") {
		serv = __url__;
	} else {
		serv = localStorage.getItem("_URL_"); // = __url__
	}

	$("#cancel").hide();
	$("#divDatos").hide();
	$("#save").hide();

	$("input, select").on("click", function () {
		$(this).removeClass("required");
	});

	$("#entradaSalida").click(function (e) {
		e.preventDefault();
		window.open(
			serv + "?controller=Servicios&action=crearEntrada",
			"Entradas / Salidas",
			"width=1300,height=300"
		);
	});

	$("#fechaPrograma").datepicker({
		showOn: "button",
		buttonText: "<span class='fas fa-calendar-alt i-calendar'></span>",
	});

	$("#fechaPrograma").click(function () {
		var fecha = $(this);
		if ($(fecha).val() != "") {
			$.confirm({
				title: "<span class='material-icons i-danger'>dangerous</span><span>¡Atención!<span>",
				content: "¿Borrar fecha?",
				type: "red",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Borrar",
						btnClass: "btn-red",
						action: function () {
							$(fecha).val("");
						},
					},
					Cancelar: function () {},
				},
			});
		}
	});

	$("#preciosServClientes").click(function () {
		window.open(
			serv + "?controller=Servicios&action=clientesServicios",
			"Precios clientes - servicios",
			"width=1300,height=700"
		);
	});

	$("#new").on("click", function (e) {
		e.preventDefault();
		$("#save").show(1000);
		$("#cancel").show(1000);
		$("#divDatos").show(1000);
		$(this).hide(500);
	});

	$("#ticket").blur(function () {
		getPesos();
	});

	$("#save").click(function (e) {
		e.preventDefault();
		if (validarFormularioServicio()) {
			$.ajax({
				data: $("#formServicioCliente").serialize(),
				url: "?ajax&controller=Servicios&action=saveServicioCliente",
				type: "POST",
				dataType: "json",
				success: function (r) {
					if (r.error) {
						mensajeCorrecto(r.mensaje);
					} else {
						mensajeError(r.mensaje);
					}
				},
				error: function (r) {
					console.log(r.responseText);
					mensajeError("Algo salio mal, contacte al administrador.");
				},
			});
		} else {
			mensajeError("Complete los datos solicitados.");
		}
	});

	$("#tablaServicioCliente").on("click", "#delete", function () {
		var del = $(this);
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
						var trSelect = $(del).parent().closest("td");
						var id = trSelect.find("#idTabla").html();
						if (id != "") {
							$.ajax({
								data: { id: id },
								url: "?ajax&controller=Servicios&action=deleteServicioCliente",
								type: "POST",
								dataType: "json",
								success: function (r) {
									if (r.error) {
										mensajeCorrecto(r.mensaje);
									} else {
										mensajeError(r.mensaje);
									}
								},
								error: function () {
									alert(
										"Algo salio mal, contacte al administrador del sistema"
									);
								},
							});
						}
					},
				},
				Cancelar: function () {},
			},
		});
	});

	$("#tablaServicioCliente").on("click", "#edit", function () {
		var trSelect = $(this).parent().closest("td");
		var tr = $(this).parent().closest("tr");
		var id = trSelect.find("#idTabla").html();
		if (id != "") {
			$("#divDatos").show(1000);
			$("#save").show(1000);
			$("#cancel").show(1000);
			$("#new").hide(1000);
			$("input, select").removeClass("required");
			$("#tablaServicioCliente").find(".i-edit, .i-delete").hide();
			$(trSelect).addClass("selected-editar-back");
			$(tr).addClass("selected-editar");
			$.ajax({
				data: { id: id },
				url: "?ajax&controller=Servicios&action=servicioClienteById",
				type: "POST",
				dataType: "json",
				success: function (r) {
					if (r.length != 0) {
						$("#cliente").val(r.cliente_id);
						$("#servicio").val(r.servicio_id);
						$("#id").val(r.id);
						$("#costo").val(htmlNum(r.costo));
						$("#unidad").val(r.unidad_id);
						$("#moneda").val(r.moneda);
						$("#empaque").val(r.tipo_empaque_id);
						$("#descripcion").val(r.descripcion);
						$("#clave").val(r.clave);
					}
				},
				error: function () {
					alert("Algo salio mal, contacte al administrador del sistema");
				},
			});
		}
	});

	$("#servicio").on("change", function () {
		var id = $(this).val();
		if (id != "") {
			$.ajax({
				data: { idServ: id },
				url: "?ajax&controller=Catalogo&action=getServicioById",
				type: "POST",
				dataType: "json",
				success: function (r) {
					if (r.length != 0) {
						console.log(r[0]);
						$("#descripcion").val(r[0].descripcion);
						$("#clave").val(r[0].clave);
					}
				},
				error: function () {
					alert("Algo salio mal, contacte al administrador del sistema");
				},
			});
		}
	});

	$("#tara").blur(function () {
		if (isNumeric($(this).val())) {
			calcularPesos();
		} else {
			mensajeError("Peso debe de ser numerico.");
		}
	});

	$("#pesoCliente").blur(function () {
		if (isNumeric($(this).val())) {
			calcularPesos();
		} else {
			mensajeError("Peso debe de ser numerico.");
		}
	});

	$("#costo").blur(function () {
		var costo = $(this).val();
		if (isNumeric(costo)) {
			$("#costo").val(htmlNum(quitarComasNumero(costo)));
		} else {
			mensajeError("Peso debe de ser numerico.");
		}
	});

	$("#btnSalir").click(function (e) {
		e.preventDefault();
		window.close();
	});

	function calcularPesos() {
		var pesoBruto = quitarComasNumero($("#pesoBruto").val());
		var tara = quitarComasNumero($("#tara").val());
		var taraKilos = parseInt(Math.round(tara * 0.453592));
		var pesoCliente = quitarComasNumero($("#pesoCliente").val());
		var pesoTeorico = pesoBruto - taraKilos;
		var diferenciaTeorica = pesoTeorico - pesoCliente;
		var tolerable = parseInt(Math.round(pesoCliente * 0.003));
		$("#tolerable").val(htmlNum(tolerable));
		$("#taraKilos").val(htmlNum(taraKilos));
		$("#pesoTeorico").val(htmlNum(pesoTeorico));
		$("#diferenciaTeorica").val(htmlNum(diferenciaTeorica));
		$("#pesoCliente").val(htmlNum(pesoCliente));
		$("#tara").val(htmlNum(tara));
		diferenciaTeoricaColor(diferenciaTeorica, tolerable);
	}

	if (
		$("#diferenciaTeorica").val() != "" &&
		$("#diferenciaTeorica").val() != undefined
	) {
		var diferenciaTeorica = quitarComasNumero($("#diferenciaTeorica").val());
		var tolerable = quitarComasNumero($("#tolerable").val());
		diferenciaTeoricaColor(diferenciaTeorica, tolerable);
	}

	function diferenciaTeoricaColor(diferenciaTeorica, tolerable) {
		if (
			Math.sign(diferenciaTeorica) == -1 &&
			Math.abs(diferenciaTeorica) > tolerable
		) {
			$("#diferenciaTeorica").removeClass("green");
			$("#diferenciaTeorica").addClass("warning");
		} else {
			$("#diferenciaTeorica").removeClass("warning");
			$("#diferenciaTeorica").addClass("green");
		}
	}

	if (
		$("#diferenciaReal").val() != "" &&
		$("#diferenciaReal").val() != undefined
	) {
		var diferenciaTeorica = quitarComasNumero($("#diferenciaReal").val());
		var tolerable = quitarComasNumero($("#tolerable").val());
		if (
			Math.sign(diferenciaTeorica) == -1 &&
			Math.abs(diferenciaTeorica) > tolerable
		) {
			$("#diferenciaReal").removeClass("green");
			$("#diferenciaReal").addClass("warning");
		} else {
			$("#diferenciaReal").removeClass("warning");
			$("#diferenciaReal").addClass("green");
		}
	}

	$("#btnGuardar").click(function (e) {
		e.preventDefault();
		if (validarDatosEnsacado()) {
			$("#ensacadoForm").find("input, select").removeAttr("disabled");
			var datosForm = new FormData($("#ensacadoForm")[0]);
			$.ajax({
				data: datosForm,
				enctype: "multipart/form-data",
				processData: false,
				contentType: false,
				url: "?ajax&controller=Servicios&action=guardarEnsacado",
				type: "POST",
				dataType: "json",
				success: function (r) {
					console.log(r);
					if (r.error) {
						mensajeCorrecto(r.mensaje);
					} else {
						mensajeError(r.mensaje);
					}
				},
				error: function (r) {
					console.log(r.responseText);
					mensajeError("Algo salio mal,  contacte al administrador.");
				},
			});
		} else {
			mensajeError("Complete los datos solicitados.");
		}
	});

	$("#cancel").click(function () {
		$("#formServicioCliente").trigger("reset");
		$("input, select").removeClass("required");
		$("#tablaServicioCliente").find(".i-edit, .i-delete").show();
		$("#tablaServicioCliente").find("td").removeClass("selected-editar-back");
		$("#tablaServicioCliente").find("tr").removeClass("selected-editar");
		$("#divDatos").hide(1000);
		$("#save").hide(1000);
		$("#cancel").hide(1000);
		$("#new").show(1000);
	});

	function validarFormularioServicio() {
		var valid = true;
		if ($("#cliente").val() == "") {
			$("#cliente").addClass("required");
			valid = false;
		}
		if ($("#servicio").val() == "") {
			$("#servicio").addClass("required");
			valid = false;
		}
		if (!isNumeric($("#costo").val()) || $("#servicio").val() == "") {
			$("#costo").addClass("required");
			mensajeError("Precio debe de ser número.");
			valid = false;
		}
		if ($("#unidad").val() == "") {
			$("#unidad").addClass("required");
			valid = false;
		}
		if ($("#moneda").val() == "") {
			$("#moneda").addClass("required");
			valid = false;
		}
		if ($("#precio").val() == "") {
			$("#precio").addClass("required");
			valid = false;
		}
		return valid;
	}

	$('input[name="ferrotolva"]').change(function () {
		cambiaFerrotolva($(this).val());
	});
	//   const cambiaFerrotolva = (ferrotolva) => {

	function validarDatosEnsacado() {
		var valid = true;
		if ($("#numeroUnidad").val() == "") {
			$("#numeroUnidad").addClass("required");
			valid = false;
		}
		if ($("#cliente").val() == "") {
			$("#cliente").addClass("required");
			valid = false;
		}

		if (
			$("#transporte").val() == "" &&
			$('input[name="ferrotolva"]').val() == "C"
		) {
			$("#transporte").addClass("required");
			valid = false;
		}
		return valid;
	}

	function validarDatosServicio() {
		var valid = true;
		if ($("#idTipoServicio").val() == "") {
			$("#idTipoServicio").addClass("required");
			valid = false;
		}
		if ($("#lote").val() == "") {
			var servicio = $("#idTipoServicio option:selected").text();
			if (servicio.includes("CARGA") || servicio.includes("AJUSTE")) {
				if ($("#loteSelect").val() == "") {
					valid = false;
					$("#loteSelect").addClass("required");
				}
			} else if (
				servicio.includes("ENSACADO") ||
				servicio.includes("ALMACENAJE") ||
				servicio.includes("ALMACEN") ||
				servicio.includes("TRASPALEO") ||
				servicio.includes("REEMPAQUE") ||
				servicio.includes("ETIQUETA")
			) {
				if ($("#loteServ").val() == "") {
					valid = false;
					$("#loteSelect").addClass("required");
				}
			}
		}
		return valid;
	}

	$("#agregarServicioModal").on("change", "#idTipoServicio", function () {
		agregarLotesEnsacado($("#agregarServicioModal"));
	});

	function agregarLotesEnsacado(form) {
		var servicio = $(form).find($("#idTipoServicio option:selected")).text();
		var lote = $(form).find($("#lote"));
		var selectLote = $(form).find($("#loteSelect"));
		if (servicio.includes("CARGA") || servicio.includes("AJUSTE")) {
			lote.attr("disabled", true).attr("hidden", true);
			selectLote.attr("disabled", false).attr("hidden", false);
			var clienteId = $("#cliente").val();
			$.ajax({
				data: { idCliente: clienteId },
				url: "?ajax&controller=Servicios&action=getLotesByClienteStock",
				type: "POST",
				dataType: "json",
				success: function (r) {
					console.log(r);
					if (r != false) {
						selectLote.find("option").not(":first").remove();
						if (r.length != 0) {
							$(r).each(function (i, v) {
								// indice, valor
								selectLote.append(
									'<option value="' +
										v.lote +
										'">' +
										v.lote +
										" - " +
										v.nombre +
										" - " +
										v.alias +
										"</option>"
								);
							});
						} else {
							selectLote.append(
								'<option value="" disabled>No hay lotes registrados</option>'
							);
						}
					}
				},
				error: function () {
					alert("Algo salio mal, contacte al Administrador.");
				},
			});
		} else if (
			servicio.includes("ENSACADO") ||
			servicio.includes("ALMACENAJE") ||
			servicio.includes("TRASPALEO") ||
			servicio.includes("REEMPAQUE")
		) {
			lote.attr("disabled", false).attr("hidden", false);
			selectLote.attr("disabled", true).attr("hidden", true);
			$("#productoServ").val("").attr("disabled", false);
			$("#aliasServ").attr("disabled", false);
		} else {
			$(lote).attr("hidden", true);
			$(selectLote).attr("hidden", true);
			$("#productoServ").val("").attr("disabled", true);
			$("#aliasServ").attr("disabled", true);
		}
	}

	$("#btnNuevoServicio").click(function () {
		$("#agregarServicioModal").modal("show");
		setTimeout(() => {
			console.log("aqui");
			$("#formAgregarServicio #producto").select2();
			$("#producto").change(function () {
				$("#alias").val($("#producto option:selected").text());
			});
		}, 1000);
	});

	$("#agregarServicioModal").on("hidden.bs.modal", function () {
		$("#formAgregarServicio").trigger("reset");
	});

	$("#editarServicioModal").on("hidden.bs.modal", function () {
		$("#formEditarServicio").trigger("reset");
	});

	$("#tablaRegistros").on("click", "#showEnsacado", function (e) {
		var tr = $(this).closest("tr");
		e.preventDefault();
		var id = tr.find("#idEnsacado").html();
		if (id != "") {
			window.open(
				serv + "?controller=Servicios&action=generarEnsacado&id=" + id,
				"Ensacado",
				"width=1300,height=700"
			);
		}
	});

	$("#ensacadoForm, #formEditarServicio, #seccionServicios").on(
		"click",
		"#show",
		function () {
			$("#editarServicioModal").modal("hide");
			var div = $(this).parent("div");
			var ferro = $("#numeroUnidad").val();
			var docInput = $(div).children("input")[2];
			var doc = $(docInput).val();
			$("#tituloDocumento").html("Archivo: " + doc);
			var url = "views/servicios/uploads/" + ferro + "/" + doc;
			console.log(docInput);
			$("#viewDoc").append(
				'<object class="view-doc" id="objDoc" data=""></object>'
			);
			$("#objDoc").attr("data", url);
			$("#modalDocumento").modal("show");
		}
	);

	$("#modalDocumento").on("hidden.bs.modal", function () {
		$("#objDoc").remove();
	});

	$("#ensacadoForm, #formEditarServicio").on("click", "#delete", function () {
		var tipo = 0;
		var del = $(this);
		var div = $(this).closest("div");
		var show = $(div).find("#show");
		var addDoc = $(div).find("#addDocumento");
		var doc = $(div).children("input")[2];
		var id = $(this).closest("form").find("#id").val();
		if (id != "") {
			var ferro = $("#numeroUnidad").val();
			var documentoTipo = $(doc).attr("id");
			var documento = $(doc).val();
			if (documentoTipo == "archivoBill") {
				tipo = 1;
			} else if (documentoTipo == "archivoTicket") {
				tipo = 2;
			} else if (documentoTipo == "archivoOrden") {
				tipo = 3;
			}
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content: "Se eliminara Archivo: <strong>" + documento + "</strong>",
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
							$.ajax({
								data: {
									id: id,
									ferrotolva: ferro,
									tipo: tipo,
									documento: documento,
								},
								url: "?ajax&controller=Servicios&action=eliminarDocumento",
								type: "POST",
								dataType: "json",
								success: function (r) {
									console.log(r);
									if (r.error) {
										mensajeCorrecto(r.mensaje);
										$(doc).val("");
										$(del).hide(500);
										$(show).hide(500);
										$(addDoc).show(500);
									} else {
										console.log(r);
										mensajeError(r.mensaje);
									}
								},
								error: function () {
									alert(
										"Algo salio mal, no se pudo borrar el archivo, contacte al administrador del sistema"
									);
								},
							});
						},
					},
					Cancelar: function () {},
				},
			});
		} else {
			$(doc).val("");
			$(this).hide(500);
		}
	});

	$("#documentoBill").change(function () {
		agregarArchivo($(this));
	});

	$("#documentoTicket").change(function () {
		agregarArchivo($(this));
	});

	$("#documentoOrden").change(function () {
		var input = $(this);
		agregarArchivo(input);
	});

	function agregarArchivo(inputFile) {
		var div = $(inputFile).closest("div");
		var doc = $(div).children("input")[0];
		if ($(doc).val() != "") {
			var tipoArchivo = $(inputFile).prop("files")[0].name;
			if (
				tipoArchivo.toLowerCase().includes(".pdf") ||
				tipoArchivo.toLowerCase().includes(".jpg") ||
				tipoArchivo.toLowerCase().includes(".jpeg") ||
				tipoArchivo.toLowerCase().includes(".png")
			) {
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
								$(div).find("#addDocumento").hide();
								$(div).find("#delete").removeAttr("hidden");
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
						"</strong> <br/> Formatos aceptados: <strong>.pdf, .png, .gif, .jpeg, .jpg. </strong>",
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
								inputFile.val("");
							},
						},
					},
				});
			}
		} else {
			$(doc).addClass("required");
			$(inputFile).val("");
			mensajeError("Debe de agregar número.");
		}
	}

	if ($("#archivoTicket").val() != "") {
		var div = $("#archivoTicket").closest("div");
		$(div).find("#addDocumento").hide();
		$(div).find("#show, #delete").removeAttr("hidden");
	}

	if ($("#archivoBill").val() != "") {
		var div = $("#archivoBill").closest("div");
		$(div).find("#addDocumento").hide();
		$(div).find("#show, #delete").removeAttr("hidden");
	}

	$("#seccionServicios").on("click", "#editarServicio", function () {
		var div = $(this).parent("div").parent("div");
		var id = $(div).find("#idServicio").val();
		if (id != "") {
			$.ajax({
				data: { id: id },
				url: "?ajax&controller=Servicios&action=getServicio",
				type: "POST",
				dataType: "json",
				success: function (r) {
					console.log(r);
					if (r != false) {
						$("#folioServicio").html(r.folio);
						var formEditar = $("#formEditarServicio");
						formEditar.find("#id").val(r.id);
						formEditar.find("#idTipoServicio").val(r.servicio_id);
						formEditar.find("#idEntrada").val(r.entrada_id);
						formEditar.find("#idEmpaque").val(r.empaque_id);
						formEditar.find("#orden").val(r.orden);
						formEditar.find("#estatus").val(r.estatus_id);
						formEditar.find("#lote").val(r.lote);
						formEditar.find("#producto").val(r.producto_id);
						formEditar.find("#alias").val(r.alias);
						formEditar
							.find("#cantidad")
							.val(r.cantidad != null ? htmlNum(r.cantidad) : "");
						formEditar
							.find("#totalEnsacado")
							.val(
								r.total_ensacado != null
									? htmlNum(r.total_ensacado)
									: ""
							);
						formEditar
							.find("#fechaInicio")
							.val(
								r.fecha_inicio != null
									? formatDateHourToString(new Date(r.fecha_inicio))
									: ""
							);
						formEditar
							.find("#fechaFin")
							.val(
								r.fecha_fin != null
									? formatDateHourToString(new Date(r.fecha_fin))
									: ""
							);
						formEditar
							.find("#fechaPrograma")
							.val(
								r.fecha_programacion != null
									? formatDateToString(new Date(r.fecha_programacion))
									: ""
							);
						formEditar
							.find("#bultos")
							.val(r.bultos != null ? htmlNum(r.bultos) : "");
						formEditar
							.find("#tarimas")
							.val(r.tarimas != null ? htmlNum(r.tarimas) : "");
						formEditar
							.find("#tipoTarima")
							.val(r.tipo_tarima != null ? htmlNum(r.tipo_tarima) : "");
						formEditar
							.find("#parcial")
							.val(r.parcial != null ? htmlNum(r.parcial) : "");
						formEditar
							.find("#barreduraSucia")
							.val(
								r.barredura_sucia != null
									? htmlNum(r.barredura_sucia)
									: ""
							);
						formEditar
							.find("#barreduraLimpia")
							.val(
								r.barredura_limpia != null
									? htmlNum(r.barredura_limpia)
									: ""
							);
						var barredura =
							Number(r.barredura_sucia) + Number(r.barredura_limpia);
						formEditar
							.find("#barredura")
							.val(barredura != 0 ? htmlNum(barredura) : "");
						formEditar.find("#observaciones").val(r.observaciones);
						var arch = formEditar.find("#archivoOrden");
						$(arch).val(r.doc_orden);
						var div = $(arch).closest("div");
						if (r.doc_orden.trim() != "") {
							$(div).find("#addDocumento").hide();
							$(div).find("#show, #delete").removeAttr("hidden");
						} else {
							$(div).find("#show, #delete").attr("hidden", true);
							$(div).find("#addDocumento").show();
						}
						var servicio = r.servicio;
						if (
							servicio.includes("CARGA") ||
							servicio.includes("AJUSTE")
						) {
							formEditar
								.find("#lote")
								.attr("disabled", true)
								.attr("hidden", true);
							formEditar
								.find("#loteSelect")
								.attr("disabled", false)
								.attr("hidden", false);
						} else if (
							servicio.includes("ENSACADO") ||
							servicio.includes("ALMACENAJE") ||
							servicio.includes("TRASPALEO") ||
							servicio.includes("REEMPAQUE")
						) {
							formEditar
								.find("#lote")
								.attr("disabled", false)
								.attr("hidden", false);
							formEditar
								.find("#loteSelect")
								.attr("disabled", true)
								.attr("hidden", true);
							formEditar
								.find("#productoServ")
								.val("")
								.attr("disabled", false);
							formEditar.find("#aliasServ").attr("disabled", false);
						} else {
							formEditar.find("#lote").attr("hidden", true);
							formEditar.find("#loteSelect").attr("hidden", true);
							formEditar
								.find("#productoServ")
								.val("")
								.attr("disabled", true);
							formEditar.find("#aliasServ").attr("disabled", true);
						}
						$("#editarServicioModal").modal("show");
					} else {
						mensajeError("Error, revisar id de servicio.");
					}
				},
				error: function (r) {
					console.log(r.responseText);
					mensajeError("Algo salio mal,  contacte al administrador.");
				},
			});
		}
	});

	$("#barreduraSucia").blur(function () {
		var bs = $(this).val();
		if (isNumeric(bs)) {
			var bl = quitarComasNumero($("#barreduraLimpia").val());
			$("#barredura").val(htmlNum(quitarComasNumero(bs) + bl));
			$(this).val(htmlNum(quitarComasNumero(bs)));
		} else {
			$(this).addClass("required");
			mensajeError("Debe de ser número.");
		}
	});

	$("#barreduraLimpia").blur(function () {
		var bs = $(this).val();
		if (isNumeric(bs)) {
			var bl = quitarComasNumero($("#barreduraSucia").val());
			$("#barredura").val(htmlNum(quitarComasNumero(bs) + bl));
			$(this).val(htmlNum(quitarComasNumero(bs)));
		} else {
			$(this).addClass("required");
			mensajeError("Debe de ser número.");
		}
	});

	$("#seccionServicios").on("click", "#deleteServicio", function () {
		var div = $(this).parent("div").parent("div");
		var id = $(div).find("#idServicio").val();
		if (id != "") {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content: "<b>Desea eliminar el servicio?</b>",
				type: "orange",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Eliminar servicio",
						btnClass: "btn btn-warning",
						action: function () {
							$.ajax({
								data: { id: id },
								url: "?ajax&controller=Servicios&action=eliminarServicioNave",
								type: "POST",
								dataType: "json",
								success: function (r) {
									console.log(r);
									if (r != false) {
										mensajeCorrecto(r.mensaje);
									} else {
										mensajeError(r.mensaje);
									}
								},
								error: function (r) {
									console.log(r.responseText);
									mensajeError(
										"Algo salio mal,  contacte al administrador."
									);
								},
							});
						},
					},
					Cancelar: function () {},
				},
			});
		}
	});

	$("#cantidad").change(function () {
		var cant = $(this).val();
		if (cant != "") {
			$(this).val(htmlNum(quitarComasNumero(cant)));
		}
	});

	$("#totalEnsacado").blur(function () {
		if (isNumeric($(this).val())) {
			var total = quitarComasNumero($(this).val());
			var formEditar = $("#formEditarServicio");
			var bultos = total / 25;
			formEditar.find("#totalEnsacado").val(htmlNum(total));
			formEditar.find("#bultos").val(htmlNum(Math.ceil(bultos)));
			formEditar.find("#tarimas").val(htmlNum(Math.floor(bultos / 55)));
			var parcial =
				parseFloat("." + (bultos / 55).toString().split(".")[1]) * 55;
			formEditar.find("#parcial").val(htmlNum(Math.round(parcial)));
		} else {
			$(this).addClass("required");
		}
	});

	$("#seccionServicios").on("click", "#iniciarServicio", function () {
		var div = $(this).parent("div").parent("div");
		var id = $(div).find("#idServicio").val();
		var nombreServicio = $(div).find("#nombreServicio").text();
		if (
			nombreServicio.includes("ENSACADO") ||
			nombreServicio.includes("ALMACENAJE") ||
			nombreServicio.includes("TRASPALEO") ||
			nombreServicio.includes("REEMPAQUE")
		) {
			var ticket = $("#ticket").val();
			if (ticket != "") {
				iniciarServicio(id);
			} else {
				mensajeError("Debe de primero agregar ticket.");
			}
		}
	});

	$("#tablaRegistros").on("click", "#iniciarServicio", function (e) {
		var tr = $(this).closest("tr");
		e.preventDefault();
		var id = tr.find("#idServicio").html();
		if (id != "") {
			iniciarServicio(id);
		}
	});

	function iniciarServicio(id) {
		alert(id);
		$.confirm({
			title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
			content: "<b>¿Iniciar servicio?</b>",
			type: "orange",
			typeAnimated: true,
			animation: "zoom",
			closeAnimation: "right",
			backgroundDismiss: false,
			backgroundDismissAnimation: "shake",
			buttons: {
				tryAgain: {
					text: "Iniciar servicio",
					btnClass: "btn btn-warning",
					action: function () {
						$.ajax({
							data: { id: id },
							url: "?ajax&controller=Servicios&action=iniciarServicio",
							type: "POST",
							dataType: "json",
							success: function (r) {
								console.log(r);
								if (r != false) {
									mensajeCorrecto(r.mensaje);
								} else {
									mensajeError(r.mensaje);
								}
							},
							error: function (r) {
								console.log(r.responseText);
								mensajeError(
									"Algo salio mal,  contacte al administrador."
								);
							},
						});
					},
				},

				Cancelar: function () {},
			},
		});
	}

	$("#btnSalida").click(function () {
		$.confirm({
			title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
			content: "<b>¿Desea dar salida a la unidad?</b>",
			type: "orange",
			typeAnimated: true,
			animation: "zoom",
			closeAnimation: "right",
			backgroundDismiss: false,
			backgroundDismissAnimation: "shake",
			buttons: {
				tryAgain: {
					text: "Salida",
					btnClass: "btn btn-warning",
					action: function () {
						var id = $("#ensacadoForm").find("#id").val();
						if (id != "") {
							$.ajax({
								data: { id: id },
								url: "?ajax&controller=Servicios&action=salidaUnidad",
								type: "POST",
								dataType: "json",
								success: function (r) {
									console.log(r);
									if (r.error != false) {
										mensajeCorrecto(r.mensaje);
									} else {
										mensajeError(r.mensaje);
									}
								},
								error: function (r) {
									console.log(r.responseText);
									mensajeError(
										"Algo salio mal,  contacte al administrador."
									);
								},
							});
						}
					},
				},
				Cancelar: function () {},
			},
		});
	});

	$("#btnIngresar").click(function () {
		$.confirm({
			title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
			content: "<b>¿Desea ingresar la unidad?</b>",
			type: "orange",
			typeAnimated: true,
			animation: "zoom",
			closeAnimation: "right",
			backgroundDismiss: false,
			backgroundDismissAnimation: "shake",
			buttons: {
				tryAgain: {
					text: "Ingresar",
					btnClass: "btn btn-warning",
					action: function () {
						var id = $("#ensacadoForm").find("#id").val();
						if (id != "") {
							$.ajax({
								data: { id: id },
								url: "?ajax&controller=Servicios&action=ingresarUnidad",
								type: "POST",
								dataType: "json",
								success: function (r) {
									console.log(r);
									if (r.error != false) {
										mensajeCorrecto(r.mensaje);
									} else {
										mensajeError(r.mensaje);
									}
								},
								error: function (r) {
									console.log(r.responseText);
									mensajeError(
										"Algo salio mal,  contacte al administrador."
									);
								},
							});
						}
					},
				},
				Cancelar: function () {},
			},
		});
	});

	$("#btnTransito").click(function () {
		$.confirm({
			title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
			content: "<b>¿Desea poner en transito la unidad?</b>",
			type: "orange",
			typeAnimated: true,
			animation: "zoom",
			closeAnimation: "right",
			backgroundDismiss: false,
			backgroundDismissAnimation: "shake",
			buttons: {
				tryAgain: {
					text: "Transito",
					btnClass: "btn btn-warning",
					action: function () {
						var id = $("#ensacadoForm").find("#id").val();
						if (id != "") {
							$.ajax({
								data: { id: id },
								url: "?ajax&controller=Servicios&action=transitoUnidad",
								type: "POST",
								dataType: "json",
								success: function (r) {
									console.log(r);
									if (r.error != false) {
										mensajeCorrecto(r.mensaje);
									} else {
										mensajeError(r.mensaje);
									}
								},
								error: function (r) {
									console.log(r.responseText);
									mensajeError(
										"Algo salio mal,  contacte al administrador."
									);
								},
							});
						}
					},
				},
				Cancelar: function () {},
			},
		});
	});
	//agregar a almacen

	$("#seccionServicios").on("click", "#detenerServicio", function () {
		var divForm = $(this).parents("div")[2];
		var nombreServicio = $(divForm).find("#nombreServicio").text();
		var form = $("#formEnviarAlmacen");

		if (
			nombreServicio.includes("ENSACADO") ||
			nombreServicio.includes("ALMACENAJE") ||
			nombreServicio.includes("TRASPALEO") ||
			nombreServicio.includes("REEMPAQUE")
		) {
			var select = $(form).find("#selectAlmacen");
			console.log("select");
			console.log(select);
			$.ajax({
				url: "?ajax&controller=Catalogo&action=getAlmacenes",
				type: "POST",
				dataType: "json",
				success: function (r) {
					console.log(r);
					if (r != false) {
						select.find("option").not(":first").remove();
						if (r.length != 0) {
							$(r).each(function (i, v) {
								// indice, valor
								select.append(
									'<option value="' +
										v.id +
										'">' +
										v.nombre +
										"</option>"
								);
							});
						} else {
							select.append(
								'<option value="" disabled>No hay almacenes registrados</option>'
							);
						}
					}
				},
				error: function () {
					alert("Algo salio mal, contacte al Administrador.");
				},
			});
			$(form)
				.find($("#idServicioEnviar"))
				.val($(divForm).find("#idServicio").val());
			$(form).find($("#operacionEnviar")).val("E");
			$("#enviarAlmacenModal").modal("show");
		}
	});

	$("#enviarFinalizarServicio").click(function () {
		if (validarDatosEnviarAlmacen()) {
			$.confirm({
				title: "<span class='material-icons i-warning'>warning</span><span>¡Atención!<span>",
				content: "<b>¿Finalizar servicio?</b>",
				type: "orange",
				typeAnimated: true,
				animation: "zoom",
				closeAnimation: "right",
				backgroundDismiss: false,
				backgroundDismissAnimation: "shake",
				buttons: {
					tryAgain: {
						text: "Finalizar servicio",
						btnClass: "btn btn-warning",
						action: function () {
							$.ajax({
								data: $("#formEnviarAlmacen").serialize(),
								url: "?ajax&controller=Servicios&action=finalizarServicio",
								type: "POST",
								dataType: "json",
								success: function (r) {
									console.log(r);
									if (r.error != false) {
										mensajeCorrecto(r.mensaje);
									} else {
										mensajeError(r.mensaje);
									}
								},
								error: function (r) {
									console.log(r.responseText);
									mensajeError(
										"Algo salio mal,  contacte al administrador."
									);
								},
							});
						},
					},
					Cancelar: function () {},
				},
			});
		} else {
			mensajeError("No puede estar un campo vacio.");
		}
	});

	function validarDatosEnviarAlmacen() {
		var form = $("#formEnviarAlmacen");
		var inputs = $(form).find("input, select");
		var valid = true;
		inputs.each(function () {
			if ($(this).val() == null || $(this).val() == "") {
				$(this).addClass("required");
				valid = false;
				console.log(this);
			}
		});
		return valid;
	}

	$("#enviarAlmacenModal").on("hidden.bs.modal", function () {
		$("#formEnviarAlmacen").trigger("reset");
		$("#formEnviarAlmacen #divAlmacenes").not(":first").remove();
	});

	$("#formEnviarAlmacen").on("change", "#cantidadEnviar", function () {
		var cantidad = $(this).val();
		if (isNumeric(cantidad)) {
			$(this).val(htmlNum(cantidad));
		} else {
			mensajeError("Cantidad debe de ser número.");
			$(this).val("");
		}
	});

	$("#agregarAlmacen").click(function () {
		var cant = $("#divAlmacenes").find("#cantidadEnviar").val();
		var almacen = $("#divAlmacenes").find("#selectAlmacen").val();
		if (cant != "" && almacen != "") {
			$("#divAlmacenes").clone().appendTo("#formEnviarAlmacen");
			var div = $("#formEnviarAlmacen #divAlmacenes").last();
			$(div).append(
				'<div id="eliminarAlmacen" class="pt-1"><span class="fa-solid fa-xmark i-pdf material-icons"></span></div>'
			);
			$(div).find("#cantidadEnviar").val("");
		} else {
			mensajeError("Debe agregar al menos un movimiento.");
		}
	});

	$("#formEnviarAlmacen").on("click", "#eliminarAlmacen", function () {
		$(this).parent("div").remove();
	});

	$("#numeroUnidad").blur(function () {
		getPesos();
	});

	function getPesos() {
		var ticket = $("#ticket").val();
		var ferrotolva = 0;
		if ($("#ferrotolva").val() == "F") {
			ferrotolva = 1;
		}
		if (ticket != "") {
			$.ajax({
				data: { id: ticket, ferrotolva: ferrotolva },
				url: "?ajax&controller=Servicios&action=getPesos",
				type: "POST",
				dataType: "json",
				success: function (r) {
					console.log(r);
					if (r != false) {
						var numero = quitarEspacios(r.EntPlacas.trim());
						if (numero == $("#numeroUnidad").val().trim()) {
							$("#pesoBruto").val(htmlNum(r.EntPesoB));
							$("#pesoTara").val(htmlNum(r.EntPesoT));
							$("#horaPeso").val(r.EntHoraE);
							$("#fechaPeso").val(
								formatDateToString(new Date(r.EntFechaE))
							);
							$("#horaPesoSalida").val(r.EntHoraS);
							$("#fechaPesoSalida").val(
								formatDateToString(new Date(r.EntFechaS))
							);
							$("#pesoNeto").val(
								htmlNum(parseInt(r.EntPesoB) - parseInt(r.EntPesoT))
							);
							calcularPesos();
						} else {
							mensajeError(
								"Numero de ferrotolva no coincide.</br><span><b> Número Ticket: </b>" +
									ticket +
									"</span></br><span><b> FT/AT: </b>" +
									r.EntPlacas +
									"</span>"
							);
							$("#ticket").addClass("required").val("");
							$("#divPesos").find("input").val("");
						}
					} else {
						mensajeError("Ticket no registrado");
					}
				},
				error: function () {
					mensajeError("Algo salio mal,  contacte al administrador.");
				},
			});
		}
	}

	$("#btnGenerarServicio").click(function (e) {
		e.preventDefault();
		$("#idEntrada").val($("#id").val());
		if (validarDatosServicio()) {
			var datosForm = new FormData($("#formAgregarServicio")[0]);
			$.ajax({
				data: datosForm,
				enctype: "multipart/form-data",
				processData: false,
				contentType: false,
				url: "?ajax&controller=Servicios&action=generarServicio",
				type: "POST",
				dataType: "json",
				success: function (r) {
					console.log(r);
					if (r.error) {
						mensajeCorrecto(r.mensaje, true);
					} else {
						console.log(r);
						mensajeError(r.mensaje);
					}
				},
				error: function (r) {
					console.log(r.responseText);
					mensajeError("Algo salio mal,  contacte al administrador.");
				},
			});
		} else {
			mensajeError("Complete los datos solicitados.");
		}
	});

	$("#btnEditarServicio").click(function (e) {
		e.preventDefault();
		var formEditar = $("#formEditarServicio");
		formEditar.find("input, select").attr("disabled", false);
		var datosForm = new FormData($(formEditar)[0]);
		$.ajax({
			data: datosForm,
			enctype: "multipart/form-data",
			processData: false,
			contentType: false,
			url: "?ajax&controller=Servicios&action=generarServicio",
			type: "POST",
			dataType: "json",
			success: function (r) {
				console.log(r);
				if (r.error) {
					mensajeCorrecto(r.mensaje);
				} else {
					console.log(r);
					mensajeError(r.mensaje);
				}
			},
			error: function (r) {
				console.log(r.responseText);
				mensajeError("Algo salio mal, contacte al administrador.");
			},
		});
	});

	$("#tablaRegistros").on("click", "#imprimirServicio", function (e) {
		var tr = $(this).closest("tr");
		e.preventDefault();
		var id = tr.find("#idServicio").html();
		if (id != "") {
			window.open(
				serv +
					"?controller=Servicios&action=imprimirServicio&&idServ=" +
					id,
				"Imprimir servicio",
				"width=1300,height=600"
			);
		}
	});

	$("#loteSelect").change(function () {
		var lote = $(this).val();
		if (lote != "") {
			getInfoLote(lote);
		}
	});

	function getInfoLote(lote) {
		$.ajax({
			data: { lote: lote },
			url: "?ajax&controller=Servicios&action=getInfoLote",
			type: "POST",
			dataType: "json",
			success: function (r) {
				console.log(r);
				if (r != false) {
					var cargas = r[0].cargas != null ? r[0].cargas : 0;
					var descargas = r[0].descargas != null ? r[0].descargas : 0;
					$("#stock").val(htmlNum(descargas - cargas));
					$("#productoServ").val(r[0].producto).attr("disabled", true);
					$("#aliasServ").val(r[0].alias).attr("disabled", true);
				} else {
					mensajeError("Lote no registrado.");
				}
			},
			error: function () {
				mensajeError("Algo salio mal, contacte al administrador.");
			},
		});
	}

	function formatDateToString(date) {
		return $.datepicker.formatDate("dd/mm/yy", date);
	}

	function formatDateHourToString(date) {
		return date.toLocaleString();
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

	function mensajeCorrecto(mnsj, reload = true) {
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
						if (reload) {
							location.reload();
							window.opener.location.reload();
						}
					},
				},
			},
		});
	}

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

	function quitarEspacios(str) {
		return str.replace(/ /g, "");
	}
	formatoNumeros();
});

const formatoNumeros = () => {
	$(".numhtml").unbind();
	$(".numhtml").blur(function () {
		var cant = $(this).val();
		if (cant != "") {
			$(this).val(htmlNum(quitarComasNumero(cant)));
		}
	});
};
function cambiaFerrotolva(ferrotolva) {
	var ferro = ferrotolva; //$(this).val();
	var seccionCamion = $("#seccionCamion");
	var seccionFerrotolva = $("#seccionFerrotolva");
	if (ferro == "F") {
		$("#transportistaTren")
			.attr("name", "transportista")
			.val("Kansas City Southern De Mexico");
		$("#transportista").removeAttr("name").val("");
		$(seccionCamion).attr("hidden", true);
		$(seccionFerrotolva).attr("hidden", false);
		$("#chofer").attr("disabled", true);
		$("#ordenTren").attr("name", "orden");
		$("#orden").removeAttr("name").val("");
		$("#transporteTren").attr("name", "transporte");
		$("#transporte").removeAttr("name").val("");
		$("#transporteTren")
			.find("option")
			.each(function () {
				var trans = this.innerText;
				if (trans.includes("Carro") || trans.includes("Ferro")) {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
	} else {
		$("#transportistaTren").removeAttr("name").val("");
		$("#transportista").attr("name", "transportista").val("");
		$(seccionCamion).attr("hidden", false);
		$(seccionFerrotolva).attr("hidden", true);
		$("#chofer").attr("disabled", false);
		$("#ordenTren").removeAttr("name");
		$("#orden").attr("name", "orden");
		$("#transporteTren").removeAttr("name");
		$("#transporte").attr("name", "transporte");
		$("#transporte")
			.find("option")
			.each(function () {
				var trans = this.innerText;
				if (trans.includes("Carro") || trans.includes("Ferro")) {
					$(this).hide();
				} else {
					$(this).show();
				}
			});
	}
}
function quitarComasNumero(value) {
	const regex = /,/g;
	if (value != "") {
		var num = value.replace(regex, "");
		return parseFloat(num);
	}
}
function htmlNum(num) {
	return Number(num).toLocaleString("en");
}

function isNumeric(value) {
	const regex = /,/g;
	var num = value.replace(regex, "");
	var valid = !isNaN(Number(num));
	return valid;
}
