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

    $(localStorage.getItem('currentTab')).click();
    $('.phone').mask('+38 (000) 000 00 00', {placeholder: "Номер телефону"});
});
// закриття меню
const CloseMenu = () => {
    $('.side_menu').toggleClass('active', false);
}

const redirect = (selector) => {
    $(selector).click(); 
    localStorage.setItem('currentTab', selector);      
}

//  очищення полів форми
const clearFormInputs = (form) => {
    $(form).find('input, textarea').val("");
    $(form).find('select').forEach(el => 
        $(el).find('option:first').prop('selected', true)
    );
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
    $('.admin_main_title').html($(e.currentTarget).data("text"));
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
        let is_showing = $(e.target).prop("checked");
        updateRequest("r", id, column, is_showing);
    })
});

document.querySelectorAll('.update_order_done').forEach(el => {
    el.addEventListener("click", (e) => {
        let form = e.target.closest('.update_order');
        let id = form.elements.id.value;
        let column = "done";
        let order_done = $(e.target).prop("checked");
        updateRequest("o", id, column, order_done);
    })
});

document.querySelectorAll('.update_car_showing').forEach(el => {
    el.addEventListener("click", (e) => {
        let form = e.target.closest('.update_car');
        let id = form.elements.id.value;
        let column = "show_car";
        let show_car = $(e.target).prop("checked");
        updateRequest("ca", id, column, show_car);
    })
});

document.querySelectorAll('.del_phone').forEach(el => {
    el.addEventListener("click", (e)=>{
        e.preventDefault();
        let id = $(e.target.closest('td')).find('.delete_form_p')[0].elements.id.value;
        $(e.target.closest('tr')).remove();
        deleteRequest(id, "c_p");
    });
});

document.querySelectorAll('.del_email').forEach(el => {
    el.addEventListener("click", (e)=>{
        e.preventDefault();
        let id = $(e.target.closest("td")).find('.delete_form_e')[0].elements.id.value;
        $(e.target.closest('tr')).remove();
        deleteRequest(id, "c_e");
    });
});

document.querySelectorAll('.del_order').forEach(el => {
    el.addEventListener("click", (e)=>{
        e.preventDefault();
        let id = $(e.target.closest('td')).find('.delete_form_o')[0].elements.id.value;
        $(e.target.closest('tr')).remove();
        deleteRequest(id, "o");
    });
});

document.querySelectorAll('.del_review').forEach(el => {
    el.addEventListener("click", (e)=>{
        e.preventDefault();
        let id = $(e.target.closest('td')).find('.delete_form_r')[0].elements.id.value;
        $(e.target.closest('tr')).remove();
        deleteRequest(id, "r");
    });
});

document.querySelectorAll('.del_call').forEach(el => {
    el.addEventListener("click", (e)=>{
        e.preventDefault();
        let id = $(e.target.closest('td')).find('.delete_form_c')[0].elements.id.value;
        $(e.target.closest('tr')).remove();
        deleteRequest(id, "c");
    });
});

document.querySelectorAll('.del_our_service').forEach(el => {
    el.addEventListener("click", (e)=>{
        e.preventDefault();
        let id = $(e.target.closest('td')).find('.delete_form_o_s')[0].elements.id.value;
        $(e.target.closest('tr')).remove();
        deleteRequest(id, "o_s");
    });
});

document.querySelectorAll('.del_p_d').forEach(el => {
    el.addEventListener("click", (e)=>{
        e.preventDefault();
        let id = $(e.target.closest('td')).find('.delete_form_p_d')[0].elements.id.value;
        $(e.target.closest('tr')).remove();
        deleteRequest(id, "p_d");
    });
});

document.querySelectorAll('.del_car').forEach(el => {
    el.addEventListener("click", (e)=>{
        e.preventDefault();
        let id = $(e.target.closest('td')).find('.delete_form_a')[0].elements.id.value;
        $(e.target.closest('tr')).remove();
        deleteRequest(id, "ca");
    });
});

