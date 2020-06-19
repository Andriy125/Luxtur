// objects with coordinates of entered addresses
let arr_obj = [];          
// calculate button                                        
let calculate = document.querySelector('.calculate'); 
//  passenger count element on calculate form
let passenger_calc_input = document.querySelector('.passenger_calc'); 
//  passenger count element on order form
let passenger_order_input = document.querySelector('.order_passengers');  
//  calculate form                                    
let calc_form = document.querySelector('.form_calc');                                       
// apikey for getting coords of addresses                                    
let apikey_geodata = '303691d597d34232b212232cb93cba14';
// url for getting coords
let api_url = 'https://api.opencagedata.com/geocode/v1/json';
let usd = 1;         //  dollar cost
let order = {};      //  order object

const hasNumber = /\d/;     //  regular expression for checking numbers in string
//  calculate button on results modal window
let calc_modal_button = document.querySelector('.results_form__button');
//  inputs entered into calculate form
let calc_inputs = [];
//  array of coords for check address inputs on order form
let coords = [];
//  count of passengers
let count_of_passengers = 0;
//  checkbox value for saving goBack value
let goBack = false;


const makeTariffObject = (currency) => {
    //  make object of certain currency based on all data from database
	let tariffObject = {};
    for(let i = 0; i < prices.length; i++){
        if(prices[i]["name"] == currency && prices[i]["value"] != null){
            //  take tariff for currency and store it into object
            tariffObject.tariff = Number(prices[i]["value"]);
            if(prices[i]["condition_"].trim() != ""){
                //  if condition isn't null we need to decompose last
                const {conditionName, operator, conditionValue} = decomposeCondition(prices[i]["condition_"]);
                tariffObject.conditionName = conditionName;
                tariffObject.operator = operator;
                tariffObject.conditionValue = conditionValue;
                tariffObject.conditionTariff = Number(prices[i]["value_2"]);
            }
        }
    }
    return tariffObject;
}

const getEndOfConditionArray = (arr) => {
    //  get the last parts of the condition's end 
    //  (because condition has three part of itselve: condition, operator and condition value,
    //  the last one can store not 1 part and we need to combine it )
    let conditionValue = "";
    for(let i = 2; i < arr.length; i++){
        conditionValue += `${arr[i]} `;
    }
    return conditionValue.trim();
}

const decomposeCondition = (conditionString) => {
    //  decomposing condition to 3 parts: condition, operator and condition value
    const decomposedValues = {};
    const condiotionParts = conditionString.split(" ");
    decomposedValues.conditionName = condiotionParts[0];
    decomposedValues.operator = condiotionParts[1];
    decomposedValues.conditionValue = getEndOfConditionArray(condiotionParts);
    return decomposedValues;
}

