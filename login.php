<?php
	include('./libs/Backend.php');
	session_start();	
?>

<html>

<head>

<title>Docu - Login</title>

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

	$("#entrar").click(function()
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
			alert("Debe escribir el usuario y la contraseña para poder ingresar.");
		}
		
	});

});

</script>

</head>

<body style="background:rgb(238, 238, 238);">

<!-- CUERPO -->
<div style="width:600px;margin:auto;padding:10px;padding-top:20px;background:white;margin-top:80px;padding-bottom:5px;">

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
			Login de usuarios:
		</div>		
		<?php	
				if ((isset($_POST['user_login']))&&(isset($_POST['passw_login'])))
				{
					$user  = $_POST['user_login'];
					$passw = $_POST['passw_login'];
					
						$bck =  new Backend_html();
						
						if ($bck->login($user,$passw))
						{	
							$_SESSION['usuario'] = $user;
							redireccionar(0,'index.php');
						}
						else
						{
							echo "<div style='color:red;font-size:20px;width:320px;'><b>Usuario o Contrase&ntilde;a incorrecta!</b></div>";
						}
				}	
		?>	
		
		<div style="font-size:15px;margin-top:15px;border-top:1px dotted silver;padding-top:15px;">
			<form action="login.php" method="post" id="form_login">
			<div style="margin:auto;width:200px;">
				<b style="color:#AAAAAA;">Usuario:</b><br>
				<input type="text" maxlength="100" name="user_login" id="usuario" style="padding:6px;width:200px;background:white;border:1px solid gray;" placeholder="Escriba el usuario.">
				<br><br>
				<b style="color:#AAAAAA;">Contrase&ntilde;a:</b><br>
				<input type="password" maxlength="10" name="passw_login" id="password" style="padding:6px;width:200px;background:white;border:1px solid gray;" placeholder="Escriba su contrase&ntilde;a.">				
				<!--Boton entrar-->
				<a href='#' id="entrar" class='btn btn-success' style="margin-top:12px;margin-left:0px;">
					<span class="glyphicon glyphicon-share-alt"></span>&nbsp;Entrar
				</a>
				<!--Boton registrar-->
				<a href='registrar.php' id="registrar" class='btn btn-info' style="margin-top:12px;margin-left:5px;">
					<span class="glyphicon glyphicon-pencil"></span>&nbsp;Registrar
				</a>
			</div>
			</form>
		</div>		
	</div>	
</div>

</body>

</html>