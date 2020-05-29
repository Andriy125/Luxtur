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

    $(localStorage.getItem('currentTab') || '#main').click();
    $('.phone').mask('+38 (000) 000 00 00', {placeholder: "Номер телефону"});
});

const hasNumber = /\d/;     //  функція перевірки рядка на наявність цифр

// закриття меню
const CloseMenu = () => {
    $('.side_menu').toggleClass('active', false);
}

const redirect = (selector) => {
    localStorage.setItem('currentTab', selector);      
}

//  очищення полів форми
const clearFormInputs = (form) => {
    $(form).find('input, textarea').val("");
    $(form).find('select').find('option:first').prop('selected', true);
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
    if(e.target.closest('div').getAttribute('id') !== null){
        localStorage.setItem("currentTab", `#${e.target.closest('div').getAttribute('id')}`);
    }
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

const deleteRequest = (id, table_name, leaveToTab="") => {
    let data = {};
    data["id"] = id;
    data["table"] = table_name;
    data["delete"] = true;
    sendRequest(data, leaveToTab);
}

const updateRequest = (table_name, id, value, currTab="", column="", iterations=0) => {
    let data = {};
    data["id"] = id;
    data["update"] = true;
    data["table"] = table_name;
    data["value"] = value;
    if(iterations !== 0){
        data["iterations"] = iterations;
    }
    if(column !== ""){
        data["column"] = column;
    }
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

const getOperatorFromName = (operatorName) => {
    switch(operatorName){
        case "більшерівне": 
            return ">=";
        case "меньшерівне": 
            return "<=";
        case "більше": 
            return ">";
        case "меньше": 
            return "<";
        case "дорівнює": 
            return "==";
        case "недорівнює": 
            return "!=";
        default: 
            return null;
    }
}

const showSelectHideInput = (selectSelector, inputSelector, reverse=false) => {
    if(reverse){
        selectSelector.style.display = "none";
       inputSelector.style.display = "block";
        return;
    }
    selectSelector.style.display = "block";
    inputSelector.style.display = "none";
}

const eventListeners = () => {
    document.querySelectorAll('.update_review_showing').forEach(el => {
        el.addEventListener("click", (e) => {
            let form = e.target.closest('.update_review');
            let id = form.elements.id.value;
            let column = "show_review";
            let is_showing = $(e.target).prop("checked") ? 1 : 0;
            updateRequest("r", id, is_showing, "#reviews", column);
        })
    });
    
    document.querySelectorAll('.update_order_done').forEach(el => {
        el.addEventListener("click", (e) => {
            let form = e.target.closest('.update_order');
            let id = form.elements.id.value;
            let column = "done";
            let order_done = $(e.target).prop("checked") ? 1 : 0;
            updateRequest("o", id, order_done, "#orders", column);
        })
    });
    
    document.querySelectorAll('.update_car_showing').forEach(el => {
        el.addEventListener("click", (e) => {
            let form = e.target.closest('.update_car');
            let id = form.elements.id.value;
            let column = "show_car";
            let show_car = $(e.target).prop("checked") ? 1 : 0;
            updateRequest("ca", id, show_car, "#edit_autopark", column);
        })
    });
    
    document.querySelectorAll('.del_phone').forEach(el => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let id = $(e.target.closest('td')).find('.delete_form_p')[0].elements.id.value;
            $(e.target.closest('tr')).remove();
            deleteRequest(id, "c_p", "#edit_contacts");
        });
    });
    
    document.querySelectorAll('.del_email').forEach(el => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let id = $(e.target.closest("td")).find('.delete_form_e')[0].elements.id.value;
            $(e.target.closest('tr')).remove();
            deleteRequest(id, "c_e", "#edit_contacts");
        });
    });
    
    document.querySelectorAll('.del_order').forEach(el => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let id = $(e.target.closest('td')).find('.delete_form_o')[0].elements.id.value;
            $(e.target.closest('tr')).remove();
            deleteRequest(id, "o", "#orders");
        });
    });
    
    document.querySelectorAll('.del_review').forEach(el => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let id = $(e.target.closest('td')).find('.delete_form_r')[0].elements.id.value;
            $(e.target.closest('tr')).remove();
            deleteRequest(id, "r", "#reviews");
        });
    });
    
    document.querySelectorAll('.del_call').forEach(el => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let id = $(e.target.closest('td')).find('.delete_form_c')[0].elements.id.value;
            $(e.target.closest('tr')).remove();
            deleteRequest(id, "c", "#calls");
        });
    });
    
    document.querySelectorAll('.del_our_service').forEach(el => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let id = $(e.target.closest('td')).find('.delete_form_o_s')[0].elements.id.value;
            $(e.target.closest('tr')).remove();
            deleteRequest(id, "o_s", "#our_service");
        });
    });
    
    document.querySelectorAll('.del_p_d').forEach(el => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let id = $(e.target.closest('td')).find('.delete_form_p_d')[0].elements.id.value;
            $(e.target.closest('tr')).remove();
            deleteRequest(id, "p_d", "#popular_directions");
        });
    });
    
    document.querySelectorAll('.del_car').forEach(el => {
        el.addEventListener("click", (e)=>{
            e.preventDefault();
            let id = $(e.target.closest('td')).find('.delete_form_a')[0].elements.id.value;
            $(e.target.closest('tr')).remove();
            deleteRequest(id, "ca", "#edit_autopark");
        });
    });
    
    $('.edit_order').on("click", (e)=>{
        let data = $(e.target).closest('tr').find(' td ');
        let update_form = $(data[10]).find(".update_order")[0].elements;
        let id = update_form.id.value;
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
        let done = $(update_form.order_done).prop("checked");
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
        sendRequest(data, '#orders');
    });
    
    document.querySelector('.edit_order_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let form = e.target.elements;
        if(hasNumber.test(form.name.value)){
            alert("Невірні дані!");
            return;
        }
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
        let addresses = {type:"string", value: getAddressesTextarea(form.addresses.value).join(' -> ')};
        let values = [name, phone, email, addresses, goBack, date, time, passengers, car, price, done];
        updateRequest("o", id, values, '#orders');
    });
    
    document.querySelector('.add_email_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let data = {};
        data["insert"] = true;
        data["table"] = "c_e";
        data["value"] = e.target.elements.email.value;
        sendRequest(data, '#edit_contacts');
    }); 
    
    document.querySelector('.add_phone_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let data = {};
        let social_media = "";
        let phone = {type: "string", value: e.target.elements.phone.value};
        let operator = {type: "string", value: e.target.elements.operator.value};
        let social_media_array = e.target.elements["social_media[]"].selectedOptions;
        for(let i = 0; i < social_media_array.length; i++){
            social_media += social_media_array[i].value;
            if(i < social_media_array.length - 1){
                social_media += " ";
            }
        }
        let soc_media = {type: "string", value: social_media};
        data["insert"] = true;
        data["value"] = [phone, operator, soc_media];
        data["table"] = "c_p";
        sendRequest(data, '#edit_contacts');
    }); 
    
    document.querySelector('.edit_email_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let id = e.target.elements.id.value;
        let email = e.target.elements.email.value;
        updateRequest("c_e", id, email, '#edit_contacts', "email");
    }); 
    
    document.querySelector('.edit_phone_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let social_media = "";
        let phone = {type: "string", value: e.target.elements.phone.value};
        let operator = {type: "string", value: e.target.elements.operator.value};
        let social_media_array = e.target.elements["social_media[]"].selectedOptions;
        for(let i = 0; i < social_media_array.length; i++){
            social_media += social_media_array[i].value;
            if(i < social_media_array.length - 1){
                social_media += " ";
            }
        }
        let soc_media = {type: "string", value: social_media}
        const id = e.target.elements.id.value;
        const values = [phone, operator, soc_media];
        updateRequest("c_p", id, values, '#edit_contacts');
    }); 
    
    document.querySelectorAll('.edit_phone').forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault();
            let data = $(e.target.closest('tr')).find('td');
            let id = $(data[4]).find('.delete_form_p')[0].elements.id.value;
            let phone = data[0].textContent;
            let operator = data[1].textContent;
            let social_media = data[2].textContent.trim() == "" ? " " : data[2].textContent.toLowerCase().split(" ");
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
    
    document.querySelectorAll('.edit_review').forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault();
            let data = $(e.target.closest('tr')).find('td');
            let update_form = $(data[4]).find('.update_review')[0].elements;
            let id = update_form.id.value;
            let name = data[0].textContent;
            let email = data[1].textContent;
            let review = data[2].textContent.slice(1,-1);
            let show_review = $(update_form.is_showing).prop('checked');
            let form = document.querySelector('.edit_review_form').elements;
            form.id.value = id;
            form.email.value = email;
            form.name.value = name;
            form.review.value = review;
            $(form.show_review).prop("checked", show_review);
        })
    });
    
    document.querySelector('.edit_review_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let email = {type:"string", value: e.target.elements.email.value};
        let id = e.target.elements.id.value;
        let name = {type:"string", value: e.target.elements.name.value};
        let review = {type:"string", value: e.target.elements.review.value};
        let show_review = {type:"number", value: $(e.target.elements.show_review).prop("checked") ? 1 : 0};
        const values = [name, email, review, show_review];
        updateRequest("r", id, values, '#reviews');
    }); 
    
    document.querySelector('.add_review_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let data = {};
        let email = {type:"string", value: e.target.elements.email.value};
        let name = {type:"string", value: e.target.elements.name.value};
        let review = {type:"string", value: e.target.elements.review.value};
        let show_review = {type:"number", value: $(e.target.elements.show_review).prop("checked") ? 1 : 0};
        data["insert"] = true;
        data["value"] = [name, email, review, show_review];
        data["table"] = "r";
        sendRequest(data, '#reviews');
    }); 
    
    document.querySelectorAll('.edit_o_s').forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault();
            let data = $(e.target.closest('tr')).find('td');
            console.log(data);
            let id = $(data[4]).find('.delete_form_o_s')[0].elements.id.value;
            let title = data[1].textContent;
            let text = data[2].textContent;
            let img_url = $(data[0].firstChild).prop("src");
            let form = document.querySelector('.edit_our_service_form').elements;
            form.id.value = id;
            form.text.value = text;
            form.title.value = title;
            $('.e_o_s_img').prop("src", img_url);
        })
    });
    
    document.querySelectorAll('.edit_p_d').forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault();
            let data = $(e.target.closest('tr')).find('td');
            let id = $(data[3]).find('.delete_form_p_d')[0].elements.id.value;
            let text = data[1].textContent;
            let img = $(data[0].firstChild).prop("src");
            $('.edit_p_d_img').prop("src", img);
            let form = document.querySelector('.edit_review_form').elements;
            form.id.value = id;
            form.text.value = text;
        })
    });
    
    document.querySelector('.edit_call_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let id = e.target.elements.id.value;
        let email = {type:"string", value: e.target.elements.email.value};
        let name = {type:"string", value: e.target.elements.name.value};
        let phone = {type:"string", value: e.target.elements.phone.value};
        let values = [name, phone, email];
        updateRequest("c", id, values, '#calls');
    }); 
    
    document.querySelector('.add_call_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let data = {};
        let email = {type:"string", value: e.target.elements.email.value};
        let name = {type:"string", value: e.target.elements.name.value};
        let phone = {type:"string", value: e.target.elements.phone.value};
        data["insert"] = true;
        data["value"] = [name, phone, email];
        data["table"] = "c";
        sendRequest(data, '#calls');
    }); 
    
    document.querySelectorAll('.edit_call').forEach(el => {
        el.addEventListener("click", (e) => {
            let data = $(e.target.closest('tr')).find('td');
            let id = $(data[4]).find('.delete_form_c')[0].elements.id.value;
            let name = data[0].textContent;
            let phone = data[1].textContent;
            let email = data[2].textContent;
            let form = document.querySelector('.edit_call_form').elements;
            form.id.value = id;
            form.name.value = name;
            form.phone.value = phone;
            form.email.value = email;
        });
    });

    document.querySelector('.edit_price_form').addEventListener("submit", (e) => {
        e.preventDefault();
        const value = e.target.elements.tariff.value;
        const condition_tariff = e.target.elements.condition_tariff.value.trim();
        if(!$.isNumeric(value) || (condition_tariff !== "" && !$.isNumeric(condition_tariff))){
            alert("Некоректне значення! Введіть число!");
            return;
        }
        const condition_parametr = e.target.elements.condition_parametr.value.trim();
        const operator = e.target.elements.operator.value.trim();
        const condition_value = e.target.elements.condition_value.value.trim();
        let condition = "";
        if( condition_parametr !== "" && operator !== "" && condition_value !== ""){
            condition = `${condition_parametr} ${operator} ${condition_value}`;
        }
        const name = e.target.elements.currency_name.value;
        const newName = {type: "string", value: name};
        const newTariff = {type: "number", value: Number(value)};
        const newConditionTariff = {type: "string", value: Number(condition_tariff).toFixed(2)};
        const newCondition = {type: "string", value: condition};
        const id = e.target.elements.id.value;
        const values = [newName, newTariff, newConditionTariff, newCondition];
        console.log(values);
        updateRequest("p", id, values, '#prices');
    });

    document.querySelectorAll('.del_price').forEach(el => {
        el.addEventListener("click", (e) => {
            const id = $(e.target.closest('td')).find('.delete_form_p')[0].elements.id.value;
            deleteRequest(id, "p", "#prices");
        });
    });

    document.querySelectorAll('.edit_price').forEach(el => {
        el.addEventListener("click", (e) => {
            const id = $(e.target.closest('td')).find('.delete_form_p')[0].elements.id.value;
            const data = $(e.target.closest('tr')).find('td');
            const name = data[0].textContent;
            const tariff = data[1].textContent;
            
            let form = document.querySelector('.edit_price_form').elements;
            let conditionArray = data[2].textContent.trim().split(" ");
            const conditionName = conditionArray[0] ?? " ";
            const conditionOperator = conditionArray[1] ?? " ";
            let endOfCondition = "";
            for(let i = 2; i < conditionArray?.length ?? 2; i++){
                endOfCondition += `${conditionArray[i]} `;
            }
            const conditionValue = endOfCondition ?? "";

            const conditionTariff = data[3].textContent == 0 ? "" : data[3].textContent;
            form.id.value = id;
            form.currency_name.value = name;
            form.tariff.value = tariff;
            if(conditionName.trim() == "" || conditionOperator.trim() == ""){
                form.condition_parametr.selectedIndex = 0;
                form.operator.selectedIndex = 0;
            }
            else{
                form.condition_parametr.value = conditionName;
                form.operator.value = getOperatorFromName(conditionOperator);
            }
            form.condition_value.value = conditionValue.trim();
            form.condition_tariff.value = conditionTariff.trim();    
        });
    });

    document.querySelector('.add_price_form').addEventListener("submit", (e) => {
        e.preventDefault();
        const value = e.target.elements.tariff.value;
        const condition_tariff = e.target.elements.condition_tariff.value.trim();
        if(!$.isNumeric(value) || (condition_tariff !== "" && !$.isNumeric(condition_tariff))){
            alert("Некоректне значення! Введіть число!");
            return;
        }
        let data = {};
        const condition_parametr = e.target.elements.condition_parametr.value.trim();
        const operator = e.target.elements.operator.value.trim();
        const condition_value = e.target.elements.condition_value.value.trim();
        let condition = "";
        if( condition_parametr !== "" && operator !== "" && condition_value !== ""){
            condition = `${condition_parametr} ${operator} ${condition_value}`;
        }
        const name = e.target.elements.currency_name.value;
        const newName = {type: "string", value: name};
        const newTariff = {type: "number", value: Number(value)};
        const newConditionTariff = {type: "number", value: Number(condition_tariff)};
        const newCondition = {type: "string", value: condition};
        data["table"] = "p";
        data["value"] = [newName, newTariff, newConditionTariff, newCondition];
        data["insert"] = true;
        sendRequest(data, '#prices');
    });

    document.querySelector('.add_user_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let data = {};
        data["c_user"] = true;
        data["email"] = e.target.elements.email.value;
        data["pass"] = e.target.elements.pass.value;
        sendRequest(data, "#users");
    });

    document.querySelectorAll('.del_u').forEach(el => {
        el.addEventListener("click", (e) => {
            const id = $(e.target.closest('td')).find('.delete_form_u')[0].elements.id.value;
            deleteRequest(id, "u", "#users");
        });
    });

    document.querySelectorAll('.edit_user').forEach(el => {
        el.addEventListener("click", (e) => {
            const data = $(e.target.closest('tr')).find('td');
            const id = $(data[2]).find('.delete_form_u')[0].elements.id.value;
            const email = data[0].textContent;
            let form = document.querySelector('.edit_user_form').elements;
            form.id.value = id; 
            form.email.value = email; 
        })
    });

    document.querySelector('.edit_user_form').addEventListener("submit", (e) => {
        e.preventDefault();
        let data = {};
        data["id"] = e.target.elements.id.value;
        data["e_user"] = true;
        data["email"] = e.target.elements.email.value;
        data["pass"] = e.target.elements.pass.value;
        sendRequest(data, "#users");
    });

}

eventListeners();