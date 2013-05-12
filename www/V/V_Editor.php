
<br/>
<a href="index.php?C=Insert"> Добавить статью </a><br/><br/>
<a href="index.php?C=InsertGall"> Добавить или удалить изображение из Галереи, добавить описание фотографии </a><br/><br/>
<a href="index.php?C=InsertAbout"> Редактировать статью "О себе" </a><br/><br/>
<a href="index.php?C=Login"> Выход </a>
<br/><br/>
<h3>Для редактирования статей нажмите на название статьи</h3>
<?foreach($articles as $article=>$key):?>
	<div>
	<img src="<?=$key['path']?>"/>
	<h3><a href="index.php?C=Edit&id_article=<?=$key['id_article']?>"><?=$key['articleName']?></a></h3>
	<?=nl2br($key['articleContent'])?><br/><br/>
	</div>
<?endforeach?>
