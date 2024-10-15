<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Carnet Digital SENA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
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
            margin: 0 auto;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Hola {{ $aprendiz }},</h1>
        <p>Adjunto encontrarás tu carnet digital.</p>
        
        <div class="card">
            <div class="logo-container">
                <img src="{{ $message->embed(public_path('img/sena-logo.png')) }}" alt="Logo" class="logo">
                <span class="logo-text">Regional Guaviare</span>
            </div>
            <div class="aprendiz-container">
                <img src="{{ $message->embed('data:image/jpeg;base64,' . $photo) }}" alt="Foto del aprendiz" class="aprendiz-img">
            </div>
            <div class="info-container">
                <h2 class="aprendiz-title">APRENDIZ</h2>
                <hr class="separator">
                <p class="nombre">{{ $aprendiz }}</p>
                <p class="cedula">C.C. {{ $documento }}</p>
                <p class="ficha">Ficha: {{ $ficha }}</p>
                <p class="programa">{{ $programa }}</p>
            </div>
            <div class="qr-container">
                {!! $qr_code !!}
            </div>
        </div>
        
        <p>Gracias por ser parte de nuestra institución.</p>
    </div>
</body>
</html>

