<?php
include('PuppyBd.php');
include('misc.php');

/*
	CLASE BACKEND
	------------------
	
	Clase que maneja el dibujo de datos en el html.
*/

class Backend_html
{
	public function login($usuario,$password)
	{
		$bck = new Backend_bd();
		return $bck->login($usuario,$password);
	}
	
	public function traer_ultimos_docs()
	{
		$bck  = new Backend_bd();
		$resu = $bck->traer_ultimos_docs();
		
		for ($i=0;$i<=count($resu)-1;$i++)
		{
			$tmp = $resu[$i];

			echo "<div style='margin-bottom:5px;'>";
			echo "		<img src='./imgs/doc.png'>&nbsp;<a href='docu.php?id=".$tmp['id']."' title='Creado por ".ucfirst($tmp['usuario'])."'>".acortar_str(ucfirst(corregir_html($tmp['titulo'])),50)."</a>";
			echo "</div>";
		}
	}
	
	public function ranking_usuarios()
	{
		$bck  = new Backend_bd();
		$resu = $bck->ranking_usuarios();
		
		for ($i=0;$i<=count($resu)-1;$i++)
		{
			$tmp = $resu[$i];
			
			//Que no sea vacio.
			if ($tmp!='')
			{
				$total  = $tmp['total'];
				$titulo = "";
				
				//Plural y singular.
				if ($total==1)
					$titulo = $tmp['total']." Documento creado.";
				else
					$titulo = $tmp['total']." Documentos creados.";
					
				//Muestro el link de usuario con el total de docs creados.	
				echo "<li><img src='./imgs/user2.png'>
						  <a href='usuario.php?user=".$tmp['usuario']."' title='".$titulo."'>
							".acortar_str(ucfirst(corregir_html($tmp['usuario'])),13).
						  "&nbsp;(".$tmp['total'].")"."</a>".
					  "</li>";
			}
		}
	}
	
	public function traer_total_docs()
	{
		$bck  = new Backend_bd();
		return $bck->traer_total_docs();
	}
	
	public function buscar_documentos($titulo,$idcateg)
	{
		$bck  = new Backend_bd();
		$resu = $bck->buscar_documentos($titulo,$idcateg);

		echo '<span style="font-size:25px;color:#AAAAAA;"><b>Resultados</b></span>';
		echo "<div>";
		
		//Colores de los colores, de los totales de resultados.
		if (count($resu)>0)
		{
			//Para que cambie de plural a singular.
			if (count($resu)==1)
				echo "<span class='label label-primary'>".count($resu)."</span>"."&nbsp;Registro encontrado.";
			else
				echo "<span class='label label-primary'>".count($resu)."</span>"."&nbsp;Registros similares encontrados.";
		}
		else
		{
			echo "<span class='label label-default'>".count($resu)."</span>"."&nbsp;Registros similares encontrados.";
		}			
		
		echo '<br>';		
		echo '<table class="table table-striped" style="margin-top:8px;">';
		echo '<thead>';
			echo '<tr>';
				echo '<td><b>Titulo</b></td>';
				echo '<td><b>Usuario</b></td>';
				echo '<td><b>Fecha</b></td>';
				echo '<td><b>Lecturas</b></td>';
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';		
		
		if (count($resu)>0)
		{
			for ($i=0;$i<=count($resu)-1;$i++)
			{
				$tmp = $resu[$i];
				
				echo "<tr>";
					echo "<td><img src='./imgs/doc.png'>&nbsp;<a href='docu.php?id=".$tmp['id']."'>".$tmp['titulo']."</a></td>";
					echo "<td>"."<img src='./imgs/user2.png' style='margin-top:-5px;'>&nbsp;".ucfirst($tmp['usuario'])."</td>";
					echo "<td>".$tmp['fecha']."</td>";
					
					//Si hay lecturas
					if ($tmp['lecturas']>0)
						echo "<td><span class='label label-info'>".$tmp['lecturas']."</span></td>";
					else
						echo "<td><span class='label label-default'>0</span></td>";
				echo "<tr>";
			}
		}
		else
		{
			echo "<tr>";
				echo "<td colspan='4'><b>No se encontraron resultados..</b></td>";
			echo "<tr>";
		}

		echo '</tbody>';
		echo '</table>';
		echo "</div>";
	}
	
