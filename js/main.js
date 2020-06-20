let add = document.querySelector('.add');                                                   //  getting button for adding inputs for calculation block
let add_order_input = document.querySelector('.order_add');                                 //  getting button for adding inputs for order form block
                                                                                            //  Get the modals
let modal_call = document.getElementById("modal_call");                                     //  modal window for ordering call
let modal_calc = document.getElementById("modal_calculate");                                //  modal window for calculation results
let modal_review = document.getElementById("modal_review");                                 //  modal window for adding review
let modal_autopark = document.getElementById("modal_autopark");                             //  modal window of autopark 
let card_slider = document.querySelector(".auto_img_slider");                               //  slider of autopark (cards) 
                                                                                            //  Get the button that opens the modal
let btn_call = document.getElementById("call");                                             //  button of ordering call
let btn_review = document.getElementById("review_button");                                  //  button of adding review
                                                                                            //  Get the <span> element that closes the modal
let span = document.getElementsByClassName("close")[0];                                     //  button for closing ordering call modal 
                                                                                            
$('.phone').mask('+38 (000) 000 00 00', {placeholder: "Номер телефону"});                   //  setting mask for phone inputs
$('.all_info__input')[0].checked = false;                                                   //  setting "all data" in result calculation modal window to false
$('.order_remove').css('display', 'none');                                                  //  hide button "delete address" in order form 
$('.minus').css('display', 'none');                                                         //  hide button "delete address" in calculation block

const setLocalDate = () => {
    //  setting current date and current time + 3h to order form
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

const showModal = (showElem) => {
    showElem.style.display = "block";
}

const hideModal = (showElem) => {
    showElem.style.display = "none";
}

const ClearCallInputs = () => {
    //  clearing inputs for call modal
    document.querySelectorAll('.call_form__input').forEach(el => {el.value = "";});
}

const addScroll = (elem) => {
    //  adding scroll to entered element
    $(elem).css('overflow-y', 'auto');
}

const createInput = (class_name, container_name, delete_button_class) =>{
    //  creating input by class name, container name and showing delete button if inputs are more than 2
    let elements = document.querySelectorAll(`.${class_name}`);
    if(elements.length > 1){
        changeContainer(container_name, delete_button_class);
    }
    CreateElement(class_name, elements[elements.length - 1]); 
}

const removeStyles = (button, form) => {
    //  reseting styles for crud buttons (order from and calculation block)
    $(button).css('display', 'none');
    $(`.${form} .crud_buttons`).css('margin-top', '0px');
    $(`.${form} .crud_buttons`).css('justify-content', 'center');
}

const CreateElement = ( _class, after ) => {      
    //  create i8nput element and paste it after                                               
    $('<input type="text" placeholder="Адреса пункту..." class="' + _class + '" name="address" required>')
    .insertAfter(after);
}

const changeContainer = (container, hidden_button) => {
    //  change container styles
    //  add scroll
    addScroll(container);
    //  get the wrapper of the container to set styles for correct crud buttons
    let wrapper = document.querySelector(container).parentElement.getAttribute("class");
    //  show "delete button"
    $(hidden_button).css('display', 'inline-flex');
    $(`.${wrapper} .crud_buttons`).css('margin-top', '15px');
    $(`.${wrapper} .crud_buttons`).css('justify-content', 'space-between');
}

const deleteLastElement = (elem_class, removestylesOf) => {
    //  delete last element wuth class "elem_class" and hide "delete button"
    //  get all elements with 'elem_class'
    let elements = document.querySelectorAll(elem_class);
    //  get form class of these elements
    let form_class = document.querySelector(elem_class).closest('form').getAttribute("class");
    if(elements.length < 4){
        //  if elements less than 4 - hide "delete button"
        removeStyles(removestylesOf, form_class);
    }
    //  delete last elements
    elements[elements.length - 1].remove();
}

const eventListeners = () => {
    //  storing event listeners

    // When the user clicks on the button, open the modal
    btn_call.onclick = function() {
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

    add.addEventListener('click', () => {
        //  handler of adding inputs to the calculation block and to order form                                  
        createInput('form__input', '.fixed_container.calc', '.minus');
        createInput('address', '.fixed_container.order', '.order_remove');
    });

    add_order_input.addEventListener('click', (e) => {
        //  handler of adding input to order form
        createInput('address', '.fixed_container.order', '.order_remove');
    })

    document.querySelector('.order_remove').addEventListener('click', () => {
        //  handler of deleting input on order form
        deleteLastElement('.address', '.order_remove');
    })

    document.querySelector('.minus').addEventListener('click', () => {
        //  handler of deleting inputs on calculation block
        //  delete input on calculation block
        deleteLastElement('.form__input', '.minus');
        //  delete input on order form
        deleteLastElement('.address', '.order_remove');
    })

    document.querySelector('.all_info').addEventListener('click', (e) => {
        //  show or hide 'all info' about calculation results on modal
        if($('.all_info__input')[0].checked){
            //  if checkbox is disable - show global distance
            $('.results_distances__standard').css('display', 'none');
            $('.results_distances__all').css('display', 'block');
        }
        else{
            //  if checkbox is active - show all addresses
            $('.results_distances__standard').css('display', 'block');
            $('.results_distances__all').css('display', 'none');
        }
    })

    document.querySelector('.burger_icon').addEventListener('click', (e) => {
        //  handler of burger menu
        if(document.querySelector('.burger_icon').classList.contains('change')){
            //  if burger menu active - hide menu and show burger
            $('.burger_icon').toggleClass('change', false);
            $('.header_right__ul').toggleClass('burger_active', false);
        }
        else{
            //  if burger menu hide - show menu and hide burger
            $('.burger_icon').toggleClass('change', true);
            $('.header_right__ul').toggleClass('burger_active', true);
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
} 

setLocalDate();
eventListeners();