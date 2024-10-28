<?php

// namespace App\Services;

// use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\Storage;
// use Endroid\QrCode\QrCode;
// use Endroid\QrCode\Writer\SvgWriter;
// use GuzzleHttp\Client;
// use Intervention\Image\Facades\Image;
// use App\Jobs\SendCarnetEmail;

// class CarnetService
// {
//     private $backgroundRemovalApiUrl = 'http://127.0.0.1:5000/remove_background';
//     private $client;

//     public function __construct(Client $client)
//     {
//         $this->client = $client;
//     }

//     public function processCsvAndPhotos(UploadedFile $csvFile, array $photos)
//     {
//         $csvData = array_map(function ($line) {
//             return str_getcsv($line, ';');
//         }, file($csvFile->getPathname()));

//         array_shift($csvData);

//         $carnets = [];

//         foreach ($csvData as $index => $row) {
//             if (count($row) < 5 || empty(array_filter($row))) {
//                 continue;
//             }

//             $carnet = $this->createCarnetData($row);

//             if (isset($photos[$index])) {
//                 $carnet['photo'] = $this->processPhoto($photos[$index]);
//             }

//             $carnet['qr_code'] = $this->generateQrCode($carnet);

//             $carnets[] = $carnet;
//         }

//         return $carnets;
//     }

//     private function createCarnetData(array $row)
//     {
//         $aprendiz = trim($row[0]) ?? 'Sin nombre';
//         $documento = trim($row[1]) ?? 'Sin documento';
//         $correo = trim($row[2]) ?? 'Sin correo';
//         $ficha = trim($row[3]) ?? 'Sin ficha';
//         $programa = trim($row[4]) ?? 'Sin programa';

//         $nombrePartes = explode(' ', $aprendiz);
//         $nombres = implode(' ', array_slice($nombrePartes, 0, -2));
//         $apellidos = implode(' ', array_slice($nombrePartes, -2));

//         return [
//             'aprendiz' => $aprendiz,
//             'documento' => $documento,
//             'correo' => $correo,
//             'ficha' => $ficha,
//             'programa' => $programa,
//             'nombres' => $nombres,
//             'apellidos' => $apellidos,
//         ];
//     }

//     private function processPhoto(UploadedFile $photo)
//     {
//         $image = Image::make($photo);
//         $image->fit(300, 300);

//         $tempPath = storage_path('app/temp/' . uniqid() . '.jpg');
//         $image->save($tempPath);

//         $response = $this->client->post($this->backgroundRemovalApiUrl, [
//             'multipart' => [
//                 [
//                     'name' => 'file',
//                     'contents' => fopen($tempPath, 'r'),
//                 ],
//             ],
//         ]);

//         unlink($tempPath);

//         if ($response->getStatusCode() == 200) {
//             return base64_encode($response->getBody());
//         }

//         return null;
//     }

//     private function generateQrCode(array $carnetData)
//     {
//         $qrCode = QrCode::create(json_encode($carnetData))
//             ->setSize(300)
//             ->setMargin(10);

//         $writer = new SvgWriter();
//         $result = $writer->write($qrCode);

//         return $result->getString();
//     }

//     public function sendAllCarnets(array $carnets, array $capturedImages)
//     {
//         $results = ['success' => 0, 'fail' => 0];

//         foreach ($carnets as $index => $carnet) {
//             try {
//                 if (isset($capturedImages[$index])) {
//                     $carnet['captured_image'] = $capturedImages[$index];
//                 }

//                 SendCarnetEmail::dispatch($carnet);
//                 $results['success']++;
//             } catch (\Exception $e) {
//                 $results['fail']++;
//             }
//         }

//         return $results;
//     }
// }