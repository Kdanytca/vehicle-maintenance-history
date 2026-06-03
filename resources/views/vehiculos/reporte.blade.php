<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Mantenimientos</title>

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
            padding:40px;
            color:white;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        .card{
            background:#13233d;
            border-radius:15px;
            padding:30px;
            margin-bottom:25px;
            box-shadow:0 0 20px rgba(0,0,0,0.3);
        }

        h1{
            margin-bottom:25px;
        }

        h2{
            margin-bottom:15px;
        }

        .formulario{
            display:flex;
            gap:15px;
            align-items:end;
        }

        .campo{
            flex:1;
        }

        label{
            display:block;
            margin-bottom:8px;
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
            padding:12px 25px;
            border:none;
            border-radius:8px;
            background:#18a8ff;
            color:white;
            font-weight:bold;
            cursor:pointer;
        }

        button:hover{
            background:#0f93e2;
        }

        .mensaje{
            background:#7a1d1d;
            padding:15px;
            border-radius:8px;
            margin-top:15px;
        }

        .vehiculo-info{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:20px;
        }

        .dato{
            background:#1b3154;
            padding:15px;
            border-radius:10px;
        }

        .dato strong{
            display:block;
            margin-bottom:8px;
            color:#18a8ff;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        th{
            background:#1b3154;
            padding:14px;
        }

        td{
            padding:12px;
            border-top:1px solid #2c446d;
            text-align:center;
        }

        tr:hover{
            background:#162948;
        }

        .pendiente{
            background:#a36a00;
            color:white;
            padding:6px 10px;
            border-radius:6px;
            font-size:13px;
        }

        .asignado{
            background:#0d6832;
            color:white;
            padding:6px 10px;
            border-radius:6px;
            font-size:13px;
        }

        @media(max-width:768px){

            .formulario{
                flex-direction:column;
            }

            .vehiculo-info{
                grid-template-columns:1fr;
            }
        }
    </style>

</head>
<body>

<div class="container">

    <div class="card">

        <h1>Reporte de Mantenimientos</h1>

        <form action="/reportes/placa/buscar" method="GET" class="formulario">

            <div class="campo">
                <label>Número de placa</label>
                <input type="text" name="placa">
            </div>

            <button type="submit">
                Buscar
            </button>

        </form>

    </div>

    @if(isset($mensaje))

        <div class="card">
            <div class="mensaje">
                {{ $mensaje }}
            </div>
        </div>

    @endif

    @if(isset($vehiculo))

        <div class="card">

            <h2>Información del Vehículo</h2>

            <div class="vehiculo-info">

                <div class="dato">
                    <strong>Placa</strong>
                    {{ $vehiculo->placa }}
                </div>

                <div class="dato">
                    <strong>Marca</strong>
                    {{ $vehiculo->marca }}
                </div>

                <div class="dato">
                    <strong>Modelo</strong>
                    {{ $vehiculo->modelo }}
                </div>

            </div>

        </div>

        <div class="card">

            <h2>Mantenimientos Registrados</h2>

            <table>

                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Costo</th>
                    <th>Mecánico</th>
                </tr>

                @foreach($mantenimientos as $mantenimiento)

                    <tr>

                        <td>{{ $mantenimiento->fecha_servicio }}</td>

                        <td>{{ $mantenimiento->descripcion_falla }}</td>

                        <td>{{ $mantenimiento->estado }}</td>

                        <td>${{ $mantenimiento->costo_mano_obra }}</td>

                        <td>

                            @if($mantenimiento->mecanico_encargado)

                                <span class="asignado">
                                    {{ $mantenimiento->mecanico_encargado }}
                                </span>

                            @else

                                <span class="pendiente">
                                    Pendiente de asignación
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

            </table>

        </div>

    @endif

</div>

</body>
</html>