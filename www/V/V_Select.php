<?php/**
*Шаблон страницы, демонстрирующей выбранную статью  и комметарии к ней
*
*$article - массив, содержащий данные о названии, содержании, дате публикации статьи,  
*а также путь($article['path']) до графического изображения, находящегося в папке imgBig
*
*$comments - массив с данными об оставленных к статье комментариях
*/?>

<!--Название выбранной статьи-->	
<h1><?=$article['articleName']?></h1>

<!--Блок с изображением из папки imgBig-->	
<div class="picture">
	<img src="<?=$article['path']?>" border='1' align='left' />
</div>

<!--Блок с содержанием выбранной статьи-->	
<div id="selectedArt">
	<p><?=nl2br($article['articleContent'])?></p>
</div>

<!--Блок с формой для отправки комментариев-->	
<div id="leaveComm">
	Add comment <br/>
	<input type="hidden" name="id_article" id="id_article" value="<?=$article['id_article']?>">
	<table id="data">
		<tr>	
			<td>Your Name:</td>
			<td><input type="text" name="name" id="name"/></td>
		</tr>
		<tr>
			<td>Your e-mail (will not display):</td>
			<td><input type="text" name="mail" id="mail"/></td>
		</tr>	
	</table>
	Your comment:<br/>
	<textarea name="text" id="text"> </textarea>
	<input type="submit" id="btnSend" value="Leave a comment"/>	
</div>

	<hr width="400px"/>
	
<!--Блоки с оставленными комментариями-->	
<div id="comments">
		
	<?foreach($comments as $comment):?>
		
		<div class="comment">
			<p><?=$comment['text']?></p>
			Posted by:&nbsp;&nbsp;<?=$comment['name']?>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$comment['date']?>
		</div>	
			
	<?endforeach?>
</div>		