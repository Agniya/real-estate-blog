<?php/**
*Шаблон Главной страницы V_View
*
*$articles - массив, содержащий данные о названии, содержании, дате публикации статьи, путь до графического изображения
*/?>

<?foreach($articles as $article=>$key):?>
	<article class="articles">
		<!--Название статьи-->
		<h2><?=$key['articleName']?></h2>
		<!--Изображение-->
		<div class="imgIntro"><img src="<?=$key['path']?>"/></div>
		<!--Содержание статьи-->
		<div id="text">
			<?=nl2br($key['intro'])?>
			<a href="index.php?C=Select&id_article=<?=$key['id_article']?>"> read further...</a><br/><br/>
			<em>Published:&nbsp;&nbsp;<?=$key['date']?></em>
		</div>
	</article>
<?endforeach?>
