<?php/**
*Шаблон страницы, демонстрирующей статьи, относящиеся к одному разделу
*
$articles - статьи, относящиеся к одному разделу
*/?>

<!--Название выбранной рубрики -->
<h1><?=$articles[0]['subject']?></h1> 

<!--Перечень статей выбранной рубрики -->
<?foreach($articles as $article=>$key):?>
	<article class="articles">
		<h1><?=$key['articleName']?></h1>
		<img src="<?=$key['path']?>"/>
		<div id="text">
			<?=nl2br($key['intro'])?>
			<a href="index.php?C=Select&id_article=<?=$key['id_article']?>"> read further...</a>
		</div>
	</article>
<?endforeach?>