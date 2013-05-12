<?php
/**
*Контроллер страницы Login
*/
class C_Login extends C_Base
{
	private $login;	// логин пользователя
	
	/**
	*Конструктор класса
	*/
	public function __construct() 
	{
		$this->needLogin = false;
		$this->user = null;			
		$this->login = '';
	}
	/**
	*Виртуальный обработчик запроса
	*/
	protected function OnInput() 
    {
		// Выход из системы пользователя.
        $m_users = M_Users::Instance();        
        $m_users->Logout();
        
		// C_Base.
        parent::OnInput();
        
		// Обработка отправки формы.
        if ($this->IsPost())
        {
	        if ($m_users->Login($_POST['login'], 
		                       $_POST['password'], 
						       isset($_POST['remember'])) && $m_users->Can('EDITOR'))
			{
				header('Location: index.php?C=Editor');
				die();
			}
			
			$this->login = $_POST['login'];
        }
    }
	/**
	*Виртуальный генератор HTML
	*/	
    protected function OnOutput() 
    {    
		// Генерация содержимого формы входа
        $vars = array('login' => $this->login);        
    	$this->content=$this->Template('V/V_Login.php', $vars);;
		
		// Вызов родительского метода
        parent::OnOutput();
    }
}