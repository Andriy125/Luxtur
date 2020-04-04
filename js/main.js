let add = document.querySelector('.add');                                                   // кнопка додавання полів
// Get the modal
let modal_call = document.getElementById("modal_call");
let modal_calc = document.getElementById("modal_calculate");
let modal_review = document.getElementById("modal_review");
let modal_autopark = document.getElementById("modal_autopark");
// Get the button that opens the modal
let btn = document.getElementById("call");
let btn_review = document.getElementById("review_button");
let btn_auto_card = document.querySelectorAll("#auto_card");

// Get the <span> element that closes the modal
let span = document.getElementsByClassName("close")[0];
$('.all_info__input')[0].checked = false;
$('.order_remove').css('display', 'none');

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



$('.phone').mask('+3 (000) 000 00 00', {placeholder: "Номер телефону"});

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal_call.style.display = "block";
}

btn_review.onclick = function() {
    modal_review.style.display = "block";
}

btn_auto_card.forEach(el => el.onclick = function() {
    modal_autopark.style.display = "block";
})

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal_call.style.display = "none";
    ClearCallInputs();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal_call) {
        modal_call.style.display = "none";
        ClearCallInputs();
    }
    else if(event.target == modal_calc){
        modal_calc.style.display = "none";
    }
    else if(event.target == modal_review){
        modal_review.style.display = "none";
    }
    else if(event.target == modal_autopark){
        modal_autopark.style.display = "none";
    }
}

const ClearCallInputs = () => {
    document.querySelectorAll('.call_form__input').forEach(el => {el.value = "";});
}

const addScroll = (elem) => {
    $(elem).css('overflow-y', 'auto');
}

add.addEventListener('click', () =>{                                                        // додавання полів                                              
    let elements = document.querySelectorAll('.form__input');
    if(elements.length > 1){
        addStyles('.fixed_container.calc', '.minus');
    }
    CreateElement('form__input', elements[elements.length - 1])  
});

const addStyles = (container, button) => {
    addScroll(container);
    $(button).css('display', 'inline-flex');
    $('.crud_buttons').css('margin-top', '15px');
    $('.crud_buttons').css('justify-content', 'space-around');
    $('.crud_buttons').css('margin-bottom', '0px');
}

const removeStyles = (button) => {
    $(button).css('display', 'none');
    $('.crud_buttons').css('margin-top', '0px');
    $('.crud_buttons').css('justify-content', 'center');
}

const CreateElement = ( _class, after ) => {                                                 // створення полів    
    $('<input type="text" placeholder="Адреса пункту..." class="' + _class + '" required>')
    .insertAfter(after);
}

document.querySelector('.order_add').addEventListener('click', (e) => {
    let addresses = document.querySelectorAll('.address');
    if(addresses.length > 1){
        addScroll('.fixed_container');
        $('.order_remove').css('display', 'inline-flex');
        $('.crud_buttons').css('margin-top', '15px');
    }
    $('<input type="text" placeholder="Адреса пункту..." class="order_data_input address" required>')
    .insertAfter(addresses[addresses.length - 1]);
})

document.querySelector('.order_remove').addEventListener('click', (e) => {
    let addresses = document.querySelectorAll('.address');
    if(addresses.length < 4){
        removeStyles('.order_remove');
    }
    addresses[addresses.length - 1].remove();
})

document.querySelector('.minus').addEventListener('click', (e) => {
    let inputs = document.querySelectorAll('.form__input');
    if(inputs.length < 4){
        removeStyles('.minus');
    }
    inputs[inputs.length - 1].remove();
})

document.querySelector('.all_info').addEventListener('click', (e) => {
    if($('.all_info__input')[0].checked){
        $('.results_distances__standard').css('display', 'none');
        $('.results_distances__all').css('display', 'block');
    }
    else
    {
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
