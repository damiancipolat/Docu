<?php

//Genera el html del logo.
function logo()
{
	echo "<div style='width:540px;'>";
		echo	"<div style='font-size:60px;color:#AAAAAA;margin-bottom:-13px;'>";
		echo		"<b>Docu</b>";
		echo	"</div>";
		echo	"<div style='color:#AAAAAA;'>";
		echo		"<b>Version 1.0</b>&nbsp;|&nbsp;Creado por <a href='https://twitter.com/DamCipolat' target='_blank'>@Damcipolat</a>&nbsp;&nbsp;<img src='./imgs/arg_flag.png' style='margin-top:-3px;'>";
		echo	"</div>";
	echo	"</div>";
}

//Acorta un string y pone los .. si excede el max fijado.
function acortar_str($cadena,$largo)
{
	if (strlen($cadena)<=$largo)
	{
		return $cadena;
	}
	else
	{
		return (substr($cadena, 0,$largo-3)."...");
	}
}

//Codigo de la barra de login.
function barra_login_home()
{
	//Si es logout.
	if (isset($_GET['logout']))
	{
	   session_destroy();
	   redireccionar(0,'index.php');
	}

	//Chequea si hay sesion abierta.
	if (isset($_SESSION['usuario']))
	{
		//Si es el admin.
		if (strtoupper($_SESSION['usuario'])=='ADMIN')
		{
			echo "<div style='float:right;'>";
				echo "<img src='./imgs/user.png' style='border:1px solid silver;margin-right:2px;margin-top:-2px;'><b style='color:gray;'>".ucfirst($_SESSION['usuario'])."</b>&nbsp;|&nbsp;";
				echo "<a href='categ.php'>Editar categor&iacute;a</a>";
				echo "&nbsp;|&nbsp;";				
				echo "<a href='mis_docs.php?user=".$_SESSION['usuario']."'>Mis Docs</a>";
				echo "&nbsp;|&nbsp;";
				echo "<a href='index.php?logout' >Cerrar Sesi&oacute;n</a>";
			echo "</div>";		
		}
		else
		{
			echo "<div style='float:right;'>";
				echo "<img src='./imgs/user.png' style='border:1px solid silver;margin-right:2px;margin-top:-2px;'><b style='color:gray;'>".ucfirst($_SESSION['usuario'])."</b>&nbsp;|&nbsp;";
				echo "<a href='mis_docs.php?user=".$_SESSION['usuario']."'>Mis Docs</a>";
				echo "&nbsp;|&nbsp;";
				echo "<a href='index.php?logout' >Cerrar Sesi&oacute;n</a>";
			echo "</div>";
		}
	}
	else
	{
		echo "<div style='float:right;'>";
			echo "<a href='login.php'>Ingresar</a>";
			echo "&nbsp;|&nbsp;";
			echo "<a href='registrar.php'>Registrarse</a>";
		echo "</div>";				
	}
}

//Calculo el timestamp del servidor.
function timestamp()
{
	$fecha = date_create();
	return date_timestamp_get($fecha);
}

//Extraer extension
function extraer_tipo($nombre)
{
	$tmp = explode(".", $nombre);
	return end($tmp);
}

//Tipo compatible de archivo de imagen.
function formato_imagen($formato)
{
	$permitidos = array("gif", "jpeg", "jpg", "png");
	
	if (in_array($formato, $permitidos))
		return true;
	else
		return false;	
}

//Remplaza caracteres a los caracteres html.
function corregir_html($txt)
{
	$txt = str_replace("á", "&aacute;", $txt);
	$txt = str_replace("é", "&eacute;", $txt);
	$txt = str_replace("í", "&iacute;", $txt);
	$txt = str_replace("ó", "&oacute;", $txt);
	$txt = str_replace("ú", "&uacute;", $txt);
	$txt = str_replace("Á", "&Aacute;", $txt);
	$txt = str_replace("É", "&Eacute;", $txt);
	$txt = str_replace("Í", "&Iacute;", $txt);
	$txt = str_replace("Ó", "&Oacute;", $txt);
	$txt = str_replace("Ú", "&Uacute;", $txt);
	$txt = str_replace("ñ", "&ntilde;", $txt);
	$txt = str_replace("Ñ", "&Ntilde;", $txt);	
	
	return $txt; 
}

//Limpiar caracteres
function limpiar($str)
{
    $str= str_replace("'", "&#39;", $str);
    $str= str_replace('"', "&#34;", $str);
    $str= str_replace(";", "&#59;", $str);
    $str= str_replace("<", "&#60;", $str);
    $str= str_replace(">", "&#62;", $str);
    $str= str_replace("drop", "&#100;&#114;&#111;&#112;", $str);
    $str= str_replace("javascript", "&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;", $str);
    $str= str_replace("script", "&#118;&#98;&#115;&#99;&#114;&#105;&#112;&#116;", $str);
    $str= str_replace("vbscript", "&#115;&#99;&#114;&#105;&#112;&#116;", $str);
    return $str;
}

//Adapta cualquier string para guardarse en una bd.´
function adptar_txt_sql($txt)
{
	return limpiar(corregir_html($txt));
}

//Redireccionar
function redireccionar($delay,$url)
{
	echo "<meta http-equiv='Refresh' content='".$delay.";url=".$url."'>";	
}

//Dice si un string se encuentra en un listado de strings separados por coma.
function usuario_tiene_acceso($usuario,$lista,$creador)
{
	//Convierto strings a mayuscula.
	$usuario = strtoupper($usuario);
	$lista   = strtoupper($lista);
	$creador = strtoupper($creador);
	
	//Revisar si el usuario logeado es el creador del doc.
	if ($creador!=$usuario)
	{
		//Revisar que el usuario logeado, pertenezca a la lista y si es visitante o no.
		$pos = strrpos($lista, $usuario);
		if ($pos === false)
			return false;
		else
			return true;	
	}
	else
	{
		//Soy el usuario creador.
		return true;
	}
}

?>