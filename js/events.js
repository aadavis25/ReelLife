$(document).ready(function () {

	$('reveal').on('click', 'ul', null, function (e) {
		$(this).children().toggle('medium');
	});
}