	public function buscar_documentos_titulo($titulo)
	{
		$bck  = new Backend_bd();
		$resu = $bck->buscar_documentos($titulo,0);

		echo '<span style="font-size:25px;color:#AAAAAA;"><b>Resultados</b></span>';
		echo "<div>";
	
		//Colores de los colores, de los totales de resultados.
		if (count($resu)>0)
		{
			//Para que cambie de plural a singular.
			if (count($resu)==1)
				echo "<span class='label label-primary'>".count($resu)."</span>"."&nbsp;Registro encontrado.";
			else
				echo "<span class='label label-primary'>".count($resu)."</span>"."&nbsp;Registros similares encontrados.";
		}
		else
		{
			echo "<span class='label label-default'>".count($resu)."</span>"."&nbsp;Registros similares encontrados.";
		}		
		
		echo '<br>';		
		echo '<table class="table table-striped" style="margin-top:8px;">';
		echo '<thead>';
			echo '<tr>';
				echo '<td><b>Titulo</b></td>';
				echo '<td><b>Usuario</b></td>';
				echo '<td><b>Fecha</b></td>';
				echo '<td><b>Lecturas</b></td>';
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';		
		
		if (count($resu)>0)
		{
			for ($i=0;$i<=count($resu)-1;$i++)
			{
				$tmp = $resu[$i];
				
				echo "<tr>";
					echo "<td><img src='./imgs/doc.png'>&nbsp;<a href='docu.php?id=".$tmp['id']."'>".$tmp['titulo']."</a></td>";
					echo "<td>"."<img src='./imgs/user2.png' style='margin-top:-5px;'>&nbsp;".ucfirst($tmp['usuario'])."</td>";
					echo "<td>".$tmp['fecha']."</td>";

					//Si hay lecturas
					if ($tmp['lecturas']>0)
						echo "<td><span class='label label-info'>".$tmp['lecturas']."</span></td>";
					else
						echo "<td><span class='label label-default'>0</span></td>";					
					
				echo "<tr>";
			}
		}
		else
		{
			echo "<tr>";
				echo "<td colspan='4'><b>No se encontraron resultados..</b></td>";
			echo "<tr>";
		}

		echo '</tbody>';
		echo '</table>';
		echo "</div>";	
	}
	
	public function traer_categorias($categ)
	{
		$bck  = new Backend_bd();
		$resu = $bck->traer_categorias();
		
		for ($i=0;$i<=count($resu)-1;$i++)
		{
			$tmp = $resu[$i];
			
			if ($tmp['id']==$categ)
				echo "<option value='".$tmp['id']."' selected>".ucfirst($tmp['categ'])."</option>";
			else
				echo "<option value='".$tmp['id']."'>".ucfirst($tmp['categ'])."</option>";
		}
	}
	
	public function dibujar_items_categoria()
	{
		$bck  = new Backend_bd();
		$resu = $bck->traer_categorias();
		
		for ($i=0;$i<=count($resu)-1;$i++)
		{
			$tmp = $resu[$i];			
			echo "<li>
					<img src='./imgs/tag.gif'>&nbsp;
					<a href='buscar.php?categ=".$tmp['id']."&nomb=".$tmp['categ']."'>".ucfirst(acortar_str($tmp['categ'],14))."</a>
				  </li>";
		}		
	}

	public function agregar_documento($usuario,$titulo,$descrip,$categ,$permitidos,$firmas,$cambiarcfg)
	{
		$bck  = new Backend_bd();
		$resu = $bck->agregar_documento($usuario,$titulo,$descrip,$categ,$permitidos,$firmas,$cambiarcfg);
		
		if ($resu!=false)
		{
			echo "<div class='alert alert-success'>";
			echo "<b>OK</b> el documento se creo exitosamente, redireccionando al editor del documento..";
			echo "</div>";
			
			$url = "editar.php?id=".$resu;
			redireccionar(1,$url);
		}
		else
		{
			echo "<div class='alert alert-error'>";
			echo "<b>Ups</b> hubo un error :/ intent&aacute; nuevamente.";
			echo "</div>";
		}
	}	

