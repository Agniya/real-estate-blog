<?php
/**
*Контроллер страницы, демонстрирующей выбранную статью и комметарии к ней
*/
class C_Select extends C_Base
{
	protected $article;		//массив, содержащий данные о названии, содержании, дате публикации статьи, путь до графического изображения 
	protected $comments;	// массив с данными об оставленных к статье комментариях
	protected $m_articles;	//менеджер статей
	/**
	*Конструктор класса
	*/
	function __construct()
	{
		$this->m_articles = M_Articles::Instance();
		$this->article = array();
	}
	/**
	*Виртуальный обработчик запроса
	*/			
	protected function OnInput()
	{
		parent::OnInput();
		//$this->title = $this->title; Родительское поле класса не выводим. 
		//Название статьи в заголовке <h1> выводится название выбранной статьи
		$id_article = $_GET['id_article'];	
		
		$this->article = $this->m_articles->Get($id_article);
		
		if ($this ->isGET()) {
			$page = (isset($_GET['page']))?(int)$_GET['page']:1;
			$this->comments = $this->m_articles->GetComments($id_article,$page);
		} else {
		    $id_article = $_POST['id_article'];	
			$name = $_POST['name'];
			$mail = $_POST['mail'];
			$text = $_POST['text'];
						
			if (($name != '') && ($text != '')) {
				$date = date("F j, Y, g:i a");
				$this->m_articles->InsertComment($name, $mail, $text,$date,$id_article);
			}
		}
	}
	/**
	*Виртуальный генератор HTML
	*/	
	protected function OnOutput()
	{
		// Генерация содержимого страницы V_Select
		$vars = array('article' => $this->article, 'comments' => $this->comments);
		$this->content = $this->Template('V/V_Select.php', $vars);
		
		// Вызов родительского метода
		parent::OnOutput();
	}
	
}
