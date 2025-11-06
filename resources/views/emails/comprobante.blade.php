<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Voto</title>
</head>
<body>
    <h2>Comprobante de Voto</h2>
    <p>Tu voto fue registrado correctamente.</p>
    <p><strong>ID:</strong> {{ $voto->user->numero_comprobante }}</p>
    <p><strong>Fecha:</strong> {{ now()->format('d/m/Y H:i') }}</p>
    <p>Gracias por confiar en SED - Sistema Electoral Digital
</html>
