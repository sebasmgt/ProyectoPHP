<?


require '../models/Horarios.php';
	

class Actividades extends Model
{



	///*********************************************************************************************************************************
	/// Descripcion = Trae todas las repeticiones disponibles 
	/// LAS REPETICIONES ESTAN HARDCODEADAS PORQUE NO SE DEBEN PODER AGREGAR OTRAS
	///*********************************************************************************************************************************
	public function getRepeticiones()
	{
		$Repeticiones = array();
		
		$Repeticion = array('Descripcion' => 'Todos Los Dias', 'Id' =>'1');				
		$Repeticiones[] = $Repeticion;
		$Repeticion = array('Descripcion' => 'Semanalmente', 'Id' =>'2');				
		$Repeticiones[] = $Repeticion;
		
		return $Repeticiones;
	}
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Trae todos los responsables
	///*********************************************************************************************************************************
	public function getResponsables()
	{
		
		$this->db->query("SELECT res_idres, res_nombr FROM responsables"  ,false);
		
		$Responsables = $this->db->fetchAll();
		
		return $Responsables;
		
	}
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Trae todas los tipos de Actividades ( taller -  espectaculo - evento)
	///*********************************************************************************************************************************
	public function getTiposActividades()
	{
		
		$this->db->query("SELECT tac_tipid, tac_descr FROM tipoactividad"  ,false);
		
		$TipoActividades = $this->db->fetchAll();
		
		return $TipoActividades;
		
	}
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Trae todas las aulas
	///*********************************************************************************************************************************
	public function getAulas()
	{
	
		$this->db->query("SELECT aul_idaul, aul_descr FROM aulas"  ,false);
		
		$Aulas = $this->db->fetchAll();
		
		return $Aulas;
	
	}
	
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Agrega una Actividad
	///*********************************************************************************************************************************
	public function AgregarActividad($POST)
	{
		$Hor = new Horarios();

		$Horarios = $Hor->ObtenerDiasHoras($POST);
		$Actividad = $_SESSION['Actividad'];
		$Repetidos = $Hor->VerificarHorarios($Actividad,$Horarios);

		 if (count($Repetidos) == 0)
		 {
		 	$this->GuardarActividad($Actividad,$Horarios);
			// SI TODO FUE BIEN MOSTRAR MENSAJE , SI NO MOSTRAR ERROR
		 }
		 else
		{
			//ENVIAR MENSAJE A LA PANTALLA MOSTRANDO LAS FECHAS QUE SE SUPERPONEN
			var_dump($Repetidos);
		}
	}
	

	
	