	public function actualizar_docu($id,$html)
	{
		$bck  = new Backend_bd();
		
		//Actualiza el contenido del documento.
		$resu = $bck->actualizar_docu($id,$html);

		//Graba el registro de cambios.
		$bck->grabar_cambio($id,$_SESSION['usuario']);
		
		return $resu;
	}
	
	public function traer_titulo_creador_doc($id)
	{
		$bck  = new Backend_bd();
		$resu = $bck->traer_titulo_creador_doc($id);
	
		return $resu;
	}

	public function traer_doc($id)
	{
		$bck  = new Backend_bd();
		$resu = $bck->traer_doc($id);
	
		return $resu;
	}	
	
	public function traer_firmas_doc($id)
	{
		$bck  = new Backend_bd();
		$resu = $bck->traer_firmas_doc($id);

		if (count($resu)>0)
		{
			echo "<p style='font-size:14px;color:gray;'><b>Aprueban este documento:</b></p>";
			
			for ($i=0;$i<=count($resu)-1;$i++)
			{
				$tmp = $resu[$i];
				echo "<small style='color:green;'><img src='./imgs/user.png'>&nbsp;".ucfirst($tmp['usuario'])."</small>";
			}
		}
		else
		{
			echo "<small style='color:navy;'>Nadie ah firmado a&uacute;n..</small>";
		}		
	}
	
	public function registrar_usuario($usuario,$passw)
	{
		$bck  = new Backend_bd();
		
		//Si existe ese nombre de usuario.
		if ($resu = $bck->existe_usuario($usuario))
		{
			echo "<div class='alert alert-error' style='font-size:14px;'>";
			echo "<b>Ups</b> el usuario ya se encuentra registrado, tiene que elegir otro.";
			echo "</div>";
		}
		else
		{
			if ($bck->registrar_usuario($usuario,$passw))
			{
				echo "<div class='alert alert-success' style='font-size:14px;'>";
				echo "<b>OK</b> el nuevo usuario se ha <b><u>registrado correctamente</u></b>, redireccionando al Login...";
				echo "</div>";
				redireccionar(2,'login.php');
			}
		}
	}

	public function valid_usuario_data()
	{
		//Si no hay sesion activa vuelvo al home.
		if (isset($_SESSION['usuario']))
		{			
			//Analiza si la url esta bien armada.
			if (isset($_GET['id']))
			{
				$resu    = $this->traer_doc($_GET['id']);				
				return $resu;				
			}
			else
			{
				//Muestra msj de error.
				echo '<div class="alert alert-danger" styl="margin-top:10px;">';
					echo '<b>URL</b> mal armada<br>Redireccionando al home...';
				echo '</div>';
				
				//Redirecciona.
				redireccionar(3,'index.php');
				exit;
			}			
		}
		else
		{
			//Muestra msj de error.
			echo '<div class="alert alert-danger" styl="margin-top:10px;">';
				echo '<b>URL</b> es necesario iniciar sesi&oacute;n,<br>redireccionando al login.';
			echo '</div>';
			redireccionar(3,'login.php');
			exit;
		}	
	}
	
	public function actualizar_data_doc()
	{	
		//Obtengo las variables del post.
		$descrip = adptar_txt_sql($_POST['descrip_doc']);
		$titulo  = adptar_txt_sql($_POST['tit_doc']);
		$permit  = $_POST['restric_doc'];		
		$categ   = $_POST['categ_buscar'];		
		$firma   = isset($_POST['firma_doc'])?1:0;
		$cambcfg = isset($_POST['cambiarcfg_Doc'])?1:0;	
		$id      = $_GET['id'];
		
		//Actualiza el documento.
		$bck  = new Backend_bd();
		
		//Si se pudo modif, lo devuelvo.
		if ($bck->doc_actualizar_data($id,$titulo,$descrip,$categ,$firma,$permit,$cambcfg))
			return true;
		else
			return false;
	}

	public function doc_esta_firmado($id,$usuario)
	{
		$bck  = new Backend_bd();
		return $bck->doc_firmado($id,$usuario);
	}
	
