$(document).ready(function () {

	$('#reveal').on('click', 'h3', null, function (e) {
		alert('woo');
		$($(this).children('ul')).toggle('medium');
	});
});