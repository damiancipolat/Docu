<?php

/*
	CLASE BACKEND
	------------------
	
	Clase que maneja el grabado de datos con la bd mysql.
*/

include('PuppyBd.php');

class vista_html
{
	public function buscar_documentos($texto)
	{
		$engine = new Engine_bd();
		$resu   = $engine->buscar_documentos_bd($texto);
		return $resu;
	}
}

class Engine_bd
{	
	public function buscar_documentos_bd($texto)
	{
		$sql = "SELECT	A.Titulo,
						A.FechaCreacion,
						A.Creador,
						B.Nick,
						A.FechaModif,
						A.Modificador,
						C.Nick,
						A.HTML
				FROM documentos as A
				left join usuarios as B on B.idusuario=A.Creador
				left join usuarios as C on C.idusuario=A.Modificador;";
				
		$obj_cliente  = new Query();
		$result	      = $obj_cliente->executeQuery($sql);
		$num		  = $obj_cliente->getResultados();
		
		$listado = array();
		
		if ($num>0)
		{
				while($row= mysql_fetch_Array($result))
				{
					$tmp = array("titulo"=>$row['Titulo'],
								 "nick"=>$row['Nick'],
								 "fecha_creac"=>$row['FechaCreacion'],
								 "html"=>$row['HTML']);
					array_push($listado,$tmp);
				}		
		}
		
		return $listado;
	}
	
