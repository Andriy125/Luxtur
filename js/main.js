let arr_obj = [];                                                                           // об єкти з широтою і довготою                                                                       
let add = document.querySelector('.add');                                                   // кнопка додавання полів
let calculate = document.querySelector('.calculate');                                       // кнопка розрахунку
let apikey_weather = '3042b9bfd374130956c1e55d218c8156';                                    // ключ для отримання координатів міст

// Get the modal
let modal_call = document.getElementById("modal_call");
let modal_calc = document.getElementById("modal_calculate");
// Get the button that opens the modal
let btn = document.getElementById("call");

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

const Reqursion = (cities, index = 0) => {                                         // рекурсивне отримання і запис координат міст                                                  
    if(index == cities.length){
        return;
    }
    fetch("http://api.openweathermap.org/data/2.5/weather?q=" + cities[index] + "&appid=" + apikey_weather)
    .then(response => {
        response.json().then(response => {                                        // розпарсинг відповіді
            let newObj = {'lat': response.coord.lat, 'long': response.coord.lon}
            arr_obj.push(newObj);
            index += 1;
            Reqursion(cities, index);
        })
    })
    .catch(err => {
        console.log(err);
        ErrorClear();
        return;
    })
}

const ErrorClear = () => {                                                          // помилка при введенні міста або присутності одного міста
    alert('You stupid kakashka!');
    arr_obj = [];
}

calculate.addEventListener('click', () =>{                                          //  розрахунок
    if(document.querySelectorAll('.form__input').length <= 1){                      // якщо одне поле 
        ErrorClear();
        return;
    }
    let inputs = [];
    document.querySelectorAll('.form__input').forEach((el) => {
        el.value = el.value.toLowerCase();
        inputs.push(el.value.charAt(0).toUpperCase() + el.value.slice(1));
    });

    calculate.textContent = 'Розрахунок...';
    Reqursion(inputs);                                                              // запуск отримання координат
    let query = '';

    setTimeout(() => {
        calculate.textContent = 'Розрахувати';
        if(arr_obj.length !== inputs.length){                                           // якщо одне поле або не всі міста корректно написані
            ErrorClear();
            return;
        }

        for(let i = 0; i < arr_obj.length; i++){
            query += arr_obj[i].lat + "," + arr_obj[i].long + ';';                      // формування запиту
        }
        fetch("https://trueway-matrix.p.rapidapi.com/CalculateDrivingMatrix?destinations="
        + encodeURIComponent(query) + 
        "&origins=" + encodeURIComponent(query), {
            "method": "GET",
            "headers": {
                "x-rapidapi-host": "trueway-matrix.p.rapidapi.com",
                "x-rapidapi-key": "07f42e69cbmshe9b66757eca013dp10519bjsn718397e16c42"
            }
        })
        .then(response => {
            response.json().then(response => {
                let text = '';
                for (let i = 0; i < inputs.length - 1; i++){                            // формування виведення
                 text += 'З ' + inputs[i] + ' дo ' + inputs[i+1] + ' = ' + (response.distances[i][i+1] / 1000).toFixed(0) + ' км <br>';
                }                                                                       // виведення результатів
                modal_calc.style.display = "block";
            })
        })
        .catch(err => {
            console.log(err);
        });
    }, inputs.length * 200);

    document.querySelectorAll('.form__input').forEach(el => el.value = '');             // очищення масиву координат і полів вводу
    arr_obj = [];
});


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


// const DistanceSum = (arr) => {
//     let sum = 0;
//     for(let i = 0; i < arr.length; i++){
        
//     }
//     return sum;
// }