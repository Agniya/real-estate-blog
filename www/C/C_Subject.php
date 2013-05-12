<?php
/**
*Контроллер страницы, демонстрирующей статьи, относящиеся к одному разделу
*/
class C_Subject extends C_Base
{
	protected $articles; 	//статьи, относящиеся к одному разделу
	protected $m_articles;	//менеджер статей
	/**
	*Конструктор класса
	*/
	public function __construct()
	{
		$this->articles = array();
		$this->m_articles = M_Articles::Instance();
	}
	/**
	*Виртуальный обработчик запроса
	*/	
	protected function OnInput()
	{
		parent::OnInput();
		
		$id_subject=$_GET['id_subject'];
		$page = (isset($_GET['page']))?(int)$_GET['page']:1;
		
		$this->articles=$this->m_articles->artSubject($page, $id_subject);
				
		foreach($this->articles as $key => $article)
			$this->articles[$key]['intro'] = $this->m_articles->articles_intro($article);
	}
	/**
	*Виртуальный генератор HTML
	*/
	protected function OnOutput()
	{
		// Генерация шаблона страницы V_Subject
		$vars = array('articles'=>$this->articles);
		$this->content = $this->Template('V/V_Subject.php', $vars);
		// Вызов родительского метода
		parent::OnOutput();
	}
}