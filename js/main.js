let add = document.querySelector('.add');                                                   // кнопка додавання полів блоку розрахунків
let add_order_input = document.querySelector('.order_add');                                  // кнопка додавання полів блоку замовлень
// Get the modal
let modal_call = document.getElementById("modal_call");                                     //  модальне вікно замовлення дзвінку
let modal_calc = document.getElementById("modal_calculate");                                //  модальне вікно для відображення результатів розрахунків
let modal_review = document.getElementById("modal_review");                                 //  модальне вікно для додавання відгуку
let modal_autopark = document.getElementById("modal_autopark");                             //  модальне вікно автопарку 
let card_slider = document.querySelector(".auto_img_slider");                             //  слайдер в карточці 
// Get the button that opens the modal
let btn = document.getElementById("call");                                                  //  кнопка замовлення дзвінку
let btn_review = document.getElementById("review_button");                                  //  кнопка додавання відгуку

let fotorama = null;    // для модалок автопарку
// Get the <span> element that closes the modal
let span = document.getElementsByClassName("close")[0];                                     //  кнопка закриття форми замовлення дзвінка
$('.all_info__input')[0].checked = false;                                                   //  встановлення кнопки "всі дані" в модальному вікні "розрахунки" по замовчування на офф
$('.order_remove').css('display', 'none');   

const setLocalDate = () => {
    let local = new Date();
    let local_date = local.getFullYear() + '-';
    if(local.getMonth() < 10){
        local_date += '0' + (local.getMonth() + 1) + '-';
    }
    else{
        local_date += (local.getMonth() + 1) + '-';
    }
    if(local.getDate() < 10){
        local_date += '0' + local.getDate();
    }
    else{
        local_date += local.getDate();
    }
    $('.order_date')[0].value = local_date;
    $('.order_date')[0].min = local_date;
    $('.order_time')[0].value = `${local.getHours() + 3}:${local.getMinutes() < 10 ? `0${local.getMinutes()}`: local.getMinutes()}`;    
}
setLocalDate();

//  задання маски для полів із телефоном
$('.phone').mask('+38 (000) 000 00 00', {placeholder: "Номер телефону"});

// When the user clicks on the button, open the modal
btn.onclick = function() {
    showModal(modal_call);
}

btn_review.onclick = function() {
    showModal(modal_review);
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    hideModal(modal_call);
    ClearCallInputs();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal_call) {
        hideModal(modal_call);
        ClearCallInputs();
    }
    else if(event.target == modal_calc){
        hideModal(modal_calc);
    }
    else if(event.target == modal_review){
        hideModal(modal_review);
    }
    else if(event.target == modal_autopark && event.target != card_slider){
        hideModal(modal_autopark);
    }
}

const showModal = (showElem) => {
    showElem.style.display = "block";
}

const hideModal = (showElem) => {
    showElem.style.display = "none";
}

const ClearCallInputs = () => {
    document.querySelectorAll('.call_form__input').forEach(el => {el.value = "";});
}

const addScroll = (elem) => {
    $(elem).css('overflow-y', 'auto');
}

// додавання полів на форму "розрахунок"
add.addEventListener('click', () => {                                  
    let elements = document.querySelectorAll('.form__input');
    if(elements.length > 1){
        changeContainer('.fixed_container.calc', '.form_calc', '.minus');
    }
    CreateElement('form__input', elements[elements.length - 1]);  
});

const addStyles = (container, form, button) => {
    addScroll(container);
    $(button).css('display', 'inline-flex');
    $(`${form} .crud_buttons`).css('margin-top', '15px');
    $(`${form} .crud_buttons`).css('justify-content', 'space-between');
    $(`${form} .crud_buttons`).css('margin-bottom', '0px');
}

const removeStyles = (button, form) => {
    $(button).css('display', 'none');
    $(`${form} .crud_buttons`).css('margin-top', '0px');
    $(`${form} .crud_buttons`).css('justify-content', 'center');
}

// створення полів
const CreateElement = ( _class, after ) => {                                                     
    $('<input type="text" placeholder="Адреса пункту..." class="' + _class + '" name="address" required>')
    .insertAfter(after);
}

//  обробник натиснення на кнопку "додати пункт" для форми із замовленням
add_order_input.addEventListener('click', (e) => {
    let addresses = document.querySelectorAll('.address');
    if(addresses.length > 1){
        changeContainer('.order_form .fixed_container', '.order_form', '.order_remove');
    }
    CreateElement('order_data_input address', addresses[addresses.length - 1]);  
})

//  задання стилів для контейнера 
const changeContainer = (container, form,  hidden_button) => {
    addScroll(container);
    $(hidden_button).css('display', 'inline-flex');
    $(`${form} .crud_buttons`).css('margin-top', '15px');
    $(`${form} .crud_buttons`).css('justify-content', 'space-between');
    $(`${form} .crud_buttons`).css('margin-bottom', '0px');
}

//  обробник натиснення на кнопку "видалити пункт" для форми із замовленням
document.querySelector('.order_remove').addEventListener('click', () => {
    deleteLastElement('.address', '.order_remove', '.order_form');
})

//  обробник подій на кнопку видалення поля на формі "розрахунок"
document.querySelector('.minus').addEventListener('click', () => {
    deleteLastElement('.form__input', '.minus', '.form_calc');
})

//  видалення останнього елемента серед елементів з класом class_elem і приховування removestylesOf
const deleteLastElement = (elem_class, removestylesOf, form) => {
    let elements = document.querySelectorAll(elem_class);
    if(elements.length < 4){
        removeStyles(removestylesOf, form);
    }
    elements[elements.length - 1].remove();
}

//  обробник на відображення всіх пунктів на модальному вікні "розрахунок"
document.querySelector('.all_info').addEventListener('click', (e) => {
    if($('.all_info__input')[0].checked){
        $('.results_distances__standard').css('display', 'none');
        $('.results_distances__all').css('display', 'block');
    }
    else{
        $('.results_distances__standard').css('display', 'block');
        $('.results_distances__all').css('display', 'none');
    }
})

document.querySelector('.burger_icon').addEventListener('click', (e) => {
    if(document.querySelector('.burger_icon').classList.contains('change')){
        $('.burger_icon').toggleClass('change', false)
        $('.header_right__ul').toggleClass('burger_active', false)
    }
    else{
        $('.burger_icon').toggleClass('change', true)
        $('.header_right__ul').toggleClass('burger_active', true)

    }
})

// Add smooth scrolling to all links
$("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
        // Prevent default anchor click behavior
        event.preventDefault();
    
        // Store hash
        var hash = this.hash;
    
        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
        scrollTop: $(hash).offset().top
        }, 800, function(){
    
        });
    } // End if
});

