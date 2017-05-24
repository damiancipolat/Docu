/*

	Scripts SQL para armar la base de datos de DOCU V 1.0
	Esta dividido en codigo sql para postgresql u mysql, segun el motor que se use ejecutar el que corresponda.
*/

/*------------------------------------*/
/*              POSTGRESQL            */
/*------------------------------------*/

create table docu_usuarios
(
	idusuario	serial,
	nick		varchar(100),
	email		varchar(100),
	password	varchar(10),
	activo		varchar(1)
);

insert into docu_usuarios(nick,email,password,activo) values('admin','','admin2014','S');

create table docu_categorias
(
	idcateg   serial,
	categoria varchar(100)
);

create table docu_documentos
(
	iddocumento   serial,
	titulo	      varchar(200),
	descripcion   varchar(300),
	fecha	      date,
	creador	      varchar(20),
	permitidos    text,
	texto	      text,
	categoria     int,
	lecturas      int,
	firmas        int,
	cambiarConfig int
);

create table docu_adjuntos
(
	idadjunto   serial,
	iddocumento int,
	nombre	    varchar(300),
	archivo	    varchar(300)
);

create table docu_firmas
(
	idfirma     serial,
	iddocumento int,
	usuario	    varchar(300)
);

create table docu_cambios_log
(
	idcambio     serial,
	iddocumento  int,
	usuario	     varchar(100),
	fecha        date
);

/*------------------------------------*/
/*              MYSQL                 */
/*------------------------------------*/

create table docu_usuarios
(
	idusuario	int not null auto_increment,
	nick		varchar(100),
	email		varchar(100),
	password	varchar(10),
	activo		varchar(1),
	primary key(idusuario)
)AUTO_INCREMENT=1;

insert into docu_usuarios(nick,email,password,activo) values('admin','','admin2014','S');

create table docu_categorias
(
	idcateg   int not null auto_increment,
	categoria varchar(100),
	primary key(idcateg)
)AUTO_INCREMENT=1;

create table docu_documentos
(
	iddocumento   int not null auto_increment,
	titulo		  varchar(200),
	descripcion   varchar(300),
	fecha		  date,
	creador		  varchar(20),
	permitidos    text,
	texto		  text,
	categoria	  int,
	lecturas      int,
	firmas        int,
	cambiarConfig int,
	primary key(iddocumento)
)AUTO_INCREMENT=1;

create table docu_adjuntos
(
	idadjunto   int not null auto_increment,
	iddocumento int,
	nombre	    varchar(300),
	archivo	    varchar(300),
	primary key(idadjunto)
)AUTO_INCREMENT=1;

create table docu_firmas
(
	idfirma     int not null auto_increment,
	iddocumento int,
	usuario	    varchar(300),
	primary key(idfirma)
)AUTO_INCREMENT=1;

create table docu_cambios_log
(
	idcambio     int not null auto_increment,
	iddocumento  int,
	usuario	     varchar(100),
	fecha        date,
	primary key(idcambio)
)AUTO_INCREMENT=1;