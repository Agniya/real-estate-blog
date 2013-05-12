<?php
/**
*Контроллер, обрабатывающий Ajax-запрос для вывода последнего отправленного пользователем комментария
*/
class C_AjaxComment extends C_Base
{
	protected $comments;// массив с комментарием пользователя, получаемый из базы
	protected $m_articles;//менеджер статей
	/**
	*Конструктор класса
	*/
	function __construct()
	{
		$this->comments=array();
	}
	/**
	*Виртуальный обработчик запроса
	*/			
	protected function OnInput()
	{
		$this->m_articles= M_Articles::Instance();	
		$this->comments = $this->m_articles->GetOneComment($_GET['id_article']);
		/*$this->comments['name'] = iconv('cp1251', 'UTF-8', $this->comments['name']);
		$this->comments['mail'] = iconv('cp1251', 'UTF-8', $this->comments['mail']);
		$this->comments['text'] = iconv('cp1251', 'UTF-8', $this->comments['text']);
		$this->comments['date'] = iconv('cp1251', 'UTF-8', $this->comments['date']);*/
	}
	/**
	*Преобразование полученных с сервера данных в формат json
	*/	
	protected function OnOutput()
	{				
		die(json_encode($this->comments));
	}
	
}