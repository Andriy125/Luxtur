<!DOCTYPE html>
<html lang="ua">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>404</title>
</head>
<body style="display:flex; justify-content:center; align-items:center; height:85vh; background-color:#cca; padding:0;margin:0">
    <div class="wrapper" style="display:flex; flex-direction:column; align-items:center; ">
        <h1 style="font-size:66px; margin-bottom:10px; padding:0">404</h1>
        <p style="font-size:42px;">Page not found</p>
        <a href="#" class="link" style="text-decoration:none; font-size:24px; color:#333">Go back</a>
    </div>
<script>
    const link = document.querySelector('.link');
    link.addEventListener('click', () => {
        history.back();
    })
</script>
</body>
</html>