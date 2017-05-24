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
	
	<!-- Bootstrap -->
	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
		
	<script type="text/javascript">	
		//Js de la pagina.
		$(document).ready(function()
		{
			//Cuando se hace click en el link de buscar.
			$("#btn_buscar").click(function()
			{	
				if ($("#buscar").val()!="")
				{
					$("#form_buscar").submit();
				}
				else
				{
					alert("Debe escribir el texto del titulo a buscar, o una parte del mismo para encontrar similitudes.");
				}					
			});	
		});
	</script>
	
</head>

<body style="background:#EEEEEE;">

	<div style="width:890px;margin-top:40px;height:350px;margin-bottom:20px;margin:auto;">
		<!-- BANNER -->
		<div id="banner_docudc">			
			<?php
				logo();
			?>			
		</div>
		<!--MENU LOGIN-->
		<div id="barra_login" style="margin-top:10px;">
			<?php
				echo barra_login_home();
			?>
		</div>
		<br>
		<!--CUERPO-->
		<div id="cuerpo_docudc" class="hero-unit" style="height:425px;background:white;padding:20px;margin-top:8px;padding-top:30px;">
			<div style="padding-bottom:2px;">
				<!-- TOTAL DE DOCUMENTOS-->
				<?php
						$bck        =  new Backend_html();
						$total_docs = $bck->traer_total_docs();										
				?>
				<div>
					<div style="float:left;">
						<img src="./imgs/libro.png" style="margin-top:-11px;">
					</div>
					<div style="color:#AAAAAA;font-size:15px;margin-top:-5px;float:left;margin-left:5px;">
						<b><?php echo $total_docs; ?></b>
						documentos creados!
					</div>
				</div>
				<br>
				<!--BUSCADOR-->
				<form method="get" action="buscar.php" id="form_buscar">
					<div>
						<div style="color:#AAAAAA;margin-top:5px;">
							<b>Buscar un documento por titulo:</b>
							<br>
							<input type="text" name="buscar" id="buscar" placeholder="Escriba el titulo a buscar" style="width:350px;margin-top:5px;border:1px solid silver;padding:5px;">
						</div>
						<div style="margin-top:5px;">
							<!--Boton buscar-->
							<button class="btn btn-primary" id="btn_buscar" type="button" style="margin-top:5px;">
								<span class='glyphicon glyphicon-search'></span>&nbsp;Buscar
							</button>
							<!--Boton nuevo documento-->
							<?php
								//Si esta el usuario logeado.
								if (isset($_SESSION['usuario']))
									echo "<a href='nuevo.php' class='btn btn-success' type='button' style='margin-top:5px;margin-left:8px;'>
											<span class='glyphicon glyphicon-plus'></span>&nbsp;Nuevo documento
										  </a>";
								else
									echo "<a href='#' class='btn btn-default' type='button' style='margin-top:5px;margin-left:8px;'>
											<span class='glyphicon glyphicon-star'></span>&nbsp;<b>Inicia sesi&oacute;n</b> para crear un doc
										  </a>";
							?>
						</div>
					 </div>
				</form>
			</div>			
			<!-- Listado de documentos -->
			<div id="cuerpo_docus" style="margin-top:15px;float:left;width:480px;">
				<!--Titulo lista documentos-->
				<div id="cuerpo_docs_titulos" style="color:#AAAAAA;border-bottom:1px solid #e7e7e7;width:450px;margin-bottom:10px;">
					<b>Ultimos documentos creados</b>
				</div>				
				<!--Lista de links de documentos-->
				<div id="cuerpo_docs" style="width:480px;margin-top:3px;background:REd;">
					<div style="padding-left:0px;float:left;margin-left:20px;margin-right:100px;">										
						<?php
							//Dibujo el listado de los links.
							$bck =  new Backend_html();
							$bck->traer_ultimos_docs();
						?>
					</div>
				</div>				
			</div>			
			<!-- Listado de usuarios -->
			<div id="cuerpo_user" style="margin-left:0px;margin-top:15px;float:left;width:150px;">
				<!--Titulo ranking-->
				<div id="cuerpo_usuarios" style="color:#AAAAAA;border-bottom:1px solid #e7e7e7;width:150px;margin-bottom:10px;">
					<b>Ranking usuarios</b>
				</div>
				<!--Listado links usuarios-->
				<div id="cuerpo_usuarios_ranking" style="width:450px;margin-top:3px;">
					<ul style="padding-left:0px;float:left;margin-left:20px;margin-right:100px;">
						<?php
							//Dibujo el listado de los links.
							$bck =  new Backend_html();
							$bck->ranking_usuarios();
						?>
					</ul>					
				</div>				
			</div>			
			<!-- Listado de tags -->
			<div id="cuerpo_user" style="margin-left:20px;margin-top:15px;float:left;width:150px;">
				<div id="cuerpo_usuarios" style="color:#AAAAAA;border-bottom:1px solid #e7e7e7;width:150px;margin-bottom:10px;">
					<b>Categorias</b>
				</div>
				<div id="cuerpo_usuarios_ranking" style="width:450px;margin-top:3px;">
					<ul style="padding-left:0px;float:left;margin-left:20px;margin-right:100px;">					
						<?php
							//Dibujo el listado para buscar por categoria.
							$bck =  new Backend_html();
							$bck->dibujar_items_categoria()
						?>
					</ul>					
				</div>				
			</div>						
		</div>
	</div>

</body>

</html>