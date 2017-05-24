<?php

include('Config.php');

/*
  .-"-.
 /|6 6|\
{/(_0_)\}
 _/ ^ \_
(/ /^\ \)-'

PUPPYBD v1.2 por Damian Cipolat www.damiancipolat.com.ar

"Clase para el manejo de Mysql u PostgreSQL desde php."

*/

//Clase conexion MYSQL.
class mysql_conexion
{
	var $conexion;
	
	//Inicializo la conexion con mysql.
	function mysql_conexion($host,$user,$bd,$passw)
	{
		$conexion = mysql_connect($host,$user,$passw);
		
		//Si la conexion fue exitosa , selecciona la base
		if ($conexion)
		{
			mysql_select_db($bd);			
			$this->conexion=$conexion;
		}
	}
	
	//Devuelve la conexion
	function getConexion()
	{
		return $this->conexion;
	}
	
	//Cierra la conexion
	function Close()
	{
		mysql_close($this->conexion);
	}	
}

//Clase Query MYSQL.
class mysql_consulta
{
	var $resultado;
	var $conexion;

	function mysql_consulta($conexion)
	{
		$this->conexion = $conexion->getConexion();
	}
	
	function ejecutar_consulta($sql)
	{
		$this->resultado = mysql_query($sql,$this->conexion);
		return $this->resultado;	
	}
	
	function get_resultado()
	{
		return $this->resultado;
	}
	
	function limpiar()
	{
		mysql_free_result($this->resultado);
	}
	
	function get_filas()
	{
		return mysql_affected_rows($this->conexion);
	}
	
	function get_afectadas()
	{
		return mysql_affected_rows($this->conexion);
	}
	
	function get_maxidcon()
	{
		return mysql_insert_id($this->conexion);
	}
	
	function get_fila($datos)
	{
		return mysql_fetch_Array($datos);
	}	
}

//Clase conexion POSTGRESQL.
class postgres_conexion
{
	var $conexion;
	
	//Inicializo la conexion con mysql.
	function postgres_conexion($hostID,$portID,$usuarioID,$passwdID,$dbnameID)
	{
		//String de conexion.
		$cnxString = "host=$hostID port=$portID dbname=$dbnameID user=$usuarioID password=$passwdID";
		
		//Realizo la conexion.
		$conexion = pg_connect($cnxString);
		
		//Si se pudo realizar la conexion.
		if (!$conexion)
		{ 
			print "Error de conexion a la DB.<BR>";
			print pg_errormessage();
			exit;
		}
		else
		{
			$this->conexion=$conexion;
		}
	}
	
	//Devuelve la conexion
	function getConexion()
	{
		return $this->conexion;
	}
	
	//Cierra la conexion
	function Close()
	{
		pg_close($this->conexion);
	}	
}

//Clase Query POSTGRESQL.
class postgres_consulta
{
	var $resultado;
	var $conexion;

	function postgres_consulta($conexion)
	{
		$this->conexion = $conexion->getConexion();
	}
	
	function ejecutar_consulta($sql)
	{
		$this->resultado = $result = pg_query($sql);
		return $this->resultado;	
	}
	
	function get_resultado()
	{
		return $this->resultado;
	}
	
	function limpiar()
	{
		pg_free_result($this->resultado);
	}
	
	function get_filas()
	{
		return pg_num_rows($this->resultado);		
	}
	
	function get_afectadas()
	{
		return pg_affected_rows($this->resultado);
	}
	
	function get_maxidcon()
	{
		return pg_last_oid($this->resultado);
	}
	
	function get_fila($datos)
	{
		return pg_fetch_array($datos);
	}	
}

//Se declara una clase para hacer la conexion con la base de datos.
class Conexion  							
{
	var $Conector;
	var $motor;
	
	function Conexion()		   	 
	{
		//Para poder usar las variables definidas en Config.php
		global $servidor_cfg,$usuario_cfg,$password_cfg,$bd_cfg,$motor,$port_cfg;
		
		//Seteo el motor en la conexion.
		$this->motor=$motor;
		
		//Segun el motor de BD, eligo que conector usar.
		if ($motor=='mysql')
		{
			$this->Conector  =  new mysql_conexion($servidor_cfg,$usuario_cfg,$bd_cfg,$password_cfg);
		}
		
		//Segun el motor de BD, eligo que conector usar.
		if ($motor=='postgresql')
		{
			$this->Conector  = new postgres_conexion($servidor_cfg,$port_cfg,$usuario_cfg,$password_cfg,$bd_cfg);
		}
	}
	
	//Devuelve la conexion
	function getConexion()
	{
		return $this->Conector->getConexion();
	}
	
	//Devuelve el motor.
	function getmotor()
	{
		return $this->motor;
	}
	
	//Cierra la conexion
	function Close()
	{
		$this->Conector->Close();
	}	
}

//Se declara una clase para poder ejecutar las consultas, esta clase llama a la clase anterior
class Query   
{
	var $coneccion;
	var $consulta;
	var $resultados;
	
	//Constructor, solo crea una conexion usando la clase "Conexion"
	function Query()
	{
		//Armo la conexion al motor de bd.
		$this->coneccion = new Conexion();
	
		//Segun el motor de BD, eligo que clase consulta usar.
		if ($this->coneccion->getmotor()=='mysql')
		{
			$this->consulta  =  new mysql_consulta($this->coneccion);
		}	

		if ($this->coneccion->getmotor()=='postgresql')
		{
			$this->consulta  =  new postgres_consulta($this->coneccion);
		}					
	}
    
	//Metodo que ejecuta una consulta y la guarda en el atributo $pconsulta	
	function executeQuery($sql)
	{
		return $this->consulta->ejecutar_consulta($sql);
	}	
	
	//Retorna la consulta en forma de result.
	function getResults()
	{
		return $this->consulta->get_resultado();
	}
	
	//Cierra la conexion.
	function Close()
	{
		$this->coneccion->Close();
	}	
	
	//Libera la consulta.
	function Clean()
	{
		$this->consulta->limpiar();
	}
	
	//Devuelve la cantidad de registros encontrados
	function getResultados()
	{
		return $this->consulta->get_filas();
	}
	
	//Trae la prox fila del dataset.
	function getfila($datos)
	{
		return $this->consulta->get_fila($datos);
	}
	
	//Devuelve las cantidad de filas afectadas
	function getAffect()
	{
		return $this->consulta->get_afectadas();
	}
	
	//Devuelve el maxid de la conexion, debe usarse desp de un insert, solo no!
	function maxId()
	{
		return $this->consulta->get_maxidcon();
	}
}

//Funcion auxiliar para unificar nombres de columnas, en las que se escriben en mayusculas o en minusculas.
function col($fila,$nombre)
{
	$resu = null;

	//Si la columna esta toda en minuscula.
	if (isset($fila[strtolower($nombre)]))
		return $fila[strtolower($nombre)];

	//Si la columna esta toda en mayuscula.
	if (isset($fila[strtoupper($nombre)]))
		return $fila[strtoupper($nombre)];
		
	//Si la columna la primera letra esta en minuscula y el resto no.
	if (isset($fila[ucfirst($nombre)]))
		return $fila[$nombre];		

	return null;
}

?>
