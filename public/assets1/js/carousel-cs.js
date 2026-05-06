$('.hero-section').owlCarousel({
    loop: true,
    margin: 10,
    dots: false,
  slideTransition: 'linear',
      autoplay: true,
      autoplayTimeout: 6000,
      autoplaySpeed: 2000,
    nav: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});
$('.Featured-carousel').owlCarousel({
    loop: true,
    margin: 10,
    dots: false,
    autoplay:true,
    nav: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 3
        },
        1200: {
            items: 4
        }
    }
});
$('.arrival-carousel').owlCarousel({
    loop: true,
    margin: 10,
    dots: true,
    autoplay:true,
    nav: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 4
        }
    }
});
$('.cat-carousel').owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout:6000,
    dots: false,
    // rtl:true,
    nav: false,
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        991: {
            items: 3
        },
        1200: {
            items: 4
        }
    }
});
$('.customer-carousel').owlCarousel({
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout:6000,
    
    dots: false,
    rtl:true,
    nav: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1000: {
            items: 1
        }
    }
});