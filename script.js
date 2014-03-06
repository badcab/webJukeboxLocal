$(function(){
	poll();

	window.setInterval(function(){poll()},3000);

	$('#skip').on('click',function(){
		skip();
	});

	$('.song-btn').on('click',function(){
		var name = $(this).find('.song-name').html();
		vote($(this).attr('song-id'), name);
	});
});

function remove_overlay(){
   $('html').removeClass("loading");
}

function thinking_overlay(message, label){
	$('.modal h1').html(message + '<br/>' + label);
	$('html').addClass("loading");
}

function poll(){
	$.ajax({
		url: 'rpc.php',
		type: 'POST',
		data: {action: 'poll'},
	})
	.done(function(result) {
		$.each(result.payload, function( index, value ) {
			$('#' + index).find('.song-name').html(value.btn_label);
			$('#' + index).find('.song-votes').html(value.votes);
			$('#' + index).attr('song-id', value.song_id);
		});
	});
}

function vote(song_id, name){
	thinking_overlay('casting vote for', name);
	$.ajax({
		url: 'rpc.php',
		type: 'POST',
		async: false,
		data: {song_id: song_id, action: 'vote'},
	})
	.done(function() {
		poll();
	})
	.fail(function() {
		remove_overlay();
	});
	setTimeout(function(){remove_overlay()}, 2000);
}

function skip(){
	thinking_overlay('skipping', 'vote');
	$.ajax({
		url: 'rpc.php',
		type: 'POST',
		async: false,
		data: {action: 'skip'},
	})
	.done(function() {
		poll();
	})
	.fail(function() {
		remove_overlay();
	});
	setTimeout(function(){remove_overlay()}, 2000);
}
