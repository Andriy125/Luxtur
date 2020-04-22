// додавання обробників івентів
$(document).ready(function(){
    document.querySelector('.menu_icon').addEventListener('click', (e) => {
        $('.side_menu').toggleClass('active', true);
    })
    document.querySelector('.close_icon').addEventListener('click', (e) => {
        CloseMenu();
    })
    document.querySelectorAll('.side_menu__item').forEach((el) => {
        el.addEventListener('click', (e) => ShowContent(e, `id-${el.getAttribute('id')}`));
    });

    document.querySelectorAll('.another').forEach((el) => {
        el.addEventListener('click', (e) => ShowContent(e, `id-${el.getAttribute('id')}`));
    });

    $('#add_our_service').click();
    $('.phone').mask('+38 (000) 000 00 00', {placeholder: "Номер телефону"});
});

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
    $('.input_date')[0].value = local_date;
    $('.input_date')[0].min = local_date;
    $('.input_time')[0].value = `${local.getHours() + 3}:${local.getMinutes() < 10 ? `0${local.getMinutes()}`: local.getMinutes()}`;    
}
setLocalDate();

// закриття меню
const CloseMenu = () => {
    $('.side_menu').toggleClass('active', false);
}

// відображення контенту після натискання на пункт меню 
const ShowContent = (e, name) => {
    // Declare all variables
    let tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("side_menu__item");
    for (let i = 0; i < tablinks.length; i++) {
        $(tablinks[i]).toggleClass('active', false);
    }
    
    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(name).style.display = "block";
    $(e.currentTarget).toggleClass("active", true);
    $('.admin_main_title').html($(e.currentTarget).text());
    CloseMenu();
}

const sortTable = (table, sort_by) => {
    let sortedRows = Array.from(table.rows)
    .slice(1)
    .sort((rowA, rowB) => rowA.cells[sort_by].innerHTML > rowB.cells[sort_by].innerHTML ? 1 : -1);  
    table.tBodies[0].append(...sortedRows);
}

const filterTrByClass = (filter_by, where) => {
    $(`${where} tr.all`).css('display', 'none');
    $(`${where} tr.${filter_by}`).css('display', 'table-row');
}

document.querySelectorAll('.update_review_showing').forEach(el => {
    el.addEventListener("click", (e) => {
        let form = e.target.closest('.update_review');
        let id = form.elements.id.value;
        let column = "show_review";
        let is_showing = $(form.is_showing).prop("checked");
        updateRequest("r", id, column, is_showing);
    })
});

document.querySelectorAll('.update_order_done').forEach(el => {
    el.addEventListener("click", (e) => {
        let form = e.target.closest('.update_order');
        let id = form.elements.id.value;
        let column = "done";
        let order_done = $(form.order_done).prop("checked");
        updateRequest("o", id, column, order_done);
    })
});

document.querySelector('.del_phone').addEventListener("click", (e)=>{
    e.preventDefault();
    let id = $('.delete_form_p')[0].elements.id.value;
    $(e.target.closest('tr')).remove();
    deleteRequest(id, "c_p");
});

document.querySelector('.del_email').addEventListener("click", (e)=>{
    e.preventDefault();
    let id = $('.delete_form_e')[0].elements.id.value;
    $(e.target.closest('tr')).remove();
    deleteRequest(id, "c_e");
});

document.querySelector('.del_order').addEventListener("click", (e)=>{
    e.preventDefault();
    let id = $('.delete_form_o')[0].elements.id.value;
    $(e.target.closest('tr')).remove();
    deleteRequest(id, "o");
});

document.querySelector('.del_review').addEventListener("click", (e)=>{
    e.preventDefault();
    let id = $('.delete_form_r')[0].elements.id.value;
    $(e.target.closest('tr')).remove();
    deleteRequest(id, "r");
});

document.querySelector('.del_call').addEventListener("click", (e)=>{
    e.preventDefault();
    let id = $('.delete_form_c')[0].elements.id.value;
    $(e.target.closest('tr')).remove();
    deleteRequest(id, "c");
});

const deleteRequest = (id, table_name) => {
    let data = {};
    data["id"] = id;
    data["table"] = table_name;
    data["delete"] = true;
    sendRequest(data);
}

const updateRequest = (table_name, id, column, value) => {
    let data = {};
    data["id"] = id;
    data["update"] = true;
    data["table"] = table_name;
    data["value"] = value;
    data["column"] = column;
    sendRequest(data);
}

const getAddressesTextarea = (str) => {    
    var split = str.split('\n');
    var lines = [];
    for (var i = 0; i < split.length; i++){
        if (split[i]){
            lines.push(split[i]);
        } 
    }
    return lines;
}

document.querySelector('.filter_review').addEventListener("change", (e)=>{
    e.preventDefault();
    let filter_by = e.target.value;
    filterTrByClass(filter_by, '.review_table');
});

document.querySelector('.sort_review').addEventListener("change", (e)=>{
    let table = document.querySelector('.review_table');
    let sort_by = e.target.selectedIndex;
    sortTable(table, sort_by);
});

document.querySelector('.add_order_form').addEventListener("submit", (e) => {
    const hasNumber = /\d/;     //  функція перевірки рядка на наявність цифр
    let form = e.target.elements;
    if(hasNumber.test(form.name.value)){
        alert("Невірні дані!");
        return;
    }
    let data = {};
    let name = form.name.value;
    let phone = form.phone.value;
    let email = form.email.value;
    let date = form.date.value;
    let time = form.time.value;
    let goBack = form.goBack.value;
    let passengers = form.passengers.value;
    let car = form.car.value;
    let price = form.price.value
    let done = form.done.value;
    let addresses = getAddressesTextarea(form.addresses.value);
    data["name"] = name;
    data["phone"] = phone;
    data["email"] = email;
    data["date"] = date;
    data["time"] = time;
    data["addresses"] = addresses;
    data["goBack"] = goBack;
    data["passenger_count"] = passengers;
    data["car"] = car;
    data["price"] = price;
    data["done"] = done;
    data["add_order"] = true;
    $(e.target).find("input, textarea").val("");
    e.target.goBack.value = "one";
    e.target.done.value = false;
    sendRequest(data);
});
