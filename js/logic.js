// об єкти з широтою і довготою  
let arr_obj = [];          
// кнопка розрахунку                                                                                                                                      
let calculate = document.querySelector('.calculate');  
//  форма розрахунку                                     
let calc_form = document.querySelector('.form_calc');                                       
// ключ для отримання координатів міст                                    
let apikey_geodata = '303691d597d34232b212232cb93cba14';
// посилання для запиту (отримання координат)
let api_url = 'https://api.opencagedata.com/geocode/v1/json';
let order = {};             //  замовлення
let usd_tariff = 1;         //  курс долара
const hasNumber = /\d/;     //  функція перевірки рядка на наявність цифр

//  функція для отримання поточного курсу долара
const getUSD = async () => {
    await fetch('https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11').then(response => {
        response.json().then(response => {
            usd_tariff = response[0].sale * 0.65;
        });
    })
}

getUSD();

//  функція отримання координат введених адрес
const getCoordinates = async (cities) => {
    let objs = [];
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
    return objs;
}

// виведення помилки та очищення масиву координат для форми "розрахунок"
const ErrorClear = () => {                                                          
    alert('Помилка! Не вірно вказані дані! Спробуйте знову!');
    document.querySelector('.passenger_calc')[0].value = ""; 
    arr_obj = [];
}
//  розрахунок
calc_form.addEventListener('submit', async (e) =>{

    e.preventDefault();
    let inputs = [];
    // якщо одне поле 
    if(document.querySelectorAll('.form__input').length <= 1 || Number($('.passenger_calc')[0].value) <= 0){                      
        ErrorClear();
        return;
    }
    // формування та форматування масиву адрес для подальшого використання
    document.querySelectorAll('.form__input').forEach((el) => {
        let val = el.value;
        val = el.value.toLowerCase();
        inputs.push(val.charAt(0).toUpperCase() + val.slice(1));
    });

    calculate.textContent = 'Розрахунок...';

    // запуск отримання координат 
    arr_obj = await getCoordinates(inputs).then(async ()=>{
        let query = '';
        calculate.textContent = 'Розрахувати';
        // якщо одне поле або не всі міста корректно написані
        if(arr_obj.length !== inputs.length){      
            console.log(111);                                    
            ErrorClear();
            return;
        }
        // формування запиту
        for(let i = 0; i < arr_obj.length; i++){
            query += arr_obj[i].lat + "," + arr_obj[i].long + ';';                      
        }
        // здійснення запиту
        await fetch("https://trueway-matrix.p.rapidapi.com/CalculateDrivingMatrix?destinations="
        + encodeURIComponent(query) + 
        "&origins=" + encodeURIComponent(query), {
            "method": "GET",
            "headers": {
                "x-rapidapi-host": "trueway-matrix.p.rapidapi.com",
                "x-rapidapi-key": "07f42e69cbmshe9b66757eca013dp10519bjsn718397e16c42"
            }
        })
        // отримання результатів
        .then(async response => {
            await response.json().then(response => {
                let from = [];
                let to = [];
                let distances = [];
                // обнулення загальної відстані
                let distance_global = 0;
                // очистка попередніх елементів 
                $('.results_distances__text').remove();
                // отримання вартості поїздки
                let price = getDistancePrice(response.distances, arr_obj);
                for (let i = 0; i < inputs.length - 1; i++){                            
                    // отримання відстані з сервера
                    let distance = response.distances[i][i+1] / 1000 > 0 ? (response.distances[i][i+1] / 1000).toFixed(0) : (response.distances[i][i+1] / 1000).toFixed(2);
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
                modal_calc.style.display = "block";
            })
        })
        .catch(err => {
            console.log(err);
        });
    }); 
    
    // очищення масиву координат і полів вводу
    document.querySelectorAll('.form__input').forEach(el => el.value = '');            
    arr_obj = [];
});

// створення елементів з результатом
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
const getDistancePrice = (arr, objects) => {
    let price = 0;
    let count_passengers = Number($('.passenger_calc')[0].value);
    let uah_tariff = count_passengers <= 8 ? 7 : 10;
    
    let usd_bool = false;
    let uah_bool = false;
    let tariff_text = "Тариф: ";

    for(let i = 0; i < arr.length; i++){
        if(i + 1 === arr.length){
            break;
        }
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
        : (arr[i][i+1] > 1000) ? (arr[i][i+1] / 1000).toFixed(0) * usd_tariff : usd_tariff;
    }
    if(uah_bool && usd_bool){
        tariff_text += `${'0.65$/км + ' + uah_tariff + ' Гривень/км'}`
    }
    else {
        tariff_text += `${usd_bool ? '0.65$/км' : uah_tariff + ' Гривень/км'}`
    }
    $('.results_tariff').text(tariff_text);
    $('.passenger_calc')[0].value= "";
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
            })
        })
        .catch(err => {
            return false;
        });
    }
    return return_value;
}

