<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'db.php';

$mensagem = '';
$tipo_mensagem = '';
$ip_votante = $_SERVER['REMOTE_ADDR'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['homenageado_id'], $_POST['cpf'])) {
    $homenageado_id = (int) $_POST['homenageado_id'];
    $cpf = preg_replace('/\D/', '', $_POST['cpf']);

    if (strlen($cpf) !== 11) {
        $mensagem = 'CPF inválido. Digite os 11 dígitos.';
        $tipo_mensagem = 'erro';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM votos WHERE ip_votante = ? OR cpf = ?');
        $stmt->execute([$ip_votante, $cpf]);

        if ($stmt->fetch()) {
            $mensagem = 'Você já registrou seu voto. Cada pessoa pode votar apenas uma vez.';
            $tipo_mensagem = 'erro';
        } else {
            $stmt = $pdo->prepare('SELECT id FROM homenageados WHERE id = ?');
            $stmt->execute([$homenageado_id]);

            if ($stmt->fetch()) {
                $stmt = $pdo->prepare('INSERT INTO votos (homenageado_id, ip_votante, cpf) VALUES (?, ?, ?)');
                $stmt->execute([$homenageado_id, $ip_votante, $cpf]);
                $mensagem = 'Seu voto foi registrado com sucesso! Obrigado por participar.';
                $tipo_mensagem = 'sucesso';
            } else {
                $mensagem = 'Homenageado inválido.';
                $tipo_mensagem = 'erro';
            }
        }
    }
}

$stmt = $pdo->prepare('SELECT homenageado_id FROM votos WHERE ip_votante = ?');
$stmt->execute([$ip_votante]);
$voto_existente = $stmt->fetchColumn();

