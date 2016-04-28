<?php

abstract class Model 
{	
	protected $db;
	
	///*********************************************************************************
	/// Constructor que obtiene la instancia de Database.
	///*********************************************************************************
	public function __construct()
	{
		$this->db = Database::getInstance();
		
	}

}