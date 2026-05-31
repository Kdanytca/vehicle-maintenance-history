<!DOCTYPE html>
<html>
<head>
    <title>Vehículos</title>
</head>
<body>

    <h1>Listado de Vehículos</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Propietario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehiculos as $vehiculo)
                <tr>
                    <td>{{ $vehiculo->placa }}</td>
                    <td>{{ $vehiculo->marca }}</td>
                    <td>{{ $vehiculo->modelo }}</td>
                    <td>{{ $vehiculo->anio }}</td>
                    <td>
                        {{ $vehiculo->propietario->nombre ?? 'Sin propietario' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>