<?php/**
*Шаблон страницы для добавления новой статьи
*
* $articleName    - название статьи
* $articleContent - содержание статьи
* $subject		  - массив - рубрики статей
* $imagesArt	  - массив - изображения для статей
*/?>

<!--Сообщение, если произошла ошибка при загрузке изображения-->
	<?if ($notice !=null):?>
	Mistake: <?=$notice?>
	<?endif?>
	
<!--Форма для загрузки изображения-->	
<form method = "post" enctype = "multipart/form-data">
Загрузить фотографию:<br/>
	<input type = "file" name = "file_upload"/><br/>
	<input type = "submit" name = "upload" value = "Загрузить"/>
</form>
<br/><br/>

<!--Форма для добавления рубрик статей-->
<form method="post">
Добавить новую рубрику <br/>
	<textarea name="subject" rows="1" cols="30"></textarea><br/>
	<input type="submit" name="insertSub" value="Добавить"/>
</form>

<form method="post">
<!--Форма для добавления статьи-->
	
	<!--Форма для выбора рубрики статьи-->
	Выбрать рубрику статьи<br/>
	<select name="id_subject">
	<option  value="empty" selected="selected"> </option>
	<?foreach($subject as $key):?>
	<option value="<?=$key['id_subject']?>"><?=$key['subject']?></option>
	<?endforeach?>
	</select><br/>
	
	<!--Форма для выбора изображения для статьи-->
	Выбрать изображение для статьи<br/>
	<select name="id_image">
	<option  value="empty" selected="selected"> </option>
	<?foreach($imagesArt as $key):?>
	<option value="<?=$key['id_image']?>"><?=$key['name']?></option>
	<?endforeach?>
	</select><br/>
	
	<!--Форма для ввода названия и содержания статьи-->
	Ввести название статьи <br/>
	<textarea name="articleName" rows="1" cols="70" required="required"><?=$articleName?></textarea><br/><br/>
	Ввести содержание статьи <br/>
	<textarea name="articleContent" rows="30" cols="70" required="required"><?=$articleContent?></textarea><br/><br/>
	
	<input type="submit" name="insert" value="Сохранить"/>
</form>