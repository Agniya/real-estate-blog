<?php
/**
*Контроллер страницы Редактора
*/
class C_Editor extends C_Base
{
	protected $articles;   //массив статей
	protected $m_articles; //менеджер статей
	
	public function __construct()
	{
		$this->m_articles = M_Articles::Instance();
		
		$this->needLogin = true;
		$this->user = null;
		$this->articles = array();		
	}
	
	protected function OnInput()
	{
		parent::OnInput();
		$this->title = $this->title.'Консоль редактора';
		$page = (isset($_GET['page']))?(int)$_GET['page']:1;
		
		$this->articles = $this->m_articles->GetAllArticles($page);
	}
	
	protected function OnOutput()
	{
		$vars = array('articles'=>$this->articles);
		$this->content = $this->Template('V/V_Editor.php', $vars);
		parent::OnOutput();
	}
}