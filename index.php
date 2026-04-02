<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votação Pública — Novo Centro Administrativo de Pau dos Ferros</title>
    <link rel="icon" type="image/png" href="img/Logo Prefeitura_SECOM 3.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --azul-claro: #00A9FF;
            --azul-escuro: #0063B6;
            --amarelo: #F4E000;
            --verde: #ABE61B;
            --bg-claro: #f5f7fa;
            --texto: #2d3748;
            --instagram: #E4405F;
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
            .wave-top svg, .wave-bottom svg { height: 45px; }
            .faixa-grafica { height: 35px; }
        }

        .resultado-waiting {
            background: #fff;
            padding: 80px 24px;
            text-align: center;
        }

        .resultado-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 18px 48px;
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            font-family: inherit;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(228, 64, 95, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-top: 40px;
        }

        .resultado-btn:hover {
            transform: scale(1.08) translateY(-5px);
            box-shadow: 0 15px 40px rgba(228, 64, 95, 0.45);
        }

        .resultado-btn svg {
            width: 24px;
            height: 24px;
            fill: currentColor;
        }

        .resultado-card {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            border-radius: 24px;
            padding: 50px 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8ecf1;
            position: relative;
            overflow: hidden;
        }

        .resultado-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--verde), var(--amarelo), var(--azul-claro), var(--azul-escuro));
        }

        .resultado-icon {
            margin-bottom: 24px;
            color: var(--azul-escuro);
            display: flex;
            justify-content: center;
        }

        .resultado-icon .lucide {
            width: 70px;
            height: 70px;
            stroke-width: 1.5;
        }

        .resultado-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--azul-escuro);
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .resultado-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 0;
        }

        .insta-tag {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: var(--instagram);
            font-size: 1.15rem;
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
        <path d="M0,35 C360,80 1080,-10 1440,35 L1440,0 L0,0 Z" fill="#fff"/>
    </svg>
</div>

<section class="resultado-waiting">
    <div class="resultado-card fade-in">
        <div class="resultado-icon">
            <i data-lucide="megaphone"></i>
        </div>
        <h2 class="resultado-title">Votação Encerrada!</h2>
        <p class="resultado-text">
            Obrigado a todos que participaram! <br>
            Já estamos processando os votos. O resultado oficial será anunciado em breve em nosso perfil oficial:
        </p>
        <span class="insta-tag">@prefeituradepaudosferros</span>
        <a href="https://www.instagram.com/prefeituradepaudosferros/" target="_blank" class="resultado-btn">
            <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            Acompanhar no Instagram
        </a>
    </div>
</section>

<div class="wave-bottom">
    <svg viewBox="0 0 1440 70" preserveAspectRatio="none">
        <path d="M0,35 C360,80 1080,-10 1440,35 L1440,0 L0,0 Z" fill="var(--bg-claro)"/>
    </svg>
</div>

<div class="wave-top">
    <svg viewBox="0 0 1440 70" preserveAspectRatio="none">
        <path d="M0,35 C360,80 1080,-10 1440,35 L1440,70 L0,70 Z" fill="#0a1a2e"/>
    </svg>
</div>

<footer class="rodape">
    <img class="logo" src="img/Logo Prefeitura_SECOM 3.png" alt="Prefeitura Municipal de Pau dos Ferros">
    <p>&copy; <?= date('Y') ?> Prefeitura Municipal de Pau dos Ferros. Todos os direitos reservados.</p>
</footer>

<div class="faixa-grafica"></div>

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

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visivel');
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    
    lucide.createIcons();
</script>

</body>
</html>