	public function doc_firmar($id,$usuario)
	{
		$bck  = new Backend_bd();
		return $bck->doc_firmar($id,$usuario);	
	}

	public function grabar_leido($id)
	{
		$bck  = new Backend_bd();
		return $bck->grabar_leido($id);
	}

	public function agregar_adjunto_doc($id,$nombre,$archivo)
	{
		$bck  = new Backend_bd();
		return $bck->agregar_adjunto_doc($id,$nombre,$archivo);
	}
	
	public function traer_adjuntos_docs($id)
	{
		$bck  = new Backend_bd();
		$resu = $bck->traer_adjuntos_docs($id);
		
		if (count($resu)>0)
		{			
			for ($i=0;$i<=count($resu)-1;$i++)
			{
				$tmp = $resu[$i];
				echo "<tr>";
					echo "<td>";
					echo	"<a href='./adjuntos/".$tmp['Archivo']."' target='_blank'><img src='./adjuntos/".$tmp['Archivo']."' style='width:60px;border:1px solid silver;padding:1px;'></a>";
					echo "</td>";
					echo "<td>";
					echo	"<span class='glyphicon glyphicon-user'></span>&nbsp;";
					echo	"Dcipolat";
					echo "</td>";
					echo "<td>";
					echo	"<span class='glyphicon glyphicon-picture'></span>&nbsp;";
					echo	"<input type='text' style='border:1px solid gray;padding:1px;width:310px;' value='./adjuntos/".$tmp['Archivo']."' readonly>";
					echo "</td>";
				echo "</tr>";
			}
		}
		else
		{
			echo "<tr><td colspan=3>No hay adjuntos para este documento.</td></tr>";
		}			
	}

	public function ver_log($id)
	{
		$bck  = new Backend_bd();
		$resu = $bck->ver_log($id);
		
		if (count($resu)>0)
		{			
			for ($i=0;$i<=count($resu)-1;$i++)
			{
				$tmp = $resu[$i];
				
				echo "<tr>";
					echo "<td>".$tmp['fecha']."</td>";
					echo "<td><img src='./imgs/user2.png'>&nbsp;".$tmp['usuario']."</td>";
				echo "</tr>";	
			}
		}
		else
		{
			echo "<tr>
					<td colspan=2><b>No hay cambios</b> para este documento, hechos actualmente..</td>
				  </tr>";
		}
	}
	
	public function buscar_documentos_categoria($idcateg)
	{
		$bck  = new Backend_bd();
		$resu = $bck->buscar_documentos_categoria($idcateg);

		echo '<span style="font-size:25px;color:#AAAAAA;"><b>Resultados</b></span>';
		echo "<br>- Buscando por  categor&iacute;a <b><u>".$_GET['nomb']."</u></b><br><br>";
		echo "<div>";
		
		//Colores de los colores, de los totales de resultados.
		if (count($resu)>0)
		{
			//Para que cambie de plural a singular.
			if (count($resu)==1)
				echo "<span class='label label-primary'>".count($resu)."</span>"."&nbsp;Registro encontrado.";
			else
				echo "<span class='label label-primary'>".count($resu)."</span>"."&nbsp;Registros similares encontrados.";
		}
		else
		{
			echo "<span class='label label-default'>".count($resu)."</span>"."&nbsp;Registros similares encontrados.";
		}
		
		echo '<br>';		
		echo '<table class="table table-striped" style="margin-top:8px;">';
		echo '<thead>';
			echo '<tr>';
				echo '<td><b>Titulo</b></td>';
				echo '<td><b>Usuario</b></td>';
				echo '<td><b>Fecha</b></td>';
				echo '<td><b>Lecturas</b></td>';
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';		
		
		if (count($resu)>0)
		{
			for ($i=0;$i<=count($resu)-1;$i++)
			{
				$tmp = $resu[$i];
				
				echo "<tr>";
					echo "<td><img src='./imgs/doc.png'>&nbsp;<a href='docu.php?id=".$tmp['id']."'>".$tmp['titulo']."</a></td>";
					echo "<td>"."<img src='./imgs/user2.png' style='margin-top:-5px;'>&nbsp;".ucfirst($tmp['usuario'])."</td>";
					echo "<td>".$tmp['fecha']."</td>";
					
					//Si hay lecturas
					if ($tmp['lecturas']>0)
						echo "<td><span class='label label-info'>".$tmp['lecturas']."</span></td>";
					else
						echo "<td><span class='label label-default'>".$tmp['lecturas']."</span></td>";
				echo "<tr>";
			}
		}
		else
		{
			echo "<tr>";
				echo "<td colspan='4'><b>No se encontraron resultados..</b></td>";
			echo "<tr>";
		}

		echo '</tbody>';
		echo '</table>';
		echo "</div>";	
	}	

