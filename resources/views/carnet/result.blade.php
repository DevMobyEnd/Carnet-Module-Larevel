<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnets Digitales Generados</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .card {
            width: 400px;
            height: 300px;
            background: linear-gradient(184deg, #ececec 0%, #ececec 25%, #f9f9f9 25%, #f9f9f9 100%);
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }
        .qr-code {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .qr-code svg {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="bg-gray-100" x-data="carnetApp()">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Carnets Digitales Generados</h1>
        
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-center">Lista de Aprendices</h2>
            <ul class="bg-white shadow-md rounded-lg divide-y divide-gray-200">
                <template x-for="(carnet, index) in carnets" :key="index">
                    <li class="px-6 py-4 flex items-center justify-between">
                        <span class="text-lg" x-text="carnet.aprendiz"></span>
                        <button 
                            @click="selectedCarnet = index" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        >
                            Mostrar Carnet
                        </button>
                    </li>
                </template>
            </ul>
        </div>

        <div x-show="selectedCarnet !== null" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" x-cloak>
            <div class="relative top-20 mx-auto p-5 border shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4 text-center">Carnet Digital</h3>
                    <div class="mt-2 px-7 py-3">
                        <template x-if="selectedCarnet !== null">
                            <div class="card">
                                <div class="flex justify-between w-full mb-4">
                                    <div class="text-left">
                                        <h4 x-text="carnets[selectedCarnet].aprendiz" class="text-xl font-bold"></h4>
                                        <p class="text-sm"><strong>Documento:</strong> <span x-text="carnets[selectedCarnet].documento"></span></p>
                                        <p class="text-sm"><strong>Correo:</strong> <span x-text="carnets[selectedCarnet].correo"></span></p>
                                    </div>
                                    <template x-if="carnets[selectedCarnet].photo">
                                        <img :src="'/storage/' + carnets[selectedCarnet].photo" :alt="'Foto de ' + carnets[selectedCarnet].aprendiz" class="w-24 h-24 object-cover rounded-full">
                                    </template>
                                </div>
                                <div class="qr-code mt-4" x-html="carnets[selectedCarnet].qr_code"></div>
                            </div>
                        </template>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button @click="selectedCarnet = null" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('carnet.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-block">
                Volver al inicio
            </a>
        </div>
    </div>

    <script>
        function carnetApp() {
            return {
                carnets: @json($carnets),
                selectedCarnet: null
            }
        }
    </script>
</body>
</html>