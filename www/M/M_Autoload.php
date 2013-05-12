<?php
	function __autoload($classname)
	{
		$type=explode('_',$classname);
		
		switch($type[0])
		{
			case 'C':
				require_once('C/'.$classname.'.php');
				break;
			case 'M':
				require_once('M/'.$classname.'.php');		
		}
	}