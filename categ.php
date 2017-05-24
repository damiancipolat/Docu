<?php
	include('./libs/Backend.php');
	session_start();	
?>

<!DOCTYPE html>
<html>

<head>

	<title>Docu - Categorias</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- JQUERY -->	
	<script src="./js/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
	
    <!--TAGIT-->
    <script src="./js/tag-it.js" type="text/javascript" charset="utf-8"></script>
	
	<!-- Bootstrap -->
	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
	
	<script language="javascript">

		function agregar()
		{			
			var val = prompt("Nueva categoria:","");

			if (val!="")
			{
				location.href="categ.php?new="+val;
			}
		}
		
		function editar(id)
		{			
			var val = prompt("Modificar texto:","");

			if (val!="")
			{
				location.href="categ.php?edit="+id+"&val="+val;
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
					<b>Categor&iacute;as</b>
				</span>
			</div>
			
		<!--PHP-->
		<?php	
			//Si esta activa la sesion y el usuario es el admin.
			if ((isset($_SESSION['usuario']))&&(strtoupper($_SESSION['usuario'])=='ADMIN'))
			{
			
				//Si se pudo Agregar.
				if (isset($_GET['new']))
				{
					$bck     =  new Backend_html();
					
					//Agregar nueva categoria
					if ($bck->agregar_categ($_GET['new']))
					{
						echo "<div class='alert alert-error' style='background:green;color:white;'>";
							echo "Categor&iacute;a agregada&nbsp;<b>OK</b>!";
						echo "</div>";
						
						redireccionar(2,'categ.php');
					}
					else
					{
						echo "<div class='alert alert-error' style='background:pink;color:white;'>";
							echo "<b>Ups hubo un error</b><br>intenta otra vez.";
						echo "</div>";
						
						redireccionar(2,'categ.php');
					}	
				}
			
				//Si se pudo modificar.
				if ((isset($_GET['edit']))&&(isset($_GET['val'])))
				{
					$bck     =  new Backend_html();
					
					//Si se pudo modif.
					if ($bck->editar_categ($_GET['edit'],$_GET['val']))
					{
						echo "<div class='alert alert-error' style='background:green;color:white;'>";
							echo "Categor&iacute;a modif&nbsp;<b>OK</b>!";
						echo "</div>";
						
						redireccionar(2,'categ.php');
					}
					else
					{
						echo "<div class='alert alert-error' style='background:pink;color:white;'>";
							echo "<b>Ups hubo un error</b><br>intenta otra vez.";
						echo "</div>";
						
						redireccionar(2,'categ.php');
					}					
				}
				
				//Si llega el parametro de borrar categoria.
				if (isset($_GET['del']))
				{
					$bck     =  new Backend_html();
					
					//Si se pudo borrar.
					if ($bck->borrar_categ($_GET['del']))
					{
						echo "<div class='alert alert-error' style='background:green;color:white;'>";
							echo "Nueva categor&iacute;a agregada&nbsp;<b>OK</b>!";
						echo "</div>";
						
						redireccionar(2,'categ.php');					
					}
					else
					{
						echo "<div class='alert alert-error' style='background:pink;color:white;'>";
							echo "<b>Ups hubo un error</b><br>intenta otra vez.";
						echo "</div>";
						
						redireccionar(2,'categ.php');
					}				
				}
			}
			else
			{
				echo "<div class='alert alert-error' style='background:pink;color:white;'>";
					echo "<b>Sesion inactiva, solo se permite al <u>administrador</u></b>";
				echo "</div>";
				
				exit;
			}
		?>
			
			<div style="width:500px;margin:auto;margin-top:30px;">
				<!-- TITULO -->
				<p style="color:#AAAAAA;">
					<b>Listado de categor&iacute;as</b>&nbsp;(solo se mostrar&aacute;n las que est&aacute;n activas).
					<br>	
						<div>
							<span class='glyphicon glyphicon-remove'></span>&nbsp;&nbsp;Al borrar una categor&iacute;a, se desvinculan los documentos que la posean.
						</div>
					<br>					
					<a href="javascript:agregar();" title="Haga click para agregar una nueva categoria"><img src='./imgs/tag.gif'>&nbsp;Agregar nueva categor&iacute;a</a>
					<br>
					<br>
					<!--LISTADO DE DOCUMENTOS-->
					<div>
						<table class="table table-striped" style="width:515px;">
						<thead>
							<tr>
								<th>Categor&iacute;a</th>
								<th>Acci&oacute;n</th>
							</tr>
						</thead>
						<tbody>
							<?php
								//Listo los doc hechos.
								$bck     =  new Backend_html();
								$bck->listar_categorias_activas();
							?>
						</tbody>
						</table>
					</div>
				</p>							
				<p>	
					<a class="btn btn-warning btn-info" href="index.php" style="margin-left:0px;">
						<span class="glyphicon glyphicon-home"></span>&nbsp;Volver a Inicio
					</a>					
				</p>
			</div>
		</div>
	</div>

</body>

</html>