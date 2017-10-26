<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- TITLE -->
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="{{asset('apple-touch-icon.png')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
    <script src="{{asset('js/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">             
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    <!-- =========================
        START HEADER SECTION
    ============================== -->
    @if(isset($resource_header) && $resource_header === true)
        @include('layouts.common.resource_hearder')
     @else
        @include('layouts.common.header')
    @endif
    <!-- =========================
        END HEADER SECTION
    ============================== -->

    @yield('content')

     <!-- =========================
        START SOCIAL SHARE SECTION
    ============================== --> 
        @include('layouts.common.social')                        
    <!-- =========================
        END SOCIAL SHARE SECTION
    ============================== --> 


    <!-- =========================
        START FOOTER SECTION
    ============================== -->   
        @include('layouts.common.footer')
    <!-- =========================
        END FOOTER SECTION
    ============================== -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')
    <?php $messages= ['success','danger','warning']; foreach($messages as $msg){?>
    @if(session()->has($msg))
        <script type="text/javascript">
            new PNotify({
                title: '{{ucfirst($msg)}} Message',
                text: '{!! session($msg) !!}',
                shadow: true,
                addclass: 'stack_top_right',
                type: '{{$msg}}',
                width: '290px',
                delay: 2000
            });
        </script>
    @endif
    <?php }?>
</body>
</html>