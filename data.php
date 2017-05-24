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
	
	<!--CSS TAGIT-->
	<link href="css/jquery.tagit.css"     rel="stylesheet" type="text/css">
    <link href="css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">	
	
	<script language="javascript">
		$(document).ready(function()
		{
			//Setear codigo tags.
            $('#restric_doc_tags').tagit(
			{
                singleField: true,
                singleFieldNode: $('#restric_doc')
            });
			
			$("#guardar_btn").click(function()
			{
				$("#form_doc").submit();
			});
		});
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
		
			//Variables comunes
			$usuario = 'dcipolat';
			$titulo  = null;
			$descrip = null;
			$categ   = null;
			$permit  = null;
			$firmas  = null;
			$permit  = null;
			$fecha   = null;

			//Controla el acceso a la pantalla.	
			$bck     =  new Backend_html();
			$resu    = $bck->valid_usuario_data();
			
			//Binding de datos con campos.
			$creador = $resu['usuario'];
			$titulo  = $resu['titulo'];
			$descrip = $resu['descrip'];
			$categ   = $resu['categ'];
			$firmas  = $resu['firmas'];
			$permit  = $resu['permitidos'];
			$cambcfg = $resu['cambcfg'];
			
			//Controla la guarda de los datos.
			if (isset($_POST['tit_doc']))
			{
				//echo json_encode($_POST);
				$bck     =  new Backend_html();
				
				//Si se puedo actualizar.
				if ($bck->actualizar_data_doc())
				{
					//Se pudo modif, vuelvo al editor.
					echo '<div class="alert alert-success" styl="margin-top:10px;">';
						echo '<b>OK</b>, Datos <u><b>actualizados</b></u>, volviendo al editor...';
					echo '</div>';
					
					//Redirecciono de nuevo al editor.
					redireccionar(2,'editar.php?id='.$_GET['id']);
				}
				else
				{
					//Si no se pudo modif, muesrto el error.
					echo '<div class="alert alert-danger" styl="margin-top:10px;">';
						echo '<b>Ups</b> hubo un problema al actualizar los datos, intenta otra vez';
					echo '</div>';				
				}
			}
		?>
		<!--MENU LOGIN-->
		<div id="barra_login" style="margin-top:10px;margin-right:5px;">
			<?php
				if (isset($_SESSION['usuario']))
				{
					echo barra_login_home();
				}
				else
				{
					redireccionar(0,'index.php');
				}
			?>
		</div>
		<!--DOCUMENTO-->		
		<div class="hero-unit" style="background:white;padding:20px;margin-top:42px;">
			<div style="border-bottom:1px solid #e7e7e7;padding-bottom:2px;">
				<img src="./imgs/libro.png" style="margin-top:-11px;">
				<span style="color:#AAAAAA;font-size:25px;">
					<b>Editar documento</b>
				</span>
			</div>
			<form action="data.php?id=<?php echo $_GET['id']; ?>" method="post" id="form_doc">
				<div style="width:500px;margin:auto;margin-top:30px;">
					<!-- TITULO -->
					<p style="color:#AAAAAA;">
						<b>Escriba el titulo del documento:</b>
					</p>
					<div>
						<input type="text" value="<?php echo $titulo; ?>" id="tit_doc" name="tit_doc" placeholder="Titulo del documento" style="width:460px;border:1px solid silver;padding:5px;">
					</div>
					<br>
					<!-- DESCRIPCION -->
					<div>
						<p style="color:#AAAAAA;">
							<b>Escriba una breve descripci&oacute;n:</b>
						</p>
						<textarea id="descrip_doc" name="descrip_doc" placeholder="Descripcion del documento" style="border:1px solid silver;width:460px;height:100px;" maxlength="300"><?php echo $descrip; ?></textarea>					
					</div>
					<br>
					<!-- CATEGORIA -->
					<div style="margin-top:0px;">
						<div>
							<p style="color:#AAAAAA;">
								<b>&iquest;Que categor&iacute;a?</b>
							</p>							
						</div>
						<select style="padding:5px;" name="categ_buscar">
						<?php
							$bck   =  new Backend_html();
							$bck->traer_categorias($categ);
						?>
						</select>
					</div>
					<br>
					<!-- FIRMAS -->
					<div style="margin-top:-80px;width:313px;margin-left:150px;margin-bottom:30px;">
						<div>
							<p style="color:#AAAAAA;">
								<b>&iquest;Habilitar firma de usuarios?</b>
							</p>							
						</div>
						<input type="checkbox" <?php if ($firmas==1) echo 'checked';?> name="firma_doc">&nbsp;Permtir dar la conformidad a este documento.
					</div>						
					<!-- USUARIOS PERMITIDOS -->
					<div>
						<p style="color:#AAAAAA;">
							<b>Usuarios permitidos, para acceso y modificaci&oacute;n:</b><br>
							<i>Esta opci&oacute;n es <u>optativa</u>, permite restringir el acceso al documento.<br>
							<i style="color:black;">Escribi los nombres de usuarios separados por una coma "," y estos se<br>
							convertiran en tags.</i>
						</p>
						<!--Almacena en un campo oculto los usuarios separados por comas-->
						<input name="restric_doc" id="restric_doc" style="display:none;" value="<?php echo $permit; ?>">
						<!--Listado de usuarios con tags-->
						<ul id="restric_doc_tags" style="width:460px;"></ul>
					</div>
					<!-- CAMBIAR CONFIG. -->
					<div style="margin-top:20px;width:453px;margin-left:0px;margin-bottom:30px;margin-top:25px;">
						<div>
							<p style="color:#AAAAAA;">
								<b>&iquest;Habilitar a los usuarios permitidos a cambiar configuraci&oacute;n?</b>
							</p>							
						</div>
						<div style="margin-top:-2px;">
							<input type="checkbox"  <?php if ($cambcfg==1) echo 'checked';?> name="cambiarcfg_Doc">&nbsp;Permitir cambiar configuraci&oacute;n.
						</div>
					</div>				
				</form>
				<p>
					<a class="btn btn-primary btn-large" id="guardar_btn">Guardar</a>
					<a class="btn btn-warning btn-large" href="editar.php?id=<?php echo $_GET['id'];?>" style="margin-left:8px;">
						Volver
					</a>
				</p>
			</div>
		</div>
	</div>

</body>

</html>