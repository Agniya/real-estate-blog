<?php/**
*Шаблон страницы для добавления информации об авторе блога
*
* $introduction - текст, введенный в форму
* $imgbig - массив с изображениеями
*/?>

<!--Проверка наличия ошибок при загрузке -->
<?if ($notice !=null):?>
Mistake: <?=$notice?>
<?endif?>
<!--Форма для загрузки фотографии -->
<form method = "post" enctype = "multipart/form-data">
	Выбрать изображение:<br/><br/>
	<input type = "file" name = "file_upload"/><br/>
	<input type = "submit" name = "upload" value = "Загрузить"/>
</form>
<br/><br/>

<!--Форма для выбора фотографии -->
<form method = "post">
	Выбрать изображение<br/>
	<select name="id_image">
	<option  value="empty" selected="selected"> </option>
	<?foreach($imgbig as $key):?>
	<option value="<?=$key['id_image']?>"><?=$key['name']?></option><br/><br/>
	<?endforeach?>
	</select><br/>
	
<!--Форма для ввода текста -->
Добавить описание:<br/><br/> <textarea cols="70" rows="10" name = "introduction" required="required"><?=$introduction?></textarea><br/><br/> 
<input type = "submit" value = "РЎРѕС…СЂР°РЅРёС‚СЊ" name = "insert"/> <br/><br/> 
</form>
<br/><br/>


	
