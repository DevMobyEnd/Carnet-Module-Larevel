<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Carnets Digitales</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Generador de Carnets Digitales</h1>
        
        <form action="{{ route('carnet.process') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="csv_file">
                    Archivo CSV
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="csv_file" type="file" name="csv_file" accept=".csv" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="photos">
                    Fotos de los Aprendices
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="photos" type="file" name="photos[]" accept="image/*" multiple required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Generar Carnets
                </button>
            </div>
        </form>
        
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-bold mb-4">Instrucciones</h2>
            <ol class="list-decimal list-inside">
                <li class="mb-2">Prepare un archivo CSV con las columnas: Aprendiz, Documento, Correo (separados por punto y coma ';').</li>
                <li class="mb-2">Asegúrese de que la primera fila del CSV contenga los encabezados.</li>
                <li class="mb-2">Prepare las fotos de los aprendices (una por cada fila del CSV, excluyendo la primera fila de encabezados).</li>
                <li class="mb-2">Suba el archivo CSV y las fotos usando el formulario anterior.</li>
                <li>Haga clic en "Generar Carnets" para crear los carnets digitales.</li>
            </ol>
        </div>
    </div>
</body>
</html>