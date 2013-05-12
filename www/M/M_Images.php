<?php
/**
*Менеджер изображений
*/
class M_Images
{
	private static $instance; // ссылка на экземпляр класса
	private $m_msql;		  // драйвер БД
	
	/*
	* Получение единственного экземпляра (одиночка)
	*/
	public static function Instance()
	{
		if(self::$instance == null)
			self::$instance = new M_Images();
		
		return self::$instance;
	}
	/*
	* Конструктор класса
	*/
	private function __construct()
	{ 
		$this->m_msql = M_MSQL::Instance();
	}
	/*
	* Генерация уникального кода для изображения
	*/
	public function GenerateStr($length = 5) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;  

		while (strlen($code) < $length) 
		$code .= $chars[mt_rand(0, $clen)];  

		return $code;
	}
	/*	
	* Определение типа файла
	*/
	public function Get_image_type($photo) 
	{
		switch($photo)
		{
			case 'image/jpeg':
			$ext='jpeg';
			break;
			case 'image/png':
			$ext='png';
			break;
			case 'image/gif':
			$ext='gif';
			break;
			default:
			$ext = false;
		}
		return $ext;
	}
	/*	
	* Уменьшение изображения до 200px по большему краю
	*/
	public function Get_small($small)
	{
		$typeok=true;
		
		switch($_FILES["file_upload"]["type"])
		{
			case "image/gif": $src=imagecreatefromgif($small); break;
			case "image/jpeg": $src=imagecreatefromjpeg($small); break;
			case "image/pjpeg": $src=imagecreatefromjpeg($small); break;
			case "image/png": $src=imagecreatefrompng($small); break;
			default: $typeok=false; break;
		}
			if($typeok)// уменьшение изображений
		{
			list($w,$h)=getimagesize($small);
			$max=250;
			$tw=$w;
			$th=$h;
						
				if($w>$h && $max < $h)
				{
					$th=$max/$w*$h;
					$tw=$max;
				}
				elseif($h>$w && $max<$h)
				{
					$tw=$max/ $h*$w;
					$th=$max;
				}
				elseif ($max< $w)
				{
					$tw=$th=$max;
				}
						
			$tmp=imagecreatetruecolor($tw,$th);
			imagecopyresampled($tmp,$src,0,0,0,0,$tw,$th,$w,$h);
			imageconvolution($tmp, array( //Улучшние резкозти изображения
									array(-1,-1,-1),
									array(-1,16,-1),
									array(-1,-1,-1),
									),8,0);
			imagejpeg($tmp,$small);
			imagedestroy($tmp);
			imagedestroy($src);
		}
		return $small;
	}
	/*	
	* Уменьшение изображения до 400px по большему краю
	*/
	public function Get_big($big)
	{
		$typeok=true;
		
		switch($_FILES["file_upload"]["type"])
		{
			case "image/gif": $src=imagecreatefromgif($big); break;
			case "image/jpeg": $src=imagecreatefromjpeg($big); break;
			case "image/pjpeg": $src=imagecreatefromjpeg($big); break;
			case "image/png": $src=imagecreatefrompng($big); break;
			default: $typeok=false; break;
		}
			if($typeok)// уменьшение изображений
		{
			list($w,$h)=getimagesize($big);
			$max=500;
			$tw=$w;
			$th=$h;
						
				if($w>$h && $max < $h)
				{
					$th=$max/$w*$h;
					$tw=$max;
				}
				elseif($h>$w && $max<$h)
				{
					$tw=$max/ $h*$w;
					$th=$max;
				}
				elseif ($max< $w)
				{
					$tw=$th=$max;
				}
						
			$tmp=imagecreatetruecolor($tw,$th);
			imagecopyresampled($tmp,$src,0,0,0,0,$tw,$th,$w,$h);
			imageconvolution($tmp, array( //Улучшние резкозти изображения
									array(-1,-1,-1),
									array(-1,16,-1),
									array(-1,-1,-1),
									),8,0);
			imagejpeg($tmp,$big);
			imagedestroy($tmp);
			imagedestroy($src);
		}
		return $big;
	}
	/*	
	* Добавление изображения 
	*/
	public function Insert($table,$id_image,$name,$path,$ext)
	{
		//подготовка
		$name=trim($name);
		$path=trim($path);
	
		//запрос
		$obj=array();
		$obj['id_image']=$id_image;
		$obj['name']=$name;
		$obj['path']=$path;
		$obj['ext']=$ext;
	
		$this->m_msql->Insert($table,$obj);
		return true;
	} 
	/*	
	* Добавление описания к фотографиям галереи
	*/
	public function UpdateGall($description,$id_image)
	{
		$description=trim($description);
					
		$object=array();
		$object['description']=$description;
		$object['id_image']=$id_image;
		$t="id_image='%s'";
		$where=sprintf($t,$id_image);
		$this->m_msql->Update('imgbiggall',$object,$where);	
		return true;
	}
	/*	
	* Получение массива фотографий из выбранной таблицы
	*/
	public function Get_all($table)
	{
		$query = "SELECT*FROM $table ORDER by id_imageAI DESC";		
		return $this->m_msql-> Select($query);
	}	
	/*	
	* Получение массива фотографий с ограничением количества выводимых на страницу изображений
	*/
	public function Get_all_page($table,$page)
	{
		$gap=($page-1)*5;
		$query="SELECT*FROM $table ORDER BY id_image DESC LIMIT $gap,5";		
		return $this->m_msql-> Select($query);
	}
	/*	
	* Получение массива фотографий в формате 400px по большему краю для галереи
	*/
	public function GetGallery()
	{
		$query="SELECT*FROM imgbiggall ORDER BY id_imageAI DESC";		
		return $this->m_msql-> Select($query);
	}
	/*	
	* Получение одного изображения в формате 400px по большему краю
	*/
	public function Get($id_image)
	{
		$query="SELECT*FROM imgbig WHERE id_image='$id_image'";
		$result=$this->m_msql->Select($query);
		return $result[0];	
	}
	/*	
	* Удаление изображения
	*/
	public function DeleteImages($table,$id_image)
	{
		$t="id_image='%s'";
		$where=sprintf($t,$id_image);
		$this->m_msql->Delete($table,$where);
		return true;
	}
}