$('.edit_order').on("click", (e)=>{
    let data = $(e.target).closest('tr').find(' td ');
    let id = $(e.target).nextAll(".delete_form_o:first")[0].id.value;
    let name = data[0].textContent;
    let phone = data[1].textContent;
    let email = data[2].textContent;
    let addresses = data[3].textContent;
    let goBack = data[4].textContent == "Так" ? "duo" : "one";
    let time = data[5].textContent.substring(0,5);
    let date = data[5].textContent.substring(7,17);
    let passengers = data[6].textContent;
    let car = data[7].textContent;
    let price = parseInt(data[8].textContent);
    let done = $(data[9].childNodes[1].order_done).prop("checked");
    let form = document.querySelector('.edit_order_form').elements;
    form.name.value = name;
    form.phone.value = phone;
    form.email.value = email;
    form.price.value = price;
    form.car.value = car;
    form.passengers.value = passengers;
    form.time.value = time;
    form.date.value = date;
    form.goBack.value = goBack;
    form.addresses.value = addresses;
    form.id.value = id;
    $(form.done).prop("checked", done);
});

$('.edit_car').on("click", (e)=>{
    let imgs_containter = $('.edit_car_imgs');
    let form = document.querySelector('.edit_car_form').elements;
    let data = $(e.target).closest('tr').find(' td ');
    let id = $(e.target).nextAll(".delete_form_a:first")[0].id.value;
    let name = data[0].textContent;
    let locations = data[1].textContent.replace(/\s+/g, " ").trim().split(' ');
    let passengers = data[2].textContent;
    let main_image = data[3].firstChild.src;
    let images = data[4].textContent.replace(/\s+/g, " ").trim().split(' ');
    let imgs_element = '';
    for(let i = 0; i < images.length; i++){
        imgs_element += `<img class="car_image" src="./img/${images[i]}" alt="">`;
    }
    for(let i = 0; i < locations.length; i++){
        $(`#locs option[value='${locations[i]}']`).prop('selected', true);
    }
    $(imgs_element).appendTo(imgs_containter);
    let advantages = data[5].textContent;
    let is_show = $(data[7].childNodes[1].is_showing).prop("checked");
    form.name.value = name;
    form.passengers.value = passengers;
    form.advantages.value = advantages;
    $('.edit_car_main_image').attr("src", main_image);
    form.id.value = id;
    $(form.show).prop("checked", is_show);

});

const deleteRequest = (id, table_name) => {
    let data = {};
    data["id"] = id;
    data["table"] = table_name;
    data["delete"] = true;
    sendRequest(data);
}

const updateRequest = (table_name, id, column, value, currTab="") => {
    let data = {};
    data["id"] = id;
    data["update"] = true;
    data["table"] = table_name;
    data["value"] = value;
    data["column"] = column;
    sendRequest(data, currTab);
}

