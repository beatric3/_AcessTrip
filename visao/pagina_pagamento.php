<?php
session_start();

$titulo = $_SESSION['titulo_servico'] ?? 'Serviço';
$valorRaw = $_SESSION['valor_servico'] ?? 0;
$valor = number_format($valorRaw, 2, ',', '.');

$preferenceId = $_GET['preference_id'] ?? null;

if (!$preferenceId) {
    die("ID da preferência de pagamento não encontrado. Volte e tente novamente.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Confirmação de Pagamento - AcessTrip</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #E9ECEF;
            margin: 0;
            padding: 0;
            color: #212529;
        }

        .container {
            max-width: 480px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1 {
            font-weight: 700;
            font-size: 28px;
            color: #1B263B;
            margin-bottom: 25px;
        }

        .servico-info p {
            font-size: 18px;
            margin: 12px 0;
            color: #34495E;
        }

        .servico-info strong {
            color: #117A65;
            font-weight: 700;
        }

        .preco {
            font-weight: 700;
            font-size: 24px;
            color: #117A65;
            margin-top: 10px;
        }

        .botao-pagar {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Confirmação de Pagamento</h1>
    <div class="servico-info">
        <p>Serviço: <strong><?= htmlspecialchars($titulo) ?></strong></p>
        <p>Valor: <span class="preco">R$ <?= $valor ?></span></p>
    </div>

    <div class="botao-pagar" id="wallet_container"></div>
</div>

<!-- SDK Mercado Pago -->
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>                        
    const mp = new MercadoPago("APP_USR-706cefe9-d1a8-43d1-87dd-61ba5878280f", {
        locale: "pt-BR"
    });

    mp.checkout({
        preference: {
            id: "<?= $preferenceId ?>"
        },
        render: {
            container: "#wallet_container",
            label: "Pagar com Mercado Pago"
        }
    });
</script>

</body>
</html>
