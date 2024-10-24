<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet Digital</title>
    <style>
        /* Aquí copia todos los estilos relevantes de tu vista result.blade.php */
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
            font-family: 'Poppins', sans-serif;
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
            /* Ajusta este valor según sea necesario */
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


        
        .cedula,
        .ficha,
        .programa {
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

        /* Ajuste para el contenedor del QR */
        .qr-container {
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            background-color: rgba(78, 248, 78, 0.2);
            /* Verde transparente */
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }



        .qr {
            top: 20px;
        }
        /* ... incluye todos los demás estilos necesarios ... */
    </style>
</head>
<body>
    <div class="card mx-auto">
        <div class="logo-container">
            <img src="{{ asset('img/sena-logo.png') }}" alt="Logo" class="logo">
            <span class="logo-text">Regional Guaviare</span>
        </div>
        <div class="aprendiz-container">
            <template x-if="carnets[selectedCarnet].photo">
                <img :src="'data:image/jpeg;base64,' + carnets[selectedCarnet].photo"
                    :alt="'Foto de ' + carnets[selectedCarnet].aprendiz" class="aprendiz-img">
            </template>
        </div>
        <div class="info-container">
            <h2 class="aprendiz-title">APRENDIZ</h2>
            <hr class="separator">
            <p class="nombre" x-text="carnets[selectedCarnet].aprendiz"></p>
            <p class="cedula"><strong>CC:</strong> <span
                    x-text="carnets[selectedCarnet].documento"></span></p>
            <p class="ficha"><strong>Ficha:</strong> <span
                    x-text="carnets[selectedCarnet].ficha"></span></p>
            <p class="programa"><strong>Programa:</strong> <span
                    x-text="carnets[selectedCarnet].programa"></span></p>
        </div>
        <div class="qr-container">
            <div class="qr" x-html="carnets[selectedCarnet].qr_code"></div>
        </div>
    </div>
</body>
</html>