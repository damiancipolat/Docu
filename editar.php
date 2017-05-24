<?php
	include('./libs/Backend.php');
	session_start();	
?>

<!DOCTYPE html>
<html>

<head>

	<title>Editar documento</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- JQUERY -->	
	<script src="./js/jquery.min.js"></script>
	
	<!-- Bootstrap -->
	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">	
	
	<!-- TinyMce -->
	<script type="text/javascript" src="./js/tinymce/tinymce.min.js"></script>
	
	<!-- JS TINYMCE -->	
	<script type="text/javascript">
		//Js de la pagina.
		$(document).ready(function()
		{
			$("#componente").height($(document).height()-375);
			
			$("#guardar_btn").click(function()
			{
				$("#form_editar").submit();
			});
			
			$(window).resize(function()
			{
				$("#componente").height($(document).height()-375);
			})
			
			$("#adjuntar_btn").click(function()
			{
				window.open("adjuntos.php?id=<?php echo $_GET['id']; ?>","_blank","menubar=no,toolbar=no, scrollbars=yes,status=no, resizable=yes, width=630, height=400,fullscreen=no")			
			});	
			
		});
		
		//JS del editor.
		tinymce.init(
		{
				selector: "textarea",
				plugins: [
							"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
							"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
							"table contextmenu directionality emoticons template textcolor paste fullpage textcolor"
						 ],
				toolbar1: "fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
				toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | inserttime preview | forecolor backcolor",
				toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",
				menubar: false,
				toolbar_items_size : 'small',
				relative_urls      : true,
				remove_script_host : false,
				convert_urls       : true,
				style_formats: [
									{title: 'Bold text', inline: 'b'},
									{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
									{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
									{title: 'Example 1', inline: 'span', classes: 'example1'},
									{title: 'Example 2', inline: 'span', classes: 'example2'},
									{title: 'Table styles'},
									{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
							   ],
				templates: [
								{title: 'Test template 1', content: 'Test 1'},
								{title: 'Test template 2', content: 'Test 2'}
						   ]
		});
	</script>
	
</head>

<?php
	//Variables globales.
	$usuario = null;
	$titulo  = null;
	$creador = null;
	$texto   = null;
	
	//Si se ha iniciado la sesion.
	if (isset($_SESSION['usuario']))
	{
		//VALIDAR URL.
		if (isset($_GET['id']))
		{
			//Traigo la info del docu.
			$bck     =  new Backend_html();
			$resu    = $bck->traer_doc($_GET['id']);		
			$titulo  = $resu['titulo'];
			$creador = $resu['usuario'];
			$usuario = $_SESSION['usuario'];
			$permit  = $resu['permitidos'];
			$cambcfg = $resu['cambcfg'];
			$texto   = base64_decode($resu['texto']);			

			
			//ACTUALIZAR CONTENIDO: Si se recibe en el post el contenido del documento.
			if (isset($_POST['componente']))
			{
				//Obtengo los datos de la bd.
				$bck   =  new Backend_html();
				$id    = $_GET['id'];
				$html  = base64_encode($_POST['componente']);
					
				//Si logro actualizarlo.
				if ($bck->actualizar_docu($id,$html))
				{
					//Muestro el ok.
					echo '<div class="alert alert-success" id="msj_info">';
						echo '<!--<a href="javascript:$(\'#msj_info\').hide();" style="margin-left:5px;margin-right:8px;color:white;padding:3px;background:green;"><b>X</b></a>-->'.
							 'Documento <u><b>guardado</b></u> con <b>exito</b>!&nbsp;'.'<span class="glyphicon glyphicon-ok-circle"></span>&nbsp;'.
							 '<!--<a href="docu.php?id='.$id.'" style="margin-left:5px;color:#468847;text-decoration:none;"><u>Haga click aqui, para ver el documento.</u></a>-->';
					echo '</div>';
					
					//Redireccionar.
					redireccionar(2,'editar.php?id='.$_GET['id']);
				}
				else
				{
					//Muestro el error.
					echo '<div class="alert alert-danger" id="msj_info">';
						echo '<a href="javascript:$(\'#msj_info\').hide();" style="margin-left:5px;margin-right:8px;color:white;padding:3px;background:#b94a48;"><b>X</b></a>'.'<b>Ups!</b> hubo un problema al intentar guardar el documento, intenta otra vez.';
					echo '</div>';		
				}
			}			
			
			//ACCESO DOCUMENTO: Si se obtiene el id, del documento.
			if ($permit!="")
			{
				//Compruebo que el usuario logeado pertenezca a esa lista o si es el creador.
				if (!(usuario_tiene_acceso($_SESSION['usuario'],$permit,$creador)))
				{
					//No hay acceso.
						echo '<div class="alert alert-danger" style="margin:30px;">';
							echo '<b>ERROR</b>, Acceso restringido al documento.<br>Para poder verlo, hace falta que el usuario sea incluido..';
						echo '</div>';
			
					//Vuelvo al home.
					redireccionar(2,'index.php');					
					exit;					
				}
			}
			
			//Si no hay ningun texto cargado.
			if ($texto=="")
				$texto ="<b>NO HAY NINGUN TEXTO CARGADO</b><br><h1><i>Usa el editor para crear tu documento.</i></h3>";
		}
		else
		{
			//Si no se pudo modif, muesrto el error.
			echo '<div class="alert alert-danger" style="margin:30px;">';
				echo '<b>ERROR</b>, Url mal armada,<br> redireccionando al home.';
			echo '</div>';
			
			//Vuelvo al home.
			redireccionar(2,'index.php');
			exit;
		}
	}
	else
	{
			//Si no se pudo acceder, por que hace falta session.
			echo '<div class="alert alert-danger" style="margin:30px;">';
				echo '<b>ERROR</b>, hace falta iniciar sesi&oacute;n.<br>Redireccionando al login.';
			echo '</div>';
			
			//Vuelvo al home.
			redireccionar(2,'login.php');
			exit;
	}
?>

<body style="background:#EEEEEE;padding:25px;">

	<!--CUERPO-->
	<div style="margin:auto;margin-top:0px;">
	
		<!--MENU LOGIN-->
		<div id="barra_login" style="margin-top:-20px;margin-right:5px;">
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
		<br>		
		<div class="hero-unit" style="background:white;overflow:auto;padding:25px;margin-top:8px;">
			<!--BANNER-->
			<div style="border-bottom:1px solid #e7e7e7;padding-bottom:2px;padding-bottom:10px;">
				<img src="./imgs/libro.png" style="margin-top:-11px;">
				<span style="color:#AAAAAA;font-size:20px;">
					<b><?php echo ucfirst($titulo); ?></b>
				</span>
				<br>
				<!--Barra de menu-->	
				<div class="btn-group" style="margin-top:8px;">
					  <!--Boton HOME-->
					  <div class="btn btn-default">
							<span class="glyphicon glyphicon-home"></span>&nbsp;														
							<a href="index.php">
								Inicio
							</a>
					  </div>
					  <!--Boton Inicio-->
					  <div class="btn btn-default">
							<img src="./imgs/flecha_izq.png" style="margin-top:-2px;">
							<a href="javascript:history.back();">
								Volver
							</a>
					  </div>
					  <!--Boton Editar-->
					  <div class="btn btn-default" <?php if (($usuario!=$creador)&&($cambcfg==0)){echo "style='display:none;'";} ?>>
						<span class="glyphicon glyphicon-cog"></span>&nbsp;
						<a href="data.php?id=<?php echo $_GET['id'];?>">
							Editar datos
						</a>
					  </div>
					  <!--Boton Ver-->
					  <div class="btn btn-default">
						<span class="glyphicon glyphicon-globe"></span>&nbsp;
						<a href="docu.php?id=<?php echo $_GET['id'];?>" target="_blank" title="Ver documento guardado.">
							Ver
						</a>
					  </div>					  
					  <!--Lecturas-->
					  <div class="btn btn-default">
						<span class="glyphicon glyphicon-user"></span>
							<a href="#">Creador&nbsp;<i><b><?php echo ucfirst($creador); ?></i></b></a>
					   </div>
					</div>
				<br>
			</div>	
			<div style="margin-top:8px;">		
					<!--Guardar documento-->
					<a class="btn btn-primary btn-large" id="guardar_btn" title="Guardar documento.">
						<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Guardar
					</a>
					<!--Adjuntar archivo-->
					<a class="btn btn-warning btn-large" href="#" style="margin-left:4px;" id="adjuntar_btn" title="Adjuntar una magen para incluir al documento">
						<span class="glyphicon glyphicon-paperclip"></span>&nbsp;Adjuntar imagen
					</a>
			</div>			
			<!--DOCUMENTO-->
			<div style="margin-top:10px;">
				<!--EDITOR-->
				<div style="margin-top:10px;">
					<form method="post" action="editar.php?id=<?php echo $_GET['id'];?>" id="form_editar" name="form_editar">						
						<textarea id="componente" name="componente" style="width:100%">
							<?php echo $texto;?>
						</textarea>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</body>

</html>