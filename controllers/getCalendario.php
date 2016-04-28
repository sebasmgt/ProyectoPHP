<?php

	session_start();

	require '../fw/fw.php';
	require '../models/Horarios.php';
	require '../views/getCalendario.php';
	
	
	
	
	// PRIMER PANTALLA MUESTRA LAS ACTIVIDADES DE EL MES Y AÑO ACTUAL
	if (!isset($_POST['Ir']))
	{
	
		$Anio = date('Y');
		$Mes = date('m');
		
	}
	else
	{
			
		$Anio = $_POST['anio'];
		$Mes = $_POST['mes'];
	}
			
		$calen = new Horarios();
		$v = new getCalendario();
		$v->Fechas = $calen->ObtenerFechasEventos($Anio,$Mes);
		$v->Anios = $calen->GenerarAnios();
		$v->Meses = $calen->GenerarMeses();
		$v->Anio = $Anio;
		$v->Mes = $Mes;
		
		$v->Calendario = $calen->ArmarCalendario($Mes,$Anio);
		$v->render();

		