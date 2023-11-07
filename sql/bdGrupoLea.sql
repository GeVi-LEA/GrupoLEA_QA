create database grupo_lea;
USE grupo_lea;

create table catalogo_unidades(
id  int(100) auto_increment not null,
nombre      varchar(100) not null,
clave   varchar(100) not null,
descripcion       varchar(400),
constraint pk_unidades PRIMARY KEY(id),
constraint uq_clave unique(clave)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_tipos_compras(
id  int(10) auto_increment not null,
tipo  varchar(100) not null,
descripcion  varchar(400),
constraint pk_compras PRIMARY KEY(id),
constraint uq_tipo unique(tipo)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_tipos_solicitudes(
id  int(100) auto_increment not null,
tipo_compra_id  int(100) not null,
tipo  varchar(400) not null,
descripcion  varchar(400),
constraint pk_solicitudes PRIMARY KEY(id),
constraint uq_tipo unique(tipo),
constraint fk_solicitud_compra foreign key(tipo_compra_id) references catalogo_tipos_compras(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_paises(
id int(20) auto_increment not null,
nombre varchar(100) not null,
clave varchar(50) not null,
constraint pk_paises PRIMARY KEY(id),
constraint uq_clave unique(clave),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_estados(
id int(20) auto_increment not null,
pais_id int(10),
nombre varchar(100) not null,
clave varchar(50) not null,
constraint pk_estados PRIMARY KEY(id),
constraint uq_clave unique(clave),
constraint uq_nombre unique(nombre),
constraint fk_estados_pais foreign key(pais_id) references catalogo_paises(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_ciudades(
id int(20) auto_increment not null,
estado_id int(10) not null,
nombre varchar(100) not null,
clave varchar(50) not null,
constraint pk_ciudades PRIMARY KEY(id),
constraint uq_clave unique(clave),
constraint uq_nombre unique(nombre),
constraint fk_estados_cuidad foreign key(estado_id) references catalogo_estados(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_estatus(
id int(20) not null,
nombre varchar(100) not null,
clave varchar(50) not null,
descripcion varchar(200),
constraint pk_estaus PRIMARY KEY(id),
constraint uq_clave unique(clave),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

insert into catalogo_estatus values(1, 'Generada', 'G', 'Requisición o orden de compra generada, en proceso, pendiente firmas.');
insert into catalogo_estatus values(2, 'Cancelada', 'C', 'Requisición o orden de compra cancelada.');
insert into catalogo_estatus values(3, 'Proceso', 'P', 'Requisición  o orden de compra en firmas.');
insert into catalogo_estatus values(4, 'Aceptada', 'A', 'Requisición  o orden de compra aceptada.');
insert into catalogo_estatus values(5, 'Finalizada', 'FIN', 'Requisición  o orden de compra finalizada, orden de compra generada.');
insert into catalogo_estatus values(6, 'Disponible', 'D', 'Documento disponible.');
insert into catalogo_estatus values(7, 'Enviada', 'E', 'Orden de compra enviada.');
insert into catalogo_estatus values(8, 'Transito', 'TRS', 'En transito.');
insert into catalogo_estatus values(9, 'Transito', 'TRS', 'En transito.');
insert into catalogo_estatus values(8, 'Transito', 'TRS', 'En transito.');
insert into catalogo_estatus values(8, 'Transito', 'TRS', 'En transito.');
insert into catalogo_estatus values(8, 'Transito', 'TRS', 'En transito.');

create table catalogo_proveedores(
id int(20) auto_increment not null,
tipo_solicitud_id int(10) not null,
ciudad_id int(10) not null,
nombre varchar(400) not null,
contacto varchar(400) not null,
direccion varchar(500) not null,
codigo_postal varchar(15),
telefono varchar(15) not null,
celular varchar(15),
correo varchar(120) not null,
correo1 varchar(120) not null,
correo2 varchar(120) not null,
correo3 varchar(120) not null,
rfc varchar(25),
cuenta varchar(30),
clasificacion varchar(10) not null,
certificacion varchar(5),
fecha_alta date not null,
fecha_evaluacion date not null,
calificacion int(5),
fecha_modificacion date,
fecha_baja date,
fecha_proxima_evaluacion date not null,
activo char(1) not null,
constraint pk_proveedores PRIMARY KEY(id),
constraint uq_cuenta unique(cuenta),
constraint uq_correo unique(correo),
constraint fk_proveedor_solicitud foreign key(tipo_solicitud_id) references catalogo_tipos_solicitudes(id),
constraint fk_proveedor_ciudad foreign key(ciudad_id) references catalogo_ciudades(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_tipos_permisos(
id int(20) not null,
nombre varchar(100) not null,
clave varchar(50) not null,
descripcion varchar(300),
constraint pk_permisos PRIMARY KEY(id),
constraint uq_clave unique(clave),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;


create table catalogo_departamentos(
id int(20) auto_increment not null,
nombre varchar(100) not null,
clave varchar(50) not null,
descripcion varchar(300),
constraint pk_departamentos PRIMARY KEY(id),
constraint uq_clave unique(clave),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_usuarios(
id int(20) auto_increment not null,
permisos varchar(250) not null,
departamento_id int(10) not null,
puesto varchar(50) not null,
nombres varchar(100) not null,
apellidos varchar(100) not null,
correo varchar(100) not null,
extension varchar(10),
telefono varchar(20),
user varchar(20) not null,
password varchar(150) not null,
fecha_alta date not null,
fecha_modificacion date,
fecha_baja date,
imagen varchar(400), 
firma varchar(400),
constraint pk_usuarios PRIMARY KEY(id),
constraint fk_usuarios_departamento foreign key(departamento_id) references catalogo_departamentos(id),
constraint uq_user unique(user)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_documentos_norma(
id int(20) auto_increment not null,
usuario_id int(10) not null,
estatus_id int(10) not null,
codigo varchar(100) not null,
revision int(5) not null,
nombre varchar(400) not null,
descripcion varchar(400),
fecha_liberacion date not null,
fecha_alta date not null,
fecha_modificacion date not null,
formato varchar(500),
constraint pk_documentos_norma PRIMARY KEY(id),
constraint uq_codigo unique(codigo),
constraint uq_nombre unique(nombre),
constraint fk_documentos_usuario foreign key(usuario_id) references catalogo_usuarios(id),
constraint fk_documentos_status foreign key(estatus_id) references catalogo_estatus(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table compras_requisiciones(
id int(100) auto_increment not null,
proveedor_id int(100) not null,
usuario_id int(100) not null,
estatus_id int(20) not null,
folio varchar(30) not null,
empresa int(5) not null,
num_proyecto varchar(200) null,
proyecto varchar(400) null,
urgente varchar(3) not null,
observaciones varchar(1000),
fecha_solicitud date not null,
fecha_requerida date not null,
fecha_modificacion date,
fecha_alta date not null,
fecha_baja date,
cotizacion varchar(300) null,
firmas varchar(100),
ruta_id int (20) null,
aduana_id int (20) null,
cliente_id int(10) null,
moneda int(2) not null,
producto_id int(20) null,
transpote_id int(10) null,
cantidad_flete int(20) null,
flete int(5) null,
constraint pk_requisicion PRIMARY KEY(id),
constraint fk_requisiciones_proveedor foreign key(proveedor_id) references catalogo_proveedores(id),
constraint fk_requisiciones_usuario foreign key(usuario_id) references catalogo_usuarios(id),
constraint fk_requisiciones_estatus foreign key(estatus_id) references catalogo_estatus(id),
constraint fk_requisiciones_ruta foreign key(ruta_id) references catalogo_rutas(id),
constraint fk_requisiciones_aduana foreign key(aduana_id) references catalogo_aduanas(id),
constraint fk_requisiciones_cliente foreign key(cliente_id) references catalogo_clientes(id),
constraint fk_requisiciones_producto foreign key(producto_id) references catalogo_productos(id)
constraint fk_requisiciones_transporte foreign key(transporte_id) references catalogo_tipos_transportes(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table compras_detalles_requisiciones(
id int(100) auto_increment not null,
requisicion_id int(100) not null,
unidad_id int(20) not null,
descripcion varchar(500) not null,
cantidad decimal(25,10) not null,
precio_unitario decimal(25,10) not null,
descuento decimal(25,10),
precio decimal(25,10),
constraint pk_requisicion PRIMARY KEY(id),
constraint fk_detalle_requisicion foreign key(requisicion_id) references compras_requisiciones(id),
constraint fk_detalle_unidad foreign key(unidad_id) references catalogo_unidades(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_clientes(
id int(20) auto_increment not null,
ciudad_id int(10) not null,
nombre varchar(400) not null,
contacto varchar(400) not null,
direccion varchar(500) not null,
codigo_postal varchar(15),
telefono varchar(15),
correo varchar(120) not null,
rfc varchar(25),
fecha_alta date not null,
constraint pk_clientes PRIMARY KEY(id),
constraint uq_correo unique(correo),
constraint fk_cliente_ciudad foreign key(ciudad_id) references catalogo_ciudades(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_tipos_transportes(
id int(20) auto_increment not null,
nombre varchar(100) not null,
clave varchar(50) not null,
descripcion varchar(300),
constraint pk_transportes PRIMARY KEY(id),
constraint uq_clave unique(clave),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_rutas(
id int(20) auto_increment not null,
proveedor_id int(20) not null,
ciudad_origen int(20) not null,
ciudad_destino int(20) not null,
tipo_transporte int(20) not null,
precio decimal(25,10) not null,
descripcion varchar(300),
fecha_vencimiento date not null,
moneda int(2) not null;
constraint pk_ruta PRIMARY KEY(id),
constraint fk_ruta_proveedor foreign key(proveedor_id) references catalogo_proveedores(id),
constraint fk_ruta_ciudadOrigen foreign key(ciudad_origen) references catalogo_ciudades(id),
constraint fk_ruta_ciudadDestino foreign key(ciudad_destino) references catalogo_ciudades(id),
constraint fk_ruta_tipo_transporte foreign key(tipo_transporte) references catalogo_tipos_transportes(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table compras_ordenes_compra(
id int(100) auto_increment not null,
requisicion_id int(20) not null,
estatus_id int(20) not null,
folio varchar(30) not null,
fecha_modificacion date,
fecha_alta date not null,
importe decimal(25,10) not null,
otro_iva int(5) null;
iva decimal (25,10),
sub_total decimal(25,10),
isr decimal (25,10),
retencion_iva decimal (25,10),
impuesto decimal (25,10),
pagos decimal (25,10),
total decimal(25,10) not null,
nota_credito decimal(25,10),
constraint pk_orden PRIMARY KEY(id),
constraint uq_requisicion unique(requisicion_id),
constraint fk_orden_requisicion foreign key(requisicion_id) references compras_requisiciones(id),
constraint fk_orden_estatus foreign key(estatus_id) references catalogo_estatus(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_refinerias(
id int(20) auto_increment not null,
nombre varchar(100) not null,
constraint pk_refineria PRIMARY KEY(id),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_productos(
id int(20) auto_increment not null,
refineria_id int(10),
nombre varchar(100) not null,
constraint pk_producto PRIMARY KEY(id),
constraint fk_producto_refineria foreign key(refineria_id) references catalogo_refinerias(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_aduanas(
id int(20) not null,
ciudad_id int(20) not null,
nombre varchar(60) not null,
clave varchar(20) not null,
constraint pk_aduana PRIMARY KEY(id),
constraint uq_tipo unique(id),
constraint fk_aduana_ciudad foreign key(ciudad_id) references catalogo_ciudades(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table compras_pedimentos(
id int(20) auto_increment not null,
numero varchar(20) not null,
referencia varchar(20) not null,
tipo_cambio decimal(25,6) not null,
incrementable decimal(25,6) null,
otros_cargos decimal(25,6) null,
total_incrementables decimal(25,6) null,
incrementables_pesos decimal(25,6) null,
valor_aduana decimal(25,6) null,
iva decimal(25,6) null,
prv decimal(25,6) null,
iva_prv decimal(25,6) null,
dta decimal(25,6) null,
valor_comercial decimal(25,6) null,
total_impuestos decimal (25,6) null,
fecha_pedimento date not null,
documento varchar(400) null,
constraint pk_pedimento PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;


create table catalogo_carro_tanques(
id int(20) not null,
numero varchar(20) not null,
estatus_id int(20) not null,
constraint pk_carro PRIMARY KEY(id),
constraint uq_numero unique(numero),
constraint fk_carro_estatus foreign key(estatus_id) references catalogo_estatus(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table compras_embarques(
id int(20) auto_increment not null,
requisicion_producto int(20) not null,
requisicion_flete int(20) null,
pedimento_id int(20) null,
aduana_id int(20) not null,
carro_tanque_id int(20) null,
cliente_id int(20) null,
estatus_id int(20) not null,
transporte_id int(20) null,
numero_transporte varchar(20) null,
cantidad_cargada decimal(25,10) null,
litros_facturados decimal(25,10) null,
precio_producto decimal(25,10) not null,
fecha_alta date not null,
fecha_modificacion date null,
numero_factura varchar(100) null,
fecha_factura date null,
oil_fee decimal(25,10) null,
importe decimal(25,10) null,
valor_dolares decimal(25,10) null,
observaciones varchar(400) null,
factura varchar(200) null,
certificado varchar(200) null,
fecha_transito date not null,
fecha_llegada date not null,
constraint pk_embarque PRIMARY KEY(id),
constraint fk_embarque_requisicion_producto foreign key(requisicion_producto) references compras_requisiciones(id),
constraint fk_embarque_requisicion_flete foreign key(requisicion_flete) references compras_requisiciones(id),
constraint fk_embarque_pedimento foreign key(pedimento_id) references compras_pedimentos(id),
constraint fk_embarque_cliente foreign key(cliente_id) references catalogo_clientes(id),
constraint fk_embarque_transporte foreign key(transporte_id) references catalogo_tipos_transportes(id),
constraint fk_embarque_estatus foreign key(estatus_id) references catalogo_estatus(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_tokens(
id int(20) not null,
entidad varchar(100) not null,
token varchar(100) not null,
descripcion varchar(150) null,
constraint pk_carro PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table almacen_movimientos_embarques(
id int(20) auto_increment not null,
embarque_id int(20) not null,
fecha date not null,
ubicacion int(3) not null,
constraint fk_movimiento_embarque foreign key(embarque_id) references compras_embarques(id),
constraint pk_movimiento PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table compras_recepciones_fletes(
id int(20) auto_increment not null,
usuario_id int(20) not null,
requisicion_id int(20) not null,
numero_factura varchar(30) not null,
fecha_recepcion date not null,
factura varchar(200) null,
docXml varchar(200) null,
remision varchar(200) null,
evaluacion varchar(100) not null,
observaciones varchar(500) null,
constraint uq_requisicion unique(requisicion_id),
constraint fk_recepcion_requisicion foreign key(requisicion_id) references compras_requisiciones(id),
constraint fk_recepcion_usuario foreign key(usuario_id) references catalogo_usuarios(id),
constraint pk_recepcion PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table sistemas_solicitudes_servicio(
id int(20) auto_increment not null,
estatus_id int(20) not null,
usuario_id int(20) not null,
usuario_sistemas_id int(20) not null,
equipo_id int(20),
folio varchar (30) not null, 
empresa int(5) not null, 
tipo_requerimiento int(5) not null,
tipo_solicitud int(5) not null,
fecha_solicitud datetime not null,
fecha_atencion datetime null,
fecha_solucion datetime null,
prioridad int(5) not null,
descripcion varchar(1000) null,
observaciones varchar(1000) null,
solucion varchar(1000) null,
constraint uq_folio unique(folio),
constraint fk_solicitud_usuario foreign key(usuario_id) references catalogo_usuarios(id),
constraint fk_solicitud_usuario_sistemas foreign key(usuario_sistemas_id) references catalogo_usuarios(id),
constraint fk_solicitud_equipo foreign key(equipo_id) references catalogo_equipos_computo(id),
constraint fk_solicitud_estatus foreign key(estatus_id) references catalogo_estatus(id),
constraint pk_solicitud_servicio PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_equipos_computo(
id int(20) auto_increment not null,
folio varchar(20) not null, 
usuario_id int(20) null,
tipo_equipo int(5) not null,
modelo varchar (30) not null,  
marca int(5) not null,  
numero_serie varchar (40) not null,
factura varchar (30) null, 
procesador varchar (10) null, 
memoria_ram varchar (10) null,
disco_duro varchar (10) null,
red_lan varchar (40)  null,
red_wifi varchar (40)  null,
aplicaciones varchar (40)  null,
fecha_compra date null,
fecha_asignacion date null,
fecha_baja date null,
fecha_mantenimiento date null,
observaciones varchar(1000) null,
constraint uq_numero_serie unique(numero_serie),
constraint fk_equipo_usuario foreign key(usuario_id) references catalogo_usuarios(id),
constraint pk_equipo_computo PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_tipos_productos_resinas_liquidos(
id int(20) auto_increment not null,
nombre varchar(50) not null,
descripcion varchar(300),
constraint pk_tipo_producto_resina_liquido PRIMARY KEY(id),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_productos_resinas_liquidos(
id int(20) auto_increment not null,
nombre varchar(50) not null,
tipo_producto_id int (20) not null,
constraint pk_producto_resina_liquido PRIMARY KEY(id),
constraint fk_producto_tipo_resina foreign key(tipo_producto_id) references catalogo_tipos_productos_resinas_liquidos(id),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_tipos_empaques (
id int(20) auto_increment not null,
nombre varchar(50) not null,
descripcion varchar(300),
constraint pk_tipos_empaques PRIMARY KEY(id),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_servicios (
id int(20) auto_increment not null,
nombre varchar(100) not null,
clave varchar(20) not null,
descripcion varchar(150),
constraint pk_servicios PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

INSERT INTO `catalogo_servicios` (`id`, `nombre`, `clave`, `descripcion`) VALUES
(1, 'SERVICIO DE ENSACADO', 'SER0017', 'Servicio de ensacado'),
(2, 'RENTA DE ESPUELA', 'SER0015', 'Renta de espuela'),
(3, 'SERVICIO DE BASCULA', 'SER0019', 'Servicio de bascula'),
(4, 'SERVICIO ALMACENAJE', 'SER0020', 'Servicio de almacenaje en piso'),
(5, 'SALIDA DE ALMACEN', 'CARGA', 'Carga de producto'),
(6, 'SERVICIO DE TRASVASE', 'SER0033', 'Trasvase'),
(7, 'USO DE CALDERA', 'SER0030', 'Uso de caldera'),
(8, 'DEMORAS', 'SER0032', 'Demoras'),
(9, 'TRASPALEO', 'SER0034', 'Traspaleo'),
(10, 'MANIOBRAS', 'SER0041', 'Maniobras'),
(11, 'REEMPAQUE', 'SER0042', 'Reempaque'),
(12, 'RE-ETIQUETA', 'SER0044', 'Re-etiqueta'),
(13, 'TIEMPO EXTRA', 'SER0046', 'Tiempo extra'),
(14, 'AJUSTE PESO', 'AJUSTE', 'Ajuste peso');

create table servicios_clientes (
id int(20) auto_increment not null,
servicio_id int(20) not null,
cliente_id int(20) not null,
tipo_empaque_id int(20),
unidad_id int(20),
costo decimal(25,10) not null,
moneda int(2) not null,
dias int(10) null,
constraint pk_servicios_cliente PRIMARY KEY(id),
constraint fk_servicio_cliente foreign key(cliente_id) references catalogo_clientes(id),
constraint fk_servicio_servicios foreign key(servicio_id) references catalogo_servicios(id),
constraint fk_servicio_tipo_empaque foreign key(tipo_empaque_id) references catalogo_tipos_empaques(id),
constraint fk_servicio_unidad foreign key(unidad_id) references catalogo_unidades(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;    

create table servicios_entradas(
id int(30) auto_increment not null,
cliente_id int(20) not null,
estatus_id int(20) not null,
tipo_transporte_id int(20) not null,
numUnidad varchar(15) not null,
fecha_entrada datetime null,
fecha_salida datetime null,
transportista varchar(200) not null,
chofer varchar(200) not null,
placa1 varchar (10) null,
placa2 varchar (10) null,
ticket varchar(15) null,
peso_cliente decimal(25,10) NULL,
peso_tara decimal(25,10) null,
peso_teorico decimal(25,10) null,
peso_bruto decimal(25,10) null,
peso_neto decimal(25,10) null,
doc_ticket varchar (20) null,
doc_remision varchar (20) null,
sello1 varchar(25) null,
sello2 varchar(25) null,
sello3 varchar(25) null,
observaciones varchar(400) null,
constraint pk_servicios_entradas PRIMARY KEY(id),
constraint fk_entrada_estatus foreign key(estatus_id) references catalogo_estatus(id),
constraint fk_entrada_cliente foreign key(cliente_id) references catalogo_clientes(id),
constraint fk_entrada_transporte foreign key(tipo_transporte_id) references catalogo_tipos_transportes(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table servicios_ensacado(
id int(30) NOT NULL AUTO_INCREMENT,
entrada_id int(20) NOT NULL,
servicio_id int(20) NOT NULL,
producto_id int(20) null,
empaque_id int(20) DEFAULT NULL,
estatus_id int(20) NOT NULL,
folio varchar(20) NOT NULL,
lote varchar(30) null,
alias varchar(30) null,
cantidad decimal(25,10) NULL,
fecha_programacion datetime NULL,
fecha_inicio datetime NULL,
fecha_fin datetime NULL,
barredura_sucia decimal(25,10) NULL,
barredura_limpia decimal(25,10) NULL,
total_ensacado decimal(25,10)  NULL,
bultos int(10) NULL,
tarimas int(10) NULL,
tipo_tarima int(3) NULL,
parcial int(10) NULL,
orden varchar(20) null,
doc_orden varchar(20) null,
observaciones varchar(200) NULL,
constraint pk_servicios_ensacado PRIMARY KEY(id),
CONSTRAINT fk_servicio_empaque FOREIGN KEY (empaque_id) REFERENCES catalogo_tipos_empaques (id),
CONSTRAINT fk_servicio_entrada FOREIGN KEY (entrada_id) REFERENCES servicios_entradas (id),
CONSTRAINT fk_servicio_estatus FOREIGN KEY (estatus_id) REFERENCES catalogo_estatus (id),
CONSTRAINT fk_servicio_producto_resina FOREIGN KEY (producto_id) REFERENCES catalogo_productos_resinas_liquidos (id),
CONSTRAINT fk_servicio_servicio FOREIGN KEY (servicio_id) REFERENCES catalogo_servicios (id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_almacenes(
id int(20) auto_increment not null,
nombre varchar(50) not null,
descripcion varchar(300),
constraint pk_almacenes PRIMARY KEY(id),
constraint uq_nombre unique(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table servicios_movimientos_almacen(
servicio_id int(20) not null,
almacen_id int(20) not null,
cantidad decimal(25,10) not null,
operacion varchar(2) not null,
fecha datetime not null,
CONSTRAINT fk_movimiento_servicio FOREIGN KEY (servicio_id) REFERENCES servicios_ensacado (id),
CONSTRAINT fk_movimiento_almacen FOREIGN KEY (almacen_id) REFERENCES catalogo_almacenes (id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create VIEW view_directorio as select concat(u.nombres, ' ', u.apellidos) as nombre, u.correo, u.telefono FROM catalogo_usuarios u 
union select p.nombre, p.correo, p.telefono from catalogo_proveedores p union select p.nombre, p.correo1, p.telefono from catalogo_proveedores p where correo1 != "" 
union select p.nombre, p.correo2, p.telefono from catalogo_proveedores p where correo2 != "" 
union select p.nombre, p.correo3, p.telefono from catalogo_proveedores p where correo3 != "" 
union select c.nombre, c.correo, c.telefono from catalogo_clientes c ORDER BY `nombre` ASC

create VIEW view_ciudades as select c.id AS id, c.estado_id AS estado_id, c.nombre AS nombre, c.clave AS clave,
e.clave AS clave_estado, e.nombre AS nombre_estado, p.clave AS clave_pais, p.nombre AS nombre_pais,
concat(c.nombre,', ',e.nombre,', ', p.clave) AS ciudad_completa from catalogo_ciudades c join catalogo_estados e
 join catalogo_paises p where c.estado_id = e.id and e.pais_id = p.id order by c.nombre

create table catalogo_espuelas (
id int(20) not null,
clave varchar(3) not null,
constraint uq_clave unique(clave),
constraint pk_espuelas PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

create table catalogo_espuelas (
id int(20) not null,
clave varchar(3) not null,
constraint uq_clave unique(clave),
constraint pk_espuelas PRIMARY KEY(id)
)ENGINE=InnoDb DEFAULT CHARSET=utf8;

insert into catalogo_espuelas values(1, 'A1');
insert into catalogo_espuelas values(2, 'A2');
insert into catalogo_espuelas values(3, 'A3');
insert into catalogo_espuelas values(4, 'A4');
insert into catalogo_espuelas values(5, 'A5');
insert into catalogo_espuelas values(6, 'A6');
insert into catalogo_espuelas values(7, 'A7');
insert into catalogo_espuelas values(8, 'A8');
insert into catalogo_espuelas values(9, 'B1');
insert into catalogo_espuelas values(10, 'B2');
insert into catalogo_espuelas values(11, 'B3');
insert into catalogo_espuelas values(12, 'B4');
insert into catalogo_espuelas values(13, 'B5');
insert into catalogo_espuelas values(14, 'B6');
insert into catalogo_espuelas values(15, 'B7');
insert into catalogo_espuelas values(16, 'B8');
insert into catalogo_espuelas values(17, 'C1');
insert into catalogo_espuelas values(18, 'C2');
insert into catalogo_espuelas values(19, 'C3');
insert into catalogo_espuelas values(20, 'C4');
insert into catalogo_espuelas values(21, 'C5');
insert into catalogo_espuelas values(22, 'C6');
insert into catalogo_espuelas values(23, 'C7');
insert into catalogo_espuelas values(24, 'C8');
insert into catalogo_espuelas values(25, 'D1');
insert into catalogo_espuelas values(26, 'D2');
insert into catalogo_espuelas values(27, 'D3');
insert into catalogo_espuelas values(28, 'D4');
insert into catalogo_espuelas values(29, 'D5');
insert into catalogo_espuelas values(30, 'D6');
insert into catalogo_espuelas values(31, 'D7');
insert into catalogo_espuelas values(32, 'D8');
insert into catalogo_espuelas values(33, 'E1');
insert into catalogo_espuelas values(34, 'E2');
insert into catalogo_espuelas values(35, 'E3');
insert into catalogo_espuelas values(36, 'E4');
insert into catalogo_espuelas values(37, 'E5');
insert into catalogo_espuelas values(38, 'E6');
insert into catalogo_espuelas values(39, 'E7');
insert into catalogo_espuelas values(40, 'E8');
insert into catalogo_espuelas values(41, 'F1');
insert into catalogo_espuelas values(42, 'F2');
insert into catalogo_espuelas values(43, 'F3');
insert into catalogo_espuelas values(44, 'F4');
insert into catalogo_espuelas values(45, 'F5');




DELIMITER $$;

create PROCEDURE stockByLote( IN lote varchar(30))
BEGIN

  DECLARE cargas DECIMAL;
  DECLARE descargas DECIMAL;
  DECLARE stock DECIMAL;
  
  select sum(servEns.cantidad) INTO descargas from servicios_entradas servEnt
  left join servicios_ensacado servEns on servEns.entrada_id = servEnt.id 
  inner join catalogo_servicios serv on servEns.servicio_id = serv.id where servEnt.lote not like '%454545%' and serv.clave not like '%CARGA%' and serv.clave not like '%AJUSTE%';
  
  select sum(servEns.total_ensacado) INTO cargas from servicios_entradas servEnt
  left join servicios_ensacado servEns on servEns.entrada_id = servEnt.id 
  inner join catalogo_servicios serv on servEns.servicio_id = serv.id where servEnt.lote like '%454545%' and serv.clave like '%CARGA%' and serv.clave like '%AJUSTE%';
 
 SET stock = descargas - if(cargas is null, 0, cargas);
 
 select cargas, descargas, stock;
 
 end $$;
 DELIMITER