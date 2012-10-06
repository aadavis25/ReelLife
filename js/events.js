$(document).ready(function () {
	$(".reveal").each(function(element){   
        var ul = $(this).next("ul");
                ul.slideUp();
        });
	
$(".reveal").each(function(element){   
    $(this).click(function(){    
        var ul = $(this).next("ul");
            if (ul.is(":hidden")) {

                ul.slideDown();
            } 
            else {
                ul.slideUp();
            }
        });
    });

    $(function() {
        $('#gallery a').lightBox();
    });
});
    