<?php
/**
*Контроллер страницы добавления изображений и описаний на страницу "Gallery"
*/
class C_InsertGall extends C_Base
{
	protected $imgbiggall;//массив фотографий из таблицы imgbiggall
	protected $description;//описание фотографии	
	protected $m_images;//менеджер фотографий
	/**
	*Конструктор класса
	*/
	public function __construct()
	{
		$this->m_images = M_Images::Instance();
		$this->imgbiggall = array();
	}
	/**
	*Виртуальный обработчик запроса
	*/
	protected function OnInput()
	{
		parent::OnInput();
		$this->title=$this->title.'Редактировать Галерею изображений';
					
		if($this->IsGet())
		{			
			// запрос списка фотографий из базы для подстановки в select
			$this->imgbiggall=$this->m_images->Get_all('imgbiggall');
			$this->description='';
		} elseif ($_POST['upload']) {	 // загрузка фото. После удачной загрузки - редирект на форму InsertGall для заполнения информации о статье 
			
			//оригинальное изображение (с сохранением исходной высоты и ширины) сохраняется в папке imgOriginal 
			$uploads_dir = 'images/imgOriginal';
			$tmp_name = $_FILES["file_upload"]["tmp_name"];
			//оригинальное имя файла - используется в select
			$name = $_FILES["file_upload"]["name"];
			//уникальный код
			$id_image=$this->m_images->GenerateStr(10);
			//определение типа файла
			$ext=$this->m_images->Get_image_type($_FILES["file_upload"]["type"]);
			//название файла, которое будет отражаться в пути до файла
			$file_name="$id_image.$ext";
			
			//если загрузка в папку imgOriginal не удалась
			if (!move_uploaded_file($tmp_name, "$uploads_dir/$file_name")) {	
				$this->notice="Upload failed";
			} else {
				// если загрузка в папку imgOriginal удалась, копируем изображение в паку миниатюр imgSmallGall
				if (!copy("$uploads_dir/$file_name", "images/imgSmallGall/$file_name")) {
					$this->notice="Copy failed";
				} else {
				// если удалось копирование в папку миниатюр, уменьшаем изображение 200px по большей стороне
					$small="images/imgSmallGall/$file_name";
					$small=$this->m_images->Get_small($small);
					$this->m_images->Insert('imgsmallgall',$id_image,$name,$small,$ext);						
				}	
				
				//копируем изображение из в папки imgOriginal в папку imgBigGall 
				if (!copy("$uploads_dir/$file_name", "images/imgBigGall/$file_name")) {
					$this->notice="Copy failed";
				} else {
				// если удалось копирование в папку imgBigGall, уменьшаем изображение до 400px по большей стороне
					$big="images/imgBigGall/$file_name";
					$big=$this->m_images->Get_big($big);
					$this->m_images->Insert('imgbiggall',$id_image,$name,$big,$ext);
				}
				
				//если удалось сохранение изображений в папки imgOriginal,imgSmallGall.imgBigGall 	
				header('Location:index.php?C=InsertGall'); 
				exit();
			}	
			
		} elseif (isset($_POST['insert'])) {		//добавление описания к фотографии
			$this->description=$_POST['description'];
			$id_image=$_POST['id_image'];
			
			//вызов метода модели M_Images и редирект на Gallery
			if ($this->m_images->UpdateGall($this->description,$id_image)) {
				header('Location: index.php?C=Gallery');
				exit();
			}
			
		} elseif (isset($_POST['Delete'])) {		//удаление фотографии
			$id_image=$_POST['id_image'];
			//вызов метода модели M_Images и редирект на Gallery
			if($this->m_images->DeleteImages('imgbiggall',$id_image)&& $this->m_images->DeleteImages('imgbiggall',$id_image))
			{
				header("Location:index.php?C=Gallery");
				die();
			}
		}
	}
	/**
	*Виртуальный генератор HTML
	*/
	protected function OnOutput()
	{	
		$vars = array('description' => $this->description,'imgbiggall'=> $this->imgbiggall);
		$this->content = $this->Template('V/V_InsertGall.php', $vars);
		parent::OnOutput();
	}
}

