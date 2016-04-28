<?php

	session_start();

	require '../fw/fw.php';
	
	require '../models/Actividades.php';
	require '../views/AddActividades.php';
	require '../views/AddHorarios.php';

	
	//Si se preciono el boton Siguiente... Cargar el objeto y pasar a la siguiente Pantalla
	if(isset($_POST['sigAct']))
	{
				
		//FALTA VALIDAR LOS DATOS QUE VIENE POR $_POST
		
		$act = new Actividades();
		
		
		$act->ValidarActividad($_POST);
		
		if (isset($_POST['chkFacturable']))
			$Facturable = "S";
		else
			$Facturable = "N";
		
		// Generamos un Array con los datos de La Actividad
		$Actividad = array(    'Descripcion' => $_POST['txtTitulo'], 
										'ID'	=> -1,
										'Responsable' => $_POST['selResponsable'],
										'FechaInicio' => $_POST['fechaIni'],
										'FechaFinalizacion' => $_POST['fechaFin'],
										'Repeticion' => $_POST['selRepeticiones'],
										'Facturable' => $Facturable,
										'TipoActividad' => $_POST['selTipAct'],
										'Repeticion' => $_POST['selRepeticiones'],
										'Tarifa' => $_POST['txtTarifa']);
							 
							 
		$_SESSION['Actividad'] = $Actividad;
	
		$Aulas = $act->getAulas();
		$Hor = new Horarios();
		$Dias = $Hor->getDiasRepeticion($Actividad['Repeticion']);

		$v = new AddHorarios();
		$v->Dias = $Dias;
		$v->Aulas = $Aulas;
		$v->render();
		
	}
	//Si se preciono el boton guardar es de la segunda Pantalla
	else if(isset($_POST['Guardar']))
	{
		$act = new Actividades();
		$act->AgregarActividad($_POST);		
		header('Location: Calendario'); 
	}
	//Es la primer pantalla que aparece (CARGAR NUEVA ACTIVIDAD VACIA) 
	else
	{
		//Models
		$act = new Actividades();
		$Repeticiones = $act->getRepeticiones();
		$Responsables = $act->getResponsables(); 
		$TipoActividades = $act->getTiposActividades();
		
		
		//Views
		$v = new AddActividades();
		$v->Repeticiones = $Repeticiones;
		$v->Responsables = $Responsables;
		$v->TipoActividades = $TipoActividades;

		//var_dump($PRepeticiones);
		$v->render();
		
	}
	

	
				
				
