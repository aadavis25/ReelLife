$(document).ready(function () {
$(".reveal").each(function(element){   
    $(this).click(function(){    
        var ul = $(this).next("ul");
            if (ul.is(":hidden")) {
                ul.slideDown();
            } else {
                ul.slideUp();
            }
        });
    });
});​