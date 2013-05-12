<?php
/**
*Контроллер страницы для добавления новой статьи
*/
class C_Insert extends C_Base
{
	protected $articleName;    //название статьи
	protected $articleContent; //содержание статьи
	protected $subject;		   //массив - рубрики статей
	protected $imagesArt;	   //массив - изображения для статей
	protected $m_articles;	   //менеджер статей
	protected $m_images;	   //менеджер избражений
	/**
	*Конструктор класса
	*/
	public function __construct()
	{
		$this->m_articles = M_Articles::Instance(); 
		$this->m_images = M_Images::Instance();
		
		$this->subject = array();
		$this->imagesArt = array();
	}
	/**
	*Виртуальный обработчик запроса
	*/	
	protected function OnInput()
	{
		parent::OnInput();
		$this->title=$this->title.'Добавить статью';
					
		if ($this->IsGet()) {			
			// запрос списка рубрик из базы для подстановки в select
			$this->subject = $this->m_articles->GetArticleSubjectsEdit();
			// запрос списка фотографий из базы для подстановки в select
			$this->imagesArt = $this->m_images->Get_all('imagesart');
			$this->articleName = '';
			$this->articleContent = '';
			
		//если была нажата кнопка upload, загрузка фото. После удачной загрузки - редирект на форму для заполнения информации о статье
		} elseif($_POST['upload']) {	
			
			//директория для загрузки оригинального изображения imgOriginal
			$uploads_dir = 'images/imgOriginal';
			$tmp_name = $_FILES["file_upload"]["tmp_name"];
			//оригинальное имя фотографии для отображения в списке
			$name = $_FILES["file_upload"]["name"];
			//уникальный код для включения в путь к файлу. Одинаковое для изображений в папках imgArt и imgBig
			$id_image = $this->m_images->GenerateStr(10);
			//определение типа файла
			$ext = $this->m_images->Get_image_type($_FILES["file_upload"]["type"]);
			//определение имя файла, под которым он будет храниться в папках imgOriginal, imgArt, imgBig
			$file_name = "$id_image.$ext";
			
			//загрузка оригинального изображения в imgOriginal
			if (!move_uploaded_file($tmp_name, "$uploads_dir/$file_name")) {	
					$this->notice="Upload failed";
			
			// если загрузка в imgOriginal удалась		
			} else {  
				//копируем изображение в папку миниатюр imgArt
				if (!copy("$uploads_dir/$file_name", "images/imgArt/$file_name")) {
					$this->notice="Copy failed";
					
				// если удалось копирование в папку миниатюр, уменьшаем скопированное изображение (200 px по большему краю изображения)	
				} else {
					$small="images/imgArt/$file_name";
					$small=$this->m_images->Get_small($small);
					$this->m_images->Insert('imagesart',$id_image,$name,$small,$ext);						
				}	
				// если копирование в imgArt удалось
				if (!copy("$uploads_dir/$file_name", "images/imgBig/$file_name")) {
					$this->notice="Copy failed";
					
				// если удалось копирование в папку imgBig, уменьшаем скопированное изображение (400 px по большему краю изображения)	
				} else {
					$big="images/imgBig/$file_name";
					$big=$this->m_images->Get_big($big);
					$this->m_images->Insert('imgbig',$id_image,$name,$big,$ext);
				}
					header('Location:index.php?C=Insert'); 
					exit();
			}	
		
		//если была нажата кнопка insertSub - добавление рубрики
		} elseif ($_POST['insertSub']) {
			//вызов метода модели M_Articles и редирект на Insert
			if($this->m_articles->InsertSub($_POST['subject']))
				header('Location: index.php?C=Insert');
				exit();
				
		//если была нажата кнопка insert - добавление статьи		
		} elseif($_POST['insert']) {
			
			//вызов метода модели M_Articles и редирект на главную
			$this->articleName = $_POST['articleName'];
			$this->articleContent = $_POST['articleContent'];
			$id_subject = $_POST['id_subject'];
			$id_image = $_POST['id_image'];
			$date = date("F j, Y, g:i a");
			
			if ($this->m_articles->InsertArticle($this->articleName,$this->articleContent,$id_subject,$id_image,$date)) {
					header('Location: index.php?C=View');
					exit();
			}
		}
		
	}
	/**
	*Виртуальный генератор HTML
	*/	
	protected function OnOutput()
	{	
		$vars = array('articleName' => $this->articleName, 'articleContent' =>$this->articleContent, 'subject' => $this->subject,'imagesArt' =>$this->imagesArt);
		$this->content = $this->Template('V/V_Insert.php', $vars);
		parent::OnOutput();
	}
}
