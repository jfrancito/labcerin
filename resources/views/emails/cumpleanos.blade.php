<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />

        <style>
            .banner{
                margin: 0 auto;
                text-align: center;
            }
            .mensaje{
                margin: 0 auto;
                width: 700px;
                text-align: center;
            }
            .mensaje p{
                text-align: center;
            }
            .mensaje .nombre{
                font-size: 20px;
                font-weight: bold;
                color: #666666;
                font-style: italic;
            }
            .mensaje .fc{
                color: #50B948;
                font-size: 24px;
                font-weight: bold;
            }
            .mensaje .agradecimiento{
                color: #999999;
                padding-left: 40px;
                padding-right: 40px;
                margin-bottom: 0px;
            }
            .mensaje .empresa{
                font-weight: bold;
                color: #999999; 
                font-size: 20px; 
                margin-top: 0px;                              
            }
        </style>


    </head>


    <body>
    	<section>
            <div class='banner'>
                <img src="{{ $message->embed('http://alfasweb.com/img/cumpleanos/cumpleanos.png')}}" alt="Banner" />
            </div>
            <div class='mensaje'>
                <p class='nombre'>Querido(a) {{$nombres}} {{$apellidopaterno}} {{$apellidomaterno}},</p>
                <p class='fc'>¡Feliz cumpleaños!</p>
                <p class='agradecimiento'>Reciba el saludo de cumpleaños de toda la familia de la corporación Induamerica, que dios le siga bendiciendo, le dé mucha felicidad y salud</p>
                <p class='agradecimiento'>
                    Que tus regalos hoy sean amor y felicidad sobre todo la bendicion de DIOS.<br>
                    Sin ti no estaríamos allí donde estamos ahora.<br>
                    Que tu día este lleno de dulces sorpresas.</p>
                <p class='agradecimiento'>Sinceramente</p>
                <p class='empresa'>Familia Induamerica.</p>
            </div>            
		</section>
    </body>

</html>


