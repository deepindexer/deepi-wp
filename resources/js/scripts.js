function notiftMe_refresh(){
	var myHost = location.protocol + "//" + location.host;
	var myURL = myHost + '/wp-content/plugins/NotifyMe/icon.php';
	$.ajax({
		type: 'POST',
		url : myURL,
		data: 'notifyMe=1&chru=0',
		success: function(data) {
			$("#notifyMe_btn").html(data);
		}
	});
}

jQuery(document).ready(function () {	
	
	setInterval(function(){		
		// This will refresh the icon.
		notiftMe_refresh();
		
	}, 10000);
	
	$("#notifyMe").on('submit','#notifyMe_refresh',function (event) {
		event.preventDefault();
		var form = $(this);
		var url = form.attr('action');
		$.ajax({
			type: "POST",
			url: url,
			data: form.serialize(),
			
			success: function(data)
			{
				$("#notifyMe_btn").html(data);
				
			}
			
		});
	});
	
	// This will Open the Modal.	
	$('#notifyMe_btn').on('click','.notifyMe_icon_active',function() {
		var myHost = location.protocol + "//" + location.host;
		var myURL = myHost + '/wp-content/plugins/NotifyMe/pop.php';
		$.ajax({
			type: 'POST',
			url : myURL,
			data: 'notifyMe=1&chru=0',
			success: function(data) {
				$("#notifyMe_container").html(data);
			}
		});
	});
	
	// Removes Notification 
	$('body').on('click','.notifyMe_remove',function() {
		var myHost = location.protocol + "//" + location.host;
		var myURL = myHost + '/wp-content/plugins/NotifyMe/delete.php';
		var notType = $(this).attr('data-type');
		var notId = $(this).attr('data-nid');
		
		if(notType == 'post')
		{
			var notData = 'post_id='+ notId ;
			var cardId = "#post_" + notId;
			var counterSpan = 'notifyMe_posts_counter';
		}
		else if(notType == 'comment'){
			var notData = 'comment_id='+ notId ;
			var cardId = "#comment_" + notId;
			var counterSpan = 'notifyMe_comments_counter';
		}
		else if(notType == 'global'){			
			var notData = 'globalMessage_id='+ notId ;
			var cardId = "#globalMessage_" + notId;
			var counterSpan = 'notifyMe_messages_counter';
		}
		
		$.ajax({
			type: 'POST',
			url : myURL,
			data: notData,
			success: function(data) {
				
				$(cardId).remove();
				var current_number = $('#' + counterSpan).html();
				var new_number = (parseInt(current_number) - 1).toString();
				$('#' + counterSpan).html(new_number);
				notiftMe_refresh();
			},
			error: function(xhr,error,errorThrowm){
				alert('[' + xhr.status + '] ' + xhr.responseText);
			}
		});
	});
	
	
	
	
	
	// This will Close the modal by clicking on black area.
	$('#notifyMe_container').on('click', '#black_bob' ,function(){
		$("#notifyMe_container").html('');
	});
	
	$('body').on('click','.notifyMe_tab_btn',function(){
		var tabContainerId = $(this).attr('data-container');
		$('.notifyMe_tab_btn').removeClass('notifyMe_tab_btn_active');
		$(this).addClass('notifyMe_tab_btn_active');
		
		$('.notifyMe_tabContainer').hide();
		$('#' + tabContainerId).fadeIn();
	});
	
	
});