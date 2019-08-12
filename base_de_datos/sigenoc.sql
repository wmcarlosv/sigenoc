/*create database sigenoc;
	use sigenoc;*/

create table usuarios(
	id int auto_increment not null,
	nombre varchar(60) not null,
	correo varchar(255) not null,
	telefono varchar(25) not null,
	clave varchar(100) not null,
	fecha_creacion timestamp not null default current_timestamp,
	fecha_actualizacion timestamp null,
	primary key (id)
)engine = innodb;

create table clientes(
	id int auto_increment not null,
	rif varchar(20) not null,
	razon_social varchar(160) not null,
	direccion varchar(255) not null,
	correo varchar(255) not null,
	telefono varchar(25) not null,
	persona_contacto varchar(255) not null,
	telefono_persona_contacto varchar(25) not null,
	fecha_creacion timestamp not null default current_timestamp,
	fecha_actualizacion timestamp null,
	primary key (id)
)engine = innodb;

create table servicios(
	id int auto_increment not null,
	nombre varchar(60) not null,
	fecha_creacion timestamp not null default current_timestamp,
	fecha_actualizacion timestamp null,
	primary key (id)
)engine = innodb;

create table mensajes(
	id int auto_increment not null,
	titulo varchar(120) not null,
	contenido text not null,
	usuario_id int not null,
	fecha_creacion timestamp not null default current_timestamp,
	fecha_actualizacion timestamp null,
	primary key (id),
	foreign key (usuario_id) references usuarios (id)
)engine = innodb;

create table mensaje_servicios(
	id int auto_increment not null,
	mensaje_id int not null,
	servicio_id int not null,
	fecha_creacion timestamp not null default current_timestamp,
	primary key (id),
	foreign key (mensaje_id) references mensajes (id),
	foreign key (servicio_id) references servicios (id)
)engine = innodb;

create table mensaje_clientes(
	id int auto_increment not null,
	mensaje_id int not null,
	cliente_id int not null,
	fecha_creacion timestamp not null default current_timestamp,
	primary key (id),
	foreign key (cliente_id) references clientes (id),
	foreign key (mensaje_id) references mensajes (id)
)engine = innodb;

/*Insertando el usuario administrador por Defecto*/
insert into usuarios (nombre, correo, telefono, clave) values ('administrador','administrador@sigenoc.com','04160000000',MD5('123456'));