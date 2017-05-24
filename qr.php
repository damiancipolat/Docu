<?php
	include "./libs/Php_QR/qrlib.php";  
	session_start();
	
	//Funcion para generar el codigo QR.
	function get_qr_url($txt)
	{
		$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;		
		$PNG_WEB_DIR  = 'temp/';		
		
		if (!file_exists($PNG_TEMP_DIR))
		     mkdir($PNG_TEMP_DIR);

		$SIZE     = 7;
		$LEVEL    = 'Q';			
		$DATA     = $txt;
		$filename = $PNG_TEMP_DIR.'test.png';												     
		$errorCorrectionLevel = $LEVEL;	
		$matrixPointSize      = min(max((int)$SIZE, 1), 10);
												    
												      
		$filename = $PNG_TEMP_DIR.'test'.md5($DATA .'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		QRcode::png($DATA , $filename, $errorCorrectionLevel, $matrixPointSize, 2);
		
		RETURN $PNG_WEB_DIR.basename($filename);
	}

	//Devuelve la url y directorio del php.
	function dir_php()
	{
		//Obtengo la url.
		$url = "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		
		//Parseo la url.
		$partes = parse_url($url);
		
		//Armo la url final.
		$final  = $partes['scheme'].'://'.$partes['host'].$partes['path'];
		
		$url    = substr($final,0,strlen($final)-6);
		return $url;
	}
?>

<!DOCTYPE html>
<html>

<head>

	<title>QR - Acceso mobile</title>
	
	<!-- JQUERY -->	
	<script src="./js/jquery.min.js"></script>
	
	<!-- Bootstrap -->
	<link href="./css/bootstrap.min.css" rel="stylesheet" media="screen">
	<script src="./js/bootstrap.min.js"></script>
	
</head>

<body style="background:white;margin:10px;">

<?php
	if (!(isset($_GET['id'])))
	{
		echo "bad url..";
		exit;
	}
	else
	{

		//var_dump(parse_url($url));
	}
?>

<div class="panel panel-default">
  <div class="panel-heading">
	<span class="glyphicon glyphicon-qrcode"></span>&nbsp;&nbsp;<b>Codigo QR - Acceso Mobile</b>
  </div>
  <div class="panel-body">
		<div>
			Escanea este codigo QR para ver el documento desde tu celular o tablet.
		</div>
		<br>
		<div style="width:250px;height:250px;margin-top:5px;margin:auto;">
			<img src="<?PHP 
							//Obtengo la url del php.
							$url  = dir_php().'mobile.php?id='.$_GET['id'];
							
							//Obtengo la url al qr.
							echo get_qr_url($url);
					  ?>" style="width:250px;height:250px;">
		</div>
		<div style="word-break:break-all;">
			<span class="glyphicon glyphicon-globe"></span>&nbsp;URL:<BR>
			<a href="#"><?php echo dir_php().'mobile.php?id='.$_GET['id'];?></a>
		</div>
  </div>
</div>
	
</body>

</html>