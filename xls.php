<?php
	
	$id =  null;
	
	if (isset($_GET['id']))
	{
		//Muestra las cabeceras para generar un archivo excel.
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=archivo.xls");
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