const getUSD =  () => {
    //  getting current dollar cost from privatbank
    $.ajax({
        url: 'https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11',
        type: "GET",  
        success: function (response) {
            usd = Number(response[0].sale).toFixed(2);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
    });
}

const getOperatorFunction = (operator) => {
    //  return function for comparing entered value with condition and return correct tariff
    switch(operator){
        case ">":
            return function(currentValue, tariffObject){
                return currentValue > tariffObject.conditionValue 
                ? tariffObject.conditionTariff 
                : tariffObject.tariff;
            }
        case "<":
            return function(currentValue, tariffObject){
                return currentValue < tariffObject.conditionValue 
                ? tariffObject.conditionTariff 
                : tariffObject.tariff;
            }
        case "==":
            return function(currentValue, tariffObject){
                return currentValue == tariffObject.conditionValue 
                ? tariffObject.conditionTariff 
                : tariffObject.tariff;
            }
        case ">=":
            return function(currentValue, tariffObject){
                return currentValue >= tariffObject.conditionValue 
                ? tariffObject.conditionTariff 
                : tariffObject.tariff;
            }
        case "<=":
            return function(currentValue, tariffObject){
                return currentValue <= tariffObject.conditionValue 
                ? tariffObject.conditionTariff 
                : tariffObject.tariff;
            }
        case "!=":
            return function(currentValue, tariffObject){
                return currentValue != tariffObject.conditionValue 
                ? tariffObject.conditionTariff 
                : tariffObject.tariff;
            }
    }
}

const getCarName = () => {
    //  getting car name from order form

    //  get car slider form
    const cars = $('.order_slider_car .order_car');
    //  get current slider
    const currentSlide = $('.order_slider_car').slick('slickCurrentSlide');
    //  get car name
    const car_name = $($(cars[currentSlide])[0].querySelector('.order_car__title'))[0].textContent;
    return car_name;
}

const getTariff = (tariffObject, passengerElement=null) => {
    //  returning correct tariff
    //  first check tariff object for condition
    //  then get compare function and return tariff depended on compare result
    if((tariffObject?.conditionName ?? null) == null) return tariffObject.tariff;
    if(tariffObject.conditionName.toLowerCase() == "пасажири")
    {
        const getTariffFunction = getOperatorFunction(tariffObject.operator);
        const currentValue = Number(passengerElement?.value) ?? null;
        if(currentValue == null) return tariffObject.tariff;
        return getTariffFunction(currentValue, tariffObject);
    }
    else{
        return tariffObject.tariff;
    }
}

const makeRequestForDistances = async (query) => {
    //  making request to api for distances between entered addresses
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

const getCoordinates = async (cities) => {
    //  getting coords of entered values
    for(let i = 0; i < cities.length; i++){
        // forming full request url
        let request_url = api_url 
        + '?'
        + 'key=' + apikey_geodata
        + '&q=' + encodeURIComponent(cities[i])
        + '&pretty=1'
        + '&language=uk';
        + '&no_annotations=1';
        // making request
        await fetch(request_url)
        .then(async response => {
            // getting object with results
            await response.json().then(response => {  
                //  make first resulted object
                let obj = response.results[0];
                //  if city in russia - return
                if(obj.components["ISO_3166-1_alpha-2"] == "RU"){
                    alert("Ми не здійснюємо перевезення в Росію!");
                    //  clear array with coords
                    arr_obj = [];
                    return null;
                }
                //  if all is alright making object for pushing into array with coords                                
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
    //  forming query for request based on entered data
    let query = "";
    for(let i = 0; i < arr.length; i++){
        query += arr[i].lat + "," + arr[i].long + ';';                      
    }
    return query;
}

const calculatingDistance = (arr, i) => {
    //  if distance less than 1km return 1km else return distance 
    return arr.distances[i][i+1] / 1000 > 0 ? (arr.distances[i][i+1] / 1000).toFixed(0) : (arr.distances[i][i+1] / 1000).toFixed(2);
}

const clearCalculatingData = () => {
    //  clearing entered data, checkbox and coords arrays
    document.querySelectorAll('.form__input').forEach(el => el.value = '');  
    $('#one').prop( "checked" , true);         
    arr_obj = [];
    coords = [];
}

const CreatingResultData = (response, inputs) => {
    //  creating result elements for modal window

    let from = [];  //  array for 'from' addresses
    let to = [];    //  array for 'to' addresses
    let distances = [];   //    array for distances between addresses
    // zeroing global distance
    let distance_global = 0;
    // removing previous result elements 
    $('.results_distances__text').remove();
    // getting price of trip
    let price = getDistancePrice(response.distances, arr_obj, passenger_calc_input);
    for (let i = 0; i < inputs.length - 1; i++){                            
        // getting distance 
        let distance = calculatingDistance(response, i);
        // forming arrays with data for future creating html elements
        from.push(inputs[i]);
        to.push(inputs[i+1]);
        distances.push(distance);
        // adding distance to global distance of the trip
        distance_global += Number(distance);
    }                                                                       
    // creating and inserting result elements into additional info (all data) in calculation result modal
    insertElement(createResultElement(from, to, distances, distances.length), '.results_distances__all');
    // creating and inserting global distance of the trip
    insertElement(createResultElement(from[0], to[to.length - 1], distance_global), '.results_distances__standard'); 
    if(inputs.length < 3){
        // if addresess less than 2 - hide all info 
        $('.all_info').css('display', 'none');                              
    }
    else{
        $('.all_info').css('display', 'flex');
    }
    //  showing total price of the trip
    $('.results_price__text').html(`Сума: ${price} грн`);
}

const capitalizeInput = (el) => {
    //  make first letter uppercased
    return `${el.value.charAt(0).toUpperCase()}${el.value.slice(1).toLowerCase()}`;
}

const ErrorClear = () => {    
    //  showing error and clearing important arrays                                                      
    alert('Помилка! Не вірно вказані дані! Спробуйте знову!');
    passenger_calc_input.value = ""; 
    arr_obj = [];
    coords = [];
}

calc_form.addEventListener('submit', async (e) =>{
    //  calculating form handler
    e.preventDefault();     //  disable default behaviour
    let inputs = [];        //  declare local array of entered addresses
    if(document.querySelectorAll('.form__input').length <= 1 || Number(passenger_calc_input.value) <= 0){  
        //  throw an error if addresses are 1 or passengers not more than 0                 
        ErrorClear();
        return;
    }
    // forming addresses 
    document.querySelectorAll('.form__input').forEach((el) => {
        inputs.push(capitalizeInput(el));
    });
    count_of_passengers = Number(passenger_calc_input.value);   //  storing count of passengers
    calc_inputs = inputs;                                       
    calculate.textContent = 'Розрахунок...';                    //  changing title of next button before calculations

    // getting coords 
    await getCoordinates(inputs).then(async ()=>{
        let query = '';
        calculate.textContent = 'Розрахувати';                  //  changing title of next button after calculations
        if(arr_obj.length !== inputs.length){  
            //  throw an error if something went wrong and someone address was wrong or timeouted              
            ErrorClear();
            return;
        }
        // forming query based on coords
        query = formingQuery(arr_obj);
        // making request and getting response object
         await makeRequestForDistances(query).then(response => {
            //  starting creating result elements and calculating total price of the trip
            CreatingResultData(response, inputs); 
            //  show the calculation results modal window
            modal_calc.style.display = "block";
        })
        
    }); 
    // affter everithin clear the stored data
    clearCalculatingData();
});

const createResultElement = (from, to, distance, count = 1) => {
    //  creating elements based on from-to addresses and distance between last ones
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

const getDistancePrice = (arr, objects, passenger_element) => {
    //  getting price of the trip based on tariff
    //  setting tariff text
    let price = 0;
    let usdTariffObject = makeTariffObject("usd");  //  usd tariff
    let uahTariffObject = makeTariffObject("uah");  //  uah tariff  
    const graivnaTariff = Number(getTariff(uahTariffObject, passenger_element));
    const usdTariff = Number(getTariff(usdTariffObject, passenger_element)).toFixed(2);
    const usdPerKM = (usdTariff * usd).toFixed(2);
    let usd_bool = false;
    let uah_bool = false;
    let tariff_text = "Тариф: ";

    for(let i = 0; i < arr.length - 1; i++){
        if(objects[i+1].country !== "UA"){
            //  if we move to non ukraine country make usd tariff
            usd_bool = true;
            price += (arr[i][i+1] > 1000) ? (arr[i][i+1] / 1000).toFixed(0) * usdPerKM : usdPerKM;
        }
        else {
            //  if we move to ukraine country make uah tariff
            uah_bool = true;
            price += (arr[i][i+1] > 1000) ? (arr[i][i+1] / 1000).toFixed(0) * graivnaTariff : graivnaTariff;
        }
    }
    //  create tariff text
    if(uah_bool && usd_bool){
        tariff_text += `${`${usdTariff}$/км / ` + graivnaTariff + ' Гривень/км'}`;
    }
    else {
        tariff_text += `${usd_bool ? `${usdTariff}$/км` : graivnaTariff + ' Гривень/км'}`;
    }
    //  set tariff text
    $('.results_tariff').text(tariff_text);
    //  clearing passenger count element
    passenger_element.value = "";
    //  saving goBack option
    goBack = $('#duo').prop( "checked" ) ? true : false;
    return $('#duo').prop( "checked" ) ? price.toFixed(0) * 2 : price.toFixed(0);
}

const insertElement = (element, appendToElement) => {
    //  inserting text element to element
    $(element).appendTo(appendToElement);
}

const checkElementUndefined = (el) => {
    //  checking value to undefined
    return el === undefined;
}

const nextSlide = () => {
    //  show next slider on order form 
    $('.slider_container').slick('slickNext');
    //  get current slider (after changing)
    var currentSlide = $('.slider_container').slick('slickCurrentSlide');
    if(currentSlide == $('.slider_container .wrap_order_request').length - 1){
        //  if current slider is the last one, move to start
        setTimeout(
            () => {
                //  move to start with animation
                $('.slider_container').slick("slickGoTo", 0, false);
            }, 3500
        )
    }
}

const checkAddressData = async (addresses) => {
    //  getting, checking on correct and saving coords of entered value on order form
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
                    //  if count of results is 0, entered incorrect value
                    return_value = false;
                }
                //  take first result object
                let obj = data.results[0];
                if(obj.components["ISO_3166-1_alpha-2"] == "RU"){
                    //  country check
                    alert("Ми не здійснюємо перевезення в Росію!");
                    return false;
                }
                //  making object with needed parameters                                 
                let newObj = {
                    'lat': obj.geometry?.lat, 
                    'long': obj.geometry?.lng,
                    'country': obj?.components["ISO_3166-1_alpha-2"]
                }
                //  pushing correct object
                coords.push(newObj);
            })
        })
        .catch(err => {
            return false;
        });
        if(return_value == false){
            //  if some value is incorrect break of loop
            break;
        }
    }
    return return_value;
}

const getPrice = async (arrayCoordObjects) => {
    //  getting price for order form
    let query = '';
    // forming query for request
    query = formingQuery(arrayCoordObjects);
    // making request
    return await makeRequestForDistances(query).then(response => {
        // getting price of the trip
        return getDistancePrice(response.distances, arrayCoordObjects, passenger_order_input); 
    })
}

const checkName = (value) => {
    //  check name value on order form
    if(value.trim().length < 2 || hasNumber.test(value)){
        return false;
    }
    return true;
}

const checkPhone = (value) => {
    //  check phone value on order form
    if(value.length !== 19){
        return false;
    }
    return true;
}

document.querySelector('.form_review').addEventListener('submit', (e)=>{
    //  handler of send review form (modal window)
    e.preventDefault();
    let name = {type:"string", value: e.target.elements.name.value};
    let email = {type:"string", value: e.target.elements.email.value};
    let review_text = {type:"string", value: e.target.elements.review.value};
    if(!checkName(name.value)){
        alert("Введіть коректне имя!");
        return;
    }
    let review = {};
    //  forming array of values for server 
    review["value"] = [name, email, review_text, {type:"number", value: 0}];
    review["insert"] = true;
    //  send request to server
    sendRequest(review);
    //  clear inputs
    e.target.elements.name.value = e.target.elements.review.value = e.target.elements.email.value = "";
    //  hide modal window after form submitting
    $('#modal_review').css("display", "none");
});

document.querySelector('.call_form').addEventListener('submit', (e) => {
    //  handler for submitting form for ordering call (modal window)
    e.preventDefault();
    let name = {type:"string", value: e.target.elements.name.value};
    let phone = {type:"string", value: e.target.elements.phone.value};
    let email = {type:"string", value: e.target.elements.email.value};
    if(!checkName(name.value)){
        alert("Введіть коректне имя!");
        return;
    }
    if(!checkPhone(phone.value)){
        alert("Введіть коректний номер телефону!");
        return;
    }
    let call = {};
    call["value"] = [name, phone, email];
    call["insert"] = true;
    //  send request to server
    sendRequest(call);
    //  clear inputs
    e.target.elements.name.value = e.target.elements.phone.value = e.target.elements.email.value = "";
    //  hide modal window after form submitting
    $('#modal_call').css("display", "none");
});

$('.order_form').on('submit', async (e) => {
    //  handler of order form
    e.preventDefault();

    //  check is it a first block of order form (contacts)
    if(!checkElementUndefined(e.target.elements.name)){    
        const name = e.target.elements.name.value;
        if(!checkName(name)){
            alert("Введіть коректне имя!");
            return;
        }
        if(!checkPhone(e.target.elements.phone.value)){
            alert("Введіть коректний номер телефону!");
            return;
        }
        nextSlide();
        order["name"] = name;
        order["phone"] = e.target.elements.phone.value;
        order["email"] = e.target.elements.email.value;
    }
    //  check is it a second block of order form (addresses and goBack checkbox)
    else if(!checkElementUndefined(e.target.elements.address)){
        let info_addresses = [];
        //  getting elements of addresses
        const addresses = document.querySelectorAll('.address');
        addresses.forEach(el=>{
            //  saving values of entered addresses
            info_addresses.push(el.value);
        }); 
        $('.address_check').html("Перевірка...");
        //  checking addresses
        let val = await checkAddressData(addresses);
        if(!val){
            alert('Введіть коректні пункти!');
            coords = [];
            return;
        }
        else{
            $('.address_check').html("Далі");
            order["addresses"] = info_addresses;
            order["goBack"] = $('#duo2').prop('checked') ? 1 : 0;
            nextSlide(); 
        }
    }
    //  check is it the third form (date and time)
    else if(!checkElementUndefined(e.target.elements.date)){
        const date = e.target.elements.date.value;
        const time = e.target.elements.time.value;
        order["date"] = date;
        order["time"] = time;
        nextSlide();
    }
    //  check is it the four form (passengers count)
    else if(!checkElementUndefined(e.target.elements.passengers)){
        const passengers = e.target.elements.passengers.value;
        order["passenger_count"] = Number(passengers);
        //  unfilter slider of cars 
        $('.order_slider_car').slick('slickUnfilter');
        //  filtering cars by passengers count
        $('.order_slider_car').slick('slickFilter', function() {
            return $(this).data('pas') >= passengers;
        });
        nextSlide();
    }
    //  check is it form of cars (autopark)
    else if(!checkElementUndefined(e.target.elements.autopark)){
        await getPrice(coords).then(price => {
            let car_name = getCarName();
            order["car"] = car_name;
            order["add_order"] = true;
            order["price"] = price;
            order["table"] = "o";
            sendRequest(order);
            $('.order_form').find("input[type=text], input[type=number], .order_email, textarea").val("");
            //  start slider of cars form first slide
            $('.order_slider_car').slick("slickGoTo", 0, true);
            //  check goBack to false in order form
            $('#one1').prop('checked', true);
            nextSlide();
        });        
    } 
});

calc_modal_button.addEventListener("click", () => {
    //  handler of "order" on calculation modal window and filling inputs of order form
    let inputs_elements = document.querySelectorAll('.order_form .address');
    for(let i = 0; i < calc_inputs.length; i++){
        inputs_elements[i].value = calc_inputs[i];
    }
    passenger_order_input.value = count_of_passengers;
    //  check correct goBack checkbox
    goBack ? $('#duo2').prop( "checked", true ) : $('#one1').prop( "checked", true );
    //  hide calculation results modal
    hideModal(modal_calc);
    calc_inputs = [];
});

//  get dollar cost
getUSD();