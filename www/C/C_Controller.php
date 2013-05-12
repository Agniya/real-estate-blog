<?php
/**
*Базовый класс контроллера
*/
abstract class C_Controller
{
	
	/**
	*Конструктор класса
	*/
	protected function __construct()
	{
	}
	/**
	*Полная обработка HTTP запроса.
	*/
	public function Request()
	{
		$this->OnInput();
		$this->OnOutput();
	}
	/**
	*Виртуальный обработчик запроса
	*/	
	protected function OnInput()
	{
	}
	/**
	*Виртуальный генератор HTML
	*/
	protected function OnOutput()
	{
	}
	/**
	*проверка метода, которым был направлен запрос
	*/
	protected function IsGet()
	{
		return $_SERVER['REQUEST_METHOD']=='GET';
	}
	/**
	*проверка метода, которым был направлен запрос
	*/
	protected function IsPost()
	{
		return $_SERVER['REQUEST_METHOD']=='POST';
	}
	/**
	*Генерация HTML шаблона в строку.
	*/
	protected function Template($FileName,$vars=array())
	{
		foreach($vars as $key=>$value)
		{
			$$key=$value;
		}
		
		ob_start();
		include $FileName;
		return ob_get_clean();
	}
}


