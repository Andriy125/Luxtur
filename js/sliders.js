$('.review_slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: '.swiper-button-prev',
    nextArrow: '.swiper-button-next'
});

$('.slider_container').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    swipe: false
});

$('.order_slider_car').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: true,
    speed: 300,
    fade: true,
    cssEase: 'linear',
    prevArrow: '.auto-order-button-prev',
    nextArrow: '.auto-order-button-next'
});

$('.auto_img_slider').slick({
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    dotsClass: 'my-dots', 
    prevArrow: '.auto_prev',
    nextArrow: '.auto_next'
});

$('.auto_slider').slick({
    slidesToShow: 3,
    dots: false,
    slidesToScroll: 1,
    infinite: false,
    speed: 300,
    prevArrow: '.auto-button-prev',
    nextArrow: '.auto-button-next',
    responsive: [
        {
            breakpoint: 1400,
            settings: {
                slidesToShow: 2
            }
        },
        {
            breakpoint: 1082,
            settings: {
                slidesToShow: 1
            }
        }
    ]
});

$('.modal_autopark_slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    asNavFor: '.modal_autopark_slider_lower',
    nextArrow: '.modal_autopark__button-next',
    prevArrow: '.modal_autopark__button-prev'
});
$('.modal_autopark_slider_lower').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    draggble: false,
    asNavFor: '.modal_autopark_slider',
    centerMode: true,
    focusOnSelect: true,
    dotsClass: '.modal_autopark_slider_lower__item'
});


		


$('.order_form__button.next').on('click', (e) => {
    e.preventDefault();
    $('.slider_container').slick('slickNext');
    var currentSlide = $('.slider_container').slick('slickCurrentSlide');
    if(currentSlide == $('.slider_container .wrap_order_request').length - 1){
        setTimeout(
            () => {
                $('.slider_container')
                .slick("slickGoTo", 0, false);
            }, 3500
        )
    }
});

$('.order_form__button.prev').on('click', (e) => {
    e.preventDefault();
    $('.slider_container').slick('slickPrev');
});

$('.auto_filter__btn').on('click', (e) => {
    $('.auto_filter__btn.active').toggleClass('active', false);
    $(e.target).toggleClass('active', true);
})

$('.auto_filter__btn.all').on('click', () => {
    document.querySelectorAll('.auto_item').forEach(el => $(el).css('display','block'));
});

$('.auto_filter__btn.ukr').on('click', () => {
    document.querySelectorAll('.auto_item').forEach(el => {
        if(el.classList.contains('ukr')){
            $(el).css('display','block');
        }
        else
        {
            $(el).css('display','none');
        }
    });
});

$('.auto_filter__btn.eu').on('click', () => {
    document.querySelectorAll('.auto_item').forEach(el => {
        if(el.classList.contains('eu')){
            $(el).css('display','block');
        }
        else
        {
            $(el).css('display','none');
        }
    });
});