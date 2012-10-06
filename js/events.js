$(document).ready(function () {

	$('#reveal').on('click', 'div', null, function (e) {
		$(this).children('ul').toggle('medium');
	});
});