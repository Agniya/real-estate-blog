
$(document).ready(function(){

//работа галереи
	$('#Big').hide();
	$('#Big div').hide();
	$('#Prev').hide();
	$('#Next').hide();

	var elemS = $('#Small img');
	
	elemS.click(function()
	{
		i=$(this).attr('number');
		$('#Small').hide();
		
		$('#Big').show();
		$('#Prev').show();
		$('#Next').show();
		
		$('#Big img').eq(i).show();
		$('#Big div').eq(i).show();
	});
	
	var elem = $('#Big img').hide();
		
	$('#Prev').mousedown(function(){
		elem.eq(i).hide();
		$('#Big div').eq(i).hide();
		i= (--i<0) ? (elem.length-1):i;
		elem.eq(i).show();
		$('#Big div').eq(i).show();
		});
	
	$('#Next').mousedown(function(){
		elem.eq(i).hide();
		$('#Big div').eq(i).hide();
		i=(++i>(elem.length-1))?0:i;
		elem.eq(i).show();
		$('#Big div').eq(i).show();
		});
		
		//комментарии к статье
	
	$('#btnSend').click(function(elem){
		var id_article = $('#id_article').val();		
		var name = $('#name').val();
		var mail = $('#mail').val();
		var text = $('#text').val();
	
		$.post('index.php?C=Select', {id_article: id_article, name: name, mail: mail, text: text}, function(){
			$('#name').val('');
			$('#mail').val('');
			$('#text').val('');
		});
		
		$.get('index.php?C=AjaxComment', {id_article: id_article}, function(comments){
				$('#comments').prepend("<div class='comment'>" + '<p>'+comments.text+'</p>'+
				'Posted by:&nbsp;&nbsp;' + comments.name+'&nbsp;&nbsp;|&nbsp;&nbsp;'+ comments.date+"</div>");
		},'json');
	});
	
	//Вывод рубрик статей
	$('.subjects').hide();
	$('#headings').css({'cursor':' pointer'});
	
	$('#headings').click(function(elem){
		$('.subjects').slideToggle();	
	});
	

});