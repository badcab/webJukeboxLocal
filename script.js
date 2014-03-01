$(function(){
	window.setInterval(function(){poll()},3000);

	$('#skip').on('click',function(){
		thinking_overlay();
		skip();
	});

	$('.song-btn').on('click',function(){
		thinking_overlay();
		var song_id = $(this).attr('song-id');
		vote(song_id);
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
		console.log("success poll");

		$('#s1').find('.song-name').html(result.payload.s1.btn_label);
		$('#s1').find('.song-votes').html(result.payload.s1.votes);
		$('#s1').attr('song-id', result.payload.s1.song_id);

		$('#s2').find('.song-name').html(result.payload.s2.btn_label);
		$('#s2').find('.song-votes').html(result.payload.s2.votes);
		$('#s2').attr('song-id', result.payload.s2.song_id);

		$('#s3').find('.song-name').html(result.payload.s3.btn_label);
		$('#s3').find('.song-votes').html(result.payload.s3.votes);
		$('#s3').attr('song-id', result.payload.s3.song_id);
	})
	.fail(function() {
		console.log("error poll");
	})
	.always(function() {
		console.log("complete poll");
	});
}

function vote(song_id){
	//will do an ajax call and all that jazz
	$.ajax({
		url: 'rpc.php',
		type: 'POST',
		data: {song_id: song_id, action: 'vote'},
	})
	.done(function() {
		poll();
	})
	.fail(function() {
		console.log("error vote");
	})
	.always(function() {
		remove_overlay();
	});

}

function skip(){
	$.ajax({
		url: 'rpc.php',
		type: 'POST',
		data: {action: 'skip'},
	})
	.done(function() {
		poll();
	})
	.fail(function() {
		console.log("error skip");
	})
	.always(function() {
		remove_overlay();
	});
}
