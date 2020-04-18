<?php 
	include 'get_data.php';
?>
<!DOCTYPE html>
<html lang="ua">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LUX TUR</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script defer src="./js/all.js"></script>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<!-- блок головний -->
	<div class="block first">
		<div class="header">
			<div class="header_left">
				<img class="header_left__img" src="img/logo.png" alt="logo">
				<h2 class="header_left__h2">LUX TUR</h2>
			</div>
			<div class="header_right">
				<div class="burger_icon">
					<span>
					</span>
				</div>
				<ul class="header_right__ul">
					<li class="header_right__li"><a href="#services">Послуги </a></li>
					<li class="header_right__li"><a href="#directions">Популярні напрямки</a></li>
					<li class="header_right__li"><a href="#price">Ціни</a></li>
					<li class="header_right__li"><a href="#autopark">Автопарк</a></li>
					<li class="header_right__li"><a href="#contacts">Контакти</a></li>
				</ul>
			</div>
		</div>
		<div class="text-box">
			<h1 class="text-box__main-text">
				Подорожуй з LUX TUR
			</h1>
			<h3 class="text-box__descr"> 
				Пасажирські автоперевезення по Україні та до країн Євросоюзу <br> 
				на замовлення
			</h3>
			<div class="text-box__links">
				<div>
					<a class="text-box__link btn white_button" href="#order">Замовити</a>
				</div>
				<div>
					<a class="text-box__link btn outlined yellow_button" href="#price">Розрахувати вартість поїздки</a>
				</div>
			</div>
		</div>
	</div>

	<!-- блок наші послуги -->
	<div class="second" id="services">
		<h2 class="title">
			Наші послуги
		</h2>
		<div class="services">

			 <div class="service">
				<div class="service__img margin_right">
					<img src="./img/поїхати на відпочинок.png" alt="">
				</div>
				<div class="service_text">
					<h3 class="service__title">Підвеземо на відпочинок</h3>
					<p class="service__descr">
						Набридли сірі робочі будні і потрібен відпочинок? Зібралися відпочити з сім’єю чи компанією на морі, покататись на лижах або просто необхідно потрапити з одного міста до іншого швидко та з комфортом?
						<br><br>
						Ми допоможемо зробити Вашу поїздку комфортною та безпечною та відвеземо у потрібний для Вас час!
					</p>
				</div>
			 </div>
			 <div class="service service_reverse_direction">
				<div class="service_text margin_right">
					<h3 class="service__title">Зустрінемо в аеропорту</h3>
					<p class="service__descr">
						Повертаєтесь з друзями або з сім’єю з відпустки, або потрібно зустріти гостей?
						<br><br>
						Ми зустрінемо Вас та Ваших друзів біля терміналу в аеропорту Бориспіль, Жуляни або на автовокзалі та з комфортом підвеземо за потрібною адресою.
					</p>
				</div>
				<div class="service__img ">
					<img src="./img/Зустріч в аєропорту.png" alt="">
				</div>
			 </div>
			 <div class="service " >
				<div class="service__img margin_right">
					<img src="./img/Ділова поїздка.png" alt="">
				</div>
				<div class="service_text">
					<h3 class="service__title">Бізнес поїздка</h3>
					<p class="service__descr">
						У Вас запланована ділова зустріч з партнерами, конференція чи потрібно за один день відвідати кілька об’єктів?
						<br><br>
						Ми завжди готові з комфортом та у зазначений час організувати поїздку на найвищому рівні!
					</p>
				</div>
			 </div>
			 <div class="service service_reverse_direction">
				<div class="service_text margin_right">
					<h3 class="service__title">Поїздки на замовлення</h3>
					<p class="service__descr">
						Ми доставимо Вас та Вашу сім’ю, друзів чи колег у всі країни Європи, до Росії та Білорусії. 
						<br><br>
						Також здійснюємо пасажирські автоперевезення по всій Україні.						
					</p>
				</div>
				<div class="service__img">
					<img src="./img/відпочинок.png" alt="">
				</div>
			 </div>

		</div>
	</div>

	<!-- блок популярні напрямки -->
	<div class="block third" id="directions">
		<h2 class="title">
			Популярні напрямки
		</h2>
		<div class="directions">
			<div class="directions_container directions_container_section1">
				<div class="direction">
					<img class="direction__img" src="img/boryspil.png" alt="Бориспіль">
					<div class="direction__textblock">
						<h2 class="direction__city">Бориспіль</h2>
					</div>
				</div>
				<div class="direction">
					<img class="direction__img" src="img/bykovel.png" alt="Буковель">
					<div class="direction__textblock">
						<h2 class="direction__city">Буковель</h2>
					</div>
				</div>
				<div class="direction">
					<img class="direction__img" src="img/lviv.png" alt="Львів">
					<div class="direction__textblock">
						<h2 class="direction__city">Львів</h2>
					</div>
				</div>
			</div>

			<div class="directions_container directions_container_section2">
				<div class="direction">
					<img class="direction__img" src="img/kyiv.png" alt="Київ">
					<div class="direction__textblock">
						<h2 class="direction__city">Київ</h2>
					</div>
				</div>
				<div class="direction">
					<img class="direction__img" src="img/poland.png" alt="Польща">
					<div class="direction__textblock">
						<h2 class="direction__city">Польща</h2>
					</div>
				</div>
				<div class="direction">
					<img class="direction__img" src="img/germany.png" alt="Германія">
					<div class="direction__textblock">
						<h2 class="direction__city">Германія</h2>
					</div>
				</div>
			</div>
			
		</div>
	</div>

	<!-- блок передзвоніть -->
	<div class="block none_padding call">
		<div class="call_block">
			<div class="call_block__img">
				<img src="./img/phone_img.png" alt="">
			</div>
			<div class="call_block__text">
				<p>Хочете передзвонимо вам?</p>
				<p class="call_block__text__descr">Індивідуальний підхід до кожного</p>
			</div>
			<div class="call_block__contacts">
				<a class="call_block__link btn black_button" id="call">Замовити дзвінок</a>
				Ми з Вами зв'яжемось
			</div>
		</div>
	</div>

	<div id="modal_calculate" class="modal">
		<div class="modal_calculate_block">
			<div class="modal_calculate_container">
				<form action="" class="results">
					<div class="results_distances">

						<div class="results_distances__standard">

						</div>

						<div class="results_distances__all">
							
						</div>

					</div>
					<h2 class="results_tariff">Тариф: 10 Гривень/км</h2>
					<div class="results_price">
						<h2 class="results_price__text">Сума: 5123 грн</h2>
					</div>
					<div class="check_block all_info">
						<input id="info" type="checkbox" checked="false" class="iOS_input all_info__input">
						<label for="info" class="check_block__text">Всі дані</label>
					</div>
					<button type="submit" class="results_form__button btn white_button">Замовити</button>
				</form>
			</div>

		</div>
	</div>

	<div id="modal_call" class="modal">
		<div class="modal-content">
			<div class="modal-output">
				<span class="close">&times;</span>
				<form action="" class="call_form">
					<h2 class="call_form__title">Форма замовлення</h2>
					<input type="text" placeholder="Ім'я" name="name" class="call_form__input" required>
					<input type="text" placeholder="Номер телефону"
					 data-mask="+38 (000) 000 00 00" name="phone" class="call_form__input phone" required>
					<input type="email" name="email" placeholder="E-mail" class="call_form__input" required>
					<button type="submit" class="call_form__button btn black_button">Замовити дзвінок</button>
				</form>
			</div>
		</div>
	</div>	

	<div id="modal_autopark" class="modal">
		<div class="modal_autopark_wrapper">
			<div class="modal_autopark__container">
				<h2>Mercedes-bens 519</h2>
				<div class="modal_autopark_slider_wrap">
					<div class="modal_autopark_slider">
						<img src="./img/auto_1.png" alt="auto">
						<img src="./img/auto_1.png" alt="auto">
						<img src="./img/auto_1.png" alt="auto">
						<img src="./img/auto_1.png" alt="auto">
					</div>
					<div class="modal_autopark_buttons">
						<div class="modal_autopark__button left btn yellow_button modal_autopark__button-prev">
							<i class="fas fa-angle-left"></i>
						</div>
						<div class="modal_autopark__button slider_button__right right btn yellow_button modal_autopark__button-next">
							<i class="fas fa-angle-left"></i>
						</div>
					</div>
				</div>
				<div class="modal_autopark_slider_lower">
					
					<div class="modal_autopark_slider_lower__item">
						<img src="./img/auto_1.png" alt="auto">
					</div>

					<div class="modal_autopark_slider_lower__item">
						<img src="./img/auto_1.png" alt="auto">
					</div>

					<div class="modal_autopark_slider_lower__item">
						<img src="./img/auto_1.png" alt="auto">
					</div>

					<div class="modal_autopark_slider_lower__item">
						<img src="./img/auto_1.png" alt="auto">
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- блок автопарк -->
	<div class="autopark_block" id="autopark">
		<h2 class="title">Наш автопарк</h2>

		<div class="auto_container">
			<div class="autopark_buttons">
				<div class="autopark_button auto-button-prev btn yellow_button">
					<i class="fas fa-angle-left"></i>
				</div>
				<div class="autopark_button arrow_right auto-button-next btn yellow_button">
					<i class="fas fa-angle-left"></i>
				</div>
			</div>
			<div class="auto_main_block">
				<div class="auto_filter">
					<div class="auto_filter__btn all active">
						Всі
					</div>
					<div class="auto_filter__btn ukr">
						По Україні
					</div>
					<div class="auto_filter__btn eu">
						По Європі
					</div>
				</div>
				<div class="auto_slider">
					<div class="auto_item ukr" id="auto_card">
						<div class="wrap_img_slider">
							<div class="auto_img_slider">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
							</div>
						</div>

						<div class="auto_text">
							<b class="auto_model">Mercedes-bens 519</b>
							<ul class="auto__ul">
								<li class="auto__li">Кількість місць: 20</li>
								<li class="auto__li">Кондиціотер</li>
								<li class="auto__li">ТV</li>
								<li class="auto__li">Багажник</li>
								<li class="auto__li">Зручні сидіння</li>
							</ul>
						</div>
					</div>

					<div class="auto_item ukr" id="auto_card">
						<div class="wrap_img_slider">
							<div class="auto_img_slider">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
							</div>
						</div>

						<div class="auto_text ">
							<b class="auto_model">Mercedes-bens 519</b>
							<ul class="auto__ul">
								<li class="auto__li">Кількість місць: 20</li>
								<li class="auto__li">Кондиціотер</li>
								<li class="auto__li">ТV</li>
								<li class="auto__li">Багажник</li>
								<li class="auto__li">Зручні сидіння</li>
							</ul>
						</div>
					</div>

					<div class="auto_item eu" id="auto_card">
						<div class="wrap_img_slider">
							<div class="auto_img_slider">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
							</div>
						</div>

						<div class="auto_text">
							<b class="auto_model">Mercedes-bens 519</b>
							<ul class="auto__ul">
								<li class="auto__li">Кількість місць: 20</li>
								<li class="auto__li">Кондиціотер</li>
								<li class="auto__li">ТV</li>
								<li class="auto__li">Багажник</li>
								<li class="auto__li">Зручні сидіння</li>
							</ul>
						</div>
					</div>

					<div class="auto_item eu" id="auto_card">
						<div class="wrap_img_slider">
							<div class="auto_img_slider">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
							</div>
						</div>

						<div class="auto_text">
							<b class="auto_model">Mercedes-bens 519</b>
							<ul class="auto__ul">
								<li class="auto__li">Кількість місць: 20</li>
								<li class="auto__li">Кондиціотер</li>
								<li class="auto__li">ТV</li>
								<li class="auto__li">Багажник</li>
								<li class="auto__li">Зручні сидіння</li>
							</ul>
						</div>
					</div>

					<div class="auto_item eu" id="auto_card">
						<div class="wrap_img_slider">
							<div class="auto_img_slider">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
								<img class="auto_item__img" src="img/auto_1.png" alt="auto">
							</div>
						</div>

						<div class="auto_text">
							<b class="auto_model">Mercedes-bens 519</b>
							<ul class="auto__ul">
								<li class="auto__li">Кількість місць: 20</li>
								<li class="auto__li">Кондиціотер</li>
								<li class="auto__li">ТV</li>
								<li class="auto__li">Багажник</li>
								<li class="auto__li">Зручні сидіння</li>
							</ul>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>

	<!-- блок розрахунків -->
	<div class="block none_padding" id="price">
		<div class="price_block">
			<h2 class="title">
				Розрахунок вартості подорожі
			</h2>
			<div class="wrap black_container">
				<div class="wrap__container wrap_bordered_container">
					<form class="form_calc" action="" method="GET">
							<input type="number" min="1" class="passenger_calc" placeholder="Кількість пасажирів" required>
							<div class="fixed_container calc">
								<input type="text" placeholder="Адреса відправлення" class="form__input" required>
								<input type="text" placeholder="Адреса прибуття" class="form__input" required>
							</div>
							<div class="crud_buttons">
								<div class="crud_button calculate_add">
									<a class="add">Додати пункт</a>
								</div>
								<div class="crud_button calculate_remove">
									<a class="minus">Видалити пункт</a>
								</div>
							</div>
							<div class="check_block">
								<input id="one" name="type1" type="radio" checked="true" value="one" class="iOS_input form__input_dir">
								<label for="one" class="check_block__text">В один напрямок</label>
							</div>
							<div class="check_block">
								<input id="duo" name="type1" type="radio" class="iOS_input form__input_dir" value="duo">
								<label for="duo" class="check_block__text">В обидва напрямки</label>
							</div>

						<div class="form_calculate">
							<button class="btn white_button calculate" type="submit">Розрахувати</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- блок замовлення -->
	<div class="order_block" id="order">
		<div class="slider_container">

			 <div class="wrap_order_request">
				<div class="order_request wrap__container">
					<div class="order_content wrap_bordered_container">
						<h2 class="form_title">Замовити поїздку</h2>
						<form action="" class="order_form">
							<input type="text" placeholder="Ім'я" name="name" class="order_name" required>
							<input type="text" 
							 data-mask="+38 (000) 000 00 00" placeholder="Номер телефону" class="phone order_phone" name="phone" required>
							<input type="email" placeholder="E-mail" class="order_email" name="email" required>
							<button class="white_button btn order_form__button next">Далі</button>
						</form>
					</div>
				</div>
			</div> 
			
			<div class="wrap_order_request">
				<div class="order_request wrap__container">
					<div class="order_content wrap_bordered_container">
						<h2 class="form_title">Маршрут поїздки</h2>
						<form action="" class="order_form">
							<div class="fixed_container">
								<input type="text" placeholder="Адреса відправлення..." name="address" class="order_data_input address input" required>
								<input type="text" placeholder="Адреса прибуття..." name="address" class="order_data_input address input" required>
							</div>
							<div class="crud_buttons">
								<div class="crud_button order_add">
									<i class="fas fa-plus-circle"></i>
									<a>Додати пункт</a>
								</div>
								<div class="crud_button order_remove">
									<i class="fas fa-minus-circle"></i>
									<a>Видалити пункт</a>
								</div>
							</div>

							<div class="check_block">
								<input id="one1" name="order_dir" type="radio" checked="true" value="one" class="iOS_input order_data_input">
								<label for="one1" class="check_block__text">В один напрямок</label>
							</div>
							<div class="check_block">
								<input id="duo2" name="order_dir" type="radio" class="iOS_input order_data_input" value="duo">
								<label for="duo2" class="check_block__text">В обидва напрямки</label>
							</div>
							<div class="submit_buttons">
								<button  class="white_button btn order_form__button prev">Назад</button>
								<button  class="white_button address_check btn order_form__button next">Далі</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="wrap_order_request">
				<div class="order_request wrap__container">
					<div class="order_content wrap_bordered_container">
						<h2 class="form_title">Дата і час</h2>
						<form action="" class="order_form">
							<h2 class="form_descr">Дата відправлення</h2>
							<div class="inline_inputs">
								<input type="date" class="order_date" name="date" required>
								<input type="time" class="order_time" name="time" required>
							</div>

							<div class="submit_buttons">
								<button  class="white_button btn order_form__button prev">Назад</button>
								<button  class="white_button btn order_form__button next">Далі</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="wrap_order_request">
				<div class="order_request wrap__container">
					<div class="order_content wrap_bordered_container">
						<h2 class="form_title">Кількість пасажирів</h2>
						<form action="" class="order_form">
							<input type="number" min="1" placeholder="Кількість пасажирів" name="passengers" class="order_pasengers" required>
							<div class="submit_buttons">
								<button  class="white_button btn order_form__button prev">Назад</button>
								<button  class="white_button btn order_form__button next">Далі</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="wrap_order_request">
				<div class="order_request wrap__container">
					<div class="order_content wrap_bordered_container slider_cont">
						<h2 class="form_title">Вибір транспорту</h2>
						<form action="" class="order_form">
							<input type="hidden" name="autopark">
							<div class="order_slider_car">
								<div class="order_car">
									<img class="order_car__img" src="./img/auto_1.png" alt="Mercedes-bens 51">
									<h2 class="order_car__title">Mercedes-bens 519</h2>
								</div>
								<div class="order_car">
									<img class="order_car__img" src="./img/auto_2.png" alt="Mercedes-bens 316">
									<h2 class="order_car__title">Mercedes-bens 316</h2>
								</div>
	
							</div>
							<div class="button_modal_auto">
								<div class="auto_slider__button auto-order-button-prev btn white_button">
									<i class="fas fa-angle-left"></i>
								</div>
								<div class="auto_slider__button auto-order-button-next arrow_right btn white_button">
									<i class="fas fa-angle-left"></i>
								</div>
							</div>
							<div class="submit_buttons">
								<button class="white_button btn order_form__button prev">Назад</button>
								<button type="submit" class="white_button btn order_form__button next apply_order">Замовити</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="wrap_order_request">
				<div class="order_request wrap__container">
					<div class="order_content wrap_bordered_container">
						<h2 class="form_title none_margin">Поїздку оформленно</h2>
					</div>
				</div>
			</div>

		</div>
	</div>

	<!-- блок відгуки -->
	<div class="reviews">
		<div class="reviews_text">
			<h3 class="reviews_text__title">Відгуки клієнтів</h3>
			<p class="reviews_text__descr">
				Нам дуже важлива Ваша думка, щоб наші нові клієнти могли дізнатися інформацію про якість поїздок та надання послуг автоперевезення.
			</p>
		</div>
		<div class="review_slider">
			<?php 
				foreach ($result_reviews as $review) {
					if($review["show_review"]){
						echo   '<div class="review">
						<h2 class="review__title">
							'. $review["name"] .'
						</h2>
						<p class="review__descr">
							"'. $review["review"] .'"
						</p>
					</div>';
					}
				}
			?>
		</div>
		<div class="slider_buttons">
			<a href="#" class="slider_button swiper-button-prev btn black_button">
				<i class="fas fa-angle-left"></i>
			</a>
			<a href="#" class="slider_button slider_button__right  swiper-button-next btn black_button">
				<i class="fas fa-angle-left"></i>
			</a>
		</div>
		<div>
			<a class="get_review_link outlined btn yellow_button" id="review_button">Залишити відгук</a>
		</div>
	</div>

	<div id="modal_review" class="modal">
		<div class="modal_form_review">
			<div class="modal_review_containter">
				<h2 class="modal_review_title">Поділіться своїми враженнями</h2>
				<form action="review_api.php" class="form_review">
					<input type="text" placeholder="Ім'я" name="name" required>
					<input type="email" placeholder="Email" name="email" required>
					<textarea placeholder="Відгук" name="review" minlength="15" class="input input_review_feedback" required></textarea>
					<button class="btn yellow_button outlined review_form_submit" type="submit">Надіслати</button>
				</form>
			</div>
		</div>
	</div>

	<!-- блок контакти -->
	<div class="block six" id="contacts">
		<h2 class="title">Наші контакти</h2>
		<div class="contacts_block">
			<div class="contacts">
				<div class="contacts_text">	
					<ul class="contacts_text__list">
					<?php foreach ($result_phones as $value) {
							if($value["operator"] == "Kyivstar"){
								echo strtolower($value["social_media"]) == "viber" ?'<li><a href="tel:'. $value["phone"] .'" class="contacts_mail__link">'. $value["phone"] .'</a><img src="img/Kyivstar-white-1-1 1.png" alt="kyivstar"><img src="img/viber_PNG15 1.png" alt="viber"></li>' : '<li><a href="tel:'. $value["phone"] .'" class="contacts_mail__link">'. $value["phone"] .'</a><img src="img/Kyivstar-white-1-1 1.png" alt="kyivstar"></li>';
							}
							else if($value["operator"] == "Vodaphone"){
								echo strtolower($value["social_media"]) == "viber" 
								?'<li><a href="tel:'. $value["phone"] .'" class="contacts_mail__link">'. $value["phone"] .' </a><img src="img/vodapfhone.png" alt="vodaphone"><img src="img/viber_PNG15 1.png" alt="viber"></li>' 
								: '<li><a href="tel:'. $value["phone"] .'" class="contacts_mail__link">'. $value["phone"] .' </a><img src="img/vodapfhone.png" alt="vodaphone"></li>';
							}
						}?>
					</ul>
					<ul class="contacts_text__list">
						Email:
						<?php foreach ($result_emails as $value) {
							foreach ($value as $email) {
								echo '<li><a class="contacts_mail__link" href="mailto:'. $email .'">'. $email .'</a></li>';
							}
						}
						?>
					</ul>
				</div>
			</div>
			<div></div>
		</div>		
	</div>

	<script src="./js/jquery.min.js"></script>
	<script src="./js/slick.min.js"></script>
    <script src="js/sendRequest.js"></script>
	<script src="./js/logic.js"></script>
	<script src="./js/sliders.js"></script>
	<script src="./js/jquery.mask.js"></script>
	<script src="./js/main.js"></script>
	<!-- <script>
		let count_passengers = Number($('.passenger_calc')[0].value);
    	let uah_tariff = count_passengers <= 8 ? 7 : ;
	</script> -->
</body>
</html>