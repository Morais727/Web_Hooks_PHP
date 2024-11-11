<?php
// Configuração de conexão com o banco de dados
$pdo = new PDO("mysql:host=localhost;dbname=semente_db", "usuario", "senha");

// Autenticação por Token, CNPJ e Senha
$headers = getallheaders();
if ($headers['Token'] !== 'seu_token_secreto' || $headers['CNPJ'] !== 'cnpj_autorizado' || $headers['Senha'] !== 'senha_autorizada') {
    http_response_code(403);
    echo json_encode(["erro" => "Acesso não autorizado"]);
    exit;
}

// Receber o número do boletim
$dadosRecebidos = json_decode(file_get_contents("php://input"), true);
if (!isset($dadosRecebidos['numero_boletim'])) {
    http_response_code(400);
    echo json_encode(["erro" => "Número do boletim não fornecido"]);
    exit;
}

$numero_boletim = $dadosRecebidos['numero_boletim'];

// Consultar o banco de dados para obter certificado e arquivo Base64
try {
    $stmt = $pdo->prepare("SELECT numero_certificado, arquivo_base64 FROM certificados WHERE numero_boletim = :numero_boletim");
    $stmt->execute([':numero_boletim' => $numero_boletim]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        http_response_code(200);
        echo json_encode([
            "certificado" => $resultado['numero_certificado'],
            "arquivo_base64" => $resultado['arquivo_base64']
        ]);
    } else {
        http_response_code(404);
        echo json_encode(["erro" => "Boletim não encontrado"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Erro ao buscar dados"]);
}
?>
