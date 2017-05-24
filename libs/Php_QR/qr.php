<?php    
    
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "./Php_QR/qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $SIZE     = 8;
    $LEVEL    = 'Q';
    $DATA     = "HOLA ale";        
    $filename = $PNG_TEMP_DIR.'test.png';
     
    $errorCorrectionLevel = $LEVEL;	
    $matrixPointSize      = min(max((int)$SIZE, 1), 10);
    
      
    $filename = $PNG_TEMP_DIR.'test'.md5($DATA .'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    QRcode::png($DATA , $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
 
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';
?>