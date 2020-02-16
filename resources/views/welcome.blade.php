<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                <?php 
            /*$config = [
                // Mandatory Configuration Options
                'hosts'            => ['10.0.2.53'],
                'base_dn'          => 'dc=una,dc=ac,dc=cr',
                'username'         => '',
                'password'         => '',

                // Optional Configuration Options
                'schema'           => Adldap\Schemas\ActiveDirectory::class,
                'account_prefix'   => '',
                'account_suffix'   => '',
                'port'             => 389,
                'follow_referrals' => false,
                'use_ssl'          => false,
                'use_tls'          => false,
                'version'          => 3,
                'timeout'          => 5,

                // Custom LDAP Options
                'custom_options'   => [
                    // See: http://php.net/ldap_set_option
                    LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_HARD
                ]
            ];

            $ad = new Adldap\Adldap();

                $connectionName = 'my-connection';

                $ad->addProvider($config, $connectionName);
                $username = '402340420';
                $checkdn='uid='.$username.', ou=People, dc=una,dc=ac,dc=cr';
                $password = '931997dm';
                //uid=402340420, ou=People, dc=una,dc=ac,dc=cr;
                try {
                    $provider = $ad->connect($connectionName);

                    echo "Great, we're connected!";
                    if($provider->auth()->attempt($checkdn, $password)){
                        echo "login";
                    }
                } catch (Adldap\Auth\BindException $e) {
                    echo "Failed to connect";
                }
               // xdebug_break();   */          
              
               
            ?>
                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
