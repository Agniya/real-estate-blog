<?php/**
*Основной шаблон страницы, демонстрирующей выбранную статью  и комметарии к ней
*
*$title - заголовок (название просматриваемой страницы)
*
*$content - содержание страницы
*/?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="V/CSS/Styles.css" type="text/css"/>
		<script type="text/javascript" src="V/JS/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="V/JS/onload.js"></script>
		<title>Yana's blog Moscow Real Estate</title>
	</head>
	
	<body>
		<div id="content">
		<!--Header - div с изображением в верхней части сайта-->
			<div>
				
				<image src="images/Template/headerMM.gif"/>
				<span id="siteName"> Yana's blog (Evans Property Services)<br/></span> 
				<span id="siteName2">
				Moscow Real Estate  
				</span>
			</div>
			
		<!--Content - основная часть сайта-->	
				
			<table id="mainTable">	
				<tr>	
					<!--Вертикальное меню-->
					<td id="menu">
							
						<!--Список рубрик-->
						<div id="headings"><u><a href="#headings">Headings</a></u></div>
							
							<div class="subjects">
							<ul>
								<?foreach($menu as $item):?>
												
								<li><a href="index.php?C=Subject&id_subject=<?=$item['id_subject']?>"><?=$item['subject']?></a></li><br/>
								
								<?endforeach?>
							</ul>	
							</div>
							
						<!--Последние статьи-->
						<div><a href="index.php?C=View">Recent articles</a></div>	
						<!--Галерея изображений-->	
						<div><a href="index.php?C=Gallery">Gallery</a></div>	
						<!--Об авторе-->
						<div><a href="index.php?C=About">About me</a></div>
						<!--Контакты-->
						<div><a href="index.php?C=Contacts">Contacts</a></div>
					</td>
					
					<!--Столбец в середине для вставки фото с кольцами от блокнота
					<td id="center" width="50px"></td>-->
					
					<!--Основная часть блога-->
					<td  id="cont" width="600px">
						<!--Название страницы -->
						<h1><?=$title?></h1>					
						<!--Содержание страницы -->
						<?=$content?>
					</td>
				</tr>
			</table>
			
		</div>
		
	</body>
	
	<footer>
		<image src="images/Template/footer-bg.jpg"/>
	</footer>
	
</html>
	
	
 