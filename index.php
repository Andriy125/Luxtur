<?php 
	include 'get_data.php';
?>
<!DOCTYPE html>
<html lang="ua">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LUX TUR</title>
	<link href="css/fotorama.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/slick.css"/>
	<script defer src="./js/all.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
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
		<?php 
			$i = 1;
			while($o_s = mysqli_fetch_array($result_our_services)):
				
				if($i % 2 != 0){?>
			<div class="service">
				<div class="service__img margin_right">
					<img src="./<?php echo $o_s["image"] ?>" alt="<?php echo $o_s["title"] ?>">
				</div>
				<div class="service_text">
					<h3 class="service__title"><?php echo $o_s["title"] ?></h3>
					<p class="service__descr"><?php echo nl2br($o_s["text"]) ?></p>
				</div>
			</div>
			<?php } else{?>
				<div class="service service_reverse_direction">
					<div class="service_text margin_right">
						<h3 class="service__title"><?php echo $o_s["title"] ?></h3>
						<p class="service__descr"><?php echo nl2br($o_s["text"]) ?></p>
					</div>
					<div class="service__img ">
						<img src="./<?php echo $o_s["image"] ?>" alt="<?php echo $o_s["title"] ?>">
					</div>
			 	</div>
				<?php } ?>
			<?php $i += 1; endwhile; ?>
		</div>
	</div>

	<!-- блок популярні напрямки -->
	<div class="block third" id="directions">
		<h2 class="title">
			Популярні напрямки
		</h2>
		<div class="directions">
		<?php 
		$len = $result_popular_directions->num_rows;
		$count_of_rows = $len;
		for($i = 0; $i < $len / 3; $i++){?>
			<div class="directions_container">
				<?php 
					$line_count = $count_of_rows >= 3 ? 3 : $count_of_rows;
				?>
				<?php for($j = 0; $j < $line_count; $j++){?>
					<?php 
						$popular_directions = mysqli_fetch_object($result_popular_directions);
					?>
					<div class="direction">
						<img class="direction__img" 
							src="./<?php echo $popular_directions->image ?>" 
							alt="<?php echo $popular_directions->text ?>">
						<div class="direction__textblock">
							<h2 class="direction__city"><?php echo $popular_directions->text ?></h2>
						</div>
					</div>
				<?php }
					$count_of_rows-= 3;
				?>
			</div>
		<?php } ?>			
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
					<a href="#order" type="submit" class="results_form__button btn white_button">Замовити</a>
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
					</div>
					<!-- <div class="modal_autopark_buttons">
						<div class="modal_autopark__button left btn yellow_button modal_autopark__button-prev">
							<i class="fas fa-angle-left"></i>
						</div>
						<div class="modal_autopark__button slider_button__right right btn yellow_button modal_autopark__button-next">
							<i class="fas fa-angle-left"></i>
						</div>
					</div> -->
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

				<?php 
				$array_of_auto_imgs = [];
				$k = -1;
				for($i = 0; $i < count($all_car); $i++): 
					$imgs_array = [];
					$imgs_array[] = "<img class='auto_item__img modal_autopark_img' src='".$all_car[$i]["main_image"] ."' alt='auto'>";
					if($all_car[$i]["show_car"] == 0){
						continue;
					}
					else{
						$k++;
					}
				?>
					<div class="auto_item 
						<?php echo strpos($all_car[$i]["location"], "Європа") !== false ? "eu " : "";
						echo strpos($all_car[$i]["location"], "Україна") !== false ? "ukr " : "";
						?>" id="auto_card">
						<input type="hidden" class="index" value="<?php echo $k; ?>">
						<div class="wrap_img_slider">
							<div class="fotorama" data-width="500" data-maxwidth="100%" data-loop="true" data-maxheight="230" >
							<img class="auto_item__img" src="<?php echo $all_car[$i]["main_image"];  ?>" alt="auto">
							<?php 
							$length_of_imgs = explode(" ", $all_car[$i]["images"]);
							
							for($j = 0; $j < count($length_of_imgs) - 1; $j++): ?>
								<img class="auto_item__img" src="<?php echo $length_of_imgs[$j]; ?>" alt="auto" >
							<?php 
								$imgs_array[] = "<img class='auto_item__img modal_autopark_img' src='". $length_of_imgs[$j] ."' alt='auto'>";							
								endfor; 
								$array_of_auto_imgs[] = $imgs_array;
								?>
							</div>
						</div>
						<div class="auto_text">
							<b class="auto_model"><?php echo $all_car[$i]["name"]; ?></b>
							<div class="auto_advantages">
								<ul class="auto__ul">
								<?php 
								$length_of_adv = explode("\n", $all_car[$i]["advantages"]);
								for($j = 0; $j < count($length_of_adv); $j++): ?>
									<li class="auto__li"><?php echo $length_of_adv[$j]; ?></li>
								<?php endfor; ?>
								</ul>
							</div>							
						</div>
					</div>
				<?php endfor; ?>
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
					<form class="form_calc">
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
						<form class="order_form">
							<div class="fixed_container order">
								<input type="text" placeholder="Адреса відправлення..." name="address" class="address input" required>
								<input type="text" placeholder="Адреса прибуття..." name="address" class="address input" required>
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
						<form class="order_form">
							<input type="number" min="1" placeholder="Кількість пасажирів" name="passengers" class="order_passengers" required>
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
						<form class="order_form">
							<input type="hidden" name="autopark">
							<div class="order_slider_car">
								<?php for($i = 0; $i < count($all_car); $i++): ?>
									<div class="order_car" data-pas="<?php echo $all_car[$i]["passengers"];?>">
										<img class="order_car__img" src="./<?php echo $all_car[$i]["main_image"];?>" alt="<?php echo $all_car[$i]["name"]?>">
										<h2 class="order_car__title"><?php echo $all_car[$i]["name"];?></h2>
									</div>
								<?php endfor;?>
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
							if($value["operator"] == "kyivstar"){
								echo strtolower($value["social_media"]) == "viber" ?'<li><a href="tel:'. $value["phone"] .'" class="contacts_mail__link">'. $value["phone"] .'</a><img src="img/Kyivstar-white-1-1 1.png" alt="kyivstar"><img src="img/viber_PNG15 1.png" alt="viber"></li>' : '<li><a href="tel:'. $value["phone"] .'" class="contacts_mail__link">'. $value["phone"] .'</a><img src="img/Kyivstar-white-1-1 1.png" alt="kyivstar"></li>';
							}
							else if($value["operator"] == "vodafone"){
								echo strtolower($value["social_media"]) == "viber" 
								?'<li><a href="tel:'. $value["phone"] .'" class="contacts_mail__link">'. $value["phone"] .' </a><img src="img/vodapfhone.png" alt="vodaphone"><img src="img/viber_PNG15 1.png" alt="viber"></li>' 
								: '<li><a href="tel:'. $value["phone"] .'" class="contacts_mail__link">'. $value["phone"] .' </a><img src="img/vodapfhone.png" alt="vodaphone"></li>';
							}
						}?>
					</ul>
					<ul class="contacts_text__list">
						Email:
						<?php while ($row = mysqli_fetch_array($result_emails)):?>
							<li><a class="contacts_mail__link" href="mailto:<?php echo $row["email"] ?>"><?php echo $row["email"] ?></a></li>
						<?php endwhile;?>
					</ul>
				</div>
			</div>
			<div></div>
		</div>		
	</div>

	<script src="./js/jquery.min.js"></script>
	<script src="js/fotorama.js"></script>
	<script src="./js/slick.min.js"></script>
    <script src="js/sendRequest.js"></script>
	<script src="./js/logic.js"></script>
	<script src="./js/sliders.js"></script>
	<script src="./js/jquery.mask.js"></script>
	<script src="./js/main.js"></script>
	<script>
		let all_car_array = <?php echo json_encode($all_car); ?>;
		let eu_car_array = <?php echo json_encode($eu_car); ?>;
		let ukr_car_array = <?php echo json_encode($ukr_car); ?>;
		let array_of_auto_imgs = <?php echo json_encode($array_of_auto_imgs); ?>;
		usd_tariff = Number(<?php echo json_encode($usd_tariff); ?>["value"]);
	</script>
</body>
</html>