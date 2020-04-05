let arr_obj = [];                                                                           // об єкти з широтою і довготою                                                                       
let calculate = document.querySelector('.calculate');                                       // кнопка розрахунку
let apikey_weather = '3042b9bfd374130956c1e55d218c8156';                                    // ключ для отримання координатів міст
let apikey_geodata = '303691d597d34232b212232cb93cba14';
let api_url = 'https://api.opencagedata.com/geocode/v1/json';
const Reqursion = (cities, index = 0) => {                                         // рекурсивне отримання і запис координат міст                                                  
    if(index == cities.length){
        return;
    }

    let request_url = api_url 
        + '?'
        + 'key=' + apikey_geodata
        + '&q=' + encodeURIComponent(cities[index])
        + '&pretty=1'
        + '&language=uk'
        + '&no_annotations=1';

    fetch(request_url)
    .then(response => {
        response.json().then(response => {                                        // розпарсинг відповіді
            let obj = response.results[0];
            console.log(obj);
            let newObj = {
                'lat': obj.geometry.lat, 
                'long': obj.geometry.lng,
                'country': obj.components["ISO_3166-1_alpha-2"]
            }
            arr_obj.push(newObj);
            console.log(newObj);
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
                console.log(response);
                let from = [];
                let to = [];
                let distances = [];
                let distance_global = 0;
                $('.results_distances__text').remove();
                let text = '';
                for (let i = 0; i < inputs.length - 1; i++){                            // формування виведення
                    let distance = response.distances[i][i+1] / 1000 > 0 ? (response.distances[i][i+1] / 1000).toFixed(0) : (response.distances[i][i+1] / 1000).toFixed(2);
                    text += 'З ' + inputs[i] + ' дo ' + inputs[i+1] + ' = ' + distance + ' км <br>';
                    from.push(inputs[i]);
                    to.push(inputs[i+1]);
                    distances.push(distance);
                    distance_global += Number(distance);
                }                                                                       // виведення результатів
                CreateResultElement(from, to, distances, '.results_distances__all', distances.length);
                let price = DistanceSum(response.distances, arr_obj);
                CreateResultElement(from[0], to[to.length - 1], distance_global, '.results_distances__standard', 1);
                console.log(text);
                if(inputs.length < 3){
                    $('.all_info').css('display', 'none');
                }
                else{
                    $('.all_info').css('display', 'flex');
                }
                $('.results_price__text').html(`Сума: ${$('#duo').prop( "checked" ) ? price * 2 : price} грн`);
                modal_calc.style.display = "block";
            })
        })
        .catch(err => {
            console.log(err);
        });
    }, inputs.length * 400);

    document.querySelectorAll('.form__input').forEach(el => el.value = '');             // очищення масиву координат і полів вводу
    arr_obj = [];
});


const CreateResultElement = (from, to, distance, insert, count) => {
    let append_elements_all = ``;
    for(let i = 0; i < count; i++){
        append_elements_all += 
            `<p class="results_distances__text">
                <span>${Array.isArray(from) ? from[i] : from}</span> 
                <span>>></span> 
                <span>${Array.isArray(to) ? to[i] : to}</span> 
                <span>:</span> 
                <span class="calc_distance">${Array.isArray(distance) ? distance[i] : distance} км.</span>
            </p>`;
    }
    $(append_elements_all).appendTo(insert);
}


const DistanceSum = (arr, objects) => {
    let price = 0;
    for(let i = 0; i < arr.length; i++){
        if(i + 1 === arr.length){
            break;
        }
        price += objects[i+1].country == "UA" 
        ? (arr[i][i+1] > 1000) ? (arr[i][i+1] / 1000).toFixed(0) * 10 : 10 
        : (arr[i][i+1] > 1000) ? (arr[i][i+1] / 1000).toFixed(0) * 27 : 27;
    }
    return price.toFixed(0);
}