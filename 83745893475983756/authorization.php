<!DOCTYPE html>
<html lang="ua">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Авторизація</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto&display=swap" rel="stylesheet">
    <script defer src="./js/all.js"></script>
	<link rel="stylesheet" href="css/input.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <div class="form_container">
        <form method="POST" action="/auth" class="auth_form">
            <input type="hidden" name="auth">
            <input type="email" name="email" placeholder="Введіть email...">
            <input type="password" name="pass" placeholder="Введіть пароль...">
            <button type="submit" class="submit_button">Увійти</button>
        </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/sendRequest.js"></script>
</body>
</html>