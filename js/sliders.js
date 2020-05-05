let auto_slider = document.querySelector('.auto_slider');   // слайдер автопарку

$(document).ready(function(){
    setTimeout(() => {
        $('.auto_item .fotorama__img').prop('title', "Переглянути всі зображення");
        let btn_auto_card = document.querySelectorAll('.auto_item .fotorama__img');                              //  карточки автопарку
        btn_auto_card.forEach(el => el.onclick = function(){
            if(fotorama){
                fotorama.data('fotorama').destroy();
                fotorama = null;
            }
            $('.modal_autopark_img').remove();
            let name = $(el).closest('.auto_item').find('.auto_model')[0].textContent;
            let index = $(el).closest('.auto_item').find('input.index')[0].value;
            let elements = '';
            for(let i = 0; i < array_of_auto_imgs[index].length; i++){
                elements += array_of_auto_imgs[index][i];
            }
            $('.modal_autopark__container h2').text(name);
            $(elements).appendTo('.modal_autopark_slider');
            fotorama = $('.modal_autopark_slider').fotorama({
                width: 500,
                maxwidth: '100%',
                thumbmargin: 30,
                nav: 'thumbs',
                loop: true
            });
            showModal(modal_autopark);    
        });
    }, 1000);
});

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
    $(auto_slider).slick('slickUnfilter');
});

// обробник натистення на клавішу фільтрування авто "україна"
$('.auto_filter__btn.ukr').on('click', () => {
    $(auto_slider).slick('slickUnfilter');
    $(auto_slider).slick('slickFilter', function() {
      return this.classList.contains('ukr');
    });
});

// обробник натистення на клавішу фільтрування авто "европа"
$('.auto_filter__btn.eu').on('click', (ev) => {
    $(auto_slider).slick('slickUnfilter');
    $(auto_slider).slick('slickFilter', function() {
      return this.classList.contains('eu');
    });
});