<?php/**
*Шаблон страницы "Gallary"
*
*$images - массив с данными о фотографиях из таблицы imgbiggall   
*/?>

<!--Контейнер с миниатюрами изображений-->
<div id="Small">
	<table align="center" width="600">
		<tr>
			<?$i=0;?>
			<?foreach($images as $photo):?>
			
			<?if($i%2==0):?>
		</tr><tr>
			<?endif;?>
			<td>
				<img number="<?=$i;?>" src="images/imgSmallGall/<?=$photo['id_image']?>.<?=$photo['ext']?>"/>
			</td>
			<?$i++;?>
			<?endforeach;?>
		</tr>
	</table>
</div>

<!--Контейнер с зображениями в увеличенном формате-->
<div id="Big">
		<!-- Указатели "Вперед"/"Назад"-->
		<input id="Prev" type="image" src="images/Template/OrangeArrowleft.png" width="60" height="60">
		<input id="Next" type="image" src="images/Template/OrangeArrowright.png" width="60" height="60">
		
	<hr/>
		
	<?php $i=0;?>
	<?php foreach($images as $photo):?>
	
		<!--Фотографии-->
		
			<img number="<?=$i;?>" src="<?=$photo['path']?>"/>
		
		<!--Описание фотографий-->
		
			<div  number = "<?=$i;?>"><?=$photo['description']?></div>
	<?php $i++;?>
	<?php endforeach ?>
	
</div>