	public function grabar_cambio($id,$usuario)
	{
		$bck  = new Backend_bd();
		$bck->grabar_cambio($id,$usuario);	
	}

	public function ver_docs_usuario($usuario)
	{
		$bck  = new Backend_bd();
		$resu = $bck->ver_docs_usuario($usuario);
		
		if (count($resu)>0)
		{			
			for ($i=0;$i<=count($resu)-1;$i++)
			{
				$tmp = $resu[$i];
				
				echo "<tr>";
					echo "<td><a href='docu.php?id=".$tmp['id']."'>".corregir_html(ucfirst($tmp['titulo']))."</a></td>";
					echo "<td>".corregir_html(ucfirst($tmp['fecha']))."</td>";
					echo "<td>".corregir_html(ucfirst($tmp['categoria']))."</td>";
					echo "<td>".
							"<a href='editar.php?id=".$tmp['id']."'>
								<span class='glyphicon glyphicon-pencil'></span>&nbsp;Editar
							 </a>".
							"&nbsp;|&nbsp;".
							"<a href='javascript:borrar(".$tmp['id'].");'>
								<span class='glyphicon glyphicon-remove'></span>&nbsp;Borrar
							 </a>".
						 "</td>";					
				echo "</tr>";
			}
		}
		else
		{
			echo "<tr>
					<td colspan=4><b>No hay documentos hechos</b> actualmente..</td>
				  </tr>";
		}	
	}
	
	public function listar_categorias_activas()
	{
		$bck  = new Backend_bd();
		$resu = $bck->listar_categorias_activas();
		
		if (count($resu)>0)
		{			
			for ($i=0;$i<=count($resu)-1;$i++)
			{
				$tmp = $resu[$i];
				
				echo "<tr>";
					echo "<td><img src='./imgs/tag.gif'>&nbsp;".corregir_html(ucfirst($tmp['categoria']))."</td>";
					echo "<td>
								<a href='javascript: if (confirm(\"¿Borrar categoria?\")){location.href=\"./categ.php?del=".$tmp['idcateg']."\";}'><span class='glyphicon glyphicon-remove'></span>&nbsp;Borrar</a>
								&nbsp;|&nbsp;
								<a href='javascript:editar(".$tmp['idcateg'].");'><span class='glyphicon glyphicon-pencil'></span>&nbsp;Editar</a>
						  </td>";
				echo "</tr>";
			}
		}
		else
		{
			echo "<tr>
					<td colspan=4><b>No tiene documentos</b> hechos este usuario.</td>
				  </tr>";
		}
	}
	
	public function ver_docs_usuario_2($usuario)
	{
		$bck  = new Backend_bd();
		$resu = $bck->ver_docs_usuario($usuario);
		
		if (count($resu)>0)
		{			
			for ($i=0;$i<=count($resu)-1;$i++)
			{
				$tmp = $resu[$i];
				
				echo "<tr>";
					echo "<td><a href='docu.php?id=".$tmp['id']."'>".corregir_html(ucfirst($tmp['titulo']))."</a></td>";
					echo "<td>".corregir_html(ucfirst($tmp['fecha']))."</td>";
					echo "<td>".corregir_html(ucfirst($tmp['categoria']))."</td>";					
				echo "</tr>";
			}
		}
		else
		{
			echo "<tr>
					<td colspan=4><b>No tiene documentos</b> hechos este usuario.</td>
				  </tr>";
		}
	}
	
	public function editar_categ($id,$txt)
	{
		$bck  = new Backend_bd();
		return $bck->editar_categ($id,$txt);
	}
	
