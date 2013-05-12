<?php
/**
*Менеджер статей
*/
class M_Articles
{
	private static $instance;	// ссылка на экземпляр класса
	protected $m_msql;			// драйвер БД
	/*
	* Получение единственного экземпляра (одиночка)
	*/
	public static function Instance()
	{
		if(self::$instance==null)
			self::$instance = new M_Articles;
		return self::$instance;
	}
	/*
	* Конструктор класса
	*/
	public function __construct()
	{
		$this->m_msql = M_MSQL::Instance();
	}
	/*
	* Получение одной статьи
	*/
	public function Get($id_article)
	{
		$t="SELECT*FROM articles JOIN imgbig USING(id_image) JOIN subject USING (id_subject) WHERE articles.id_article='%d'";
		$query=sprintf($t,$id_article);
		$result=$this->m_msql->Select($query);
		
		return $result[0];
	}	
	/**
	*Вывод рубрик в вертикальное меню. Показ только тех рубрик, для которых имеются статьи
	*/
	public function GetArticleSubjects()
	{
		$query="SELECT DISTINCT subject.id_subject, subject.subject FROM subject JOIN articles USING (id_subject) ORDER BY subject.id_subject ASC";
		return $this->m_msql->Select($query);
	}
	/**
	*Вывод рубрик в V_Edit, V_Insert. Показ в select всех рубрик
	*/
	public function GetArticleSubjectsEdit()
	{
		$query="SELECT*FROM subject";
		return $this->m_msql->Select($query);
	}
	/*
	* Получение всех статей, относящихся к одной рубрике
	*/	
	public function artSubject($page,$id_subject)
	{
		$gap=($page-1)*5;
		$t="id_subject='%d'";
		$where=sprintf($t,$id_subject);
		$query="SELECT*FROM articles JOIN imagesart USING (id_image) JOIN subject USING (id_subject) WHERE $where ORDER BY id_article DESC LIMIT $gap,5";
		$result=$this->m_msql->Select($query);
		return $result;
	}
	/*
	* Получение всех статей
	*/
	public function GetAllArticles($page)
	{
		$gap=($page-1)*5;
		$query="SELECT*FROM articles JOIN imagesart USING (id_image) ORDER BY id_article DESC LIMIT $gap,5";
		return $this->m_msql->Select($query);
	}
	/*
	* Получение комментариев к статье
	*/
	public function GetComments($id_article,$page)
	{
		$gap=($page-1)*5;
		$t="id_article='%d'";
		$where=sprintf($t,$id_article);
		$query="SELECT*FROM comments WHERE $where ORDER BY id_comment DESC LIMIT $gap,5";
		$result=$this->m_msql->Select($query);
		return $result;
	}
	/*
	* Получение последнего комментария к статей
	*/
	public function GetOneComment($id_article)
	{
		$t="id_article='%d'";
		$where=sprintf($t,$id_article);
		$query="SELECT*FROM comments WHERE $where ORDER BY id_comment DESC";
		$result=$this->m_msql->Select($query);
		return $result[0];
	}
	/*
	* Добавление рубрики
	*/	
	public function InsertSub($subject)
	{
		$subject=trim($subject);
		
		$object=array();
		$object['subject']=$subject;
		$this->m_msql->Insert('subject', $object);
		return true;
	}
	/*
	* Добавление статьи
	*/	
	public function InsertArticle($articleName,$articleContent,$id_subject,$id_image,$date)
	{
		$articleName=trim($articleName);
		$articleContent=trim($articleContent);
		
		if($id_subject=='')
			$id_subject=null;
		if($id_image=='')
			$id_image=null;
		
		$object=array();
		$object['articleName']=$articleName;
		$object['articleContent']=$articleContent;
		$object['id_subject']=$id_subject;
		$object['id_image']=$id_image;
		$object['date']=$date;
		$this->m_msql->Insert('articles', $object);
		return true;
	}
	/*
	* Добавление комментария
	*/	
	public function InsertComment($name, $mail, $text,$date,$id_article)
	{
		$name=trim($name);
		$mail=trim($mail);
		$text=trim($text);
		
		$object=array();
		$object['name']=$name;
		$object['mail']=$mail;
		$object['text']=$text;
		$object['date']=$date;
		$object['id_article']=$id_article;
		$this->m_msql->Insert('comments', $object);
		return true;
	}
	/*
	* Внесение изменений в статю
	*/	
	public function UpdateArticle($articleName,$articleContent,$id_article, $id_subject,$id_image)
	{
		$articleName=trim($articleName);
		$articleContent=trim($articleContent);
		
		if($articleName=='')
			return false;
		if($articleContent=='')	
			return false;
			
		if($id_subject=='')
			$id_subject==null;
		if($id_image=='')
			$id_image==null;
			
		$object=array();
		$object['articleName']=$articleName;
		$object['articleContent']=$articleContent;
		$object['id_subject']=$id_subject;
		$object['id_image']=$id_image;
		$t="id_article='%d'";
		$where=sprintf($t,$id_article);
		$this->m_msql->Update('articles',$object,$where);	
		return true;
	}
	/*
	* Удаление статьи
	*/	
	public function DeleteArticle($id_article)
	{
		$t="id_article='%d'";
		$where=sprintf($t,$id_article);
		$this->m_msql->Delete('articles',$where);
		return true;
	}
	/*
	* Уменьшение содержания статьи
	*/	
	public function articles_intro($article)
	{
		if(strlen ($article['articleContent'])>400)
		{
			$i=strpos($article['articleContent'],'.',400);
			return substr($article['articleContent'], 0, $i+1);
		}
		else return $article['articleContent'];
	}
}