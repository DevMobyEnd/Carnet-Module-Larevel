<!-- resources/views/emails/carnet.blade.php -->
<p>Hola {{ $carnet['aprendiz'] }},</p>
<p>Tu carnet digital está listo para descargar. Haz clic en el siguiente enlace para obtenerlo:</p>
<p><a href="{{ $downloadLink }}">Descargar Carnet</a></p>
<p>Este enlace es válido por 24 horas.</p>
