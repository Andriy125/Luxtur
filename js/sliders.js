let auto_slider = document.querySelector('.auto_slider');                                   // slider of autopark
let fotorama = null;                                                                        //  slider for autopark modal
$(document).ready(function(){
    setTimeout(() => {
        //  after 1 sec set the tips to the each image of the slider inside every car card and set the event listener to each image
        $('.auto_item .fotorama__img').prop('title', "Переглянути всі зображення");        //  when sliders ready set the title of the slider in each car card
        let btn_auto_card = document.querySelectorAll('.auto_item .fotorama__img');        //  car cards
        btn_auto_card.forEach(el => el.onclick = function(){
            //  on click each image in car card 
            if(fotorama){
                //  if modal already created - delete it
                fotorama.data('fotorama').destroy();
                //  nulling modal slider
                fotorama = null;
            }
            //  removing all images of modal slider
            $('.modal_autopark_img').remove();
            //  get the name of the card
            let name = $(el).closest('.auto_item').find('.auto_model')[0].textContent;
            //  get the car card index 
            let index = $(el).closest('.auto_item').find('input.index')[0].value;
            let elements = '';
            for(let i = 0; i < array_of_auto_imgs[index].length; i++){
                //  get all url images of card in format ("img/name.png")
                elements += array_of_auto_imgs[index][i];
            }
            //  paste name of car to the modal window
            $('.modal_autopark__container h2').text(name);
            //  set the images to modal slider
            $(elements).appendTo('.modal_autopark_slider');
            //  initialize modal slider
            fotorama = $('.modal_autopark_slider').fotorama({
                width: 500,
                maxwidth: '100%',
                thumbmargin: 30,
                nav: 'thumbs',
                loop: true
            });
            //  show the modal
            showModal(modal_autopark);    
        });
    }, 1000);
});

//  reviews slider
$('.review_slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: '.swiper-button-prev',
    nextArrow: '.swiper-button-next'
});

// order form slider
$('.slider_container').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    swipe: false
});

// car slider inside order form
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

// car card slider
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

$('.order_form__button.prev').on('click', (e) => {
    //  handler of 'back' button on order form sldier
    e.preventDefault();
    $('.slider_container').slick('slickPrev');
});

$('.auto_filter__btn').on('click', (e) => {
    //  filtering auto in autopark (car cards)
    $('.auto_filter__btn.active').toggleClass('active', false);
    $(e.target).toggleClass('active', true);
});

$('.auto_filter__btn.all').on('click', () => {
    //  handler of showing all cars in car cards slider
    $(auto_slider).slick('slickUnfilter');
});

$('.auto_filter__btn.ukr').on('click', () => {
    //  showing 'ukraine' locations of car cards slider
    $(auto_slider).slick('slickUnfilter');
    $(auto_slider).slick('slickFilter', function() {
      return this.classList.contains('ukr');
    });
});

$('.auto_filter__btn.eu').on('click', (ev) => {
    //  showing 'europe' location of car cards slider
    $(auto_slider).slick('slickUnfilter');
    $(auto_slider).slick('slickFilter', function() {
      return this.classList.contains('eu');
    });
});