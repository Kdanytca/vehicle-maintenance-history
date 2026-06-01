<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Mantenimientos por Placa</title>
</head>
<body>

    <h1>Reporte de Mantenimientos</h1>

    <form action="/reportes/placa/buscar" method="GET">

        <label>Número de placa:</label>
        <input type="text" name="placa">

        <button type="submit">
            Buscar
        </button>

    </form>

    <hr>

    @if(isset($mensaje))
        <p>{{ $mensaje }}</p>
    @endif

    @if(isset($vehiculo))

        <h2>Vehículo</h2>

        <p>
            <strong>Placa:</strong>
            {{ $vehiculo->placa }}
        </p>

        <p>
            <strong>Marca:</strong>
            {{ $vehiculo->marca }}
        </p>

        <p>
            <strong>Modelo:</strong>
            {{ $vehiculo->modelo }}
        </p>

        <h2>Mantenimientos</h2>

        <table border="1">

            <tr>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Costo</th>
            </tr>

            @foreach($mantenimientos as $mantenimiento)

                <tr>
                    <td>{{ $mantenimiento->fecha_servicio }}</td>
                    <td>{{ $mantenimiento->descripcion_falla }}</td>
                    <td>{{ $mantenimiento->estado }}</td>
                    <td>${{ $mantenimiento->costo_mano_obra }}</td>
                </tr>

            @endforeach

        </table>

    @endif

</body>
</html>