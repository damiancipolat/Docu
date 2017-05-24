<?php
	include('Backend.php');
?>

<?php
	
	$texto      = null;
		
	//Creo el objeto que instancia al backend.
	$bck        = new Backend_html();		
		
	//Grabo la lectura del documento.		
	$bck->grabar_leido($_GET['id']);
	
	//Traigo los datos del doc de la bd.
	$resu       = $bck->traer_doc($_GET['id']);			
	
	//Bindeo los datos, de la bd.
	$texto      = base64_decode($resu['texto']);
	
?>

<?php
	echo $texto;
?>
	