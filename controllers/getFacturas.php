<?php

	session_start();

	require '../fw/fw.php';
	require '../models/Actividades.php';
	require '../models/Facturas.php';
	require '../views/getFacturas.php';
	
	
	// PRIMER PANTALLA MUESTRA LAS ACTIVIDADES DE EL MES Y AÑO ACTUAL
	
	$act = new Actividades();
	$Responsables = $act->getResponsables();
	
	if (isset($_POST['Ir']))
	{
	
	
	
		$fact = new Facturas();
		$fact->validarBusqueda($_POST);
		
		$Anio = $_POST['anio'];
		$Mes = $_POST['mes'];
		$Responsable = $_POST['Res'];
		
		
		$calen = new Horarios();
		
		$Facturas =  $fact->ObtenerFacturas($Anio,$Mes,$Responsable);
		
		$v = new getFacturas();
		$v->Anios = $calen->GenerarAnios();
		$v->Responsables = $Responsables;
		$v->Meses = $calen->GenerarMeses();
		$v->Anio = $Anio;
		$v->Mes = $Mes;
		$v->Responsable = $Responsable;
		$v->Facturas = $Facturas;
		
		$v->render();
		
	}
	else
	{
		$Anio = date('Y');
		$Mes = date('m');
		$Responsable = 0;
		
		$calen = new Horarios();
	
		$fact = new Facturas();
		$Facturas = $fact->ObtenerFacturas($Anio,$Mes,$Responsable);
		
		$v = new getFacturas();
		$v->Anios = $calen->GenerarAnios();
		$v->Responsables = $Responsables;
		$v->Meses = $calen->GenerarMeses();
		$v->Anio = $Anio;
		$v->Mes = $Mes;
		$v->Responsable = $Responsable;
		$v->Facturas = $Facturas;
		$v->render();
		
	}
	

		
		

		