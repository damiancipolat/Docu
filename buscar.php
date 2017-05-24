<?php
	include('./libs/Backend.php');
	session_start();	
?>

<!DOCTYPE html>
<html>

<head>

	<title>Docu - Buscar</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- JQUERY -->	
	<script src="./js/jquery.min.js"></script>
	
	<!-- Bootstrap -->
	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
	
	<script language="javascript">
		$(document).ready(function()
		{
			$("#btn_buscar").click(function()
			{
				$("#form_buscar").submit();
			});
		});
	</script>
	
</head>

<body style="background:#EEEEEE;">

	<div style="width:800px;margin:auto;margin-top:80px;margin-bottom:60px;">
		<!--LOGO-->
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
		<!--Cuerpo-->
		<div class="hero-unit" style="background:white;padding:20px;margin-top:45px;">
			<div>
				<div style="border-bottom:1px solid #e7e7e7;padding-bottom:2px;">
					<img src="./imgs/libro.png" style="margin-top:-11px;">
					<span style="color:#AAAAAA;font-size:25px;"><b>Buscar documentos</b></span>
				</div>				
				<div style="width:500px;margin-top:30px;">
					<!--Titulo-->
					<p style="color:#AAAAAA;">
						<b>Escriba el titulo del documento</b>
					</p>
					<form action="buscar.php" method="post" id="form_buscar">
						<!--Texto-->
						<div>
							<input type="text" name="titulo_buscar" placeholder="Titulo del documento" maxlength="200" style="width:460px;padding:5px;background:white;border:1px solid silver;">
						</div>
						<!--Categoria-->
						<div style="margin-top:15px;">
								<div>
									<p style="color:#AAAAAA;">
										<b>&iquest;Cual categor&iacute;a?</b>
									</p>							
								</div>
								<select style="padding:5px;" name="categ_buscar">
									<option value='-1'>Todos</option>
									<?php
										$bck   =  new Backend_html();
										$categ = '';
										
										//Si viene el dato del combo buscar.
										if (isset($_POST['categ_buscar']))
											$categ = $_POST['categ_buscar'];

										//Si viene el dato del combo buscar.
										if (isset($_GET['categ']))
											$categ = $_GET['categ'];
											
										$bck->traer_categorias($categ);
									?>
								</select>
						</div>
					</form>
					<br>
					<p>
						<!--Boton de buscar-->
						<a class="btn btn-primary btn-large" id="btn_buscar">
							<span class="glyphicon glyphicon-search"></span>&nbsp;Buscar
						</a>
					</p>
				</div>
				<!-- El resto de cosas-->
				<div style="margin-top:18px;border:1px dotted gray;"></div>
				<!--Resultado de la busqueda-->
				<div style="margin-top:px;">
					<br>
					<?php
						//Si no se encontro nada.
						$resu = false;
					
						//Buscar por categoria.
						if (isset($_GET['categ']))
						{
							$resu = true;
							$bck  =  new Backend_html();
							$bck->buscar_documentos_categoria($_GET['categ']);						
						}
						
						//Buscar por titulo.
						if (isset($_GET['buscar']))
						{
							$resu = true;
							$bck  =  new Backend_html();
							$bck->buscar_documentos_titulo($_GET['buscar']);						
						}
					
						//Buscar por titulo y categoria.
						if ((isset($_POST['categ_buscar']))&&(isset($_POST['titulo_buscar'])))
						{						
								$resu = true;
								$bck  =  new Backend_html();
								$bck->buscar_documentos($_POST['titulo_buscar'],$_POST['categ_buscar']);
						}
						
						//No se pidio buscar.
						if ($resu==false)
						{
							echo "<i>A&uacute;n no se ha hecho ninguna busqueda.</i>";
						}
					?>					
				</div>				
			</div>			
		<div>		
	</div>
	
	<!-- BOTON DE VOLVER -->
	<div style="margin-top:5px;">
		<a class="btn btn-primary btn-info" href="javascript:history.back();" id="guardar_btn" title="Guardar documento.">
			<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Volver
		</a>&nbsp;
		<a class="btn btn-primary btn-info" href="index.php" id="home_btn" title="Volver al home.">
			<span class="glyphicon glyphicon-home"></span>&nbsp;Ir a inicio
		</a>&nbsp;
	</div>
	
</body>

</html>