<?php

// namespace App\Jobs;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;
// use App\Mail\CarnetMail;
// use Illuminate\Support\Facades\Mail;
// use Barryvdh\DomPDF\Facade\Pdf;

// class SendCarnetEmail implements ShouldQueue
// {
//     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//     protected $carnetData;

//     public function __construct(array $carnetData)
//     {
//         $this->carnetData = $carnetData;
//     }

//     public function handle()
//     {
//         $pdf = $this->generatePdf();
//         $pdfPath = storage_path('app/carnets/' . $this->carnetData['documento'] . '.pdf');
//         $pdf->save($pdfPath);

//         // Verificar si existe una imagen para adjuntar
//         $imagePath = null;
//         if (isset($this->carnetData['photo']) && !empty($this->carnetData['photo'])) {
//             $imagePath = storage_path('app/photos/' . $this->carnetData['documento'] . '.jpg');
//             file_put_contents($imagePath, base64_decode($this->carnetData['photo']));
//         }

//         Mail::to($this->carnetData['correo'])->send(new CarnetMail($this->carnetData, $pdfPath, $imagePath));

//         // Eliminar archivos temporales
//         unlink($pdfPath);
//         if ($imagePath && file_exists($imagePath)) {
//             unlink($imagePath);
//         }
//     }

//     private function generatePdf()
//     {
//         return Pdf::loadView('pdf.carnet', ['carnet' => $this->carnetData]);
//     }
// }