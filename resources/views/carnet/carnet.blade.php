<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet Digital SENA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .card {
            width: 340px;
            height: 460px;
            background: linear-gradient(184deg,
                        #4ef84e 0%,
                        #4ef84e 15%,
                        rgba(225, 239, 218, 0.9) 35%,
                        #e1efda 40%,
                        #e1efda 100%);
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .logo-container {
            position: absolute;
            top: 15px;
            left: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80px;
        }
        .logo {
            width: 70px;
            height: auto;
        }
        .logo-text {
            font-size: 12px;
            color: #333333;
            margin-top: 5px;
            font-weight: 600;
            text-align: center;
        }
        .aprendiz-container {
            position: absolute;
            top: 20px;
            right: 30px;
            width: 140px;
            height: 130px;
            overflow: hidden;
            border-radius: 10px;
        }
        .aprendiz-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            mask-image: linear-gradient(to bottom, black 90%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 90%, transparent 100%);
        }
        .info-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px;
        }
        .aprendiz-title {
            font-weight: 600;
            font-size: 18px;
            font-weight: bold;
        }
        .separator {
            border: none;
            height: 2px;
            background-color: #39ff14;
        }
        .cedula, .ficha, .programa {
            font-size: 14px;
            font-weight: 400;
        }
        .nombre {
            font-weight: 600;
            font-size: 18px;
            text-align: center;
        }
        .programa {
            font-size: 12px;
        }
        .qr-container {
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            background-color: rgba(78, 248, 78, 0.2);
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .qr {
            top: 20px;
        }
    </style>
</head>
<body>
    @foreach($carnets as $carnet)
    <div class="card">
        <div class="logo-container">
            <img src="{{ asset('img/sena-logo.png') }}" alt="Logo SENA" class="logo">
            <div class="logo-text">SENA</div>
        </div>
        <div class="aprendiz-container">
            @if($carnet['photo'])
                <img src="data:image/jpeg;base64,{{ $carnet['photo'] }}" alt="Foto del Aprendiz" class="aprendiz-img">
            @else
                <img src="{{ asset('img/default-photo.jpg') }}" alt="Foto por defecto" class="aprendiz-img">
            @endif
        </div>
        <div class="info-container">
            <h2 class="aprendiz-title">Aprendiz</h2>
            <hr class="separator">
            <p class="nombre">{{ $carnet['aprendiz'] }}</p>
            <p class="cedula">CC: {{ $carnet['documento'] }}</p>
            <p class="ficha">Ficha: {{ $carnet['ficha'] }}</p>
            <p class="programa">{{ $carnet['programa'] }}</p>
        </div>
        <div class="qr-container">
            <div class="qr">{!! $carnet['qr_code'] !!}</div>
        </div>
    </div>
    @endforeach
</body>
</html>