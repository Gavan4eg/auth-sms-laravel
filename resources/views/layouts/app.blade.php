<!DOCTYPE html>
<html lang="uk">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <!-- <style>body{opacity: 0;}</style> -->
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}">
    <link rel="shortcut icon" href="favicon.ico">
    <!-- <meta name="robots" content="noindex, nofollow"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<body>
<div class="wrapper">

    @yield('content')

    <footer class="footer">
        <div class="footer__container">
            <div class="footer__body">
                <a href="" class="footer__logo header__logo">php<span>laravel</span></a>
                <div class="footer__wrap">
                    <div class="footer__info">
                        <a href="" class="footer__link">Угода користувача</a>
                        <a href="" class="footer__link">Політика конфіденційності</a>
                        <a href="" class="footer__link">Оплата та повернення</a>
                    </div>
                    <a href="" class="footer__contact btn _icon-arrow-1">Звʼязатись</a>
                </div>
            </div>
        </div>
    </footer>
</div>
<script src="{{ asset('js/app.min.js') }}"></script>
</body>

</html>