	/*public function login($usuario,$password)
	{
		$usuario      = limpiar(corregir_html($usuario));
		$password     = limpiar(corregir_html($password));	
		$sql 		  = "select * from usuarios where usuario='".$usuario."' and password='".$password."';";
		$obj_cliente  = new Query();
		$result	      = $obj_cliente->executeQuery($sql);
		$num		  = $obj_cliente->getResultados();
		
		if ($num>0)
			return true;
		else
			return false;		
	}

	public function traer_albunes()
	{
		$obj_cliente = new Query();
		$sql 	     = "select idalbum,nombre,descripcion from album;";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();
					
		if ($num>0)
		{
				while($row= mysql_fetch_Array($result))
				{
					echo "<tr>
							<td class='celda' style='background:#F2E0C6;'><u><a style='text-decoration:none;color:black;' href='fotos.php?id_album=".$row['idalbum']."'>".$row['nombre']."</a></u></td>
							<td class='celda' style='background:#F2E0C6;'>".$row['descripcion']."</td>
							<td class='celda' style='background:#F2E0C6;'><a style='text-decoration:none;color:black;' href='album.php?id_album=".$row['idalbum']."'><img src='./imgs/b_add.png'></a></td>
							<td class='celda' style='background:#F2E0C6;'><a style='text-decoration:none;color:black;' href='index.php?edit_album=".$row['idalbum']."'><img src='./imgs/b_edit.png'></a></td>
							<td class='celda' style='background:#F2E0C6;'><a style='text-decoration:none;color:red;' href='index.php?del_album=".$row['idalbum']."'><img src='./imgs/b_drop.png'></a></td>
						</tr>";
				}		
		}
		else
		{
				echo "<tr><td class='celda' style='background:#F2E0C6;' colspan='5'>No hay albums cargados</td>";
		}
	}
	
	public function traer_album($id)
	{
		$obj_cliente = new Query();
		$sql 	     = "select idalbum,nombre,descripcion,fec_creacion from album where idalbum=".$id." limit 1;";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();	
		
		if ($num>0)
		{
			$row= mysql_fetch_Array($result);			
			return array("titulo"=>$row['nombre'],"descrip"=>$row['descripcion'],"fecha"=>$row['fec_creacion']);
		}
		
		return null;
	}
	
	public function borrar_album($id)
	{
		$obj_cliente = new Query();
		$sql 	     = "delete from album where idalbum= ".$id.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
		{
			echo "<div style='background:green;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Album borrado con EXITO! :D</b></div>";
		}
		else
		{
			echo "<div style='background:red;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Ups!</b> hubo un problema al borrar el album :S.</div>";
		}
	}

	public function editar_album($id,$titulo,$descrip)
	{
		$obj_cliente = new Query();		
		$titulo      = limpiar(corregir_html($titulo));
		$descrip     = limpiar(corregir_html($descrip));		
		$sql 	     = 'update album set nombre ="'.$titulo.'" ,descripcion = "'.$descrip.'" where idalbum= '.$id.';';
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
		{
			echo "<div style='background:green;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Album Modificado con EXITO! :D</b></div>";
		}
		else
		{
			echo "<div style='background:red;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Ups!</b> hubo un problema al modif el album :S.</div>";
		}
	}
	
	public function agregar_album($titulo,$descrip)
	{
		$obj_cliente = new Query();		
		$titulo      = limpiar(corregir_html($titulo));
		$descrip     = limpiar(corregir_html($descrip));		
		$sql 	     = 'insert into album (fec_creacion,nombre,descripcion) values(now(),"'.$titulo.'","'.$descrip.'");';
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
		{
			echo "<div style='background:green;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Album agregado con EXITO! :D</b></div>";
		}
		else
		{
			echo "<div style='background:red;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Ups!</b> hubo un problema al grabar el album :S.</div>";
		}		
		
	}

	public function agregar_foto_album($idalbum,$nombre,$archivo,$descrip)
	{
		$obj_cliente = new Query();		
		$descrip     = limpiar(corregir_html($descrip));		
		$sql 	     = 'insert into fotos(fec_creacion,archivo,descripcion,idalbum,nombre) values(now(),"'.$archivo.'","'.$descrip.'",'.$idalbum.',"'.$nombre.'");';		
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();

		if ($filas>0)
		{
			echo "<div style='background:green;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Foto subida con EXITO! :D</b></div>";
		}
		else
		{
			echo "<div style='background:red;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Ups!</b> hubo hubo un problema al grabar la foto en el album :S.</div>";
		}		
	}
	
	public function traer_fotos_album($idalbum)
	{
		$obj_cliente = new Query();
		$sql 	     = "select idfoto,idalbum,archivo,nombre,descripcion from fotos where idalbum=".$idalbum.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();
					
		if ($num>0)
		{
				while($row= mysql_fetch_Array($result))
				{
					echo "<tr>
							<td class='celda' style='background:#F2E0C6;'><a href='./fotos/".$row['archivo']."'><img src='./fotos/".$row['archivo']."' style='width:80px;'></a><br>".$row['nombre']."</td>
							<td class='celda' style='background:#F2E0C6;'>".$row['descripcion']."</td>
							<td class='celda' style='background:#F2E0C6;'><a style='text-decoration:none;color:red;' href='album.php?id_album=".$row['idalbum']."&del_foto=".$row['idfoto']."'><img src='./imgs/b_drop.png'></a></td>
						</tr>";
				}		
		}
		else
		{
				echo "<tr><td class='celda' style='background:#F2E0C6;' colspan='3'>No hay fotos cargadas</td>";
		}	
	}

	public function traer_fotos_album_divs($idalbum)
	{
		$obj_cliente = new Query();
		$sql 	     = "select idfoto,idalbum,archivo,nombre,descripcion from fotos where idalbum=".$idalbum.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$num		 = $obj_cliente->getResultados();
					
		if ($num>0)
		{
				while($row= mysql_fetch_Array($result))
				{					
					echo "<div style='height:300px;margin-bottom:3px;margin-top:3px;margin-left:3px;margin-right:3px;padding:5px;border:1px solid silver;float:left;'>";
						echo "<div>";
							echo "<a href='./fotos/".$row['archivo']."' target='_blank'><img src='./fotos/".$row['archivo']."' style='width:200px;'></a>";
						echo "</div>";
						echo "<div>";
							echo $row['descripcion']." | ".$row['nombre'];
						echo "</div>";
					echo "</div>";
				}		
		}
		else
		{
				echo "<tr><td class='celda' style='background:#F2E0C6;' colspan='3'>No hay fotos cargadas</td>";
		}	
	}	

	public function borrar_foto($id)
	{
		$obj_cliente = new Query();
		$sql 	     = "delete from fotos where idfoto= ".$id.";";
		$result	     = $obj_cliente->executeQuery($sql);
		$filas	     = $obj_cliente->getAffect();
		
		if ($filas>0)
		{
			echo "<div style='background:green;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Foto borrada con EXITO! :D</b></div>";
		}
		else
		{
			echo "<div style='background:red;padding:10px;text-align:center;color:white;margin-top:3px;margin-bottom:5px;'><b>Ups!</b> hubo un problema al borrar la foto :S.</div>";
		}	
	}*/
}

?>