	///*********************************************************************************************************************************
	/// Agrega una Actividad 
	///*********************************************************************************************************************************
	private function GuardarActividad($Actividad,$Horarios)
	{

		// ABRIR TRANSACCION - GRABAR ACTIVIDAD - BUSCAR ID INSERTADO - GUARDAR HORARIOS PARA LA ACTIVIDAD
		
     	$Estado = array();
		
		$this->db->IniciarTran();
		
								
		$this->db->query("INSERT INTO actividades (act_respo,act_descr,act_tipoa,act_feini,act_fefin,act_esfac,act_repet,act_tarifa)
								  VALUES (".$Actividad['Responsable'].",'".$Actividad['Descripcion']."',".$Actividad['TipoActividad'].",
								  '".$Actividad['FechaInicio']."','".$Actividad['FechaFinalizacion']."','".$Actividad['Facturable']."',".$Actividad['Repeticion'].",".$Actividad['Tarifa'].") "  ,true);
		
		
		$IdActividad = $this->db->UltimoIdInsertado();
			
		foreach($Horarios as $Horario)
		{
			// TODO: SI JUSTO 2 USUARIOS INSERTAN AL MISMO TIEMPO HORARIOS QUE SE PISAN PARA DISTINTAS ACTIVIDADES
			
			$Hor = new Horarios();
		    $Hor->VerificarHorario($Actividad, $Horario);

			if ($this->db->num_rows() == 0)  			
					$this->db->query("INSERT INTO actividades_dias (acd_idact,acd_diaac,acd_horai,acd_horaf,acd_idaul)
									  VALUES (".$IdActividad.",".$Horario['Id'].",'".$Horario['HoraInicio']."',
									  '".$Horario['HoraFinal']."',".$Horario['selAula'].") ",true);
			else	
				$estado[] = $Horario;
				
		}
								
		$this->db->CommitTran();

		
		
	}
	
	///*********************************************************************************************************************************
	/// Valida todos los datos de la actividad pasados por POST
	///*********************************************************************************************************************************
	public function ValidarActividad($POSTACT)
	{
	    // VERIFICAR SI LA VARIABLE ESTE SETEADA
		$this->db->Existe($POSTACT,'txtTitulo');
		$this->db->Existe($POSTACT,'selResponsable');
		$this->db->Existe($POSTACT,'selRepeticiones');
		$this->db->Existe($POSTACT,'fechaIni');
		$this->db->Existe($POSTACT,'fechaFin');
		$this->db->Existe($POSTACT,'selTipAct');
		$this->db->Existe($POSTACT,'txtTarifa');
		
		
		// VERIFICA EL CONTENIDO
		$this->db->checkFloat($POSTACT['txtTarifa'],0,1000000);
		$this->db->checkAlphaNum($POSTACT['txtTitulo'],6,80);
		$this->db->checkNumber($POSTACT['selResponsable']);
		$this->db->checkNumber($POSTACT['selRepeticiones']);
		$this->db->checkDate($POSTACT['fechaIni']);
		$this->db->checkDate($POSTACT['fechaFin']);
		$this->db->checkNumber($POSTACT['selTipAct']);
		$this->db->VerifFechaDH($POSTACT['fechaIni'],$POSTACT['fechaFin']);

		// VERIFICO QUE EXISTA EL RESPONSABLE Y EL TIPO DE Actividad	
		$this->db->query("SELECT * FROM responsables WHERE res_idres = ".$POSTACT['selResponsable']  ,false);
		if($this->db->num_rows() == 0)
			throw new Exception('Error al buscar dato en la BD');
			
		$this->db->query("SELECT * FROM tipoactividad WHERE tac_tipid = ".$POSTACT['selTipAct']  ,false);
		if($this->db->num_rows() == 0)
			throw new Exception('Error al buscar dato en la BD');
		
	}
	

	///*********************************************************************************************************************************
	/// Obtiene los datos de una actividad pasandole el ID
	///*********************************************************************************************************************************
	public function getActividad ($GET)
	{
	
		$this->db->Existe($GET,'ID');
		$this->db->checkNumber($GET['ID']);
				
		$id = $GET['ID'];
				
		$this->db->query("SELECT * FROM actividades 			  
									  WHERE act_idact =".$id , false);
		
		
		
		$Actividad = $this->db->fetch();
		
		if($this->db->num_rows() == 0)
				throw new Exception('Error al buscar dato en la BD');
			
		return $Actividad;

	}
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Modifica una Actividad
	///*********************************************************************************************************************************
	public function ModificarActividad($POST)
	{
		$Hor = new Horarios();

		$Horarios = $Hor->ObtenerDiasHoras($POST);
		
		
		$Actividad = $_SESSION['Actividad'];
		$Repetidos = $Hor->VerificarHorarios($Actividad,$Horarios);

		 if (count($Repetidos) == 0)
		 {
		 	$this->GuardarModificacionActividad($Actividad,$Horarios);
			// SI TODO FUE BIEN MOSTRAR MENSAJE , SI NO MOSTRAR ERROR
		 }
		 else
		{
			//ENVIAR MENSAJE A LA PANTALLA MOSTRANDO LAS FECHAS QUE SE SUPERPONEN
			throw new Exception('Actividad se sobrepone con otra');
		}
	}
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Modifica una Actividad
	///*********************************************************************************************************************************
	public function BorrarActividad($GET)
	{
	
		$this->getActividad($GET);
		
		// Borro los Horarios e Inserto los Nuevos, 
		$this->db->query("DELETE FROM actividades WHERE  act_idact = ".$GET['ID'],false);
		
		// Borro los Horarios e Inserto los Nuevos, 
		$this->db->query("DELETE FROM actividades_dias WHERE acd_idact = ".$Actividad['ID'],false);
	
	}
	
	
	
	///*********************************************************************************************************************************
	/// Guarda la modificacion una Actividad 
	///*********************************************************************************************************************************
	private function GuardarModificacionActividad($Actividad,$Horarios)
	{
				
     	$Estado = array();
		$this->db->IniciarTran();
		
		// Hace el update de la cabecera de la actividad
		$this->db->query("UPDATE actividades
											SET act_respo = ".$Actividad['Responsable'].",
												   act_descr = '".$Actividad['Descripcion']."',
												   act_tipoa = ".$Actividad['TipoActividad'].",
												   act_feini = '".$Actividad['FechaInicio']."',
												   act_fefin = '".$Actividad['FechaFinalizacion']."',
												   act_esfac = '".$Actividad['Facturable']."',
												   act_repet = ".$Actividad['Repeticion'].",
												   act_tarifa = ".$Actividad['Tarifa']."
										    WHERE act_idact = ".$Actividad['ID']. " AND
												   (act_respo <> ".$Actividad['Responsable']." OR
												    act_descr <> '".$Actividad['Descripcion']."' OR
												    act_tipoa <> ".$Actividad['TipoActividad']." OR
												    act_feini <> '".$Actividad['FechaInicio']."' OR
												    act_fefin <> '".$Actividad['FechaFinalizacion']."' OR
												    act_esfac <> '".$Actividad['Facturable']."' OR
												    act_repet <> ".$Actividad['Repeticion']." OR
													act_tarifa <> ".$Actividad['Tarifa']."
													)",true);
		
		
		// Borro los Horarios e Inserto los Nuevos, 
		$this->db->query("DELETE FROM actividades_dias WHERE acd_idact = ".$Actividad['ID'],true);
		
		// Inserto Nuevamente los Registros con las cambios que se hicieron
		foreach($Horarios as $Horario)
		{
			$Hor = new Horarios();
		    $Hor->VerificarHorario($Actividad, $Horario);

			if ($this->db->num_rows() == 0)  			
					$this->db->query("INSERT INTO actividades_dias (acd_idact,acd_diaac,acd_horai,acd_horaf,acd_idaul)
									  VALUES (".$Actividad['ID'].",".$Horario['Id'].",'".$Horario['HoraInicio']."',
									  '".$Horario['HoraFinal']."',".$Horario['selAula'].") ",true);
			else	
				$estado[] = $Horario;
		
		}
		
		$this->db->CommitTran();		
	}

}


