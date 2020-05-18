// об єкти з широтою і довготою  
let arr_obj = [];          
// кнопка розрахунку                                         
let calculate = document.querySelector('.calculate'); 
//  поле кількість пасажирів на формі розрахунків
let passenger_calc_input = document.querySelector('.passenger_calc'); 
//  поле кількість пасажирів на формі замовлення
let passenger_order_input = document.querySelector('.order_passengers');  
//  форма розрахунку                                     
let calc_form = document.querySelector('.form_calc');                                       
// ключ для отримання координатів міст                                    
let apikey_geodata = '303691d597d34232b212232cb93cba14';
// посилання для запиту (отримання координат)
let api_url = 'https://api.opencagedata.com/geocode/v1/json';
let usd = 1;         //  курс долара
let usd_tariff = 0.65;  //  загран тариф
let order = {};             //  замовлення

const hasNumber = /\d/;     //  функція перевірки рядка на наявність цифр
let calc_modal_button = document.querySelector('.results_form__button');
let calc_inputs = [];
let coords = [];
let count_of_passengers = 0;
let goBack = false;

//  функція для отримання поточного курсу долара
const getUSD =  () => {
    $.ajax({
        url: 'https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11',
        type: "GET",  
        success: function (response) {
            usd = response[0].sale * usd_tariff;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
    });
}

const makeRequestForDistances = async (query) => {
    return await fetch("https://trueway-matrix.p.rapidapi.com/CalculateDrivingMatrix?destinations="
    + encodeURIComponent(query) + 
    "&origins=" + encodeURIComponent(query), {
        "method": "GET",
        "headers": {
            "x-rapidapi-host": "trueway-matrix.p.rapidapi.com",
            "x-rapidapi-key": "07f42e69cbmshe9b66757eca013dp10519bjsn718397e16c42"
        }
    })
    .then(async response => {
        return await response.json().then(async data => {
            return await data;
        })
    })
    .catch(err => {
        console.log(err);
    });
}

//  функція отримання координат введених адрес
const getCoordinates = async (cities) => {
    for(let i = 0; i < cities.length; i++){
        // формування повної адреси запиту
        let request_url = api_url 
        + '?'
        + 'key=' + apikey_geodata
        + '&q=' + encodeURIComponent(cities[i])
        + '&pretty=1'
        + '&language=uk';
        + '&no_annotations=1';
        // запит
        await fetch(request_url)
        .then(async response => {
            // розпарсинг відповіді
            await response.json().then(response => {   
                let obj = response.results[0];
                if(obj.components["ISO_3166-1_alpha-2"] == "RU"){
                    alert("Ми не здійснюємо перевезення в Росію!");
                    arr_obj = [];
                    return null;
                }                                 
                let newObj = {
                    'lat': obj.geometry.lat, 
                    'long': obj.geometry.lng,
                    'country': obj.components["ISO_3166-1_alpha-2"]
                }
                arr_obj.push(newObj);
            })
        })
        .catch(err => {
            console.log(err);
            return null;
        })
    }
}

const formingQuery = (arr) => {
    let query = "";
    for(let i = 0; i < arr.length; i++){
        query += arr[i].lat + "," + arr[i].long + ';';                      
    }
    return query;
}

const calculatingDistance = (arr, i) => {
    return arr.distances[i][i+1] / 1000 > 0 ? (arr.distances[i][i+1] / 1000).toFixed(0) : (arr.distances[i][i+1] / 1000).toFixed(2);
}

const clearCalculatingData = () => {
    document.querySelectorAll('.form__input').forEach(el => el.value = '');  
    $('#one').prop( "checked" , true);         
    arr_obj = [];
    coords = [];
}

const CreatingResultData = (response, inputs) => {
    let from = [];
    let to = [];
    let distances = [];
    // обнулення загальної відстані
    let distance_global = 0;
    // очистка попередніх елементів 
    $('.results_distances__text').remove();
    // отримання вартості поїздки
    let price = getDistancePrice(response.distances, arr_obj, passenger_calc_input);
    for (let i = 0; i < inputs.length - 1; i++){                            
        // отримання відстані з сервера
        let distance = calculatingDistance(response, i);
        // додавання елементів в масив для подальшого опрацювання і додавання елементів
        from.push(inputs[i]);
        to.push(inputs[i+1]);
        distances.push(distance);
        // загальна відстань
        distance_global += Number(distance);
    }                                                                       
    // додавання елементів в пункті "всі дані" в модальне вікно результатів розрахунку
    insertElement(createResultElement(from, to, distances, distances.length), '.results_distances__all');

    // відображення голового шляху (від початкового місця до кінцевого)
    insertElement(createResultElement(from[0], to[to.length - 1], distance_global), '.results_distances__standard'); 
    if(inputs.length < 3){
        // приховувати кнопку "всі дані" коли пунктів тільки два
        $('.all_info').css('display', 'none');                              
    }
    else{
        $('.all_info').css('display', 'flex');
    }
    // додавання вартості 
    $('.results_price__text').html(`Сума: ${price} грн`);
}

const capitalizeInput = (el) => {
    let val = el.value;
    val = el.value.toLowerCase();
    return val.charAt(0).toUpperCase() + val.slice(1);
}

// виведення помилки та очищення масиву координат для форми "розрахунок"
const ErrorClear = () => {                                                          
    alert('Помилка! Не вірно вказані дані! Спробуйте знову!');
    passenger_calc_input.value = ""; 
    arr_obj = [];
    coords = [];
}

//  розрахунок
calc_form.addEventListener('submit', async (e) =>{
    e.preventDefault();
    let inputs = [];
    // якщо одне поле 
    if(document.querySelectorAll('.form__input').length <= 1 || Number(passenger_calc_input.value) <= 0){                   
        ErrorClear();
        return;
    }
    // формування та форматування масиву адрес
    document.querySelectorAll('.form__input').forEach((el) => {
        inputs.push(capitalizeInput(el));
    });
    count_of_passengers = Number(passenger_calc_input.value);
    calc_inputs = inputs;
    calculate.textContent = 'Розрахунок...';

    // запуск отримання координат 
    await getCoordinates(inputs).then(async ()=>{
        let query = '';
        calculate.textContent = 'Розрахувати';
        // якщо одне поле або не всі міста корректно написані
        if(arr_obj.length !== inputs.length){                
            ErrorClear();
            return;
        }
        // формування запиту
        query = formingQuery(arr_obj);
        // здійснення запиту / отримання результатів
         await makeRequestForDistances(query).then(response => {
            CreatingResultData(response, inputs); 
            modal_calc.style.display = "block";
        })
        
    }); 
    // очищення масиву координат і полів вводу
    clearCalculatingData();
});

// створення елементів з результатом для модального вікна розрахунків
const createResultElement = (from, to, distance, count = 1) => {
    let element = '';
    for(let i = 0; i < count; i++){
        element += 
            `<p class="results_distances__text">
                <span>${Array.isArray(from) ? from[i] : from}</span> 
                <span>>></span> 
                <span>${Array.isArray(to) ? to[i] : to}</span> 
                <span>:</span> 
                <span class="calc_distance">${Array.isArray(distance) ? distance[i] : distance} км.</span>
            </p>`;
    }
    return element;
}

// вирахування вартості поїздки із перевіркою на зворотній шлях
const getDistancePrice = (arr, objects, passenger_element) => {
    let price = 0;
    let count_passengers = Number(passenger_element.value);
    let uah_tariff = count_passengers <= 8 ? 7 : 10;
    let usd_bool = false;
    let uah_bool = false;
    let tariff_text = "Тариф: ";

    for(let i = 0; i < arr.length - 1; i++){
        if(objects[i+1].country !== "UA"){
            usd_bool = true;
        }
        else {
            uah_bool = true;
        }
        price += objects[i+1].country == "UA" 
        // якщо по Україні
        ? (arr[i][i+1] > 1000) ? (arr[i][i+1] / 1000).toFixed(0) * uah_tariff : uah_tariff 
        // якщо не по Україні
        : (arr[i][i+1] > 1000) ? (arr[i][i+1] / 1000).toFixed(0) * usd : usd;
    }
    if(uah_bool && usd_bool){
        //  TODO: змінити 0.65 на динамічну змінну для можливих змін
        tariff_text += `${`${usd_tariff}$/км /` + uah_tariff + ' Гривень/км'}`
    }
    else {
        tariff_text += `${usd_bool ? `${usd_tariff}$/км` : uah_tariff + ' Гривень/км'}`
    }
    //  задання тарифу 
    $('.results_tariff').text(tariff_text);
    //  очищення поля кількості пасажирів
    passenger_element.value = "";
    goBack = $('#duo').prop( "checked" ) ? true : false;
    return $('#duo').prop( "checked" ) ? price.toFixed(0) * 2 : price.toFixed(0);
}

//  вставка елементів
const insertElement = (element, appendToElement) => {
    $(element).appendTo(appendToElement);
}

const checkElementUndefined = (el) => {
    return el === undefined;
}

//  функція прокрутки слайдеру замовлення
const nextSlide = () => {
    $('.slider_container').slick('slickNext');
    var currentSlide = $('.slider_container').slick('slickCurrentSlide');
    if(currentSlide == $('.slider_container .wrap_order_request').length - 1){
        setTimeout(
            () => {
                $('.slider_container').slick("slickGoTo", 0, false);
            }, 3500
        )
    }
}

//  перевірка введених адрес в формі замовлення
const checkAddressData = async (addresses) => {
    let return_value = true; 
    
    for(let i = 0; i < addresses.length; i++){
        let request_url = api_url 
        + '?'
        + 'key=' + apikey_geodata
        + '&q=' + encodeURIComponent(addresses[i].value)
        + '&pretty=1'
        + '&language=uk';
        + '&no_annotations=1';
        // запит
        await fetch(request_url)
        .then(async response => {
            await response.json().then(data=>{
                if(data.results.length == 0){
                    return_value = false;
                }
                let obj = data.results[0];
                if(obj.components["ISO_3166-1_alpha-2"] == "RU"){
                    alert("Ми не здійснюємо перевезення в Росію!");
                }                                 
                let newObj = {
                    'lat': obj.geometry.lat, 
                    'long': obj.geometry.lng,
                    'country': obj.components["ISO_3166-1_alpha-2"]
                }
                coords.push(newObj);
            })
        })
        .catch(err => {
            return false;
        });
        if(!return_value){
            break;
        }
    }
    return return_value;
}

const getPrice = async (arr) => {
    let price = 0;
    let query = '';
    // формування запиту
    query = formingQuery(arr);
    // здійснення запиту
    return await makeRequestForDistances(query).then(response => {
        // отримання вартості поїздки
        price = getDistancePrice(response.distances, arr, passenger_order_input); 
        return price;
    })
}

//  функція перевірки на коректність поля ім'я
const checkName = (value) => {
    if(value.trim().length < 2 || hasNumber.test(value)){
        alert("Введіть коректне имя!");
        return false;
    }
    return true;
}

//  функція перевірки на коректність поля телефон
const checkPhone = (value) => {
    if(value.length !== 19){
        alert("Введіть коректний номер телефону!");
        return false;
    }
    return true;
}

//  обробник відправки форми відгуки (в модальному вікні)
document.querySelector('.form_review').addEventListener('submit', (e)=>{
    e.preventDefault();
    let name = {type:"string", value: e.target.elements.name.value};
    let email = {type:"string", value: e.target.elements.email.value};
    let review_text = {type:"string", value: e.target.elements.review.value};
    if(!checkName(name.value)){
        return;
    }
    let review = {};
    review["value"] = [name, email, review_text, {type:"number", value: 0}];
    review["insert"] = true;
    sendRequest(review);
    e.target.elements.name.value = e.target.elements.review.value = e.target.elements.email.value = "";
    $('#modal_review').css("display", "none");
});

//  обробник відправки форми замовити дзвінок (в модальному вікні)
document.querySelector('.call_form').addEventListener('submit', (e) => {
    e.preventDefault();
    let name = {type:"string", value: e.target.elements.name.value};
    let phone = {type:"string", value: e.target.elements.phone.value};
    let email = {type:"string", value: e.target.elements.email.value};
    if(!checkName(name.value)){
        return;
    }
    if(!checkPhone(phone.value)){
        return;
    }
    let call = {};
    call["value"] = [name, phone, email];
    call["insert"] = true;
    sendRequest(call);
    e.target.elements.name.value = e.target.elements.phone.value = e.target.elements.email.value = "";
    $('#modal_call').css("display", "none");
});

//  обробник відправки форми замовлення
$('.order_form').on('submit', async (e) => {
    e.preventDefault();
    let name, addresses = [], date, passengers;
    //  перевірка на першу форму (контактні дані)
    if(!checkElementUndefined(e.target.elements.name)){
        name = e.target.elements.name.value;
        if(!checkName(name)){
            return;
        }
        if(!checkPhone(e.target.elements.phone.value)){
            return;
        }
        nextSlide();
        order["name"] = name;
        order["phone"] = e.target.elements.phone.value;
        order["email"] = e.target.elements.email.value;
    }
    //  перевірка на другу форму (місця і зворотній шлях)
    else if(!checkElementUndefined(e.target.elements.address)){
        let info_addresses = [];
        addresses = document.querySelectorAll('.address');
        addresses.forEach(el=>{
            info_addresses.push(el.value);
        }) 
        $('.address_check').html("Перевірка...");
        let val = await checkAddressData(addresses);
        if(!val){
            alert('Введіть коректні пункти!');
            return;
        }
        else{
            $('.address_check').html("Далі");
            order["addresses"] = info_addresses;
            order["goBack"] = $('#duo2').prop('checked') ? 1 : 0;
            nextSlide(); 
        }
    }
    //  перевірка на третю форму (дата і час)
    else if(!checkElementUndefined(e.target.elements.date)){
        date = e.target.elements.date;
        time = e.target.elements.time;
        order["date"] = date.value;
        order["time"] = time.value;
        nextSlide();
    }
    //  перевірка на четверту форму (к-сть пасажирів)
    else if(!checkElementUndefined(e.target.elements.passengers)){
        passengers = e.target.elements.passengers;
        order["passenger_count"] = Number(passengers.value);
        $('.order_slider_car').slick('slickUnfilter');
        $('.order_slider_car').slick('slickFilter', function() {
            return $(this).data('pas') >= passengers.value;
        });
        nextSlide();
    }
    //  перевірка на п'яту форму (автопарк)
    else if(!checkElementUndefined(e.target.elements.autopark)){
        await getPrice(coords).then(price => {
            let cars = $('.order_slider_car .order_car');
            let currentSlide = $('.order_slider_car').slick('slickCurrentSlide');
            let car_name = $($(cars[currentSlide])[0].querySelector('.order_car__title'))[0].textContent;
            order["car"] = car_name;
            order["add_order"] = true;
            order["price"] = Number(order["goBack"] == 1 ? price * 2 : price);
            order["table"] = "o";
            sendRequest(order);
            $('.order_form').find("input[type=text], input[type=number], .order_email, textarea").val("");
            $('.order_slider_car').slick("slickGoTo", 0, true);
            $('#one1').prop('checked', true);
            nextSlide();
        })        
    } 
});

//  обробник переходу на форму замовлення і заповнення введених полів
calc_modal_button.addEventListener("click", () => {
    let inputs_elements = document.querySelectorAll('.order_form .address');
    for(let i = 0; i < calc_inputs.length; i++){
        inputs_elements[i].value = calc_inputs[i];
    }
    passenger_order_input.value = count_of_passengers;
    goBack ? $('#duo2').prop( "checked", true ) : $('#one1').prop( "checked", true );
    hideModal(modal_calc);
    calc_inputs = [];
});

getUSD();