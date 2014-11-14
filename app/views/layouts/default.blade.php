<!DOCTYPE html>
<html lang="{{Config::get('app.locale')}}">
<head>
    <meta charset="utf-8" />
    <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <title>{{!empty($this->title) ? $this->title: ''}}</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    @include('layouts.link')
    <!-- JS files are loaded at the bottom of the page -->
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="top-header">
                <a class="logo" href="/"></a>
                @if (Auth::check())
                    <nav>
                        <ul>
                            @if(Auth::user()->role=='admin')
                                @include('include.navadmin')
                            @elseif(Auth::user()->role!='admin')
                                @include('include.nav')
                            @endif
                        </ul>
                    </nav>
                    <a class="exit" href="/logout">Выйти</a>
                @endif
                <span class="phone">8(8793) <span>40-72-90</span></span>
            </div>
            <div class="orang-block">
                <div class="inner-orang-block">
                    <span class="personal-account">Личный кабинет клиента</span>
                    <span class="search-number-keyword">Поиск по номеру или слову</span>
                    <div class="search-form">
                        {{Form::open(array('url'=>'search/index','method'=>'get'))}}
                            {{Form::text('q',Input::get('q'))}}
                            {{Form::submit('Поиск')}}
                        {{Form::close()}}
                    </div>
                    <span class="head-rog"></span>
                </div>
            </div>
        </header><!-- .header-->
        <main class="content">
            <div class="inner-content @if(Auth::check()) admin @endif">
                @yield('content')
            </div>
        </main><!-- .content -->
    </div><!-- .wrapper -->
    <footer class="footer">
        <div class="footer-inner-block">
            <span class="footer-rog"></span>
            <span class="copy">2008-2014 «Вебмастер КМВ»</span>
            <span class="address">г. Пятигорск, пр. Кирова, 61 а</span>
        </div>
    </footer><!-- .footer -->
    <div id="basic-modal-content" class="modal1">
        <span class="title">Очевидно, Вы не вняли нашим советам<br/> относительно хранения секретного пароля.</span>
        <span class="coll-phone">Для того, чтобы получить новый, звоните по номеру:</span>
        <span class="phone-number">8 (8793) <span>40-72-90</span></span>
        <span class="ready">И будьте готовы предоставить подтверждающие Вашу личность <br/>документы.</span>
    </div>
    @include('layouts.scripts')
</body>
</html>


