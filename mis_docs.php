<?php
	include('./libs/Backend.php');
	session_start();
?>

<!DOCTYPE html>
<html>

<?php
	
	if (!(isset($_SESSION['usuario'])))
	{
		echo '<div class="alert alert-danger" style="margin-top:15px;">';
			echo '<b>URL</b> mal armada<br>Redireccionando al home...';
		echo '</div>';	
	}
	
?>

<head>

	<title>Docu - Mis documentos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- JQUERY -->	
	<script src="./js/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
	
    <!--TAGIT-->
    <script src="./js/tag-it.js" type="text/javascript" charset="utf-8"></script>
	
	<!-- Bootstrap -->
	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
	
	<!--Javascript-->
	<script language="javascript">
	
		function borrar(id)
		{
			//Si hace click en aceptar.
			if (confirm("¿Desea borrar este documento?, este cambio es irreversible."))
			{
				var url = "mis_docs.php?user=<?php echo $_SESSION['usuario'];?>&delete="+id;
				location.href=url;
			}
		}
		
	</script>
	
</head>

<body style="background:#EEEEEE;">

	<div style="width:800px;margin:auto;margin-top:30px;margin-bottom:70px;">
		
		<div>
			<?php
				logo();
			?>	
		</div>
		
		<?php
			
			//Reviso si la sesion esta activa.
			if (isset($_SESSION['usuario']))
			{
				//Si llega el cmd de borrar.
				if (isset($_GET['delete']))
				{					
					$bck   =  new Backend_html();
					
					//Si se pudo borrar.
					if ($bck->borrar_documento($_GET['delete']))
					{
						//Muestra msj de error.
						echo '<div class="alert alert-success" style="margin-top:15px;">';
							echo '<b>OK!</b><br> documento borrado con exito.';
						echo '</div>';

						redireccionar(1,'mis_docs.php?user='.$_SESSION['usuario']);
					}
					else
					{
						//Muestra msj de error.
						echo '<div class="alert alert-danger" style="margin-top:15px;">';
							echo '<b>Error!</b><br> no se ha podido borrar el documento.';
						echo '</div>';
						
						redireccionar(1,'mis_docs.php?user='.$_SESSION['usuario']);
					}
				}		
			
				//Si es valida la URL.
				if (isset($_GET['user']))
				{
					//*******
				}
				else
				{
					//Muestra msj de error.
					echo '<div class="alert alert-danger" style="margin-top:15px;">';
						echo '<b>URL</b> mal armada<br>Redireccionando al home...';
					echo '</div>';
					
					//Redirecciona.
					redireccionar(2,'index.php');
					exit;				
				}
			}
			else
			{
				//No esta activa la sesion.
				echo '<div class="alert alert-danger" style="margin-top:15px;">';
					echo '<b>ERROR</b> es necesario inisiar la sesi&oacute;n.';
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
					<b>Mis documentos</b>
				</span>
			</div>
			<div style="width:500px;margin:auto;margin-top:30px;">
				<!-- TITULO -->
				<p style="color:#AAAAAA;">
					<b>Documentos creados por:</b>&nbsp;<span class="label label-primary" style="padding:4px;"><b><?php echo ucfirst($_SESSION['usuario']);?></b></span>
					<br>
					<!--LISTADO DE DOCUMENTOS-->
					<div>
						<table class="table table-striped" style="width:515px;">
						<thead>
							<tr>
								<th>T&iacute;tulo</th>
								<th>Fecha</th>
								<th>Categoria</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php
								//Listo los doc hechos.
								$bck     =  new Backend_html();
								$bck->ver_docs_usuario($_GET['user']);
							?>
						</tbody>
						</table>
					</div>
				</p>							
				<p>
					<a class="btn btn-warning btn-info" href="javascript:history.back();" style="margin-left:0px;">
						<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Volver
					</a>&nbsp;
					<a class="btn btn-warning btn-info" href="index.php" style="margin-left:0px;">
						<span class="glyphicon glyphicon-home"></span>&nbsp;Volver a Inicio
					</a>					
				</p>
			</div>
		</div>
	</div>

</body>

</html>