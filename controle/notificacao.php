<?php
require_once '../vendor/autoload.php';
require_once '../modelo/DAO/ContratacaoDAO.php';

MercadoPago\SDK::setAccessToken('APP_USR-3696188317831487-061419-3062dad8aa8172b6f918f8eb8a9ec3fc-2480703273');

$logFile = __DIR__ . '/notificacao.log';

function logMsg($msg) {
    global $logFile;
    $date = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$date] $msg" . PHP_EOL, FILE_APPEND);
}

logMsg("=== Nova notificação recebida via POST ===");

$input = file_get_contents("php://input");
logMsg("Corpo da requisição: $input");

$data = json_decode($input, true);
logMsg("Dados decodificados do JSON: " . print_r($data, true));

if (isset($data['topic']) && $data['topic'] === 'merchant_order') {
    logMsg("Notificação merchant_order ignorada.");
    http_response_code(200);
    exit("Notificação merchant_order ignorada.");
}

$payment_id = null;

if (isset($data['data']['id']) && isset($data['type']) && $data['type'] === 'payment') {
    $payment_id = $data['data']['id'];
    logMsg("Detectado formato v1. ID do pagamento: $payment_id");
} elseif (isset($data['resource']) && isset($data['topic']) && $data['topic'] === 'payment') {
    $payment_id = $data['resource'];
    logMsg("Detectado formato v0. ID do pagamento (resource): $payment_id");
} else {
    logMsg("Parâmetros inválidos ou notificação irrelevante. Encerrando.");
    http_response_code(400);
    exit("Notificação inválida");
}

try {
    $payment = MercadoPago\Payment::find_by_id($payment_id);
    logMsg("Dados do pagamento: " . print_r($payment, true));
} catch (Exception $e) {
    logMsg("Erro ao buscar pagamento: " . $e->getMessage());
    http_response_code(500);
    exit("Erro interno");
}

if ($payment && $payment->status === 'approved') {
    $status = $payment->status;
    $valor = $payment->transaction_amount;
    $dataAprovacao = $payment->date_approved;
    $external_reference = $payment->external_reference;

    if (!isset($external_reference) || strpos($external_reference, '|') === false) {
        logMsg("Referência externa inválida: $external_reference");
        http_response_code(400);
        exit("Referência externa inválida");
    }

    list($idUsuario, $idServico) = explode('|', $external_reference);

    $contratacaoDAO = new ContratacaoDAO();

    if ($contratacaoDAO->existePagamento($payment_id)) {
        logMsg("Pagamento já registrado. Ignorando.");
        http_response_code(200);
        exit("Pagamento já registrado");
    }

    $sucesso = $contratacaoDAO->registrarContratacao(
        $idServico,
        $idUsuario,
        $valor,
        $status,
        $dataAprovacao,
        $payment_id 
    );

    if ($sucesso) {
        logMsg("Registro salvo com sucesso no banco.");
        http_response_code(200);
        echo "Registro salvo com sucesso";
    } else {
        logMsg("Falha ao salvar no banco.");
        http_response_code(500);
        echo "Erro ao salvar no banco";
    }
} else {
    logMsg("Pagamento não aprovado ou não encontrado.");
    http_response_code(204);
}
