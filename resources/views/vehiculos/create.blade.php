<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vehículo</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#081426;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
        }

        .container{
            width:500px;
            background:#13233d;
            padding:35px;
            border-radius:15px;
            box-shadow:0 0 20px rgba(0,0,0,0.4);
        }

        h1{
            text-align:center;
            margin-bottom:25px;
            color:#ffffff;
        }

        .mensaje-exito{
            background:#0d6832;
            color:white;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
        }

        .errores{
            background:#8b1e1e;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
        }

        .errores ul{
            margin-left:20px;
        }

        .campo{
            margin-bottom:18px;
        }

        label{
            display:block;
            margin-bottom:8px;
            color:#cfd8e3;
        }

        input{
            width:100%;
            padding:12px;
            border:none;
            border-radius:8px;
            background:#1b3154;
            color:white;
        }

        input:focus{
            outline:none;
            border:2px solid #1ea7ff;
        }

        button{
            width:100%;
            padding:14px;
            border:none;
            border-radius:8px;
            background:#18a8ff;
            color:white;
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#0f93e2;
        }
    </style>

</head>
<body>

    <div class="container">

        <h1>Registrar Vehículo</h1>

        @if(session('success'))
            <div class="mensaje-exito">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="errores">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/vehiculos" method="POST">

            @csrf

            <div class="campo">
                <label>Placa</label>
                <input type="text" name="placa" value="{{ old('placa') }}">
            </div>

            <div class="campo">
                <label>Marca</label>
                <input type="text" name="marca" value="{{ old('marca') }}">
            </div>

            <div class="campo">
                <label>Modelo</label>
                <input type="text" name="modelo" value="{{ old('modelo') }}">
            </div>

            <div class="campo">
                <label>Nombre del Propietario</label>
                <input type="text" name="propietario" value="{{ old('propietario') }}">
            </div>

            <button type="submit">
                Registrar Vehículo
            </button>

        </form>

    </div>

</body>
</html>