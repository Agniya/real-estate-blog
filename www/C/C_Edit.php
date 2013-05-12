<?php
/**
*Контроллер страницы редактирования статьи
*/
class C_Edit extends C_Base
{
	protected $articleName;//название статьи
	protected $articleContent;//текст статьи
	protected $articleSuject;//тематика выбранной статьи
	protected $articleSujectId;//id_subject выбранной статьи
	protected $articleImage;//изображение для статьи
	protected $articleImageId;//id_image выбранной статьи
	protected $subject;//массив с id и названием рубрик статей
	protected $imagesart;//массив id и названием с фотографий
	protected $m_articles;// менеджер статей
	protected $m_images;// менеджер фотографий
	/**
	*Конструктор класса
	*/
	function __construct()
	{
		$this->m_articles = M_Articles::Instance();
		$this->m_images = M_Images::Instance();
		
		$this->subject = array();
		$this->imagesart = array();
	}
	/**
	*Виртуальный обработчик запроса
	*/	
	protected function OnInput()
	{
		parent::OnInput();
		
		$this->title = $this->title.'Редактирование выбранной статьи';
		$id_article = $_GET['id_article'];
		
		if ($this->IsGet()) {
			// запрос списка рубрик статей из базы для подстановки в select
			$this->subject=$this->m_articles->GetArticleSubjectsEdit();
			// запрос списка фотографий из базы для подстановки в select
			$page = (isset($_GET['page']))?(int)$_GET['page']:1;
			$this->imagesart=$this->m_images->Get_all_page('imagesart',$page);
			
			//получение данных о выбранной статье для подстановки в форму редактирования
			$article=array();
			$article=$this->m_articles->Get($id_article);
			$this->articleName=$article['articleName'];
			$this->articleContent=$article['articleContent'];
			
			$this->articleSuject=$article['subject'];
			$this->articleSujectId=$article['id_subject'];
			
			$this->articleImage=$article['name'];
			$this->articleImageId=$article['id_image'];
			
		} elseif($this->IsPost()) {
			$this->articleName=$_POST['articleName'];
			$this->articleContent=$_POST['articleContent'];
			$id_subject=$_POST['id_subject'];
			$id_image=$_POST['id_image'];
			
			if (isset($_POST['Update'])) {
				if ($this->m_articles->UpdateArticle($this->articleName,$this->articleContent,$id_article, $id_subject,$id_image)) {
					header("Location:index.php?C=Editor");
					die();				
				}
			} elseif (isset($_POST['Delete'])) {
				if ($this->m_articles->DeleteArticle($id_article)) {
					header("Location:index.php?C=Editor");
					die();
				}
			}
		}
	}
	/**
	*Виртуальный генератор HTML
	*/	
	protected function OnOutput()
	{
		$vars = array('imagesart'=>$this->imagesart, 'subject'=>$this->subject,'articleName'=>$this->articleName, 
		'articleSujectId'=>$this->articleSujectId, 'articleImageId'=>$this->articleImageId,
		'articleSuject'=>$this->articleSuject, 'articleImage'=>$this->articleImage,'articleContent'=>$this->articleContent);
		$this->content = $this->Template('V/V_Edit.php', $vars);
		parent::OnOutput();
	}
}