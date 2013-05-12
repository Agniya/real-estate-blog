<?php
header("Content-Type:text/html;charset=utf-8");
require_once('M/M_Autoload.php');
require_once('M/M_Startup.php');

switch($_GET['C'])
{
	case 'Login':
		$controller= new C_Login();
		break;
	case 'InsertGall':
		$controller= new C_InsertGall();
		break;
	case 'InsertAbout':
		$controller= new C_InsertAbout();
		break;
	case 'Insert':
		$controller= new C_Insert();
		break;
	case 'Edit':
		$controller= new C_Edit();
		break;
	case 'Editor':
		$controller= new C_Editor();
		break;	
	case 'About':
		$controller= new C_About();
		break;
	case 'Gallery':
		$controller= new C_Gallery();
		break;	
	case 'AjaxComment':
		$controller= new C_AjaxComment();
		break;
	case 'Select':
		$controller= new C_Select();
		break;	
	case 'Subject':
		$controller= new C_Subject();
		break;		
	case 'Contacts':
		$controller= new C_Contacts();
		break;
	default:
		$controller= new C_View();
}
$controller->Request();