	public function borrar_categ($id)
	{
		$bck  = new Backend_bd();
		return $bck->borrar_categ($id);
	}
	
	public function borrar_documento($id)
	{
		$bck  = new Backend_bd();
		return $bck->borrar_documento($id);
	}

	public function agregar_categ($categ)
	{
		$bck  = new Backend_bd();
		return $bck->agregar_categ($categ);	
	}	
}

/*
	CLASE BACKEND
	------------------
	
	Clase que maneja el grabado de datos con la bd mysql.
*/

class Backend_bd
{
	public function login($usuario,$password)
	{
		$usuario      = limpiar(corregir_html($usuario));
		$password     = limpiar(corregir_html($password));	
		$sql 		  = "select * from docu_usuarios where nick='".$usuario."' and password='".$password."';";
		$obj_cliente  = new Query();
		$result	      = $obj_cliente->executeQuery($sql);
		$num		  = $obj_cliente->getResultados();
		
		if ($num>0)
			return true;
		else
			return false;		
	}
	
	public function traer_total_docs()
	{
		$obj_cliente = new Query();
		$sql 		 = "select count(*) as total from docu_documentos;";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();
		
		if ($num>0)
		{
			$row= $obj_cliente->getfila($result);			
			return col($row,'total');
		}		
		
		return 0;
	}
	
