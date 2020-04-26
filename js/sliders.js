//  слайдер відгуків
$('.review_slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: '.swiper-button-prev',
    nextArrow: '.swiper-button-next'
});

// слайдер кнопок модального вікна автопарку (нижні переключашки)
$('.modal_autopark_slider_lower').slick({
    slidesToShow: 4,
    slidesToScroll: 0,
    draggble: false,
    asNavFor: '.modal_autopark_slider',
    centerMode: true,
    focusOnSelect: true,
    dotsClass: '.modal_autopark_slider_lower__item'
});

// слайдер автопарку в модальному вікні
$('.modal_autopark_slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: false,
    asNavFor: '.modal_autopark_slider_lower',
    nextArrow: '.modal_autopark__button-next',
    prevArrow: '.modal_autopark__button-prev'
});

// слайдер замовлення
$('.slider_container').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    swipe: false
});

// слайдер вибору авто в формі замовлення
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

// слайдер карточок автопарку
$('.auto_slider').slick({
    slidesToShow: 3,
    dots: false,
    slidesToScroll: 1,
    infinite: false,
    swipe:false,
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

// слайдер зображень авто в коожній карточці
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

// обробник натиснення на кнопку "назад" в слайдері форми замовлення
$('.order_form__button.prev').on('click', (e) => {
    e.preventDefault();
    $('.slider_container').slick('slickPrev');
});

// обробник натистення на клавішу фільтрування авто
$('.auto_filter__btn').on('click', (e) => {
    $('.auto_filter__btn.active').toggleClass('active', false);
    $(e.target).toggleClass('active', true);
});

// обробник натистення на клавішу фільтрування авто "всі"
$('.auto_filter__btn.all').on('click', () => {
    document.querySelectorAll('.auto_item').forEach(el => $(el).css('display','block'));
});

// обробник натистення на клавішу фільтрування авто "україна"
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

// обробник натистення на клавішу фільтрування авто "европа"
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