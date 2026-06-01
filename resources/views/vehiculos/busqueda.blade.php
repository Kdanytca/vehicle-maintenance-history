<!DOCTYPE html>
<html>
<head>
    <title>Búsqueda de Vehículos</title>
</head>
<body>

    <h1>Buscar Vehículo</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/vehiculos/buscar" method="GET">

        <label>Placa o Propietario:</label>
        <input type="text" name="termino">

        <button type="submit">
            Buscar
        </button>

    </form>

    <hr>

    @isset($vehiculos)

        @if($vehiculos->count() > 0)

            <h2>Resultados</h2>

            <table border="1">
                <tr>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Propietario</th>
                </tr>

                @foreach($vehiculos as $vehiculo)
                    <tr>
                        <td>{{ $vehiculo->placa }}</td>
                        <td>{{ $vehiculo->marca }}</td>
                        <td>{{ $vehiculo->modelo }}</td>
                        <td>
                            {{ \App\Models\Propietario::find($vehiculo->id_propietario)?->nombre }}
                        </td>
                    </tr>
                @endforeach

            </table>

        @else

            <p>No se encontraron resultados.</p>

        @endif

    @endisset

</body>
</html>