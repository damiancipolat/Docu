<?php
	
	$id =  null;
	
	if (isset($_GET['id']))
	{
		//Muestra las cabeceras para generar un archivo word.
		header('Content-type: application/vnd.ms-word');
		header("Content-Disposition: attachment; filename=archivo.doc");
		header("Pragma: no-cache");
		header("Expires: 0");

		//Php que genera el html.
		include('/libs/plain.php');
	}
	else
	{
		echo "bad param :/";
	}
	
?>	