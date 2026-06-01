<!DOCTYPE html>
<html>
<head>
    <title>Registrar Vehículo</title>
</head>
<body>

    <h1>Registrar Vehículo</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/vehiculos" method="POST">
        @csrf

        <div>
            <label>Placa:</label>
            <input type="text" name="placa" value="{{ old('placa') }}">
        </div>

        <br>

        <div>
            <label>Marca:</label>
            <input type="text" name="marca" value="{{ old('marca') }}">
        </div>

        <br>

        <div>
            <label>Modelo:</label>
            <input type="text" name="modelo" value="{{ old('modelo') }}">
        </div>

        <br>

        <div>
            <label>Nombre del Propietario:</label>
            <input type="text" name="propietario" value="{{ old('propietario') }}">
        </div>

        <br>

        <button type="submit">
            Registrar Vehículo
        </button>

    </form>

</body>
</html>