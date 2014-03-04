$(function(){
	poll();

	window.setInterval(function(){poll()},3000);

	$('#skip').on('click',function(){
		skip();
	});

	$('.song-btn').on('click',function(){
		vote($(this).attr('song-id'));
	});
});

function remove_overlay(){
   $('html').removeClass("loading");
}

function thinking_overlay(){
	$('.modal h1').html('Loading Next Vote');
	$('html').addClass("loading");
}

function poll(){
	$.ajax({
		url: 'rpc.php',
		type: 'POST',
		data: {action: 'poll'},
	})
	.done(function(result) {
		$('#s1').find('.song-name').html(result.payload.s1.btn_label);
		$('#s1').find('.song-votes').html(result.payload.s1.votes);
		$('#s1').attr('song-id', result.payload.s1.song_id);

		$('#s2').find('.song-name').html(result.payload.s2.btn_label);
		$('#s2').find('.song-votes').html(result.payload.s2.votes);
		$('#s2').attr('song-id', result.payload.s2.song_id);

		$('#s3').find('.song-name').html(result.payload.s3.btn_label);
		$('#s3').find('.song-votes').html(result.payload.s3.votes);
		$('#s3').attr('song-id', result.payload.s3.song_id);

		remove_overlay();
	});
}

function vote(song_id){
	thinking_overlay();
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
}

function skip(){
	thinking_overlay();
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
}
