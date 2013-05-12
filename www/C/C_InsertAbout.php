<?php
/**
*Контроллер страницы для добавления информации об авторе блога
*/
class C_InsertAbout extends C_Base
{
	protected $introduction; //текст, введенный в форму
	protected $imgbig; 		//массив с изображениеями
	protected $m_images;	//менеджер фотографий
	/**
	*Конструктор класса
	*/
	public function __construct()
	{
		$this->m_images = M_Images::Instance();
	}
	/**
	*Виртуальный обработчик запроса
	*/	
	protected function OnInput()
	{
		parent::OnInput();
		$this->title = $this->title. 'Редактировать страницу About';
		
		//проверка метода запроса
		if ($this->IsGet()) {			
			// запрос списка фотографий из базы для подстановки в select
			$this->imgbig = $this->m_images->Get_all('About');
			$this->introduction = '';
		
		// если нажата кнопка upload, загрузка фото. После удачной загрузки - редирект на форму для заполнения информации о статье	
		} elseif($_POST['upload']) {	
			
			//папка, в которую загружается оригинальное изображение
			$uploads_dir = 'images/imgOriginal';
			$tmp_name = $_FILES["file_upload"]["tmp_name"];
			//оригинальное название фотографии, отображается в select
			$name = $_FILES["file_upload"]["name"];
			//уникальный код
			$id_image = $this->m_images->GenerateStr(10);
			//определение типа файла
			$ext = $this->m_images->Get_image_type($_FILES["file_upload"]["type"]);
			//имя файла, одинаковое для изображения в папке imgOriginal и в папке About
			$file_name = "$id_image.$ext";
			
			//сохранение оригинального изображения в папку imgOriginal
			if (!move_uploaded_file($tmp_name, "$uploads_dir/$file_name")) {	
				$this->notice = "Upload failed";
			
			// если загрузка удалась, сохраняем изображение в папку About
			} else {
				
				if (!copy("$uploads_dir/$file_name", "images/About/$file_name")) {
					$this->notice = "Copy failed";
					
				// если удалось копирование в папку About, уменьшаем изображение до 400px по большей стороне	
				} else {
					$big="images/About/$file_name";
					$big=$this->m_images->Get_big($big);
					$this->m_images->Insert('about',$id_image,$name,$big,$ext);
				}
					
					header('Location:index.php?C=InsertAbout'); 
					exit();
			}	
			//если нажата кнопка insert	
		} elseif(isset($_POST['insert'])) {
			$introductionH=fopen("documents/About.txt",'w') or die ("Создать файл не удалось");
			$text=$_POST['introduction'];
			fwrite($introductionH,$text) or die ("Сбой записи файла");
			fclose($introductionH);
				
			header("Location:index.php?C=About");
			exit();
		} else {
				$this->introduction = '';
		}
			
	}
	/**
	*Виртуальный генератор HTML
	*/		
	protected function OnOutput()
	{
		$vars = array('introduction' => $this->introduction,'imgbig'=> $this->imgbig);
		$this->content = $this->Template('V/V_InsertAbout.php', $vars);
		parent::OnOutput();
	}

}