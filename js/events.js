$(document).ready(function () {

    $("#reveal").click(function(){
    var ul = $(this).next("ul");
    if (ul.is(":hidden")) {
        ul.slideDown();
    } else {
        ul.slideUp();
    }
	});
});​