$stmt = $pdo->query('SELECT * FROM homenageados ORDER BY id');
$homenageados = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votação Pública — Novo Centro Administrativo de Pau dos Ferros</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
            background: #fff;
            overflow-x: hidden;
        }

        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: var(--azul-escuro);
        }

        .hero-bg {
            position: absolute;
            inset: -10%;
            background: url('img/Foto Projeto.png') center/cover no-repeat;
            will-change: transform;
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                160deg,
                rgba(0, 99, 182, 0.88) 0%,
                rgba(0, 169, 255, 0.72) 50%,
                rgba(0, 99, 182, 0.85) 100%
            );
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 60px 24px;
            max-width: 900px;
        }

        .hero-letreiro {
            max-width: 680px;
            width: 90%;
            margin: 0 auto 30px;
            animation: floatIn 1.2s ease-out;
            filter: drop-shadow(0 6px 24px rgba(0, 0, 0, 0.35));
        }

        .hero-subtexto {
            color: #fff;
            font-size: clamp(1rem, 2.2vw, 1.25rem);
            font-weight: 400;
            line-height: 1.7;
            opacity: 0;
            animation: fadeUp 1s ease-out 0.5s forwards;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .hero-detalhe {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--verde), var(--amarelo), var(--azul-claro), var(--azul-escuro));
        }

        .hero-scroll {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            animation: bounce 2s infinite;
        }

        .hero-scroll svg {
            width: 32px;
            height: 32px;
            fill: none;
            stroke: rgba(255,255,255,0.7);
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        @keyframes floatIn {
            0% { opacity: 0; transform: translateY(-40px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }

        .wave-top {
            display: block;
            width: 100%;
            line-height: 0;
            margin-top: -2px;
        }

        .wave-top svg {
            display: block;
            width: 100%;
            height: 70px;
        }

        .wave-bottom {
            display: block;
            width: 100%;
            line-height: 0;
            margin-bottom: -2px;
            transform: rotate(180deg);
        }

        .wave-bottom svg {
            display: block;
            width: 100%;
            height: 70px;
        }

        .explicativo {
            background: var(--bg-claro);
            padding: 80px 24px;
            text-align: center;
        }

        .explicativo-inner {
            max-width: 800px;
            margin: 0 auto;
        }

        .explicativo h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--azul-escuro);
            margin-bottom: 20px;
        }

        .explicativo p {
            font-size: 1.05rem;
            line-height: 1.9;
            color: #555;
        }

        .mensagem {
            max-width: 700px;
            margin: 0 auto 30px;
            padding: 16px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: center;
            animation: slideDown 0.4s ease;
        }

        .mensagem.sucesso { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .mensagem.erro { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .homenageados {
            background: #fff;
            padding: 80px 24px;
        }

        .homenageados > h2 {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: var(--azul-escuro);
            margin-bottom: 50px;
        }

        .cards-lista {
            max-width: 920px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            padding: 40px;
            display: flex;
            gap: 36px;
            align-items: flex-start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e8ecf1;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, var(--azul-claro), var(--azul-escuro));
            border-radius: 20px 0 0 20px;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 99, 182, 0.1);
            border-color: var(--azul-claro);
        }

        .card-foto-wrapper { flex-shrink: 0; }

        .card-foto {
            width: 150px;
            height: 180px;
            border-radius: 16px;
            object-fit: cover;
            object-position: top center;
            border: 3px solid #e0e6ed;
            background: #e8ecf1;
            transition: border-color 0.3s;
        }

        .card:hover .card-foto { border-color: var(--azul-claro); }

        .card-info { flex: 1; }

        .card-info h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--azul-escuro);
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--bg-claro);
        }

        .curriculo-texto {
            font-size: 0.93rem;
            line-height: 1.85;
            color: #555;
            white-space: pre-line;
            margin-bottom: 22px;
        }

        .btn-votar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 36px;
            background: linear-gradient(135deg, var(--azul-claro), var(--azul-escuro));
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-votar:hover {
            transform: scale(1.04);
            box-shadow: 0 6px 20px rgba(0, 99, 182, 0.3);
        }

        .btn-votar svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: #fff;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .btn-votado {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 36px;
            background: var(--verde);
            color: #1a4a00;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .btn-resultado-wrapper {
            text-align: center;
            margin-top: 50px;
        }

        .btn-resultado {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 44px;
            background: transparent;
            color: var(--azul-escuro);
            border: 2px solid var(--azul-escuro);
            border-radius: 10px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-resultado:hover {
            background: var(--azul-escuro);
            color: #fff;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 20, 50, 0.6);
            backdrop-filter: blur(4px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .modal-overlay.ativo { display: flex; }

        .modal {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            max-width: 460px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: modalIn 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .modal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--verde), var(--amarelo), var(--azul-claro), var(--azul-escuro));
        }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal h3 {
            font-size: 1.3rem;
            color: var(--azul-escuro);
            margin-bottom: 6px;
            margin-top: 10px;
        }

        .modal .modal-nome {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--azul-claro);
            margin-bottom: 24px;
        }

        .modal label {
            display: block;
            text-align: left;
            font-weight: 600;
            font-size: 0.88rem;
            color: #444;
            margin-bottom: 6px;
        }

        .modal input[type="text"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #dde2e8;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1.05rem;
            text-align: center;
            letter-spacing: 2px;
            transition: border-color 0.2s;
            margin-bottom: 24px;
        }

        .modal input[type="text"]:focus {
            outline: none;
            border-color: var(--azul-claro);
        }

        .modal-botoes {
            display: flex;
            gap: 12px;
        }

        .modal-botoes button {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, opacity 0.2s;
        }

        .modal-botoes button:hover { transform: scale(1.02); }
        .modal-cancelar { background: #e8ecf1; color: #555; }

        .modal-confirmar {
            background: linear-gradient(135deg, var(--azul-claro), var(--azul-escuro));
            color: #fff;
        }

        .rodape {
            background: #0a1a2e;
            padding: 40px 24px;
            text-align: center;
        }

        .rodape img.logo {
            max-width: 200px;
            height: auto;
        }

        .rodape p {
            margin-top: 14px;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.45);
        }

        .faixa-grafica {
            width: 100%;
            height: 50px;
            background: url('img/faixa.png') repeat-x center / auto 100%;
            line-height: 0;
            font-size: 0;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .fade-in.visivel {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 700px) {
            .hero { min-height: 80vh; }

            .card {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 30px 24px;
            }

            .card::before {
                width: 100%;
                height: 5px;
                top: 0;
                left: 0;
                border-radius: 20px 20px 0 0;
            }

            .card-info h3 { text-align: center; }
            .curriculo-texto { text-align: left; }

            .card-foto {
                width: 130px;
                height: 160px;
            }

            .wave-top svg, .wave-bottom svg { height: 45px; }
            .faixa-grafica { height: 35px; }
        }
    </style>
</head>
<body>

<section class="hero">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-content">
        <img class="hero-letreiro" src="img/Sua voz vai escolher o nome do nosso novo Centro Administrativo.png" alt="Sua voz vai escolher o nome do nosso novo Centro Administrativo">
        <p class="hero-subtexto">Participe da votação pública e ajude a homenagear quem fez história em Pau dos Ferros.</p>
    </div>
    <div class="hero-detalhe"></div>
    <div class="hero-scroll">
        <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
    </div>
</section>

<div class="wave-top">
    <svg viewBox="0 0 1440 70" preserveAspectRatio="none">
        <path d="M0,35 C360,80 1080,-10 1440,35 L1440,0 L0,0 Z" fill="var(--azul-escuro)"/>
    </svg>
</div>

<section class="explicativo">
    <div class="explicativo-inner fade-in">
        <h2>Sobre a Votação</h2>
        <p>A Prefeitura Municipal de Pau dos Ferros convida toda a população a participar da escolha do nome do novo Centro Administrativo. Conheça os três homenageados indicados — cidadãos que dedicaram suas vidas ao serviço público, à educação e à justiça. Leia seus currículos e faça sua escolha com consciência e orgulho.</p>
    </div>
</section>

<div class="wave-bottom">
    <svg viewBox="0 0 1440 70" preserveAspectRatio="none">
        <path d="M0,35 C360,80 1080,-10 1440,35 L1440,0 L0,0 Z" fill="var(--bg-claro)"/>
    </svg>
</div>

<section class="homenageados" id="votacao">
    <h2 class="fade-in">Conheça os Homenageados</h2>

    <?php if ($mensagem): ?>
        <div class="mensagem <?= $tipo_mensagem ?>"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <div class="cards-lista">
        <?php foreach ($homenageados as $pessoa): ?>
        <div class="card fade-in">
            <div class="card-foto-wrapper">
                <img class="card-foto" src="<?= htmlspecialchars($pessoa['imagem']) ?>" alt="<?= htmlspecialchars($pessoa['nome']) ?>">
            </div>
            <div class="card-info">
                <h3><?= htmlspecialchars($pessoa['nome']) ?></h3>
                <div class="curriculo-texto"><?= nl2br(htmlspecialchars($pessoa['descricao'])) ?></div>

                <?php if ($voto_existente): ?>
                    <?php if ((int)$voto_existente === (int)$pessoa['id']): ?>
                        <div class="btn-votado">&#10003; Você votou neste homenageado</div>
                    <?php endif; ?>
                <?php else: ?>
                    <button type="button" class="btn-votar" onclick="abrirModal(<?= (int)$pessoa['id'] ?>, '<?= htmlspecialchars(addslashes($pessoa['nome']), ENT_QUOTES) ?>')">
                        <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                        Votar neste homenageado
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="btn-resultado-wrapper fade-in">
        <a href="resultado.php" class="btn-resultado">Ver resultado da votação</a>
    </div>
</section>

<div class="wave-top">
    <svg viewBox="0 0 1440 70" preserveAspectRatio="none">
        <path d="M0,35 C360,80 1080,-10 1440,35 L1440,70 L0,70 Z" fill="#0a1a2e"/>
    </svg>
</div>

<footer class="rodape">
    <img class="logo" src="img/logo-prefeitura.png" alt="Prefeitura Municipal de Pau dos Ferros">
    <p>&copy; <?= date('Y') ?> Prefeitura Municipal de Pau dos Ferros. Todos os direitos reservados.</p>
</footer>

<div class="faixa-grafica"></div>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <h3>Confirmar voto</h3>
        <p class="modal-nome" id="modalNome"></p>
        <form method="POST" action="#votacao" id="formVoto">
            <input type="hidden" name="homenageado_id" id="modalHomenageadoId">
            <label for="cpfInput">Digite seu CPF para confirmar:</label>
            <input type="text" name="cpf" id="cpfInput" placeholder="000.000.000-00" maxlength="14" required autocomplete="off">
            <div class="modal-botoes">
                <button type="button" class="modal-cancelar" onclick="fecharModal()">Cancelar</button>
                <button type="submit" class="modal-confirmar">Confirmar voto</button>
            </div>
        </form>
    </div>
</div>

<script>
    const heroBg = document.getElementById('heroBg');
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                heroBg.style.transform = 'translateY(' + (window.scrollY * 0.35) + 'px)';
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    function abrirModal(id, nome) {
        document.getElementById('modalHomenageadoId').value = id;
        document.getElementById('modalNome').textContent = nome;
        document.getElementById('cpfInput').value = '';
        document.getElementById('modalOverlay').classList.add('ativo');
        setTimeout(() => document.getElementById('cpfInput').focus(), 200);
    }

    function fecharModal() {
        document.getElementById('modalOverlay').classList.remove('ativo');
    }

    document.getElementById('modalOverlay').addEventListener('click', (e) => {
        if (e.target === e.currentTarget) fecharModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') fecharModal();
    });

    document.getElementById('cpfInput').addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '').slice(0, 11);
        if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
        else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
        this.value = v;
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visivel');
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
</script>

</body>
</html>
