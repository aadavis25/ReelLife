$(document).ready(function () {
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
var cont_left = $(".container").position().left;
        $("a img").hover(function() {
            // hover in
            $(this).parent().parent().css("z-index", 1);
            $(this).animate({
               height: "100%",
               width: "100%"
            }, "fast");
        }, function() {
            // hover out
            $(this).parent().parent().css("z-index", 0);
            $(this).animate({
                height: "50%",
                width: "50%"
            }, "fast");
        });

        $(".img").each(function(index) {
            var left = (index * 160) + cont_left;
            $(this).css("left", left + "px");
        });
});