	public function traer_ultimos_docs()
	{
		$obj_cliente = new Query();
		$sql 		 = "select iddocumento,titulo,creador from docu_documentos order by iddocumento desc limit 8;";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();

		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("id"     =>col($row,'Iddocumento'),
						      "titulo" =>col($row,'Titulo'),
							  "usuario"=>col($row,'Creador'));
							  
				array_push($tmp,$item);
			}
		}
		
		return $tmp;
	}
	
	public function traer_adjuntos_docs($id)
	{
		$obj_cliente = new Query();
		$sql 		 = "select nombre,archivo from docu_adjuntos where iddocumento=".$id.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();

		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("Nombre" =>col($row,'Nombre'),
				              "Archivo"=>col($row,'Archivo'));
				array_push($tmp,$item);
			}
		}
		
		return $tmp;
	}	

	public function ranking_usuarios()
	{
		$obj_cliente = new Query();
		$sql 		 = "select creador as usuario,count(*) as total from docu_documentos group by creador order by total desc limit 8";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();

		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("usuario"=>col($row,'usuario'),
				              "total"  =>col($row,'total'));
				
				array_push($tmp,$item);
			}
		}
		
		return $tmp;
	}

	public function buscar_documentos_categoria($idcateg)
	{
		$obj_cliente = new Query();
		
		$sql = "SELECT iddocumento,titulo,creador,fecha,lecturas FROM docu_documentos  where categoria=".$idcateg.";";
			
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();	

		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("id"         => col($row,'Iddocumento'),
							   "titulo"    => col($row,'Titulo'),
							   "usuario"   => col($row,'Creador'),
							   "fecha"     => col($row,'Fecha'),
							   "lecturas"  => col($row,'Lecturas')
							 );

				array_push($tmp,$item);
			}
		}
		
		return $tmp;		
	}
	
	public function buscar_documentos($titulo,$idcateg)	
	{
		$obj_cliente = new Query();
		
		//Cuando se pasa la categoria menos 1, se busca solo por titulo, de lo contrario titulo y categoria.
		if ($idcateg==-1)
			$sql = "SELECT iddocumento,titulo,creador,fecha,lecturas FROM docu_documentos  where titulo like '%".$titulo."%';";		
		else
			$sql = "SELECT iddocumento,titulo,creador,fecha,lecturas FROM docu_documentos  where titulo like '%".$titulo."%' and categoria=".$idcateg.";";
	
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();	

		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("id"         => col($row,'Iddocumento'),
							   "titulo"    => col($row,'Titulo'),
							   "usuario"   => col($row,'Creador'),
							   "fecha"     => col($row,'Fecha'),
							   "lecturas"  => col($row,'Lecturas')
							 );

				array_push($tmp,$item);
			}
		}
		
		return $tmp;		
	}
	
	public function traer_categorias()
	{
		$obj_cliente = new Query();
		$sql 		 = "select idcateg,categoria from docu_categorias;";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();

		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("id"   =>col($row,'idcateg'),
						      "categ"=>col($row,'categoria'));
				
				array_push($tmp,$item);
			}
		}
		
		return $tmp;
	}
	
	public function agregar_documento($usuario,$titulo,$descrip,$categ,$permitidos,$firma,$cambiarcfg)
	{
		$usuario  = limpiar($usuario);
		$titulo   = limpiar($titulo);
		$descrip  = limpiar($descrip);
		
		$obj_cliente = new Query();
		$sql         = "insert into docu_documentos(titulo,descripcion,fecha,creador,permitidos,lecturas,categoria,firmas,cambiarConfig)
						values('".$titulo."','".$descrip."',now(),'".$usuario."','".$permitidos."',0,".$categ.",".$firma.",".$cambiarcfg.");";
						
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
			return $obj_cliente->maxId();
		else		
			return false;
	}

	public function actualizar_docu($id,$html)
	{
		$obj_cliente = new Query();
		$sql         = "update docu_documentos set texto ='".$html."' where iddocumento=".$id.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		//echo $sql;
		//if ($filas>0)
			return true;
		//else		
			//return false;		
	}
	
	public function grabar_leido($id)
	{
		$obj_cliente = new Query();
		$sql         = "update docu_documentos set lecturas = lecturas+1 where iddocumento=".$id.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
			return true;
		else		
			return false;			
	}
	
	public function traer_titulo_creador_doc($id)
	{
		$obj_cliente = new Query();
		$sql 	     = "SELECT titulo,creador FROM docu_documentos WHERE iddocumento=".$id.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();		
		$tmp 		 = array();
		
		if ($num>0)
		{
			$row= $obj_cliente->getfila($result);
			$item = array("titulo"  => col($row,'Titulo'),
						  "usuario" => col($row,'Creador'));
			
			return $item;
		}
		
		return null;
	}
	
	public function traer_firmas_doc($id)
	{
		$obj_cliente = new Query();
		$sql 		 = "select distinct usuario from docu_firmas where iddocumento = ".$id." ;";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();

		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("usuario" => col($row,'Usuario'));
				
				array_push($tmp,$item);
			}
		}
		
		return $tmp;
	}

	public function ver_log($id)
	{
		$obj_cliente = new Query();
		$sql 	     = "select usuario,fecha from docu_cambios_log where iddocumento=".$id.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();
		
		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("usuario"     => col($row,'Usuario'),
							  "fecha"       => col($row,'Fecha'));
				
				array_push($tmp,$item);							  
			}
		}
		
		return $tmp;
	}
	
	public function ver_docs_usuario($usuario)
	{
		$obj_cliente = new Query();
		$sql ="SELECT     A.iddocumento,A.titulo,A.fecha,A.creador,B.categoria
			   FROM       docu_documentos as A
			   inner join docu_categorias as B on B.idcateg=A.categoria
			   where      A.creador='".$usuario."'";
			   
		$result	= $obj_cliente->executeQuery($sql);
		$num	= $obj_cliente->getResultados();
		
		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("titulo"    => col($row,'Titulo'),
							  "fecha"     => col($row,'Fecha'),
							  "creador"   => col($row,'Creador'),
							  "categoria" => col($row,'Categoria'),
							  "id"        => col($row,'Iddocumento'));
				
				array_push($tmp,$item);							  
			}
		}
		
		return $tmp;			   
	}
	
	public function traer_doc($id)
	{
		$obj_cliente = new Query();
		$sql 	     = "SELECT titulo,creador,categoria,descripcion,texto,permitidos,lecturas,firmas,cambiarConfig,fecha FROM docu_documentos WHERE iddocumento=".$id.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();
	
		if ($num>0)
		{
			$row  = $obj_cliente->getfila($result);
			$item = array("titulo"     => col($row,'Titulo'),
					      "usuario"    => col($row,'Creador'),
						  "descrip"    => col($row,'Descripcion'),
						  "categ"      => col($row,'Categoria'),						  
					      "texto"      => col($row,'Texto'),
					      "permitidos" => col($row,'Permitidos'),
					      "lecturas"   => col($row,'Lecturas'),
					      "firmas"     => col($row,'Firmas'),
						  "fecha"      => col($row,'Fecha'),
						  "cambcfg"    => col($row,'CambiarConfig'));
						  
			return $item;
		}
		
		return null;	
	}
	
	public function existe_usuario($usuario)
	{
		$obj_cliente = new Query();
		$sql 	     = "SELECT nick FROM docu_usuarios WHERE nick='".$usuario."';";
		//echo $sql;
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();	
		//echo $num;
		if ($num>0)
			return true;
		else
			return false;
	}
	
	public function registrar_usuario($usuario,$passw)
	{
		$usuario  = limpiar($usuario);	
		
		$obj_cliente = new Query();		
		$sql         = "insert into docu_usuarios(nick,password,activo) values('".$usuario."','".$passw."','S');";		
	
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
			return true;
		else		
			return false;	
	}
	
	public function doc_firmado($id,$usuario)
	{
		$obj_cliente = new Query();
		$sql         = "SELECT * FROM docu_firmas WHERE iddocumento=".$id." and usuario='".$usuario."'";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();		
	
		if ($num>0)
			return true;
		else
			return false;
	}

	public function doc_firmar($id,$usuario)
	{
		$obj_cliente = new Query();
		$sql         = "insert into docu_firmas(iddocumento,usuario) values(".$id.",'".$usuario."');";		
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
			return true;
		else		
			return false;		
	}
	
	public function borrar_documento($id)
	{
		$obj_cliente = new Query();
		$sql         = "delete from docu_documentos where iddocumento=".$id.";";		
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
			return true;
		else		
			return false;	
	}

	public function agregar_categ($categ)
	{
		$obj_cliente = new Query();
		$sql         = "insert into docu_categorias(categoria) values('".$categ."');";
					  
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
			return true;
		else		
			return false;	
	}	
	
	public function borrar_categ($id)
	{
		$obj_cliente = new Query();
		$sql         = "delete from docu_categorias where idcateg=".$id.";";
					  
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
			return true;
		else		
			return false;	
	}
	
	public function editar_categ($id,$txt)
	{
		$obj_cliente = new Query();
		$sql         = "update docu_categorias set categoria='".$txt."' where idcateg=".$id.";";

		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		return true;
	}
	
	public function doc_actualizar_data($id,$titulo,$descrip,$categ,$firma,$permit,$cambcfg)
	{
		$obj_cliente = new Query();
		$sql         = "update docu_documentos set titulo     ='".$titulo."',
											  descripcion='".$descrip."',
											  permitidos ='".$permit."',
											  categoria  =".$categ.",
											  permitidos ='".$permit."',
											  firmas     =".$firma.",
											  cambiarConfig=".$cambcfg."
											  where iddocumento=".$id.";";
											  
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		//if ($filas>0)
			return true;
		//else		
			//return false;			
	}
	
	public function listar_categorias_activas()
	{
		$obj_cliente = new Query();	
		$sql 		 = "select distinct A.idcateg,A.categoria from docu_categorias as A;";

		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();

		$tmp = array();
		
		if ($num>0)
		{
			while($row= $obj_cliente->getfila($result))
			{
				$item = array("idcateg"     => col($row,'Idcateg'),
							  "categoria"   => col($row,'Categoria'));
				
				array_push($tmp,$item);							  
			}
		}
		
		return $tmp;		
	}

	public function agregar_adjunto_doc($id,$nombre,$archivo)
	{
		$obj_cliente = new Query();
		$sql         = "insert into docu_adjuntos(iddocumento,nombre,archivo)
						values(".$id.",'".$nombre."','".$archivo."');";
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
			return $obj_cliente->maxId();
		else		
			return false;	
	}

	public function grabar_cambio($id,$usuario)
	{
		$obj_cliente = new Query();
		$sql 		 = "insert into docu_cambios_log(iddocumento,usuario,fecha) values(".$id.",'".$usuario."',now());";
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
			return $obj_cliente->maxId();
		else		
			return false;
	}	
}

?>