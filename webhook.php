<?php
// Configura la cabecera para indicar que se espera JSON
header('Content-Type: application/json');

// Captura y decodifica el JSON recibido
$data = json_decode(file_get_contents('php://input'), true);

// Guarda todo lo recibido en un archivo para registro (opcional y útil para depurar)
file_put_contents('whatsapp_log.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);

// Validar que existen los datos esperados
if (isset($data['type'], $data['from'], $data['from_name'], $data['to'], $data['message'])) {
    
    // Almacenar los datos en variables
    $type = $data['type'];
    $from = $data['from'];
    $fromName = $data['from_name'];
    $to = $data['to'];
    $message = strtolower($data['message']);

    // Puedes responder o ejecutar lógica según el mensaje
    if ($message === 'hello') {
        // Por ejemplo, puedes llamar otra API, guardar en base de datos, etc.
        file_put_contents('respuestas.txt', "Saludo de $fromName ($from): $message\n", FILE_APPEND);
    } elseif ($message === 'bye') {
        file_put_contents('respuestas.txt', "Despedida de $fromName ($from): $message\n", FILE_APPEND);
    } elseif ($message === 'test') {
        file_put_contents('respuestas.txt', "Prueba recibida de $fromName ($from)\n", FILE_APPEND);
    }

    // Puedes devolver un mensaje de éxito si quieres (opcional)
    echo json_encode(['status' => 'ok', 'message' => 'Mensaje procesado']);
} else {
    // Datos incompletos o mal formateados
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos o JSON mal formado']);
}


?>
