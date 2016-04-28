<?php

class Horarios extends Model
{


	///*********************************************************************************************************************************
	/// Descripcion = Arma los dias se la semana dependiendo del tipo de repeticion (Semanal o Diario)
	///*********************************************************************************************************************************
	public function getDiasRepeticion($TipoRepeticion)
	{
		$DiaRepeticiones = array();
		
		if($TipoRepeticion == '1')
		{
			$Dia = array('Dia' => 'Todos Los Dias', 'Id' => '0');				
			$DiaRepeticiones[] = $Dia;
		
		}
		else
		{
			$Dia = array('Dia' => 'Lunes', 'Id' => '1');				
			$DiaRepeticiones[] = $Dia;
			$Dia = array('Dia' => 'Martes', 'Id' => '2');				
			$DiaRepeticiones[] = $Dia;
			$Dia = array('Dia' => 'Miercoles', 'Id' => '3');				
			$DiaRepeticiones[] = $Dia;
			$Dia = array('Dia' => 'Jueves', 'Id' => '4');				
			$DiaRepeticiones[] = $Dia;
			$Dia = array('Dia' => 'Viernes', 'Id' => '5');				
			$DiaRepeticiones[] = $Dia;
			$Dia = array('Dia' => 'Sabado', 'Id' => '6');				
			$DiaRepeticiones[] = $Dia;
			$Dia = array('Dia' => 'Domingo', 'Id' => '7');				
			$DiaRepeticiones[] = $Dia;
		
		}		
		//var_dump($DiaRepeticiones);
		return $DiaRepeticiones;
	}
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Arma un array con los dias y horas seleccionados
	///*********************************************************************************************************************************
	public function ObtenerDiasHoras($Horarios)
	{
			
		$i = array();
		
		$i = 0;
		
		while($i <= 7)
		{
			if(isset($Horarios['dia'.$i]) && $Horarios['dia'.$i] == 'on')
			{
				$this->ValidarHorario($Horarios, $i);
				
				$Horario = array('Id' => $i, 'HoraInicio' => $Horarios['horaInicio'.$i],
								 'HoraFinal' => $Horarios['horaFinal'.$i], 'selAula' => $Horarios['selAula'.$i]);				
				$HorariosSeleccionados[] = $Horario;
			}
			$i = $i + 1;
		}

		return $HorariosSeleccionados;
		
	}
	
	///*********************************************************************************************************************************
	/// Descripcion = Armas las fechas disponibles entre una fecha desde, una fecha hasta y con los horarios seleccionados
	///*********************************************************************************************************************************
	public function Calcular_Fechas($FechaInicio, $FechaFinal, $Horarios)
	{
	  //var_dump($Horarios);
	
		$Jornadas = array();
		
		for($i=$FechaInicio; $i <= $FechaFinal; $i = date("Y-m-d", strtotime($i ."+ 1 days")))
		{
			
			$dia = substr($i,8,2);
			$mes = substr($i,5,2);
			$anio = substr($i,0,4); 
			
		
			//var_dump($FechaFinal);
			
			//echo substr($i,8,2) . " " . substr($i,5,2). " " . substr($i,0,4) ."<br />";
			
			$semana = date('N',  mktime(0,0,0,$mes,$dia,$anio)); 
			//var_dump($Horarios);
				
			foreach($Horarios as $Horario)
			{
				if(($Horario['acd_diaac'] == $semana || $Horario['acd_diaac'] == 0) && (
						$i >= $Horario['act_feini']  &&  $i <= $Horario['act_fefin'] ))
				{	
					$Jornadas[] = array('idActividad' => $Horario['act_idact'], 
													 'FechaActividad' => $i, 
													 'TituloActividad' => $Horario['act_descr'], 
													 'HoraInicio' => $Horario['acd_horai'], 
													 'HoraFinalizacion' => $Horario['acd_horaf']);

					//echo $i." - ".$Horario['acd_horai']." - ".$Horario['acd_horaf']." - ".$Horario['acd_idaul']."<br />";	
				} 
			}
					
		}	
		 //var_dump($Jornadas);
		 return $Jornadas;
		
	}
	
	///*********************************************************************************************************************************
	/// Descripcion =  Verifica que no exista una actividad que se superpongan los horarios
	///*********************************************************************************************************************************
	public function VerificarHorarios($Actividad, $Horarios)
	{
	
		$Repetidos = array();
		
		foreach($Horarios as $Horario)
		{
			
		    $this->VerificarHorario($Actividad, $Horario);

			if ($this->db->num_rows() > 0)
				$Repetidos[] = $this->db->fetch();
		}		 
		
		return $Repetidos;
	
	}
	
	
	
	///*********************************************************************************************************************************
	/// Verifica que un horario no exista en otra actividad con el mismo dia, aula y hora desde - hasta
	///*********************************************************************************************************************************
	public function VerificarHorario($Actividad, $Horario)
	{

		$Query  =	"SELECT * FROM actividades_dias
										   JOIN actividades ON act_idact = acd_idact
										   WHERE  (acd_diaac = ".$Horario['Id']."  OR ".$Horario['Id']." = 0) AND
										   (act_idact <> ".$Actividad['ID'].") AND
										   (('".$Horario['HoraInicio']."' BETWEEN  acd_horai AND acd_horaf) OR ('".$Horario['HoraFinal']."' BETWEEN  acd_horai AND acd_horaf)) AND
										   (('".$Actividad['FechaInicio']."' BETWEEN act_feini AND act_fefin ) OR ( '".$Actividad['FechaFinalizacion']."' BETWEEN act_feini AND act_fefin )) AND
										   (acd_idaul = ".$Horario['selAula'].") ";
										   
						
		$this->db->query($Query,false);	
	
	}
	
