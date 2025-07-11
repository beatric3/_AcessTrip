<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../modelo/DAO/ServicoDAO.php';
MercadoPago\SDK::setAccessToken('APP_USR-3696188317831487-061419-3062dad8aa8172b6f918f8eb8a9ec3fc-2480703273');

$servicoId = $_POST['servico_id'] ?? null;
$usuarioId = $_SESSION['usuario_id'] ?? null;

if (!$servicoId || !$usuarioId) {
    die("Serviço ou usuário inválido.");
}

$servicoDAO = new ServicoDAO();
$servico = $servicoDAO->buscarPorId($servicoId);

if (!$servico) {
    die("Serviço não encontrado.");
}

$item = new MercadoPago\Item();
$item->title = $servico->getTitulo();
$item->quantity = 1;
$item->unit_price = floatval($servico->getValor());

$preference = new MercadoPago\Preference();
$preference->items = [$item];

$preference->external_reference = "$usuarioId|$servicoId";
$preference->notification_url = "https://3554-2804-14c-65f3-8e5b-30a2-dccc-f061-9a2c.ngrok-free.app/AcessTrip/controle/notificacao.php";

$_SESSION['titulo_servico'] = $servico->getTitulo();
$_SESSION['valor_servico'] = $servico->getValor();

try {
    $preference->save();

    if (!$preference->id) {
        throw new Exception("Erro ao gerar preferência.");
    }

    header("Location: /AcessTrip/visao/pagina_pagamento.php?preference_id=" . $preference->id);
    exit;

} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
