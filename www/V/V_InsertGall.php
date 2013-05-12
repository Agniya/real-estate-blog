<?php/**
* Добавить изображение в "Gallery"
*
*$imgbiggall -  массив фотографий
*$description - описания
*/?>

<!--Форма для загрузки изображения-->
Выберете новое изображение:<br/><br/>
<?if ($notice !=null):?>
Mistake: <?=$notice?>
<?endif?>
<form method = "post" enctype = "multipart/form-data">
<input type = "file" name = "file_upload"/><br/>
<input type = "submit" name = "upload" value = "Загрузить"/>
</form>
<br/><br/>

<hr width="400px" align="center">
<br/><br/>

<!--Форма для добавления описания-->
<form method="post">
	Выберете изображение, для которого вводится описание:<br/><br/>
	<select name="id_image">
	
	<option  value="empty" selected="selected"> </option>
	<?foreach($imgbiggall as $key):?>
	<option value="<?=$key['id_image']?>"><?=$key['name']?></option>
	<?endforeach?>

	</select><br/><br/>
	
	Введите описание фотографии: <br/><br/>
	<textarea name="description" rows="1" cols="50"><?=$description?></textarea><br/><br/>
	
	<input type="submit" name="insert" value="Добавить"/>
</form>
<br/><br/>

<hr width="400px" align="center">
<br/><br/>

<!--Форма удаления изображения-->
<form method="post">
Выберете изображение, которое хоите удалить:<br/><br/>
	<select name="id_image">
		
		<option  value="empty" selected="selected"> </option>
		<?foreach($imgbiggall as $key):?>
		<option value="<?=$key['id_image']?>"><?=$key['name']?></option>
		<?endforeach?>
		
	</select><br/>
	<input type="submit" name="Delete" value="Удалить">
</form>