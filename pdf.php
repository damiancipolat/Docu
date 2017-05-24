<?php
	
	$id =  null;
	
	if (isset($_GET['id']))
	{
		//Generador de pdf en base a un html.
		ob_start();
		
		//Php que genera el html.
		include('/libs/plain.php');
				
		$id = $_GET['id'];
		
		$content = ob_get_clean();

		//Convertir a pdf
		require_once(dirname(__FILE__).'\libs\html2pdf\html2pdf.class.php');
		
		try
		{
			$html2pdf = new HTML2PDF('P', 'A4', 'fr');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			$html2pdf->Output('docu.pdf');
		}
		catch(HTML2PDF_exception $e)
		{
			echo $e;
			exit;
		}
	}
	else
	{
		echo "Bad Param :/";
	}
	
?>	