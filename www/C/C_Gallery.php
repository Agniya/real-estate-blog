<?php
/**
*Контроллер страницы, демонстрирующей выбранную статью и комметарии к ней
*/
class C_Gallery extends C_Base
{
	protected $images;	// массив с данными о фотографиях из таблицы imgbiggall (в таблице 
						//кроме данных о фотографиях в увеличенном размере, содержится их описание)
	protected $m_images;//менеджер фотографий
	/**
	*Конструктор класса
	*/
	public function __construct()
	{
		$this->m_images = M_Images::Instance();
		$this->images = array();
	}
	/**
	*Виртуальный обработчик запроса
	*/	
	protected function OnInput()
	{
		parent::OnInput();
		$this->title = $this->title.'Gallery';
			
		$this->images = $this->m_images->GetGallery();
	}
	/**
	*Виртуальный генератор HTML
	*/
	protected function OnOutput()
	{
		$vars = array('images'=>$this->images);
		$this->content = $this->Template('V/V_Gallery.php', $vars);
		parent::OnOutput();
	}
}