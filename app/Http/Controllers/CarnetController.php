<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;

class CarnetController extends Controller
{
    public function index()
    {
        return view('carnet.index');
    }

    public function processCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $csvFile = $request->file('csv_file');
        $photos = $request->file('photos', []);

        $csvData = array_map(function ($line) {
            return str_getcsv($line, ';'); // Usar punto y coma como separador
        }, file($csvFile->getPathname()));

        array_shift($csvData); // Eliminar la primera fila (encabezados)

        $carnets = [];

        foreach ($csvData as $index => $row) {
            // Verificar si la fila tiene al menos 5 elementos (ahora incluimos Ficha y Programa)
            if (count($row) < 5 || empty(array_filter($row))) {
                continue; // Saltar esta fila si no tiene suficientes datos o está vacía
            }

            $Aprendiz = trim($row[0]) ?? 'Sin nombre';
            $Documento = trim($row[1]) ?? 'Sin documento';
            $Correo = trim($row[2]) ?? 'Sin correo';
            $Ficha = trim($row[3]) ?? 'Sin ficha';
            $Programa = trim($row[4]) ?? 'Sin programa';

            // Dividir el nombre completo
            $nombrePartes = explode(' ', $Aprendiz);
            $nombres = implode(' ', array_slice($nombrePartes, 0, -2)); // Todos menos los dos últimos
            $apellidos = implode(' ', array_slice($nombrePartes, -2)); // Los dos últimos

            // Formatear los datos para el QR
            $qrData = "{$nombres}|{$apellidos}|{$Documento}";
            $qrCode = new QrCode($qrData);
            $writer = new SvgWriter();
            $qrCodeSvg = $writer->write($qrCode)->getString();

            $carnet = [
                'aprendiz' => $Aprendiz,
                'documento' => $Documento,
                'correo' => $Correo,
                'ficha' => $Ficha,
                'programa' => $Programa,
                'qr_code' => $qrCodeSvg,
                'photo' => isset($photos[$index]) ? $photos[$index]->store('photos', 'public') : null,
            ];

            $carnets[] = $carnet;
        }

        if (empty($carnets)) {
            return back()->with('error', 'No se pudo procesar ningún dato del CSV. Por favor, verifica el formato del archivo.');
        }

        return view('carnet.result', compact('carnets'));
    }
}