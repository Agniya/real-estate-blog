<?php/**
*Шаблон страницы редактирования статьи
*
*$articleName - новое название статьи
*$articleContent - новый текст статьи
*$articleSuject - выбранная тематика статьи
*$articleImage - изображение для статьи
*$subject - массив с id и названием рубрик статей
*$imagesart - массив id и названием с фотографий
*
*/?>

<!--Форма для выбора рубрики статьи-->
<form method="post">
Выберите рубрику статьи:<br/>
<select name="id_subject">
	<option value="<?=$articleSujectId?>" selected="selected"><?=$articleSuject?></option>
	<?foreach($subject as $key):?>
	<option value="<?=$key['id_subject']?>"><?=$key['subject']?></option>
	<?endforeach;?>
</select><br/>

<!--Форма для выбора изображения для статьи-->
Выберите изображение для статьи:<br/>
<select name="id_image">
	<option value="<?=$articleImageId?>" selected="selected"><?=$articleImage?></option>
	<?foreach($imagesart as $key):?>
	<option value="<?=$key['id_image']?>"><?=$key['name']?></option>
	<?endforeach;?>
</select><br/>

<!--Форма редактирования названия и содержания статьи-->
Введите новое название статьи:<br/>
	<textarea name="articleName" cols="50" rows="1"><?=$articleName?></textarea><br/>
Введите новое содержание статьи:<br/>
	<textarea name="articleContent" cols="50" rows="3"><?=$articleContent?></textarea><br/>
<input type="submit" name="Update" value="Изменить">&nbsp;&nbsp;
<input type="submit" name="Delete" value="Удалить">
</form>