<?php

abstract Class View
{
	public function render()
	{
		//var_dump(get_class($this));
		include '../html/'.get_class($this).'.php';
	}
}