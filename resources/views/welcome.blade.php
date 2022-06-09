<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel EventStream</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
        <script src="{{ asset('js/app.js') }}" ></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body>
        <div class="container w-full mx-auto pt-20">
            <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

                <div class="flex flex-wrap">
                    <div class="w-full md:w-2/2 xl:w-3/3 p-3">
                        <div class="bg-white border rounded shadow p-2">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded p-3 bg-yellow-600"><i class="fas fa-user-plus fa-2x fa-fw fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h5 class="font-bold uppercase text-gray-500">Latest trade</h5>
                                    <h3 class="font-bold text-3xl">
                                        <p>
                                            Name: <span id="latest_trade_user"></span>
                                        </p>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="contadorDiv">
            <a id="contador" onclick="showDiv()" role="button"></a>
        </div>
        <div class="hidden" id="notificationsDiv">  
        </div>
        <div class="container w-full mx-auto" style="border:0.5px; border:solid;" id="currentDiv">
            <form action="/" method="POST" id="form">
                
                <label>Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"/>
                <label>Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad"/>
                <input type="hidden" id="data">
                @csrf
                <button type="submit" class="btn btn-info mt-2 mb-2" onclick="submiForm()">Enviar</button>
            </form>


        </div>

    </body>
    
    <script>
        var count=0;
        Echo.channel('trades')
            .listen('NewTrade', (e) => {
                count++;
                console.log(e.trade);
                document.getElementById('latest_trade_user').innerText = e.trade;
                document.getElementById('contador').innerText = 'tienes '+count +' notificaciones nuevas';
                var medadiv = document.getElementById("notificationsDiv") ;      
                var newDiv = document.createElement('div');
                var newNotification = document.createTextNode("Nueva publicacion de "+e.trade);
                newDiv.appendChild(newNotification);
                var currentDiv = document.getElementById("currentDiv");
                medadiv.appendChild(newDiv);
            });

            function showDiv()
        {
            var div = document.getElementById("notificationsDiv");
            div.classList.remove('hidden');
            div.classList.add('visible');
console.log(div) 
       }
        function submiForm() {
            var form = document.getElementById("form");
            var nombre =  document.getElementById("nombre").value;
            var cantidad = document.getElementById("cantidad").value;
            var data ;

            data = [nombre, cantidad];
            var inputData = document.getElementById("data");
            inputData.value = data;
            console.log(inputData.value);
            inputData = JSON.stringify(inputData);
            //data = JSON.stringify("nombre" => nombre, "cantidad" => cantidad);
            form.submit();
           
        }    
    </script>
</html>