// об єкти з широтою і довготою  
let arr_obj = [];          
// кнопка розрахунку                                                                                                                                      
let calculate = document.querySelector('.calculate');                                       
// ключ для отримання координатів міст                                    
let apikey_geodata = '303691d597d34232b212232cb93cba14';
// посилання для запиту (отримання координат)
let api_url = 'https://api.opencagedata.com/geocode/v1/json';

// рекурсивне отримання і запис координат міст
const Reqursion = (cities, index = 0) => {                                                                                           
    if(index == cities.length){
        return;
    }
    // формування повної адреси запиту
    let request_url = api_url 
        + '?'
        + 'key=' + apikey_geodata
        + '&q=' + encodeURIComponent(cities[index])
        + '&pretty=1'
        + '&language=uk'
        + '&no_annotations=1';
    // запит
    fetch(request_url)
    .then(response => {
        // розпарсинг відповіді
        response.json().then(response => {                                        
            let obj = response.results[0];
            let newObj = {
                'lat': obj.geometry.lat, 
                'long': obj.geometry.lng,
                'country': obj.components["ISO_3166-1_alpha-2"]
            }
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
// помилка при введенні міста або присутності одного міста
const ErrorClear = () => {                                                          
    alert('You stupid kakashka!');
    arr_obj = [];
}
//  розрахунок
calculate.addEventListener('click', () =>{    
    // якщо одне поле                                       
    if(document.querySelectorAll('.form__input').length <= 1){                      
        ErrorClear();
        return;
    }
    let inputs = [];
    // формування та форматування масиву адрес для подальшого використання
    document.querySelectorAll('.form__input').forEach((el) => {
        el.value = el.value.toLowerCase();
        inputs.push(el.value.charAt(0).toUpperCase() + el.value.slice(1));
    });

    calculate.textContent = 'Розрахунок...';
    // запуск отримання координат
    Reqursion(inputs);                                                              
    let query = '';

    setTimeout(() => {
        calculate.textContent = 'Розрахувати';
         // якщо одне поле або не всі міста корректно написані
        if(arr_obj.length !== inputs.length){                                          
            ErrorClear();
            return;
        }
        // формування запиту
        for(let i = 0; i < arr_obj.length; i++){
            query += arr_obj[i].lat + "," + arr_obj[i].long + ';';                      
        }
        // здійснення запиту
        fetch("https://trueway-matrix.p.rapidapi.com/CalculateDrivingMatrix?destinations="
        + encodeURIComponent(query) + 
        "&origins=" + encodeURIComponent(query), {
            "method": "GET",
            "headers": {
                "x-rapidapi-host": "trueway-matrix.p.rapidapi.com",
                "x-rapidapi-key": "07f42e69cbmshe9b66757eca013dp10519bjsn718397e16c42"
            }
        })
        // отримання результатів
        .then(response => {
            response.json().then(response => {
                let from = [];
                let to = [];
                let distances = [];
                // обнулення загальної відстані
                let distance_global = 0;
                // очистка попередніх елементів 
                $('.results_distances__text').remove();
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
                // отримання вартості поїздки
                let price = getDistancePrice(response.distances, arr_obj);
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
    }, inputs.length * 400);
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
    for(let i = 0; i < arr.length; i++){
        if(i + 1 === arr.length){
            break;
        }
        price += objects[i+1].country == "UA" 
        // якщо по Україні
        ? (arr[i][i+1] > 1000) ? (arr[i][i+1] / 1000).toFixed(0) * 10 : 10 
        // якщо не по Україні
        : (arr[i][i+1] > 1000) ? (arr[i][i+1] / 1000).toFixed(0) * 27 : 27;
    }
    return $('#duo').prop( "checked" ) ? price.toFixed(0) * 2 : price.toFixed(0);
}

//  вставка елементів
const insertElement = (element, appendToElement) => {
    $(element).appendTo(appendToElement);
}