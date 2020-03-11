let arr_obj = [];                                                                           // об єкти з широтою і довготою
let arr = ['A', 'B', 'C', 'D', 'I', 'F', 'G'];                                              // літери для додавання полів і кружочків
let index = 2;                                                                              // індекс для масива з літерами                                                                         
let add = document.querySelector('.add');                                                   // кнопка додавання полів
let calculate = document.querySelector('.calculate');                                       // кнопка розрахунку
let apikey_weather = '3042b9bfd374130956c1e55d218c8156';                                    // ключ для отримання координатів міст

// Get the modal
let modal = document.getElementById("myModal");

// Get the button that opens the modal
let btn = document.getElementById("call");

// Get the <span> element that closes the modal
let span = document.getElementsByClassName("close")[0];


$('.phone').mask('+3 (000) 000 00 00', {placeholder: "Номер телефону"});

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    ClearCallInputs();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        ClearCallInputs();
    }
}

const ClearCallInputs = () => {
    document.querySelectorAll('.call_form__input').forEach(el => {el.value = "";});
}

$(document).click(function(event) {                                                         // видалення елемента
    let text = $(event.target).text();
    let obj = arr.find(el => el === text);
    if(obj){                                                                    
        index -= document.querySelectorAll(".circle." + text).length;
        $( "." + text ).remove();
        if(index === 0){                // якщо індекс 0, додаємо 1, щоб додавався наступний елемент, так як перший елемент видалити не можна
            index += 1;
        }
    }
    if(document.querySelectorAll('.circles .circle').length <= 2){
        $('.form_pasengers').css('padding-right', '20px');
    }
});

const addScroll = (elem) => {
    $(elem).css('overflow-y', 'auto');
}

add.addEventListener('click', () =>{                                                        // додавання полів і кружочків
    if(document.querySelectorAll('.circles .circle').length >= 2){                                   // якщо елементів 4 і більше, вмикати скролл
        addScroll('.form_inputs');
        $('.form_pasengers').css('padding-right', '40px');
    }

    if(arr[index] !== undefined){                                                           // якщо літера існує (не за межами массиву)
        for(let i = 0; i < arr.length; i++){
            let indic = false;
            for(let j = 0; j < document.querySelectorAll('.circle').length; j++){
                if(document.querySelectorAll('.circle')[j].textContent === arr[i]){
                    indic = true;
                    break;
                }
            }
            if(!indic){
                CreateElement(arr[i], arr[i-1]);
                return;
            }
        }
    }
    else{
        alert('You can\'t do this!');
    }
});

const CreateElement = ( text, after ) => {                                                 // створення полів і кружочків    
    if(after === 'A'){
        after = 'requi';
    }
    $("<div class='group " + text + "'></div>").insertAfter('.circle.' + after);
    $("<div class='circle " + text + "' title='Видалити'>" + text + "</div>").insertAfter('.group.' + text);

    $('<label class="form__label ' + text + '">Пункт</label>').insertAfter('.form__input.' + after);
    $('<input type="text" placeholder="Пункт..." class="form__input ' + text + '"/>').insertAfter('.form__label.' + text);
    index += 1;
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
                }
                $('.result').html(text);                                                // виведення результатів
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
        $('.order_buttons').css('margin-top', '15px');
    }
    $('<input type="text" placeholder="Адреса пункту..." class="order_data_input address">')
    .insertAfter(addresses[addresses.length - 1]);
})

document.querySelector('.order_remove').addEventListener('click', (e) => {
    let addresses = document.querySelectorAll('.address');
    if(addresses.length < 4){
        $('.order_remove').css('display', 'none');
        $('.order_buttons').css('margin-top', '0px');
    }
    addresses[addresses.length - 1].remove();
})