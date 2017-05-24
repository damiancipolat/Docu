<?php
	include('./libs/Backend.php');
	session_start();	
?>

<!DOCTYPE html>
<html>

<head>

	<title>Ver documento</title>
		
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/
	
	
	<!-- JQUERY -->	
	<script src="./js/jquery.min.js"></script>
	
	<!-- Bootstrap -->
	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
	<script src="./js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		var estado_firma=0;
	
		//Js de la pagina.
		$(document).ready(function()
		{
			$("#firmas_div").hide();
			$("#firmas_link_bajar").show();
			$("#firmas_link_subir").hide();
			
			//Cuando se hace click en el icono de ver descripcion.
			$("#descrip_ver").click(function()
			{
				$("#descrip_ver").hide();
				$("#descrip_ocultar").show();
				$("#descrip_div").show();
			});
			
			//Cuando se hace click en el icono de ocultar descripcion.
			$("#descrip_ocultar").click(function()
			{
				$("#descrip_ver").show();
				$("#descrip_ocultar").hide();
				$("#descrip_div").hide();
			});
			
			//Cuando se hace click en el icono de ver firmas.
			$("#firmas_link_bajar").click(function()
			{	
					$("#firmas_div").show();
					$("#firmas_link_bajar").hide();
					$("#firmas_link_subir").show();
					$("#icon_arrow").attr("src", "imgs/flecha_up.png");				
			});
			
			//Cuando se hace click en el icono de ver firmas.
			$("#firmas_link_subir").click(function()
			{	
					$("#firmas_div").hide();
					$("#firmas_link_bajar").show();
					$("#firmas_link_subir").hide();
					$("#icon_arrow").attr("src", "imgs/flecha_down.png");
			});			
		});
	</script>
	
</head>

<?php
	$usuario    = null;
	$titulo     = null;
	$creador    = null;
	$lecturas   = null;
	$permitidos = null;
	$firmas     = null;
	$texto      = null;
	$usuario    = null;
	$descrip    = null;
		
	if (isset($_GET['id']))
	{
		//Creo el objeto que instancia al backend.
		$bck        = new Backend_html();		
		
		//Grabo la lectura del documento.		
		$bck->grabar_leido($_GET['id']);
		
		//Traigo los datos del doc de la bd.
		$resu       = $bck->traer_doc($_GET['id']);			
	
		//Bindeo los datos, de la bd.
		$titulo     = $resu['titulo'];
		$creador    = $resu['usuario'];
		$texto      = base64_decode($resu['texto']);
		$lecturas   = $resu['lecturas'];
		$permitidos = $resu['permitidos'];
		$descrip 	= $resu['descrip'];
		
		//Dice si es permitido o no.
		if ($resu['firmas']=='0')
			$firmas = false;		
		else
			$firmas = true;
			
		//Si recibo el param de firmar y estoy logeado.
		if ((isset($_GET['firmar']))&&(isset($_SESSION['usuario'])))
		{	
			$bck        = new Backend_html();		
			
			//Si se pudo firmar.			
			if ($bck->doc_firmar($_GET['id'],$_SESSION['usuario']))
			{
				//Muestra msj de ok.
				echo '<div class="alert alert-success" styl="margin-top:10px;">';
					echo '<span class="glyphicon glyphicon-ok-circle"></span>&nbsp;Firma <b>realizada</b>.';
				echo '</div>';
				
				//Vuelvo al docu.
				$url = 'docu.php?id='.$_GET['id'];
				redireccionar(2,$url);
			}
			else
			{
				//Muestra msj de error.
				echo '<div class="alert alert-danger" styl="margin-top:10px;">';
					echo '<b>Ups</b> hubo un problema al firmar el documento.';
				echo '</div>';
				
				//Vuelvo al docu.
				$url = 'docu.php?id='.$_GET['id'];
				redireccionar(2,$url);
			}
		}
	}
?>

