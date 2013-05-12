<?php
/**
*Контроллер страницы "Contacts"
*/
class C_Contacts extends C_Base
{
	/**
	*Конструктор класса
	*/
	function __construct()
	{
	}
	/**
	*Виртуальный обработчик запроса
	*/
	protected function OnInput()
	{
		parent::OnInput();
		if (isset($_POST['submit'])) { // проверяем была ли нажата кнопка "send"
		 // получаем данные из формы и заносим их в массивы
			 $fio=$_POST['fio'];
			 $phone=$_POST['phone'];
			 $mail=$_POST['mail'];
			 $message=$_POST['message'];
			 // формируем заголовок и тело письма
			 $headers  = "Content-type: text/html; charset=windows-1251 \r\n"; 
			 //указать адрес сайта
			 $headers .= "From: moscowrealestateblog.com <noreply@moscowrealestateblog.com>\r\n"; 
			 $picture="";
			 $msg="Имя: $fio<br />
					Телефон: $phone<br />
					E-mail: $mail<br />
					Сообщение: $course<br />";
			$mail_to="7745398@mail.ru"; // почта куда отправлять письмо
		 // Отправляем почтовое сообщение
			if(mail($mail_to, $msg, $headers))
			header('Location:index.php?C=Contacts');
		}
	}
	/**
	*Виртуальный генератор HTML
	*/
	protected function OnOutput()
	{
		$vars = array();
		$this->content=$this->Template('V/V_Contacts.php', $vars);
		parent::OnOutput();
	}
	
}