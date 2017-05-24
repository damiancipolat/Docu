<html>

<head>

<title>Docu - Adjuntos</title>

<!-- JQUERY -->	
<script src="./js/jquery.min.js"></script>
<script src="./js/jquery.zclip.min.js"></script>

<!-- Bootstrap -->
<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
	
<style>
.celda
{
	border:1px solid black;
	text-align:center;
}

body
{
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}
</style>

<script language="javascript">

$(document).ready(function()
{
	$("#enviar_btn").click(function()
	{
		$("#form_adjuntar").submit();
	});
});

</script>

</head>

<?php
	include('./libs/Backend.php');
?>

<body style="background:rgb(238, 238, 238);">

<?php
		if (!(isset($_GET['id'])))
		{
			//Muestro el error.
			echo '<div class="alert alert-danger" id="msj_info">';
				echo '<b>Ups</b><br>La foto excede mas de 2mb.';
			echo '</div>';
		}
?>

<!-- CUERPO -->
<div style="margin:10px;background:white;width:600px;">

	<!-- BANNER -->
	<div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title">Archivos Adjuntos del documento</h3>
        </div>
		
		<?php		
		if (isset($_POST['file_adj_tmp']))
		{
			//Codigo para subir la imagen.
			if ($_FILES["file_adj"]["error"] > 0)
			{
				echo "<div style='background:red;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Ups!</b> hubo un problema al al subir la foto.</div>";			
			}
			else
			{
				//Si la imagen cumple con los tipos de archivos fijados.
				if (formato_imagen(extraer_tipo($_FILES["file_adj"]["name"])))
				{					
					//Si no supera 1MB
					if (($_FILES["file_adj"]["size"] / 1024)<=1024)
					{
						//Armo archivos y copio la imagen al directorio adjuntos.
						$id      = $_GET['id'];
						$nombre  = $_FILES["file_adj"]["name"];
						$file    = timestamp()."_".$_FILES["file_adj"]["name"];
						move_uploaded_file($_FILES["file_adj"]["tmp_name"],"./adjuntos/".$file);

						//Guardo el archivo en la bd.
						$bck        = new Backend_html();
						if ($bck->agregar_adjunto_doc($id,$nombre,$file))
						{
							//Muestro el ok.
							echo '<div class="alert alert-success" id="msj_info" style="margin:10px;">';
								echo '<b>Archivo subido correctamente!</b><br>Se cargo con el nuevo nombre:<br> <i><u>'.$file.'</u></i>';
							echo '</div>';
							
							//Redirecciono.
							redireccionar(2,'adjuntos.php?id='.$_GET['id']);
						}
						else
						{
							//Muestro el error.
							echo '<div class="alert alert-danger" id="msj_info" style="margin:10px;">';
								echo '<b>Ups</b><br>hubo un problema al guardar, el nombre del archivo, prueba nuevamente.';
							echo '</div>';
						}
					}
					else
					{
							//Muestro el error.
							echo '<div class="alert alert-danger" id="msj_info" style="margin:10px;">';
								echo '<b>Error</b><br>La foto excede mas de 1MB.';
							echo '</div>';
					}  
								
				}
				else
				{
						//Muestro el error.
						echo '<div class="alert alert-danger" id="msj_info" style="margin:10px;">';
							echo '<b>Error</b><br>Formato de archivo incorrecto, solo se permiten Jpeg, Png, Gif.';
						echo '</div>';
				}
			
			}
		}	
		?>		
		
        <div class="panel-body">
			<!--Archivos adjuntos-->
			<div style="margin-bottom:25px;">
				<span class="glyphicon glyphicon-open"></span>
				&nbsp;Subir im&aacute;gen:<br>
				<i>* El archivo debe ser menor a 1MB y ser Png,Jpeg o Gif.</i>
				<!--Formulario con la codificacion-->
				<form id="form_adjuntar" action="adjuntos.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="file_adj_tmp">
					<input type="file"   name="file_adj" style="margin-top:8px;">
				</form>
				<!--Boton subir archivo-->
				<a href='#' id="enviar_btn" class='btn btn-success' style='margin-top:10px;'>
					<span class="glyphicon glyphicon-open"></span>&nbsp;Cargar archivo
				</a>
				<hr>				
			</div>		
			<!--Archivos adjuntos-->
			<div style="padding-bottom:5px;">
				<span class="glyphicon glyphicon-paperclip"></span>
				&nbsp;Listado de archivos adjuntos<br>
				<i>* Copie el texto de la columna <span class="label label-primary">"Archivo"</span> para agregar la im&aacute;gen al documento,</i>.
				<br>&nbsp;&nbsp;&nbsp;el path empieza "./adjuntos/[archivo]", el nombre del archivo cambia para 
				<br>&nbsp;&nbsp;&nbsp;poder ser guardado en el servidor.
				<br>
			</div>
			<!--Listado de archivos adjuntos-->
			<table class="table table-striped" style="margin-top:10px;width:550px;">
					<thead>
					  <tr>
						<th>Im&aacute;gen</th>
						<th>Subido por</th>
						<th>Archivo</th>
					  </tr>
					</thead>
					<tbody>
					<?php
						//Dibujo la lista de los archivos.	
						$bck        = new Backend_html();
						$bck->traer_adjuntos_docs($_GET['id'])
					?>
					</tbody>
				  </table>			
        </div>
      </div>
</div>

</body>

</html>