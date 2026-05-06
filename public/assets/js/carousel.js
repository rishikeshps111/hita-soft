$('.baner-main-carousel').owlCarousel({
    loop: true,
    dots: false,
    nav: false,
    margin:0,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut',
    autoplay: true,
    autoplayTimeout: 3000,
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 1
        },
        991: {
            items: 1
        },
        1200: {
            items: 1
        },
    }
});

$('.category-carusel').owlCarousel({
     loop: true,
    dots: true,
    nav: true,
    margin:10,
    autoplay: true,
    autoplayTimeout: 3000,
  
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
            items:4
        },
    }
});
$('.service-carusel').owlCarousel({
     loop: true,
    dots: true,
    nav: true,
    margin:10,
    autoplay: true,
    autoplayTimeout: 5000,
  
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
            items:3
        },
    }
});
$('.sell-brand-carousel').owlCarousel({
     loop: true,
    dots: true,
    nav: true,
    margin:10,
    autoplay: true,
    autoplayTimeout: 3000,
  
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
            items:6
        },
    }
});

$('.testi-carusel').owlCarousel({
     loop: true,
    dots: true,
    nav: true,
    margin:10,
    autoplay: true,
    autoplayTimeout: 3000,
  
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
            items:3
        },
    }
});