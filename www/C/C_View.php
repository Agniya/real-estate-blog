<?php
/**
*Контроллер Главной страницы V_View
*/
class C_View extends C_Base
{
	protected $articles;   //массив, содержащий данные о названии, содержании, дате публикации статьи, путь до графического изображения
	protected $m_articles; //менеджер статей
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
		$this->title = $this->title.'Recent articles';
		$page = (isset($_GET['page']))?(int)$_GET['page']:1;
		
		$this->articles=$this->m_articles->GetAllArticles($page);
		foreach($this->articles as $key => $article)
			$this->articles[$key]['intro'] = $this->m_articles->articles_intro($article);
	}
	/**
	*Виртуальный генератор HTML
	*/	
	protected function OnOutput()
	{
		// Генерация шаблона страницы V_View
		$vars = array('articles'=>$this->articles);
		$this->content = $this->Template('V/V_View.php', $vars);
		
		// Вызов родительского метода
		parent::OnOutput();
	}
}