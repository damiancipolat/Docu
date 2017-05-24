<?php
	include('./libs/Backend.php');
	session_start();	
?>

<!DOCTYPE html>
<html>

<head>

	<title>Docu</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- JQUERY -->	
	<script src="./js/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
	
    <!--TAGIT-->
    <script src="./js/tag-it.js" type="text/javascript" charset="utf-8"></script>
	
	<!-- Bootstrap -->
	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
	
</head>

<body style="background:#EEEEEE;">

	<div style="width:800px;margin:auto;margin-top:30px;margin-bottom:70px;">
		
		<div>
			<?php
				logo();
			?>	
		</div>
		
		<?php
			
			//Variables comunes
			$creador = null;
			$titulo  = null;
			$fecha   = null;

			//Analiza si la url esta bien armada.
			if (isset($_GET['id']))
			{
				//Traigo la info del doc.
				$bck     =  new Backend_html();				
				$resu    = $bck->traer_doc($_GET['id']);
				
				//Binding de datos con campos.
				$creador = $resu['usuario'];
				$titulo  = $resu['titulo'];
				$fecha   = $resu['fecha'];
			}
			else
			{
				//Muestra msj de error.
				echo '<div class="alert alert-danger" styl="margin-top:15px;">';
					echo '<b>URL</b> mal armada<br>Redireccionando al home...';
				echo '</div>';
				
				//Redirecciona.
				redireccionar(2,'index.php');
				exit;
			}
			
		?>
		
		<!--MENU LOGIN-->
		<div id="barra_login" style="margin-top:10px;margin-right:5px;">
			<?php
					echo barra_login_home();
			?>
		</div>
		<!--DOCUMENTO-->		
		<div class="hero-unit" style="background:white;padding:20px;margin-top:42px;">
			<div style="border-bottom:1px solid #e7e7e7;padding-bottom:2px;">
				<img src="./imgs/libro.png" style="margin-top:-11px;">
				<span style="color:#AAAAAA;font-size:25px;">
					<b>Registro de cambios</b>
				</span>
			</div>
			<div style="width:500px;margin:auto;margin-top:30px;">
				<!-- TITULO -->
				<p style="color:#AAAAAA;">
					<b>Datos documento:</b>
					<br>
					<!--Datos del documento-->
					<div style="margin-top:3px;">
					<?php
						echo "<b><i>- Titulo:</i></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$titulo."<br>";
						echo "<b><i>- Creador:</i></b>&nbsp;".ucfirst($creador)."<br>";
						echo "<b><i>- Fecha:</i></b>&nbsp;&nbsp;&nbsp;&nbsp;".$fecha."<br>";
					?>
					</div>
					<div style="margin-top:20px;color:#AAAAAA;border-bottom:1px solid silver;padding-bottom:5px;">
						<b>Cambios realizados</b>
					</div>
					<!--LISTADO DE MODIFICADIONES-->
					<div>
						<table class="table table-striped">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Usuario</th>
							</tr>
						</thead>
						<tbody>
							<?php
								//Listo las modificaciones hechas.
								$bck     =  new Backend_html();				
								$resu    = $bck->ver_log($_GET['id']);						
							?>
						</tbody>
						</table>
					</div>
				</p>							
				<p>
					<a class="btn btn-warning btn-info" href="javascript:history.back();" style="margin-left:0px;">
						<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Volver
					</a>
					&nbsp;
					<a class="btn btn-warning btn-info" href="index.php" style="margin-left:0px;">
						<span class="glyphicon glyphicon-home"></span>&nbsp;Volver a Inicio
					</a>					
				</p>
			</div>
		</div>
	</div>

</body>

</html>