<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Planillas">
    <meta name="author" content="Cinthia Vivanco Gonzales">
    <link rel="icon" href="{{ asset('public/img/icono/cerin.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/alfasweb.css') }} "/>


    <title>Cerin</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css') }} "/>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}" type="text/css"/>


  </head>
  <body class="be-splash-screen">

    <div class="be-wrapper be-login">
      <div class="be-content ajaxpersonal">  
        <div class="main-content container-fluid">
          <div class="splash-container">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
              <div class="panel-heading">
                
              <img src="{{ asset('public/img/logologin.png') }}" alt="logo" width="170" height="120" class="logo-img">
              <span class="splash-description">Por favor ingrese su información de usuario.</span>
              </div>
              <div class="panel-body">

                <form method="POST" action="{{ url('login') }}">
                  {{ csrf_field() }}

                  <div class="form-group">

                    <input id="name" name='name' type="text" required = "" value="{{ old('name') }}"  placeholder="Usuario" autocomplete="off" class="form-control" data-aw="1"/>

                    @include('error.erroresvalidate', [ 'id' => $errors->has('name')  , 
                                                        'error' => $errors->first('name', ':message') , 
                                                        'data' => '1'])

                    @include('error.erroresbd', [ 'id' => Session::get('errorbd')  , 
                                                  'error' => Session::get('errorbd') , 
                                                  'data' => '1'])


                  </div>

                  <div class="form-group">
                    <input id="password" name='password' type="password" required = ""   placeholder="Clave" class="form-control" data-aw="2"/>
                    @include('error.erroresvalidate', ['id' => $errors->has('name')  , 'error' => $errors->first('name', ':message'), 'data' => '2'])
                    @include('error.erroresbd', ['id' => Session::get('errorbd')  , 'error' => Session::get('errorbd'), 'data' => '2'])

                  </div>


                  <div class="form-group login-submit">
                    <button data-dismiss="modal" type="submit"  class="btn btn-primary btn-xl">Inicia sesión</button>
                  </div>

                
                  <input type='hidden' id='carpeta' value="{{$capeta}}"/>
                  <input type="text" id="token"  class ="ocultar" name="_token"  value="{{ csrf_token() }}">

                </form>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('public/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>


    <script type="text/javascript">
      $(document).ready(function(){
        App.init();
        $('form').parsley();
      });
    </script>

    <script src="{{ asset('public/js/user/user.js') }}" type="text/javascript"></script>

  </body>
</html>