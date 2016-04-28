<?php

	session_start();

	require '../fw/fw.php';
	require '../models/Actividades.php';
	require '../views/UpdActividades.php';
	require '../views/UpdHorarios.php';

	
	//CARGA EN LA PANTALLA LOS DATOS DE LA ACTIVIDAD A MODIFICAR
	if(isset($_GET['ID']))
	{
		
		//Models
		$act = new Actividades();
		$Repeticiones = $act->getRepeticiones();
		$Responsables = $act->getResponsables(); 
		$TipoActividades = $act->getTiposActividades();
		$Actividad = $act->getActividad($_GET);
		
		//Views
		$v = new UpdActividades();
		$v->Repeticiones = $Repeticiones;
		$v->Responsables = $Responsables;
		$v->TipoActividades = $TipoActividades;
		$v->Actividad = $Actividad;

		//var_dump($Actividad);
		$v->render();
	
	}
	// SE PRESIONO SIGUIENTE
	else if(isset($_POST['sigAct']))
	{
			
		$act = new Actividades();	
		$act->ValidarActividad($_POST);
		
		$act->getActividad($_POST);
		
		if (isset($_POST['chkFacturable']))
			$Facturable = "S";
		else
			$Facturable = "N";
		
		// Generamos un Array con los datos de La Actividad
		$Actividad = array('Descripcion' => $_POST['txtTitulo'], 
										 'ID'	=>$_POST['ID'],			
										'Responsable' => $_POST['selResponsable'],
										'FechaInicio' => $_POST['fechaIni'],
										'FechaFinalizacion' => $_POST['fechaFin'],
										'Repeticion' => $_POST['selRepeticiones'],
										'Facturable' => $Facturable,
										'TipoActividad' => $_POST['selTipAct'],
										'Repeticion' => $_POST['selRepeticiones'],
										'Tarifa' => $_POST['txtTarifa']);
							 
							 
		
		$_SESSION['Actividad'] = $Actividad;
	
		//Cargo las Aulas
		$Aulas = $act->getAulas();	
		
		//Cargo los Horarios
		$Hor = new Horarios();
		$Dias = $Hor->getDiasRepeticion($Actividad['Repeticion']);
		$Horarios = $Hor->getHorariosActividad($Actividad['ID']);
				
		$v = new UpdHorarios();
		$v->Dias = $Dias;
		$v->Aulas = $Aulas;
		$v->IdActividad = $Actividad['ID'];
		$v->Horarios = $Horarios;
		$v->render();
	}
	else if(isset($_POST['Guardar']))
	{
		$act = new Actividades();			
		$act->ModificarActividad($_POST);
		header('Location: Calendario'); 		
	}
	else
	{
		echo "ERROR";
	}

	

	
				
				
