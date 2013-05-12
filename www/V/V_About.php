<?php/**
*Шаблон страницы "About me" - об авторе блога
*
*$about - массив с фотографиями для страницы "About me". Выводится последняя загруженная фотография
*$introduction - текст страницы "About me"
*
*/?>

<!--Блок с изображением из папки About-->	
<div class="picture">
	<img src="<?=$about[0]['path']?>"/>
</div>

<!--Блок с текстом About.txt-->	
<div id="introduction">
	<?=nl2br($introduction)?>
</div>

	


