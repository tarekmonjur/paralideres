$(document).ready(function(){
    /*
     =========================================================================================
     12. SLIDE
     =========================================================================================
     */

    // var banner_slider = $("#banner_slider");
    // banner_slider.owlCarousel({
    //     loop: true,
    //     margin: 0,
    //     smartSpeed:450,
    //     autoplay:false,
    //     dots:true,
    //     nav: false,
    //     responsive: {
    //         0: {
    //             items: 1
    //         },
    //         400: {
    //             items: 1
    //         },
    //         768: {
    //             items: 1
    //         },
    //         1200: {
    //             items: 1
    //         }
    //     }
    // });

    var test_slider = $("#test_slider");
    test_slider.owlCarousel({
        loop: true,
        margin: 0,
        smartSpeed:450,
        autoplay:false,
        dots:true,
        nav: false,
        responsive: {
            0: {
                items: 1
            },
            400: {
                items: 1
            },
            768: {
                items: 1
            },
            1200: {
                items: 1
            }
        }
    });
});
