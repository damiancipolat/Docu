<html>

<head>

<title>Docu - Registrar</title>

<!-- JQUERY -->	
<script src="./js/jquery.min.js"></script>

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
	$("#registrar").click(function()
	{
		//Revisa si el usuario y contraseña fueron escritos.
		var user  = $("#usuario").val();
		var passw = $("#password").val();
		
		if ((user!="")&&(passw!=""))
		{
			$("#form_login").submit();
		}
		else
		{
			alert("Debe escribir el usuario y la contraseña para poder registrar tu nuevo usuario.");
		}
		
	});

});

</script>

</head>

<?php
	include('./libs/Backend.php');
?>

<body style="background:rgb(238, 238, 238);">

<!-- CUERPO -->
<div style="width:600px;margin:auto;padding:10px;padding-top:20px;background:white;margin-top:80px;">

	<!-- BANNER -->
	<div style="font-size:40px;margin:auto;width:300px;">
		<div style="margin-left:68px;">
			<div style="float:left;color:#AAAAAA;">
				<b>Docu</b>
			</div>
			<div style="float:left;color:#986820;">
				<img src="./imgs/libro.png" style="margin-left:10px;margin-top:16px;">
			</div>
		</div>
		<br><br>
		<div style="margin-left:60px;margin-top:-57px;font-size:20px;color:#AAAAAA;">
			Registrarte:
		</div>		
		<?php	
				//Maneja el acceso y permisos.
				if ((isset($_POST['user_login']))&&(isset($_POST['passw_login'])))
				{
					$user  = $_POST['user_login'];
					$passw = $_POST['passw_login'];
					
					if ('ADMIN'!=strtoupper($user))
					{
						$bck =  new Backend_html();
						
						//Registro el usuario.
						$bck->registrar_usuario($user,$passw);						
					}
					else
					{
						echo "<div style='background:pink;color:white;font-size:20px;padding:5px;'>
									<b>No es posible registrar el ADMIN</b>
							  </div>";					
						
						redireccionar(2,'registrar.php');
						
						exit;						
					}
				}	
		?>	
		
		<div style="font-size:15px;margin-top:15px;border-top:1px dotted silver;padding-top:15px;">
			<form action="registrar.php" method="post" id="form_login">
			<div style="margin:auto;width:200px;">
				<b style="color:#AAAAAA;">Usuario:</b><br>
				<input type="text" maxlength="100" name="user_login" id="usuario" style="padding:6px;width:200px;background:white;border:1px solid gray;" placeholder="Escriba el usuario.">
				<br><br>
				<b style="color:#AAAAAA;">Contrase&ntilde;a:</b><br>
				<input type="password" maxlength="10" name="passw_login" id="password" style="padding:6px;width:200px;background:white;border:1px solid gray;" placeholder="Escriba su contrase&ntilde;a.">				
				<!--Link de registrar-->
				<a href='#' id="registrar" class='btn btn-success' style="margin-top:12px;margin-left:0px;">
					<span class="glyphicon glyphicon-share-alt"></span>&nbsp;Registrar
				</a>
				<!--Link de volver a inicio-->
				<a href='index.php' id="volver" class='btn btn-primary' style="margin-top:12px;margin-left:5px;">
					<span class="glyphicon glyphicon-home"></span>&nbsp;Inicio
				</a>
			</div>
			</form>
		</div>		
	</div>	
</div>

</body>

</html>