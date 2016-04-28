<?php


class Database
{
		
		///*********************************************************************************
		/// Atributos
		///*********************************************************************************
		private static $instancia;
		private $cn;
		private $res;
		
		
		private function __construct(){}
		
		
		///*********************************************************************************
		/// Obtiene la instancia de DataBase
		///*********************************************************************************
		public static function getInstance()
		{
				if(! self::$instancia)
						self::$instancia = new Database();
				return self::$instancia;
		}
		
		
		///*********************************************************************************
		/// Realiza la conexion con la Base de Datos
		///*********************************************************************************
		private function connect()
		{
				$this->cn = mysqli_connect("localhost","root","","laescalera",3306);
		}
		
		
		///*********************************************************************************
		/// Procesa una query
		///*********************************************************************************
		public function query($q, $ConTran)
		{
				if(!$this->cn) 
					$this->connect();
				
				$this->res = mysqli_query($this->cn,$q);
				
				if(mysqli_error($this->cn)!= "")
					if ($ConTran)
					{
						$this->RollbackTran();				
						echo mysqli_error($this->cn);  
					}
					else
						echo mysqli_error($this->cn);  
				
		}

		///*********************************************************************************
		/// Retorna el resultado de una consulta
		///*********************************************************************************
		public function fetch()
		{
				return mysqli_fetch_assoc($this->res);
		}
		
		///*********************************************************************************
		/// Retorna el numero de resultados de una Query
		///*********************************************************************************
		public function num_rows()
		{
				return mysqli_num_rows($this->res);
		}

		///*********************************************************************************
		/// Retorna una lista con los Resultados
		///*********************************************************************************
		public function fetchAll()
		{
			$temp = array();
			while($fila = $this->fetch())
			{
				$temp[] = $fila;
			}
			return $temp;
		}
		
		
		///*********************************************************************************
		/// Verifica si es un entero positivo y su rango
		///*********************************************************************************
		public function Existe($array, $var)	
		{
			if (!isset ($array[$var]))
				throw new Exception('Variable no definida');
		}
		

		///*********************************************************************************
		/// Verifica si la variable  no este vacia
		///*********************************************************************************
		public function isEmpty($var)
		{
				if($var == "")
					throw new Exception('Variable no definida');
						
		}
			
		
		///*********************************************************************************
		/// Retorna una string sin comillas
		///*********************************************************************************
		public function escape($str)
		{
				if(!$this->cn) 
					$this->connect();
					
				return mysqli_escape_string($this->cn,$str);
		}
		
		///*********************************************************************************
		/// Remplaza un comodin de un string
		///*********************************************************************************		
		public function replaceStr($str,$car,$new){
		
	      return str_replace($str,$new,$car);

	   }

		///*********************************************************************************
		/// Verifica si es un entero positivo y su rango
		///*********************************************************************************
		public function checkAlphaNum($str,$min,$max)	
		{			
			$this->isEmpty($str);
			
			if (!ctype_alnum($str))
				throw new Exception('Error en conversion de dato');
			
			if(strlen($str) < $min) 
				throw new Exception('Error en conversion de dato');
				
			if(strlen($str) > $max) 
				throw new Exception('Error en conversion de dato');
		}

		
		///*********************************************************************************
		/// Verifica si es un entero positivo y su rango
		///*********************************************************************************
		public function checkNumber($num)	
		{		
			$this->isEmpty($num);
			
			if (!ctype_digit($num))
				throw new Exception('Error en conversion de dato');
		}
		
		
		///*********************************************************************************
		/// Verifica un flotante y su rango
		///*********************************************************************************
		public function checkFloat($num,$min,$max)	
		{
			if (!is_numeric($num))
				throw new Exception('Error en conversion de dato');
			
			if($num < $min)
				throw new Exception('Error en conversion de dato');
				
			if($num > $max)
				throw new Exception('Error en conversion de dato');
		}
		
		
		///*********************************************************************************
		/// Verifica una Hora
		///*********************************************************************************
		function checktime($time)
		{
			
			$this->isEmpty($time);
							
			list($hour,$minute) = explode(':',$time);

			if (!($hour > -1 && $hour < 24 && $minute > -1 && $minute < 60))
		    {
				throw new Exception('Error en conversion de dato');
		    }
		} 
		
		
		///*********************************************************************************
		/// Verifica una Fecha
		///********************************************************************************* 
			function checkDate($date)
			{
				
				$this->isEmpty($date);
							
				list($yy,$mm,$dd) = explode("-",$date);
			   
			   if ($dd!="" && $mm!="" && $yy!="")
			   {
					  if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd))
					  {
						 if(!checkdate($mm,$dd,$yy))
								throw new Exception('Error en conversion de dato'); 
					  }
			   } 
			   else
						throw new Exception('Error en conversion de dato');
			}
		
		
		///*********************************************************************************
		/// Verifica que la fecha desde sea menor a la fecha Hasta
		///*********************************************************************************
		public function VerifFechaDH($fechaDesde, $fechaHasta)	
		{
	      		$des = explode ("-", $fechaDesde);
			    $has = explode ("-", $fechaHasta);
				
				$Diferencia = GregorianToJD($des[1], $des[2], $des[0]) - GregorianToJD($has[1], $has[2], $has[0]);
		
				if($Diferencia > 0)
					throw new Exception('Error en rango de dato');
		}	

		///*********************************************************************************
		/// Verifica que la Hora desde sea menor a la fecha Hasta
		///*********************************************************************************
		public function VerifHoraDH($HoraDesde, $HoraHasta)	
		{
				$hora1 = strtotime($HoraDesde);
				$hora2 = strtotime($HoraHasta);

				if( $hora1 > $hora2 ) 
						throw new Exception('Error en rango de dato');
						
		}
		
		///*********************************************************************************
		/// Inicia Transaccion
		///*********************************************************************************
		public function IniciarTran()
		{ 
			$this->query( "BEGIN",false); 
		}
	
		///*********************************************************************************
		/// Hace commit de la transaccion
		///*********************************************************************************
		public function CommitTran()
		{ 
			$this->query( "COMMIT",false); 
		}

		///*********************************************************************************
		/// Rollback de la transaccion
		///*********************************************************************************
		public function RollbackTran()
		{ 
			$this->query( "ROLLBACK",false); 
		}
		
		
		///*********************************************************************************
		/// Obtiene el ID del ultimo registro insertado  luego de un INSERT
		///*********************************************************************************
		public function UltimoIdInsertado()
		{ 
			if(!$this->cn) 
				$this->connect();
				
			return mysqli_insert_id($this->cn);
		}
		
		
}

		//$d = Database::getInstance();
		//$d->query("select * from empleado");
		//var_dump($d->fetchAll());
		//var_dump($d->num_rows());
		//var_dump($d->escape("%&dasda#sdas%$&"));
		
		
		