	///*********************************************************************************************************************************
	/// Valida todos los datos de los Horarios pasados por POST
	///*********************************************************************************************************************************
	public function ValidarHorario($Horarios, $i)
	{
	
	    // VERIFICAR SI LA VARIABLE ESTE SETEADA
		$this->db->Existe($Horarios,'horaInicio'.$i);
		$this->db->Existe($Horarios,'horaFinal'.$i);
		$this->db->Existe($Horarios,'selAula'.$i);
		
		
		// VERIFICA EL CONTENIDO

		$this->db->checktime($Horarios['horaInicio'.$i]);
		$this->db->checktime($Horarios['horaFinal'.$i]);
		$this->db->checkNumber($Horarios['selAula'.$i]);

		$this->db->VerifHoraDH($Horarios['horaInicio'.$i],$Horarios['horaFinal'.$i]);
	
	}
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Conversor de horarrios
	///*********************************************************************************************************************************
	public function ConvertirHorarios($Horarios)
	{
		
		$lista = array();
		

		foreach($Horarios as $Hor)
			{
					$lista[$Hor['acd_diaac']] = $Hor;
			}		 
			
			return $lista;
	
	
	}
	
	///*********************************************************************************************************************************
	/// Descripcion = Obtiene los Horarios de una Actividad
	///*********************************************************************************************************************************
	public function getHorariosActividad($id)
	{
			$Query  =	"SELECT * FROM actividades_dias
										   JOIN actividades ON act_idact = acd_idact
										   WHERE act_idact = " . $id ;
										   
			$this->db->query($Query,false);	
			
			$Horarios = $this->db->fetchAll();
			
			return $this->ConvertirHorarios($Horarios);
			
	}
	
	///*********************************************************************************************************************************
	/// Descripcion = Genera un Array con años
	///*********************************************************************************************************************************
	public function GenerarAnios()
	{
		$ListaAnios = Array();
		
		for($anio=(date('Y')+1); 1980 <= $anio; $anio--) 
		{
				$ListaAnios[] = $anio;		
		}
		
		return $ListaAnios;
	}
	
	
	///*********************************************************************************************************************************
	/// Descripcion = Genera un Array con los Meses
	///*********************************************************************************************************************************
	public function GenerarMeses()
	{
		$ListaMeses = Array();
		
			$Mes = array('Mes' => 'Enero', 'Id' => '1');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Febrero', 'Id' => '2');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Marzo', 'Id' => '3');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Abril', 'Id' => '4');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Mayo', 'Id' => '5');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Junio', 'Id' => '6');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Julio', 'Id' => '7');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Agosto', 'Id' => '8');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Septiembre', 'Id' => '9');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Octubre', 'Id' => '10');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Noviembre', 'Id' => '11');				
			$ListaMeses[] = $Mes;
			$Mes = array('Mes' => 'Diciembre', 'Id' => '12');				
			$ListaMeses[] = $Mes;			
		
		return $ListaMeses;
	}
	

	///*********************************************************************************************************************************
	/// Descripcion = Obtiene las fechas de las actividades de un determinado mes y año
	///*********************************************************************************************************************************
	public function ObtenerFechasEventos($Anio, $Mes)
	{
		
			
		$FechaInicio = date("Y-m-d", mktime(0, 0, 0, $Mes, 01, $Anio));
		$UltimoDiaMes = $this->getUltimoDiaMes($Anio,$Mes);
		$FechaFinalizacion = date("Y-m-d", mktime(0, 0, 0, $Mes, $UltimoDiaMes, $Anio));

		// var_dump($FechaInicio);
		// var_dump($UltimoDiaMes);
		// var_dump($FechaFinalizacion);
		
		$this->db->query("SELECT * FROM actividades 
									  JOIN actividades_dias ON act_idact = acd_idact
									  WHERE (act_feini between '".$FechaInicio."' and '".$FechaFinalizacion."') OR (act_fefin between '".$FechaInicio."' and '".$FechaFinalizacion."') ORDER BY acd_horai",false);
		
		
		
		$DiasActividad = $this->db->fetchAll();
	
		
		$Hor = new Horarios();
		$Fechas = $Hor->Calcular_Fechas($FechaInicio, $FechaFinalizacion, $DiasActividad);
		//var_dump($Fechas);
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
	/// Descripcion = Genera los datos para armar el calendario de un mes y año determinado
	///*********************************************************************************************************************************	
	public function ArmarCalendario($Mes,$Anio)
	{

			$CantidadDeDias = date('t', mktime(0, 0, 0, $Mes, 1, $Anio));
						
			$week = 1;
			for($i=1;$i <= $CantidadDeDias ;$i++) 
			{				
				$day_week = date('N', mktime(0,0,0,$Mes,$i,$Anio));
					
				$calendar[$week][$day_week] = $i;
	
				if ($day_week == 7) { $week++; };
					
			}
			
			return $calendar;
	
	
	
	}	
	
	
	

	
	
}


