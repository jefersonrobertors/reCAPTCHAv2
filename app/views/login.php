<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="center">
        <?php \app\utils\Flash::display('login'); ?>   
        <form action="/login" method="post">
            <input type="email" name="email" id="email" autocomplete="off">
            <input type="password" name="password" id="password" autocomplete="off">
            <?php \app\services\CsfrProtection::show(); ?>
            <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['G_RECAPTCHA_SITE_KEY']; ?>"></div>
            <input type="submit" value="Submit">
        </form>
    </div>
    <script src="/public/js/main.js"></script>
</body>
</html>