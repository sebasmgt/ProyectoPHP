<?php

class Facturas extends Model
{


	public function getActividadSinPagar($Anio,$Mes,$Respo)
	{
		// VALIDAR EL POST
		
		
		
			

		
		$FechaInicio = date("Y-m-d", mktime(0, 0, 0, $Mes, 01, $Anio));
		$UltimoDiaMes = $this->getUltimoDiaMes($Anio,$Mes);
		$FechaFinalizacion = date("Y-m-d", mktime(0, 0, 0, $Mes, $UltimoDiaMes, $Anio));
			
		
		$this->db->query("SELECT * FROM actividades 
							WHERE ((act_feini between '".$FechaInicio."' and '".$FechaFinalizacion."') OR (act_fefin between '".$FechaInicio."' and '".$FechaFinalizacion."')) AND act_respo = ".$Respo." ORDER BY act_idact",false);


		
		$Actividades = $this->db->fetchAll();
		
		
		$this->db->query("SELECT * FROM actividades 
									JOIN actividades_dias ON act_idact = acd_idact
									JOIN aulas  on acd_idaul = aul_idaul
								   WHERE ((act_feini between '".$FechaInicio."' and '".$FechaFinalizacion."') OR (act_fefin between '".$FechaInicio."' and '".$FechaFinalizacion."')) AND act_respo = ".$Respo." AND act_esfac = 'S' ORDER BY act_idact",false);


		$DiasActividad = $this->db->fetchAll();	

		$Fechas = $this->Calcular_Fechas($FechaInicio, $FechaFinalizacion, $DiasActividad,$Actividades);
		return $Fechas;
		
	}
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Obtiene ultimo dia de un mes y añor determiado
	///*********************************************************************************************************************************
	private function getUltimoDiaMes($Anio,$Mes) 
	{
			return date("d",(mktime(0,0,0,$Mes+1,1,$Anio)-1));
	}
	
	///*********************************************************************************************************************************
	/// Descripcion = Arma las fechas para mostrarlas correctamente
	///*********************************************************************************************************************************
	public function Calcular_Fechas($FechaInicio, $FechaFinal, $Horarios, $Actividades)
	{
	
		$Jornadas = array();
								
			foreach($Actividades as $act)
			{
					$CantidadClases = 0;
					foreach($Horarios as $Horario)
					{
						
						if($act['act_idact'] == $Horario['act_idact'])
						{						
								for($i=$FechaInicio; $i <= $FechaFinal; $i = date("Y-m-d", strtotime($i ."+ 1 days")))
								{
									$dia = substr($i,8,2);
									$mes = substr($i,5,2);
									$anio = substr($i,0,4); 
									$semana = date('N',  mktime(0,0,0,$mes,$dia,$anio)); 
									
									 if(($Horario['acd_diaac'] == $semana || $Horario['acd_diaac'] == 0) && (
											 $i >= $Horario['act_feini']  &&  $i <= $Horario['act_fefin'] ))			
									 {									
										$CantidadClases = $CantidadClases + 1;
									 } 
								}	
						}   
					 }
					
					$Total = $CantidadClases * $act['act_tarifa'];
					
					$Jornadas[] = array(	'idActividad' => $act['act_idact'], 
														'TituloActividad' => $act['act_descr'], 
														'Tarifa' => $act['act_tarifa'],
														'Total' => $Total,
														'CantidadClases' =>$CantidadClases);
					
			}
		 return $Jornadas;
		
	}
	
	//*********************************************************************************************************************************
	/// Descripcion = Genera una Factura
	///*********************************************************************************************************************************
	public function AgregarFactura($Actividades, $Datos)	
	{
			//var_dump($Datos);
			//var_dump($Actividades);
			// VALIDAR Datos
			
			$this->VerificarFacturacion($Datos);
			$this->GuardarFactura($Actividades,$Datos);
			
	}
	
	
	//*********************************************************************************************************************************
	/// Descripcion = Verifica si esa actividad ha sido facturada en ese mes y ese año para el responsable
	///*********************************************************************************************************************************
	public function VerificarFacturacion($Datos)	
	{
			
					$this->db->query("SELECT * FROM pagos 
								    WHERE pag_anio = ".$Datos['Anio']." AND pag_mes = ".$Datos['Mes']." AND pag_idres = ".$Datos['Res'] ,false);

					if($this->db->num_rows() > 0)
							throw new Exception('Actividad Ya Facturada');
					
	}
	
	
	public function CalculoTotal($Actividades)	
	{
			$total = 0;
			foreach($Actividades as $act)
			{
				$total = $total + $act['Total'];
			}
			
			return $total;
				
	}
	
	///*********************************************************************************************************************************
	/// Agrega una Actividad 
	///*********************************************************************************************************************************
	private function GuardarFactura($Actividades, $Datos)
	{

		// ABRIR TRANSACCION - GRABAR ACTIVIDAD - BUSCAR ID INSERTADO - GUARDAR HORARIOS PARA LA ACTIVIDAD
		
		$Total = $this->CalculoTotal($Actividades);
		$FechaActual = date('Y-m-d');
		
		
		$this->db->IniciarTran();
		
		$this->db->query("INSERT INTO pagos (pag_fegen, pag_anio, pag_mes, pag_idres, pag_total)
								  VALUES ('".$FechaActual."',".$Datos['Anio'].",".$Datos['Mes'].",
								  ".$Datos['Res'].",".$Total.") "  , true);
		
		
		$IdPago = $this->db->UltimoIdInsertado();
		
		var_dump ($IdPago);
		
			
		foreach($Actividades as $Actividad)
		{
				$this->db->query("INSERT INTO pagos_actividades (pac_idpago,pac_idact,pac_monto,pac_canti)
									      VALUES (".$IdPago.",".$Actividad['idActividad'].",".$Total.",".$Actividad['CantidadClases'].") ",true);
			
		}
								
		$this->db->CommitTran();

		
		
	}
	
	///*********************************************************************************************************************************
	/// Valida todos los datos de la actividad pasados por POST
	///*********************************************************************************************************************************
	public function validarBusqueda($POSTACT)
	{
	    // VERIFICAR SI LA VARIABLE ESTE SETEADA
		$this->db->Existe($POSTACT,'anio');
		$this->db->Existe($POSTACT,'mes');
		$this->db->Existe($POSTACT,'Res');

		
		$this->db->checkNumber($POSTACT['anio']);
		$this->db->checkNumber($POSTACT['mes']);
		$this->db->checkNumber($POSTACT['Res']);

		// VERIFICO QUE EXISTA EL RESPONSABLE Y EL TIPO DE Actividad	
		$this->validarResponsable($POSTACT['Res']);
				
	}
	
	
	public function validarResponsable($respon)
	{	
	
	    // VERIFICO QUE EXISTA EL RESPONSABLE Y EL TIPO DE Actividad	
		$this->db->query("SELECT * FROM responsables WHERE res_idres = ".$respon ,false);
		if($this->db->num_rows() == 0)
			throw new Exception('Error al buscar dato en la BD');
	
	}	
	
	//*********************************************************************************************************************************
	/// Descripcion = Trae las Facturas
	///*********************************************************************************************************************************
	public function ObtenerFacturas($Anio,$Mes,$Responsable)	
	{
		
		
		$this->db->query("SELECT * FROM pagos 
					JOIN responsables ON res_idres = pag_idres
				    WHERE pag_anio = ".$Anio." AND pag_mes = ".$Mes." AND pag_idres = ".$Responsable,false);


		$Facturas = $this->db->fetchAll();	
			
		return $Facturas;
			
	}
	
	


}


