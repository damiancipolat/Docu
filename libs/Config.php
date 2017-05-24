<?php

	//Ejemplo si se usara MYSQL, la variable puerto se ignora.
	$motor        = "mysql";      //Motor de base de datos, opciones: "mysql" u "postgresql".
	$servidor_cfg = "localhost";  //host
	$port_cfg     = "";           //Se usa solo para Postgresql, en mysql ignorarlo.
	$usuario_cfg  = "root";		  //usuario
	$password_cfg = "";	    	  //password
	$bd_cfg	      = "docu";		  //base de datos

/*
	//Ejemplo si se usara postgresql.
	$motor        = "postgresql"; //Motor de base de datos, opciones: "mysql" u "postgresql".
	$servidor_cfg = "127.0.0.1";  //host
	$port_cfg     = "5432";       //Se usa solo para Postgresql, en mysql ignorarlo.
	$usuario_cfg  = "postgres";	  //usuario
	$password_cfg = "";	    	  //password
	$bd_cfg	      = "docu";		  //base de datos
*/	

?>