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

// Receber e validar os dados do boletim
$dadosRecebidos = json_decode(file_get_contents("php://input"), true);
if (!isset($dadosRecebidos['numero_boletim']) || !isset($dadosRecebidos['produtor']) || !isset($dadosRecebidos['peso_lote'])) {
    http_response_code(400);
    echo json_encode(["erro" => "Dados incompletos"]);
    exit;
}

// Preparar a inserção no banco de dados
try {
    $stmt = $pdo->prepare("INSERT INTO boletins (numero_boletim, produtor, especie, cultivar, safra, categoria, peso_lote) VALUES (:numero_boletim, :produtor, :especie, :cultivar, :safra, :categoria, :peso_lote)");
    $stmt->execute([
        ':numero_boletim' => $dadosRecebidos['numero_boletim'],
        ':produtor' => $dadosRecebidos['produtor'],
        ':especie' => $dadosRecebidos['especie'],
        ':cultivar' => $dadosRecebidos['cultivar'],
        ':safra' => $dadosRecebidos['safra'],
        ':categoria' => $dadosRecebidos['categoria'],
        ':peso_lote' => $dadosRecebidos['peso_lote']
    ]);
    $protocolo = $pdo->lastInsertId();
    http_response_code(200);
    echo json_encode(["sucesso" => "Dados recebidos com sucesso", "protocolo" => $protocolo]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Falha ao salvar dados"]);
}
?>
