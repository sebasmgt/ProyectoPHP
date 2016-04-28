<?php

	session_start();

	require '../fw/fw.php';
	require '../models/Actividades.php';
	require '../views/delActividades.php';

	
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
		$v = new delActividades();
		$v->Repeticiones = $Repeticiones;
		$v->Responsables = $Responsables;
		$v->TipoActividades = $TipoActividades;
		$v->Actividad = $Actividad;

		//var_dump($Actividad);
		$v->render();
	
	}
	else if(isset($_POST['Eliminar']))
	{
		$act = new Actividades();			
		$act->BorrarActividad($_POST);
		header('Location: Calendario'); 		
	}
	else
	{
		echo "ERROR";
	}

	

	
				
				