const getAddressesTextarea = (str) => {    
    let split = str.split('\n');
    let lines = [];
    for (let i = 0; i < split.length; i++){
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

document.querySelector('.filter_order').addEventListener("change", (e)=>{
    e.preventDefault();
    let filter_by = e.target.value;
    filterTrByClass(filter_by, '.order_table');
});

document.querySelector('.sort_order').addEventListener("change", (e)=>{
    let table = document.querySelector('.order_table');
    let sort_by = e.target.selectedIndex;
    sortTable(table, sort_by);
});

document.querySelector('.add_order_form').addEventListener("submit", (e) => {
    e.preventDefault();
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
    let goBack = form.goBack.value == "duo" ? 1 : 0;
    let passengers =  Number(form.passengers.value);
    let car = form.car.value;
    let price = Number(form.price.value);
    let done = $(form.done).prop("checked") == true ? 1 : 0;
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
    data["table"] = "o";
    $(e.target).find("input, textarea").val("");
    e.target.goBack.value = "one";
    e.target.done.value = false;
    sendRequest(data, '#orders');
});

document.querySelector('.edit_order_form').addEventListener("submit", (e) => {
    e.preventDefault();
    const hasNumber = /\d/;     //  функція перевірки рядка на наявність цифр
    let form = e.target.elements;
    if(hasNumber.test(form.name.value)){
        alert("Невірні дані!");
        return;
    }
    let data = {};
    let id = form.id.value;
    let name = {type:"string", value: form.name.value};
    let phone = {type:"string", value: form.phone.value};
    let email = {type:"string", value: form.email.value};
    let date = {type:"string", value: form.date.value};
    let time = {type:"string", value: form.time.value};
    let goBack = {type:"number", value: form.goBack.value == "duo" ? 1 : 0};
    let passengers = {type:"number", value: form.passengers.value};
    let car = {type:"string", value: form.car.value};
    let price = {type:"number", value: Number(form.price.value)};
    let done = {type:"number", value: $(form.done).prop("checked") == true ? 1 : 0};
    let addresses = {type:"array", value: getAddressesTextarea(form.addresses.value)};
    let values = [name, phone, email, date, time, goBack, passengers, car, price, done, addresses];
    let columns = ["name", "phone", "email", "date", "time", "goBack", "passengers", "car", "price", "done", "addresses"];
    data["id"] = id;
    data["value"] = values;
    data["column"] = columns;
    data["update"] = true;
    data["table"] = "o";
    $(e.target).find("input, textarea").val("");
    e.target.goBack.value = "one";
    e.target.done.value = false;
    sendRequest(data, '#orders');
});

document.querySelector('.add_email_form').addEventListener("submit", (e) => {
    e.preventDefault();
    let data = {};
    data["insert_email"] = true;
    data["table"] = "c_e";
    data["email"] = e.target.elements.email.value;
    sendRequest(data, '#edit_contacts');
    clearFormInputs(e.target);
}); 

document.querySelector('.add_phone_form').addEventListener("submit", (e) => {
    e.preventDefault();
    let data = {};
    let social_media = "";
    let phone = e.target.elements.phone.value;
    let operator = e.target.elements.operator.value;
    let social_media_array = e.target.elements["social_media[]"].selectedOptions;
    for(let i = 0; i < social_media_array.length; i++){
        social_media += social_media_array[i].value;
        if(i < social_media_array.length - 1){
            social_media += " ";
        }
    }
    data["insert_c_p"] = true;
    data["operator"] = operator;
    data["phone"] = phone;
    data["social_media"] = social_media;
    data["table"] = "c_p";
    sendRequest(data, '#edit_contacts');
    clearFormInputs(e.target);
}); 

document.querySelector('.edit_email_form').addEventListener("submit", (e) => {
    //  послідовно задавати масив значень відповідно до таблиці
    e.preventDefault();
    let id = e.target.elements.id.value;
    //redirect('#edit_contacts');
    updateRequest("c_e", id, "email", e.target.elements.email.value, '#edit_contacts');
    clearFormInputs(e.target);
}); 

document.querySelector('.edit_phone_form').addEventListener("submit", (e) => {
    e.preventDefault();
    let data = {};
    let social_media = "";
    let phone = e.target.elements.phone.value;
    let operator = e.target.elements.operator.value;
    let social_media_array = e.target.elements["social_media[]"].selectedOptions;
    for(let i = 0; i < social_media_array.length; i++){
        social_media += social_media_array[i].value;
        if(i < social_media_array.length - 1){
            social_media += " ";
        }
    }
    data["update"] = true;
    data["id"] = e.target.elements.id.value;
    data["value"] = [{type: "string", value: phone}, {type: "string", value: operator}, {type: "string", value: social_media}]
    data["table"] = "c_p";
    sendRequest(data, '#edit_contacts');
    clearFormInputs(e.target);
}); 

document.querySelectorAll('.edit_phone').forEach(el => {
    el.addEventListener("click", (e) => {
        e.preventDefault();
        let data = $(e.target.closest('tr')).find('td');
        let id = $(data[4]).find('.delete_form_p')[0].elements.id.value;
        let phone = data[0].textContent;
        let operator = data[1].textContent;
        let social_media = data[2].textContent == "" ? " " : data[2].textContent.toLowerCase().split(" ");
        let form = document.querySelector('.edit_phone_form').elements;
        form.id.value = id;
        form.phone.value = phone;
        form.operator.value = operator.toLowerCase();
        $(form["social_media[]"]).val(social_media);
    })
});

document.querySelectorAll('.edit_email').forEach(el => {
    el.addEventListener("click", (e) => {
        e.preventDefault();
        let data = $(e.target.closest('tr')).find('td');
        let id = $(data[2]).find('.delete_form_e')[0].elements.id.value;
        let email = data[0].textContent;
        let form = document.querySelector('.edit_email_form').elements;
        form.id.value = id;
        form.email.value = email;
    })
});