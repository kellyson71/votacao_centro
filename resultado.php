<?php
header('Content-Type: text/html; charset=utf-8');

$resultados = [
    ['nome' => 'Candidato Exemplo 1', 'imagem' => 'img/Foto Francisco.png', 'total_votos' => 120],
    ['nome' => 'Candidato Exemplo 2', 'imagem' => 'img/Foto Padre Sátiro.png', 'total_votos' => 85],
    ['nome' => 'Candidato Exemplo 3', 'imagem' => 'img/Foto Xixico.png', 'total_votos' => 45],
];

$total_geral = 0;
foreach ($resultados as $r) {
    $total_geral += $r['total_votos'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado — Votação Pública</title>
    <link rel="icon" type="image/png" href="img/Logo Prefeitura_SECOM 3.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --azul-claro: #00A9FF;
            --azul-escuro: #0063B6;
            --amarelo: #F4E000;
            --verde: #ABE61B;
            --bg-claro: #f5f7fa;
            --texto: #2d3748;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--texto);
            background: var(--bg-claro);
            min-height: 100vh;
        }

        .topo {
            background: linear-gradient(135deg, var(--azul-escuro), var(--azul-claro));
            padding: 50px 24px;
            text-align: center;
            color: #fff;
        }

        .topo h1 { font-size: 2rem; font-weight: 800; }
        .topo p { margin-top: 8px; font-size: 1rem; opacity: 0.85; }

        .container {
            max-width: 800px;
            margin: -40px auto 60px;
            padding: 0 24px;
        }

        .resultado-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            padding: 30px 36px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 24px;
            border: 1px solid #e8ecf1;
            transition: transform 0.3s ease;
        }

        .resultado-card:hover { transform: translateY(-3px); }

        .resultado-card:first-child {
            border-color: var(--amarelo);
            box-shadow: 0 4px 30px rgba(244,224,0,0.15);
        }

        .resultado-foto {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            object-position: top center;
            border: 3px solid var(--azul-claro);
            flex-shrink: 0;
            background: #e8ecf1;
        }

        .resultado-info { flex: 1; }

        .resultado-nome {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--azul-escuro);
            margin-bottom: 8px;
        }

        .barra-container {
            width: 100%;
            height: 16px;
            background: #e0e6ed;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 6px;
        }

        .barra-preenchida {
            height: 100%;
            background: linear-gradient(90deg, var(--azul-claro), var(--azul-escuro));
            border-radius: 8px;
            transition: width 1.2s ease;
            min-width: 0;
        }

        .resultado-numeros { font-size: 0.88rem; color: #777; }
        .resultado-numeros strong { color: var(--azul-escuro); }

        .total-box {
            text-align: center;
            padding: 24px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            margin-bottom: 24px;
        }

        .total-box .numero { font-size: 2.5rem; font-weight: 800; color: var(--azul-escuro); }
        .total-box .label { font-size: 0.95rem; color: #777; }

        .btn-voltar {
            display: inline-block;
            padding: 14px 44px;
            background: linear-gradient(135deg, var(--azul-claro), var(--azul-escuro));
            color: #fff;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-voltar:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 20px rgba(0,99,182,0.3);
        }

        .voltar-wrapper { text-align: center; margin-top: 10px; }

        .rodape {
            background: #0a1a2e;
            padding: 30px 24px;
            text-align: center;
        }

        .rodape img { max-width: 160px; height: auto; }
        .rodape p { margin-top: 10px; font-size: 0.8rem; color: rgba(255,255,255,0.4); }

        .faixa-grafica {
            width: 100%;
            height: 50px;
            background: url('img/faixa.png') repeat-x center / auto 100%;
            line-height: 0;
            font-size: 0;
        }

        @media (max-width: 600px) {
            .resultado-card {
                flex-direction: column;
                text-align: center;
                padding: 24px;
            }
            .faixa-grafica { height: 35px; }
        }
    </style>
</head>
<body>

<div class="topo">
    <h1>Resultado da Votação</h1>
    <p>Acompanhe o resultado parcial em tempo real</p>
</div>

<div class="container">
    <div class="total-box">
        <div class="numero"><?= $total_geral ?></div>
        <div class="label">votos registrados</div>
    </div>

    <?php foreach ($resultados as $r): ?>
        <?php $pct = $total_geral > 0 ? round(($r['total_votos'] / $total_geral) * 100, 1) : 0; ?>
        <div class="resultado-card">
            <img class="resultado-foto" src="<?= htmlspecialchars($r['imagem']) ?>" alt="<?= htmlspecialchars($r['nome']) ?>">
            <div class="resultado-info">
                <div class="resultado-nome"><?= htmlspecialchars($r['nome']) ?></div>
                <div class="barra-container">
                    <div class="barra-preenchida" style="width: <?= $pct ?>%"></div>
                </div>
                <div class="resultado-numeros">
                    <strong><?= $r['total_votos'] ?></strong> voto<?= $r['total_votos'] != 1 ? 's' : '' ?> — <strong><?= $pct ?>%</strong>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="voltar-wrapper">
        <a href="index.php" class="btn-voltar">← Voltar para a página inicial</a>
    </div>
</div>

<footer class="rodape">
    <img src="img/Logo Prefeitura_SECOM 3.png" alt="Prefeitura Municipal de Pau dos Ferros">
    <p>&copy; <?= date('Y') ?> Prefeitura Municipal de Pau dos Ferros.</p>
</footer>

<div class="faixa-grafica"></div>

</body>
</html>
