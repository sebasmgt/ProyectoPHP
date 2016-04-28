<?php

	session_start();

	require '../fw/fw.php';
	require '../models/Actividades.php';
	require '../models/Facturas.php';
	require '../views/addFactura.php';
	
	
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
		
		$Actividades =  $fact->getActividadSinPagar($Anio,$Mes,$Responsable);


		$v = new addFactura();
		$v->Anios = $calen->GenerarAnios();
		$v->Responsables = $Responsables;
		$v->Meses = $calen->GenerarMeses();
		$v->Anio = $Anio;
		$v->Mes = $Mes;
		$v->Responsable = $Responsable;
		$v->Actividades = $Actividades;
		
		$_SESSION['Actividades'] = $Actividades;
		
		$v->render();
		
	}
	else if(isset($_POST['fac']))
	{
		$fact = new Facturas();		
		$fact->AgregarFactura($_SESSION['Actividades'],$_GET);		
		header('Location: Calendario'); 
	}
	else
	{
		$Anio = date('Y');
		$Mes = date('m');
		$Responsable = 0;
		
		$calen = new Horarios();
	
		$fact = new Facturas();
		$Actividades = $fact->getActividadSinPagar($Anio,$Mes,$Responsable);


		$v = new addFactura();
		$v->Anios = $calen->GenerarAnios();
		$v->Responsables = $Responsables;
		$v->Meses = $calen->GenerarMeses();
		$v->Anio = $Anio;
		$v->Mes = $Mes;
		$v->Responsable = $Responsable;
		$v->Actividades = $Actividades;
		$v->render();
		
	}
	

		
		

		