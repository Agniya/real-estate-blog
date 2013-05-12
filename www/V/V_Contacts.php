<?php/**
*Шаблон страницы "Contacts"
*/?>
<!--Контактные данные -->
<p>
	Contacts:<br/> 
	<ul>
		<li>phone number: +7 985 774 53 98</li><br/> 
		<li>e-mail: 7745398@mail.ru</li> <br/>
	</ul>
</p>	
<!--Форма для отправки письма -->
<span id="connect">You can leave a message by filling the following form <br/><br/></span> 
	<form id="form" method="post">
		Your name:<br />
		<textarea cols="20" rows="1" name="fio"></textarea><br />
		Your phone number:<br />
		<textarea cols="20" rows="1" name="phone"></textarea><br/>
		E-mail:<br />
		<textarea cols="20" rows="1" name="mail"></textarea><br/>
		Your message:<br />
		<textarea cols="20" rows="1" name="message"></textarea><br/><br/>
		<input id="sent" type="submit" name="order" value=" Leave a message "/>
	</form>			 
		
