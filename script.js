$(function(){
	window.setInterval(function(){poll()},3000);

	$('#skip').on('click',function(){
		skip();
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
	//check for new vote totals
	console.log('poll called');
	$.ajax({
		url: 'rpc.php',
		type: 'POST',
		data: {action: 'poll'},
	})
	.done(function() {
		console.log("success vote");
	})
	.fail(function() {
		console.log("error vote");
	})
	.always(function() {
		console.log("complete vote");
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
		console.log("success vote");
	})
	.fail(function() {
		console.log("error vote");
	})
	.always(function() {
		console.log("complete vote");
	});

}

function skip(){
	$.ajax({
		url: 'rpc.php',
		type: 'POST',
		data: {action: 'skip'},
	})
	.done(function() {
		console.log("success skip");
	})
	.fail(function() {
		console.log("error skip");
	})
	.always(function() {
		console.log("complete skip");
	});
}