//  функція відправлення запиту
const sendRequest = (url, order) => {
    $.ajax({
        url: `/${url}`,
        type: "POST",
        data: JSON.parse(JSON.stringify(order)),    
        success: function (response) {
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
    });
}

//  функція перевірки на коректність поля ім'я
const checkName = (value) => {
    if(value.trim().length < 2 || hasNumber.test(value)){
        alert("Введіть коректне имя!");
        return;
    }
}

//  функція перевірки на коректність поля телефон
const checkPhone = (value) => {
    if(value.length !== 19){
        alert("Введіть коректний номер телефону!");
        return;
    }
}

//  обробник відправки форми відгуки (в модальному вікні)
document.querySelector('.form_review').addEventListener('submit', (e)=>{
    e.preventDefault();
    name = e.target.elements.name.value;
    checkName(name);
    let review = {};
    review["name"] = name;
    review["email"] = e.target.elements.email.value;
    review["review"] = e.target.elements.review.value;
    sendRequest("review_api.php", review);
    e.target.elements.name.value = e.target.elements.review.value = e.target.elements.email.value = "";
    $('#modal_review').css("display", "none");
});

//  обробник відправки форми замовити дзвінок (в модальному вікні)
document.querySelector('.call_form').addEventListener('submit', (e) => {
    e.preventDefault();
    name = e.target.elements.name.value;
    checkName(name);
    checkPhone(e.target.elements.phone.value);
    let call = {};
    call["name"] = name;
    call["phone"] = e.target.elements.phone.value;
    call["email"] = e.target.elements.email.value;
    sendRequest("orderCall_api.php", call);
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
        checkName(name);
        checkPhone(e.target.elements.phone.value);
        nextSlide();
        order["name"] = name;
        order["phone"] = e.target.elements.phone.value;
        order["email"] = e.target.elements.email.value;
    }
    //  перевірка на другу форму (місця і зворотній шлях)
    else if(!checkElementUndefined(e.target.elements.address)){
        let info_address = [];
        addresses = document.querySelectorAll('.address');
        $('.address_check').html("Перевірка...");
        let correct_addresses = await checkAddressData(addresses);
        $('.address_check').html("Далі");
        if(!correct_addresses){
            alert('Введіть коректні пункти!');
            return;
        }
        addresses.forEach(el=>{
            info_address.push(el.value);
        })
        order["addresses"] = info_address;
        order["goBack"] = $('#duo2').prop('checked');
        nextSlide();     
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
        nextSlide();
    }
    //  перевірка на п'яту форму (автопарк)
    else if(!checkElementUndefined(e.target.elements.autopark)){
        let cars = $('.order_slider_car .order_car');
        let currentSlide = $('.order_slider_car').slick('slickCurrentSlide');
        let car_name = $($(cars[currentSlide])[0].querySelector(' .order_car__title'))[0].textContent;
        order["car"] = car_name;
        sendRequest("order_api.php", order);
        $('.order_form').find("input[type=text], input[type=number], .order_email, textarea").val("");
        $('.order_slider_car').slick("slickGoTo", 0, true);
        $('#one1').prop('checked', true);
    } 
});