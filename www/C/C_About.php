<?php
/**
*Контроллер страницы "About me"
*/
class C_About extends C_Base
{
	protected $introduction; //переменная, в которую считывается текстовый файл 'About.txt' (текст страницы "About me")
	protected $about; //массив с фотографиями для страницы "About me". На страницу выводится одна - последняя загруженная
	protected $m_images;//менеджер изображений
	/**
	*Конструктор класса
	*/
	function __construct()
	{
		$this->m_images = M_Images::Instance();
		$this->about = array();
	}
	/**
	*Виртуальный обработчик запроса
	*/
	protected function OnInput()
	{
		parent::OnInput();
		$this->title = $this->title. 'About me';
		
		$this->about=$this->m_images->Get_all('About');
		
		if (!file_exists('documents/About.txt'))
			die("Файл не существует или Вы не обладаете правами на его открытие");
		$this->introduction = file_get_contents('documents/About.txt');
	}
	/**
	*Виртуальный генератор HTML
	*/	
	protected function OnOutput()
	{
		$vars=array('introduction' => $this->introduction,'about'=> $this->about);
		$this->content=$this->Template('V/V_About.php', $vars);
		parent::OnOutput();
	}
	
}