<body style="background:#EEEEEE;padding:12px;">

	<!--CUERPO-->
	<div style="margin:auto;margin-top:0px;">	
			<!--ACCESO-->
			<?php
				//Controlar el acceso al documento, si esta definida la lista de permitidos.
				if (($permitidos!=null)&&($permitidos!=""))
				{
					//Si esta activa la sesion.
					if (isset($_SESSION['usuario']))
					{
						//Si el usuario esta dentro de la lista de permitidos.
						if (!(usuario_tiene_acceso($_SESSION['usuario'],$permitidos,$creador)))
						{
							echo "<div class='alert alert-error' style='font-size:14px;background:pink;margin-top:10px;border-bottom:1px solid gray;border-right:1px solid gray;'>";
							echo "Este documento <u>es privado</u>, no posees acceso para visualizarlo.";
							echo "</div>";							
							exit;
						}
					}
				}
			?>
			
			<!--BARRA TOOLS-->
			<div class="hero-unit" style="background:white;overflow:auto;padding:25px;margin-top:8px;">
				<!--BANNER-->
				<div style="border-bottom:1px solid #e7e7e7;padding-bottom:2px;padding-bottom:10px;">
					<!--Flecha para ver la descipcion-->
					<a href="#" id="descrip_ver" title="Haga click para ver la descripcion del documento.">
						<img src="./imgs/flecha_down.png">
					</a>
					<a href="#" id="descrip_ocultar" title="Haga click para ocultar la descripcion del documento." style="display:none;">
						<img src="./imgs/flecha_up.png">
					</a>
					<!--Icono del libro-->
					<img src="./imgs/libro.png" style="margin-top:-11px;">
					<span class="glyphicon glyphicon-phone" style="color:#AAAAAA;"></span>
					<!--Titulo-->
					<span style="color:#AAAAAA;font-size:20px;">
						<b><?php echo ucfirst($titulo); ?></b>
					</span>
					<!--Descripcion-->
					<div id="descrip_div" style="display:none;border-top:1px solid #e7e7e7;padding-top:3px;margin-top:2px;">
						<?php
							echo "<b><u><i>Descripci&oacute;n:</i></u></b>";
							echo "<br>";
							//Si hay una descripcion cargada.
							if (($descrip!="")&&($descrip!=null))
							{
								echo "<i>".corregir_html(ucfirst($descrip))."</i>";
							}
							else
							{
								echo "<i>No hay ninguna descripci&oacute;n cargada a&uacute;n..</i>";
							}							
						?>
					</div>
					<!--Muestro el usuario-->
					<div style="margin-top:10px;">
						<span class="glyphicon glyphicon-user"></span>
						 <a href="#">Creador&nbsp;<i><b><?php echo ucfirst($creador); ?></b></i></a>
						 <br>
						 <!--Muestro las lecturas-->
						 <span class="glyphicon glyphicon-eye-open"></span>
						 <a href="#">Lecturas&nbsp;</a><span class="badge"><?php echo $lecturas; ?>&nbsp;veces</span>
					</div>
				</div>
				
				<!--FIRMAS-->
				<div style="margin-top:0px;border-bottom:1px dotted #e7e7e7;padding-bottom:4px;">
						<div>
							<?php
								//Si estamos logeados, reviso si se puede mostrar el link para firmar.
								if ((isset($_SESSION['usuario']))&&($firmas==true))
								{
									$bck        = new Backend_html();
									
									//Si no esta firmado muestro el link.
									if (!($bck->doc_esta_firmado($_GET['id'],$_SESSION['usuario'])))
									{
										echo "<div style='float:left;'>";
											echo "<img src='./imgs/doc.png'>&nbsp;";
											echo "<a href='docu.php?id=".$_GET['id']."&firmar=1'  id='firmar_link' style='color:green;'>";
													echo "<i>Firmar Documento</i>";
											echo "</a>";	
											echo "</a>&nbsp;|&nbsp;";
										echo "</div>";
									}
								}
							?>
							<!--Boton de ver firmas-->
							<div style="float:left;<?php if ($firmas==false)echo 'display:none;'?>">
								  <!--Ver firmas-->
									<img src="./imgs/flecha_down.png" id="icon_arrow">
									&nbsp;
									<a href="#" id="firmas_link_bajar" title="Mostrar el listado de firmas.">Ver firmas</a>
								  <!--Subir firmas-->					
								  <a href="#" id="firmas_link_subir" title="Ocultar el listado de firmas.">
									Ver firmas
								  </a>
							</div>
						</div>
						<br>			
					<!--Listado de firmas de usuarios -->
					<div id="firmas_div" style="margin-top:8px;">
						<!--Muestra en una lista las firmas-->
						<blockquote>
						<?php
								$bck     =  new Backend_html();
								$bck->traer_firmas_doc($_GET['id']);
						?>
						</blockquote>
					</div>
			</div>			
			<!--DOCUMENTO-->
			<div style="margin-top:10px;">
				<!--CONTENIDO-->
				<div style="margin-top:10px;">
					<?php
						//Muestro el contenido del documento.
						echo $texto;
					?>					
				</div>
			</div>
		</div>
	</div>
	
</body>

</html>