<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Carnets Digitales</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .drag-active {
            border-color: #3b82f6 !important;
            background-color: rgba(59, 130, 246, 0.1) !important;
        }
        
        .file-selected {
            border-color: #22c55e !important;
            background-color: rgba(34, 197, 94, 0.1) !important;
        }

        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            font-family: 'Poppins', Arial, sans-serif;
        }

        .upload-zone {
            border: 2px dashed #4b5563;
            transition: all 0.3s ease;
        }

        .upload-zone:hover {
            border-color: #6b7280;
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body class="p-8">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Encabezado -->
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Generador de Carnets Digitales</h1>
            <p class="text-gray-300">Sube tus archivos y genera carnets profesionales en segundos</p>
        </div>

        <!-- Formulario principal -->
        <form action="{{ route('carnet.process') }}" method="POST" enctype="multipart/form-data" id="carnetForm">
            @csrf
            
            <div class="bg-gray-800 rounded-lg shadow-xl p-6 space-y-6">
                <!-- Zona de carga CSV -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium mb-2">
                        Archivo CSV
                    </label>
                    <div class="upload-zone rounded-lg p-8 text-center" id="csvDropZone">
                        <input type="file" 
                               name="csv_file" 
                               id="csvFile" 
                               accept=".csv" 
                               class="hidden" 
                               required>
                        <svg class="upload-icon text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-200 mb-1" id="csvLabel">
                            Arrastra tu archivo CSV aquí
                        </h3>
                        <p class="text-sm text-gray-400" id="csvSubLabel">
                            o haz clic para seleccionar
                        </p>
                    </div>
                </div>

                <!-- Zona de carga de fotos -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium mb-2">
                        Fotos de los Aprendices
                    </label>
                    <div class="upload-zone rounded-lg p-8 text-center" id="photosDropZone">
                        <input type="file" 
                               name="photos[]" 
                               id="photoFiles" 
                               accept="image/*" 
                               multiple 
                               class="hidden" 
                               required>
                        <svg class="upload-icon text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-200 mb-1" id="photosLabel">
                            Arrastra las fotos aquí
                        </h3>
                        <p class="text-sm text-gray-400" id="photosSubLabel">
                            o haz clic para seleccionar
                        </p>
                    </div>
                </div>

                <!-- Botón de envío -->
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    Generar Carnets
                </button>
            </div>

            <!-- Instrucciones -->
            <div class="bg-gray-800 rounded-lg shadow-xl p-6 mt-6">
                <h2 class="text-xl font-bold text-white mb-4">Instrucciones</h2>
                <div class="bg-gray-700 rounded-lg p-4 text-gray-300">
                    <ul class="list-disc pl-4 space-y-2">
                        <li>El archivo CSV debe contener las columnas: Aprendiz, Documento, Correo</li>
                        <li>Los campos deben estar separados por punto y coma (;)</li>
                        <li>La primera fila debe contener los nombres de las columnas</li>
                        <li>Debe subir una foto por cada aprendiz listado en el CSV</li>
                        <li>Las fotos deben estar en formato JPG, PNG o JPEG</li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

    <script>
        function setupDropZone(dropZoneId, inputId, labelId, subLabelId, isMultiple = false) {
            const dropZone = document.getElementById(dropZoneId);
            const input = document.getElementById(inputId);
            const label = document.getElementById(labelId);
            const subLabel = document.getElementById(subLabelId);

            // Activar input al hacer clic en la zona
            dropZone.addEventListener('click', () => input.click());

            // Manejar el drag & drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Estilos durante el arrastre
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.add('drag-active');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.remove('drag-active');
                });
            });

            // Manejar archivos soltados
            dropZone.addEventListener('drop', (e) => {
                const files = e.dataTransfer.files;
                input.files = files;
                updateLabel(files);
            });

            // Manejar selección mediante el input
            input.addEventListener('change', (e) => {
                updateLabel(e.target.files);
            });

            function updateLabel(files) {
                if (files.length > 0) {
                    dropZone.classList.add('file-selected');
                    if (isMultiple) {
                        label.textContent = `${files.length} archivo${files.length === 1 ? '' : 's'} seleccionado${files.length === 1 ? '' : 's'}`;
                    } else {
                        label.textContent = files[0].name;
                    }
                    subLabel.textContent = 'Archivo(s) listo(s) para subir';
                } else {
                    dropZone.classList.remove('file-selected');
                    label.textContent = isMultiple ? 'Arrastra las fotos aquí' : 'Arrastra tu archivo CSV aquí';
                    subLabel.textContent = 'o haz clic para seleccionar';
                }
            }
        }

        // Inicializar las zonas de drop
        document.addEventListener('DOMContentLoaded', () => {
            setupDropZone('csvDropZone', 'csvFile', 'csvLabel', 'csvSubLabel');
            setupDropZone('photosDropZone', 'photoFiles', 'photosLabel', 'photosSubLabel', true);
        });
    </script>
</body>
</html>