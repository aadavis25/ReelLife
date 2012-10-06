$(document).ready(function () {

	$('#reveal').on('click', 'h3', null, function (e) {
		$(this).children('ul').toggle('medium');
	});
});