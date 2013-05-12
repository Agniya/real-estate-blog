<?php
/**
*Базовый контроллер сайта
*/
abstract class C_Base extends C_Controller
{
	protected $needLogin;	// необходимость авторизации 
	protected $user;		// авторизованный пользователь
	protected $m_users; 	//менеджер пользователей
	protected $m_articles;  //менеджер статей
	
	protected $title;		//название страницы сайта
	protected $content;		//содержание страницы сайта
	/**
	*Конструктор класса
	*/
	public function __construct()
	{
		$this->needLogin = false;
		$this->user = null;		
	}
	/**
	*Виртуальный обработчик запроса
	*/	
	protected function OnInput()
	{
		$this->m_users = M_Users::Instance();	
		$this->m_articles = M_Articles::Instance();
		
		$this->m_users->ClearSessions();		
		$this->user = $this->m_users->Get();
		
		// Перенаправление на страницу авторизации, если это необходимо.
		if ($this->user == null && $this->needLogin) {       	
			header("Location: index.php?C=Login");
			die();
		}
		//Получение списка рубрик для вертикального меню. Отображается в основном шаблоне
		$this->menu = $this->m_articles->GetArticleSubjects();
		
		//$this->title='Блог риэлтора';
		$this->content = '';
	}
	/**
	*Виртуальный генератор HTML
	*/
	protected function OnOutput()
	{
		// Основной шаблон всех страниц
		$vars = array('menu'=>$this->menu,'title' =>$this->title, 'content'=>$this->content);
		$page = $this->Template('V/V_Main.php', $vars);
		// Вывод HTML
		echo $page;
	}
}
