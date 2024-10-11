<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use GuzzleHttp\Client;
use App\Mail\CarnetMail;



class CarnetController extends Controller
{
    private $backgroundRemovalApiUrl = 'http://127.0.0.1:5000/remove_background';

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
        $photos = $request->file('photos') ?? [];

        $csvData = array_map(function ($line) {
            return str_getcsv($line, ';');
        }, file($csvFile->getPathname()));

        array_shift($csvData);

        $carnets = [];

        foreach ($csvData as $index => $row) {
            if (count($row) < 5 || empty(array_filter($row))) {
                continue;
            }

            $Aprendiz = trim($row[0]) ?? 'Sin nombre';
            $Documento = trim($row[1]) ?? 'Sin documento';
            $Correo = trim($row[2]) ?? 'Sin correo';
            $Ficha = trim($row[3]) ?? 'Sin ficha';
            $Programa = trim($row[4]) ?? 'Sin programa';

            $nombrePartes = explode(' ', $Aprendiz);
            $nombres = implode(' ', array_slice($nombrePartes, 0, -2));
            $apellidos = implode(' ', array_slice($nombrePartes, -2));

            $qrData = "{$nombres}|{$apellidos}|{$Documento}";
            $qrCode = new QrCode($qrData);
            $qrCode->setSize(120);
            $writer = new SvgWriter();
            $qrCodeSvg = $writer->write($qrCode)->getString();

            $photoData = null;
            if (isset($photos[$index])) {
                $photoData = $this->removeImageBackground($photos[$index]);
            }

            $carnet = [
                'aprendiz' => $Aprendiz,
                'documento' => $Documento,
                'correo' => $Correo,
                'ficha' => $Ficha,
                'programa' => $Programa,
                'qr_code' => $qrCodeSvg,
                'photo' => $photoData,
            ];

            $carnets[] = $carnet;
        }

        if (empty($carnets)) {
            return back()->with('error', 'No se pudo procesar ningún dato del CSV. Por favor, verifica el formato del archivo.');
        }

        return view('carnet.result', compact('carnets'));
    }

    private function removeImageBackground($photo)
    {
        $client = new Client();

        try {
            // Verifica si $photo es una instancia válida de UploadedFile
            if (!$photo instanceof \Illuminate\Http\UploadedFile) {
                throw new \Exception("Invalid file provided");
            }

            // Asegúrate de que el archivo existe y es legible
            if (!$photo->isValid()) {
                throw new \Exception("Invalid or unreadable file");
            }

            $response = $client->post($this->backgroundRemovalApiUrl, [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen($photo->getRealPath(), 'r'),
                        'filename' => $photo->getClientOriginalName()
                    ]
                ]
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                $imageData = $response->getBody()->getContents();
                return base64_encode($imageData);
            } else {
                throw new \Exception("API returned status code: " . $statusCode);
            }
        } catch (\Exception $e) {
            // Log the error with more details
            Log::error('Error removing image background: ' . $e->getMessage(), [
                'file' => $photo ? $photo->getClientOriginalName() : 'No file',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // If there's an error, return the original image
            return $photo ? base64_encode(file_get_contents($photo->getRealPath())) : null;
        }
    }

    public function sendCarnetByEmail(Request $request)
    {
        $carnetData = $request->validate([
            'aprendiz' => 'required',
            'documento' => 'required',
            'correo' => 'required|email',
            'ficha' => 'required',
            'programa' => 'required',
            'qr_code' => 'required',
            'photo' => 'required'
        ]);

        try {
            Mail::send('emails.carnet', $carnetData, function ($message) use ($carnetData) {
                $message->to($carnetData['correo'], $carnetData['aprendiz'])
                    ->subject('Tu Carnet Digital SENA');
            });

            return response()->json(['message' => 'Carnet enviado con éxito']);
        } catch (\Exception $e) {
            Log::error('Error al enviar el carnet por correo: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo enviar el carnet'], 500);
        }
    }
    public function sendAll()
{
    $carnets = session('carnets', []);

    foreach ($carnets as $carnet) {
        // Asumiendo que tienes un campo 'email' en tus datos de carnet
        // Si no lo tienes, necesitarás ajustar esto para obtener el correo del aprendiz
        $email = $carnet['correo'];

        // Envía el correo
        Mail::to($email)->send(new CarnetMail($carnet));
    }

    return redirect()->route('carnet.result')->with('message', 'Todos los carnets han sido enviados por correo.');
}
}
