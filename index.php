<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();
require_once "config/db_config.php";

$logado = isset($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcella Gonçalves | Home</title>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <meta name="referrer" content="strict-origin-when-cross-origin">

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">

    <style>
        /* ============================================================
   1. CONFIGURAÇÕES GERAIS E VARIÁVEIS
   ============================================================ */
        :root {
            --color-1: #FFA461;
            --color-2: #FD987E;
            --color-3: #FD9585;
            --color-4: #FAA7D5;
            --text-dark: #333333;
            --color-accent: #FC8C9B;
            --bg-light: #fdfdfd;
            --agendador-gradient: linear-gradient(225deg, #ffa361e7 0%, #fd977eea 15%, #fd9585e8 50%, #FAA7D5 97%);
            --cor-branco: #ffffff;
            --cor-texto: #333333;
            --raio-borda: 25px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-dark);
            background-color: #ffffff;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /* ============================================================
   2. HEADER & NAVIGATION (NAV-PRINCIPAL)
   ============================================================ */
        .header-wrapper {
            background: linear-gradient(to right, var(--color-1), var(--color-2), var(--color-3), var(--color-4));
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 100dvh;
            padding-top: 60px;
            padding-bottom: 80px;
        }


        .nav-principal {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 8%;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .links-institucionais {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .nav-link {
            font-size: 11px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            transition: 0.3s;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .nav-link:hover {
            opacity: 0.7;
        }

        .botao-agendar {
            background: #ffffff;
            color: var(--color-2);
            padding: 10px 25px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .botao-agendar:hover {
            transform: scale(1.05);
            background: var(--text-dark);
            color: #fff;
        }

        .nav-principal.nav-scroll {
            background: #ffffff;
            backdrop-filter: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .nav-principal.nav-scroll .nav-link {
            color: #333 !important;
        }

        .nav-principal.nav-scroll .user-greeting {
            color: #333;
        }

        .nav-principal.nav-scroll .user-sub {
            color: #777;
        }

        .nav-principal.nav-scroll .user-info {
            background: rgba(0, 0, 0, 0.05);
        }

        .nav-principal.nav-scroll .botao-agendar {
            background: linear-gradient(135deg, #FD9585, #FAA7D5);
            color: #fff;
        }

        .nav-principal.nav-scroll .btn-logout {
            border: 1px solid #ddd;
            color: #333;
        }

        .nav-principal.nav-scroll .btn-logout:hover {
            background: #FD9585;
            color: #fff;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 10px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FD9585, #FAA7D5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .user-texto {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-greeting {
            font-size: 13px;
            font-weight: 700;
            color: #fff;
        }

        .user-sub {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-logout {
            margin-left: 10px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #fff;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #fff;
            color: #FD9585;
        }

        .acoes-usuario {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-adm a {
            background: #ffffff;
            color: var(--color-2);
            padding: 10px 25px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-adm a:hover {
            transform: scale(1.05);
            background: var(--text-dark);
            color: #fff;
        }

        /* ============================================================
   3. HERO SECTION (#inicio)
   ============================================================ */
        #inicio {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 100px 8% 0;
            position: relative;
        }

        .conteudo-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 100%;
        }

        .texto-principal {
            flex: 0 0 70%;
            padding-bottom: 20px;
            margin-top: -20px;
        }

        .nome-imagem-logo {
            max-width: 700px;
            width: 100%;
            height: auto;
            display: block;
            margin-left: -15px;
            margin-bottom: 40px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
        }

        .descricao-hero {
            color: #ffffff;
            font-size: clamp(16px, 1.2vw, 19px);
            line-height: 1.7;
            font-weight: 600;

            max-width: 520px;
            margin-top: 15px;

            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }

        .container-foto {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            height: 100%;
        }

        .foto-recortada {
            max-width: 100%;
            height: auto;
            max-height: 80vh;
            display: block;
            object-fit: contain;
            filter: drop-shadow(0 15px 40px rgba(0, 0, 0, 0.15));
            margin-bottom: -2px;
        }

        /* CONTAINER DA FOTO */
        .container-foto {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .aura-luz {
            position: absolute;
            width: 120%;
            height: 120%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            z-index: 1;
            pointer-events: none;
        }

        .moldura-organica-quadrada {
            position: relative;
            width: 100%;
            max-width: 280px;
            aspect-ratio: 3 / 4;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(25px);
            border: 2px solid rgba(255, 255, 255, 0.7);
            box-shadow:
                0 0 0 15px rgba(255, 255, 255, 0.05),
                0 40px 100px -20px rgba(0, 0, 0, 0.35);
            border-radius: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 5;
            animation: flutuarHero 8s ease-in-out infinite;
            padding: 20px;
        }

        @media (min-width: 1400px) {
            .moldura-organica-quadrada {
                width: 260px;
                height: 360px;
            }

        }

        @keyframes flutuarHero {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-25px);
            }
        }

        .video-wrapper {
            width: 100%;
            height: 100%;
            overflow: hidden;
            border-radius: 35px;
            position: relative;
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .video-wrapper video,
        .video-wrapper iframe {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .foto-recortada {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: contrast(1.02) brightness(1.04);
            pointer-events: none;
        }

        .frase-bemvinda {
            position: absolute;
            top: -30px;
            left: -20px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            color: var(--color-3);
            padding: 14px 30px;
            border-radius: 40px 40px 40px 8px;
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: clamp(0.9rem, 1.5vw, 1.25rem);
            white-space: nowrap;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            z-index: 25;
            border: 1px solid white;
            letter-spacing: 0.5px;
        }

        .brilho {
            position: absolute;
            background: white;
            border-radius: 50%;
            opacity: 0;
            animation: brilhar 5s infinite;
            z-index: 7;
        }

        @keyframes brilhar {

            0%,
            100% {
                opacity: 0;
                transform: scale(0);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.5);
                box-shadow: 0 0 15px white;
            }
        }

        .borboleta {
            position: absolute;
            width: clamp(45px, 6vw, 65px);
            height: clamp(45px, 6vw, 65px);
            z-index: 15;
            filter: drop-shadow(0 8px 15px rgba(0, 0, 0, 0.3));
        }

        .borboleta svg {
            width: 100%;
            height: 100%;
        }

        .asa {
            fill: #ffffff;
            transform-origin: center;
            animation: flap 0.18s infinite alternate ease-in-out;
        }

        .corpo-borboleta {
            fill: var(--color-accent);
        }

        .borboleta-topo {
            top: 10%;
            right: -10%;
            animation: tremor 5.5s infinite ease-in-out;
            transform: rotate(15deg);
        }

        .borboleta-base {
            bottom: 15%;
            left: -8%;
            animation: tremor 7s infinite ease-in-out;
            transform: rotate(-10deg);
        }

        @keyframes flap {
            from {
                transform: scaleX(1);
            }

            to {
                transform: scaleX(0.25);
            }
        }

        @keyframes tremor {

            0%,
            100% {
                transform: translate(0, 0) rotate(inherit);
            }

            50% {
                transform: translate(8px, -12px) rotate(inherit);
            }
        }

        @media (max-width: 768px) {
            .conteudo-hero {
                flex-direction: column;
                text-align: center;
                gap: 60px;
            }

            .texto-principal {
                max-width: 100%;
            }

            .frase-bemvinda {
                left: 50%;
                transform: translateX(-50%);
                top: -25px;
            }

            .borboleta-topo {
                right: -5%;
            }

            .borboleta-base {
                left: -5%;
            }
        }

        /* ============================================================
   4. SEÇÃO BOAS VINDAS
   ============================================================ */
        .secao-boas-vindas {
            background: #fff;
            padding: 80px 8% 100px;
            text-align: center;
            position: relative;
            z-index: 5;
            margin-top: -50px;
        }

        .titulo-boas-vindas {
            font-family: 'Playfair Display', serif;
            font-size: clamp(26px, 5vw, 40px);
            color: #222;
            margin-bottom: 100px;
            font-weight: 300 !important;
        }

        .titulo-boas-vindas b {
            font-weight: 700;
        }

        .highlight-text {
            color: var(--color-accent);
        }

        .texto-apoio {
            max-width: 900px;
            margin: 0 auto;
            color: #555;
            font-size: clamp(16px, 2.5vw, 25px);
            line-height: 1.8;
        }

        /* ============================================================
   5. SEÇÃO SERVIÇOS / AGENDADOR
   ============================================================ */

        /* 1. Fundo do agendador (gradiente vertical) */
        .agendador {
            background: linear-gradient(180deg,
                    #ff9e67 0%,
                    #fd8a8a 50%,
                    #f9a1d0 100%);
            border-radius: 30px;
            padding: 30px;
            color: white;
            max-width: 550px;
            margin: 20px auto;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
            font-family: 'Segoe UI', sans-serif;
        }

        /* 2. Cabeçalho do agendador */
        .agendador .topo {
            font-size: 1.5rem;
            font-weight: 800;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 2px;
            margin-bottom: 12px;
            color: white;
        }

        .agendador .subtitulo {
            display: block;
            font-size: 0.85rem;
            text-transform: uppercase;
            opacity: 0.8;
            text-align: center;
            margin-bottom: 22px;
            color: white;
        }

        #categorias {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px 10px;
            margin-bottom: 20px;
        }

        /* Container de subcategorias */
        #subcategorias {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px 10px;
            margin-bottom: 18px;
        }

        /* Subcategoria padrão */
        #subcategorias .item {
            padding: 6px 12px;
            border-radius: 30px;
            border: 1px solid #fff;
            background: transparent;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        #subcategorias .item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.04);
        }

        #subcategorias .item.ativo {
            background: #fff;
            color: #fd8a8a;
            border: none;
            font-weight: 700;
        }

        .filtros .item {
            padding: 8px 14px;
            border-radius: 30px;
            border: 1.5px solid #fff;
            background: transparent;
            color: #fff;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .filtros .item:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .filtros .item.ativo {
            background: #fff;
            border: none;
            color: #fd8a8a;
            font-weight: 700;
        }

        /* 4. Lista de serviços – card interno */
        .lista .servico {
            background: rgba(255, 255, 255, 0.51);
            border-radius: 15px;
            padding: 12px 16px;
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: 0.25s ease;
            color: #333;
        }

        .lista .servico:hover {
            background: #fff;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
        }

        .servico.eleito {
            background-color: rgba(255, 255, 255, 0.97);
        }

        .lista .servico .nome {
            font-weight: 700;
            font-size: 14px;
        }

        .lista .servico .tempo {
            font-size: 12px;
            color: #666;
        }

        .lista .servico .preco {
            font-weight: 700;
            font-size: 14px;
            color: #333;
        }

        /* 5. Botão CTA – Próximo / Confirmar */
        .agendador .botao {
            width: 100%;
            padding: 16px;
            border-radius: 15px;
            background: #fff;
            color: #fd8a8a;
            text-transform: uppercase;
            font-weight: 800;
            font-size: 1rem;
            border: none;
            margin-top: 15px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .agendador .botao:hover {
            background: #fafafa;
            transform: scale(1.02);
        }

        /* Resumo de Selecionados */
        .resumo-selecionados {
            background: #ffffff;
            border-radius: 16px;
            padding: 15px;
            margin: 20px auto;
            max-width: 420px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .resumo-selecionados h4 {
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #333;
        }

        /* Lista */
        #lista-selecionados li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafafa;
            padding: 10px 12px;
            margin-bottom: 8px;
            border-radius: 10px;
            transition: 0.2s;
        }

        #lista-selecionados li:hover {
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* Info interna */
        .resumo-item-info {
            display: flex;
            flex-direction: column;
        }

        .resumo-nome {
            font-weight: 600;
            font-size: 13px;
            color: #333;
        }

        .resumo-preco {
            font-size: 12px;
            color: #888;
        }

        /* Botão remover */
        .remover {
            background: none;
            border: none;
            font-size: 18px;
            color: #bbb;
            cursor: pointer;
            transition: 0.2s;
        }

        .remover:hover {
            color: #FD9585;
            transform: scale(1.2);
        }

        /* Total */
        #total-geral {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ddd;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            color: #FD9585;
        }

        /* Calendário e Horários */
        .mes {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .grade {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .titulo-horarios {
            margin: 20px 0 10px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        /* Botões do Agendador */
        .agendador .botao {
            width: 100%;
            padding: 16px;
            border-radius: 15px;
            background: #fff;
            color: #fd8a8a;
            text-transform: uppercase;
            font-weight: 800;
            cursor: pointer;
            transition: 0.3s;
        }

        /* ============================================================
   6. SEÇÕES GENÉRICAS (RESULTADOS, LOCALIZAÇÃO, CONTATOS)
   ============================================================ */
        section {
            padding: 110px 8%;
            min-height: 100dvh;
            padding-top: 60px;
            padding-bottom: 80px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 5vw, 48px);
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 90px;
            position: relative;
            font-weight: 300 !important;
        }

        .section-title b {
            font-weight: 700 !important;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 2px;
            background: linear-gradient(to right, var(--color-1), var(--color-4));
            margin: 15px auto 0;
            border-radius: 2px;
        }

        #resultados {
            background-color: #ffffff;
        }

        #localizacao {
            background-color: var(--bg-light);
        }

        #contatos {
            background-color: #ffffff;
        }

        /* ============================================================
   7. MODAL LOGIN
   ============================================================ */
        .modal-login {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
        }

        .caixa-login {
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 30px;
            width: 90%;
            max-width: 420px;
            text-align: center;
            position: relative;
        }

        .input-login {
            width: 100%;
            padding: 16px 20px;
            margin-bottom: 15px;
            border-radius: 15px;
            border: 1px solid #f0f0f0;
            background: #fafafa;
        }

        .botao-acao-modal {
            width: 100%;
            padding: 16px;
            border-radius: 15px;
            background: linear-gradient(to right, var(--color-1), var(--color-3));
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
        }

        .fechar-modal {
            position: absolute;
            top: 10px;
            right: 15px;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            border: none;
            cursor: pointer;
        }

        /* ============================================================
        8. UTILITÁRIOS E RESPONSIVIDADE
        ============================================================ */
        .oculto,
        .escondido {
            display: none !important;
        }

        @media (max-width: 992px) {
            .header-wrapper {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                -webkit-mask-image: none;
                mask-image: none;
            }

            #inicio {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                padding: 110px 5% 0;
            }

            .conteudo-hero {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 100%;
                gap: 0;
            }

            .container-foto {
                display: flex !important;
                order: 2;
                width: 100%;
                justify-content: center;
                margin-bottom: -50px;
                z-index: 5;
            }

            .foto-recortada {
                max-height: 55vh;
                width: auto;
                object-fit: contain;
                filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.25));
            }

            .nome-imagem-logo {
                order: 3;
                max-width: 85%;
                margin: 0 auto 15px;
                z-index: 10;
                filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
            }

            .descricao-hero {
                order: 4;
                font-size: 14px;
                line-height: 1.8;
                padding: 0 15px 60px;
                max-width: 500px;
                margin: 0 auto;
                text-align: justify;
                text-indent: 40px;
                hyphens: auto;
            }

            .texto-principal {
                display: contents;
            }
        }

        @media (max-width: 600px) {
            .agendador {
                padding: 20px;
            }

            .filtros .item {
                padding: 7px 12px;
                font-size: 0.85rem;
            }
        }

        /* Estilos de menu responsivo */

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            z-index: 2000;
        }

        .menu-toggle .bar {
            width: 25px;
            height: 3px;
            background-color: #fff;
            border-radius: 2px;
            transition: 0.3s;
        }

        .nav-principal.nav-scroll .menu-toggle .bar {
            background-color: #333;
        }

        @media (max-width: 992px) {
            .menu-toggle {
                display: flex;
            }

            .links-institucionais,
            .acoes-usuario,
            .btn-adm {
                position: fixed;
                right: -100%;
                background: #fff;
                transition: 0.4s ease-in-out;
                display: flex;
                flex-direction: column;
                align-items: center;
                z-index: 1500;
            }

            .links-institucionais {
                top: 0;
                width: 280px;
                height: 100vh;
                padding-top: 100px;
                gap: 30px;
                box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
            }

            .acoes-usuario {
                top: 450px;
                right: -100%;
                width: 280px;
                gap: 20px;
            }

            .btn-adm {
                top: 380px;
                right: -100%;
                width: 280px;
            }

            .nav-principal.menu-aberto .links-institucionais,
            .nav-principal.menu-aberto .acoes-usuario,
            .nav-principal.menu-aberto .btn-adm {
                right: 0;
            }

            .nav-link {
                color: var(--text-dark) !important;
                font-size: 16px !important;
            }

            .user-info {
                background: rgba(0, 0, 0, 0.05);
                backdrop-filter: none;
            }

            .user-greeting {
                color: var(--text-dark);
            }

            .user-sub {
                color: rgba(0, 0, 0, 0.6);
            }

            .btn-logout {
                color: var(--text-dark);
                border: 1px solid rgba(0, 0, 0, 0.2);
            }

            .btn-logout:hover {
                background: var(--color-2);
                color: #fff;
            }

            .user-greeting {
                color: var(--text-dark);
                margin-bottom: 10px;
                display: block;
            }

            .menu-toggle.active .bar:nth-child(1) {
                transform: translateY(8px) rotate(45deg);
                background-color: var(--color-2);
            }

            .menu-toggle.active .bar:nth-child(2) {
                opacity: 0;
            }

            .menu-toggle.active .bar:nth-child(3) {
                transform: translateY(-8px) rotate(-45deg);
                background-color: var(--color-2);
            }
        }
    </style>
</head>

<body>

    <div class="site-container">

        <div class="header-wrapper">

            <nav class="nav-principal">

                <div class="menu-toggle" id="mobile-menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
                <div class="links-institucionais">
                    <a href="#inicio" class="nav-link">Início</a>
                    <a href="#servicos" class="nav-link">Serviços</a>
                    <a href="#cursos" class="nav-link">Cursos</a>
                    <a href="#resultados" class="nav-link">Resultados</a>
                    <a href="#localizacao" class="nav-link">Localização</a>
                    <a href="#contatos" class="nav-link">Contatos</a>
                </div>

                <?php if (isset($_SESSION['usuario_email']) && $_SESSION['usuario_email'] == $admin_email): ?>

                    <div class="btn-adm"><a href="admin/painel.php">Painel Admin</a></div>

                <?php endif; ?>

                <div class="acoes-usuario">
                    <?php if ($logado): ?>

                        <div class="user-info">

                            <div class="user-avatar">
                                <?php echo strtoupper(substr($_SESSION['usuario_nome'], 0, 1)); ?>
                            </div>

                            <div class="user-texto">
                                <span class="user-greeting">
                                    Olá,
                                    <?php echo htmlspecialchars(explode(' ', $_SESSION['usuario_nome'])[0]); ?>
                                </span>
                                <span class="user-sub">Bem-vinda de volta</span>
                            </div>

                            <a href="auth/logout.php" class="btn-logout">Sair</a>

                        </div>

                    <?php else: ?>

                        <a href="javascript:void(0)" class="nav-link" onclick="abrirLogin()" style="font-weight: 800;">
                            Login
                        </a>

                    <?php endif; ?>
                    <a href="#container-principal" class="botao-agendar">Agendar</a>
                </div>

            </nav>
            <div id="modalLogin" class="modal-login">
                <div class="caixa-login">

                    <?php if (isset($_GET['erro'])): ?>
                        <div class="alerta-erro">E-mail ou palavra-passe incorretos.</div>
                    <?php endif; ?>

                    <div id="containerLogin" class="vista-login <?php echo $logado ? 'escondido' : ''; ?>">
                        <h3
                            style="margin-bottom: 25px; font-family: 'Playfair Display', serif; font-size: 26px; color: #000;">
                            Bem-vinda de volta</h3>
                        <button class="fechar-modal" onclick="fecharLogin()">✕</button>
                        <form id="formLogin" method="POST" action="auth/login.php">
                            <input type="email" name="email" class="input-login" placeholder="E-mail" required>
                            <input type="password" name="senha" class="input-login" placeholder="Palavra-passe"
                                required>
                            <button type="submit" class="botao-agendar"
                                style="width:100%; padding: 16px; margin-top: 10px;">Entrar</button>
                        </form>

                        <div class="divisor-modal"><span>ou</span></div>
                        <div id="g_id_onload"
                            data-client_id="821436734385-7cdnrc9a23v52qkfekevi35sumdr4so8.apps.googleusercontent.com"
                            data-context="signin" data-ux_mode="popup" data-callback="handleCredentialResponse"
                            data-auto_prompt="false">
                        </div>

                        <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline"
                            data-text="signin_with" data-size="large" data-logo_alignment="left" data-width="320">
                        </div>
                        <p class="texto-alternar">Não tem conta? <span class="link-toggle"
                                onclick="toggleVistas()">Criar conta
                                agora</span></p>
                    </div>

                    <div id="containerRegistro" class="vista-registro escondido">
                        <h3
                            style="margin-bottom: 25px; font-family: 'Playfair Display', serif; font-size: 26px; color: #000;">
                            Criar a sua conta</h3>
                        <button class="fechar-modal" onclick="fecharLogin()">✕</button>
                        <form action="registro.php" method="POST">
                            <input type="text" name="nome_completo" class="input-login" placeholder="Nome Completo"
                                required>
                            <input type="email" name="email" class="input-login" placeholder="E-mail" required>
                            <input type="password" name="senha" class="input-login" placeholder="Senha" required>
                            <button type="submit" class="botao-agendar"
                                style="width:100%; padding: 16px; margin-top: 10px;">
                                Cadastrar
                            </button>
                        </form>
                        <p class="texto-alternar" style="margin-top: 20px;">Já é cliente? <span class="link-toggle"
                                onclick="toggleVistas()">Entrar na conta</span></p>
                    </div>
                </div>
            </div>
            <section id="inicio">
                <div class="conteudo-hero">
                    <div class="texto-principal">

                        <img src="logo.png" alt="Logo Marcella Gonçalves" class="nome-imagem-logo">

                        <p class="descricao-hero">
                            Transformando olhares através da naturalidade. Mais de 20 mil atendimentos realizados com
                            técnica exclusiva e personalizada.
                        </p>
                    </div>

                    <div class="container-foto">
                        <div class="aura-luz"></div>

                        <div class="brilho" style="top: -5%; left: 0%; width: 7px; height: 7px; animation-delay: 0s;">
                        </div>
                        <div class="brilho"
                            style="bottom: 10%; right: -5%; width: 5px; height: 5px; animation-delay: 2.5s;"></div>

                        <div class="moldura-organica-quadrada">

                            <div class="frase-bemvinda">
                                Bem-vinda ao seu momento
                            </div>

                            <div class="borboleta borboleta-topo">
                                <svg viewBox="0 0 100 100">
                                    <path d="M48 40 Q45 25 35 20 M52 40 Q55 25 65 20" stroke="white" fill="none"
                                        stroke-width="1.5" />
                                    <g class="asa">
                                        <path d="M50 50 C20 10 5 40 15 60" fill="white" opacity="0.95" />
                                        <path d="M50 50 C25 60 10 85 30 85" fill="white" opacity="0.75" />
                                    </g>
                                    <g class="asa" style="transform: scaleX(-1); transform-origin: 50px;">
                                        <path d="M50 50 C20 10 5 40 15 60" fill="white" opacity="0.95" />
                                        <path d="M50 50 C25 60 10 85 30 85" fill="white" opacity="0.75" />
                                    </g>
                                    <ellipse cx="50" cy="55" rx="3" ry="12" class="corpo-borboleta" />
                                </svg>
                            </div>

                            <div class="video-wrapper">
                                <video autoplay muted loop playsinline class="foto-recortada">
                                    <source src="marcella.mp4" type="video/mp4">
                                    O seu navegador não suporta a reprodução de vídeo.
                                </video>
                            </div>

                            <div class="borboleta borboleta-base">
                                <svg viewBox="0 0 100 100">
                                    <path d="M48 40 Q45 25 35 20 M52 40 Q55 25 65 20" stroke="white" fill="none"
                                        stroke-width="1.5" />
                                    <g class="asa">
                                        <path d="M50 50 C20 10 5 40 15 60" fill="rgba(255,255,255,0.95)" />
                                        <path d="M50 50 C25 60 10 85 30 85" fill="rgba(255,255,255,0.75)" />
                                    </g>
                                    <g class="asa" style="transform: scaleX(-1); transform-origin: 50px;">
                                        <path d="M50 50 C20 10 5 40 15 60" fill="rgba(255,255,255,0.95)" />
                                        <path d="M50 50 C25 60 10 85 30 85" fill="rgba(255,255,255,0.75)" />
                                    </g>
                                    <ellipse cx="50" cy="55" rx="3" ry="12" class="corpo-borboleta" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <section class="secao-boas-vindas">
            <h2 class="titulo-boas-vindas">
                Bem-vinda ao Equilíbrio entre <b>Técnica</b> e <b>Bem-estar</b>.
            </h2>
            <p class="texto-apoio">
                Acreditamos que a verdadeira estética não nasce apenas do talento, mas do respeito. Aqui, o atendimento
                premium se traduz em zelo: protocolos de biossegurança rigorosos, produtos de alta performance e um
                ambiente estruturado para o seu bem-estar. Para nós, cuidar da sua imagem é um compromisso técnico;
                cuidar de você é a nossa missão.
            </p>
        </section>

        <section id="servicos">
            <h2 class="section-title">SERVIÇOS <b><em>EXCLUSIVOS</em></b></h2>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <p>Olá
                    <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>, explore os nossos serviços exclusivos
                    abaixo.
                </p>
            <?php else: ?>
                <p>Inicie sessão para aceder a opções exclusivas de agendamento.</p>
            <?php endif; ?>

            <div class="agendador tema-colorido" id="container-principal">

                <div class="topo">AGENDE SEU HORARIO</div>


                <div id="etapa1">
                    <div class="corpo">
                        <div class="filtros" id="categorias">
                        </div>

                        <div id="subcategorias" class="sub oculto"></div>

                        <div class="lista" id="lista-servicos">
                            <div
                                style="background:rgba(255,255,255,0.1); padding:15px; border-radius:12px; display:flex; justify-content:space-between;">
                            </div>
                        </div>
                    </div>

                    <div id="resumo-selecionados" class="resumo-selecionados oculto">
                        <h4>Serviços Selecionados:</h4>
                        <ul id="lista-selecionados"></ul>
                        <div id="total-geral">Total: R$ 0</div>
                    </div>

                    <div class="base">
                        <button class="botao" id="proximo" onclick="irParaEtapa(2)">Próximo</button>
                    </div>
                </div>


                <div id="etapa2" class="oculto">
                    <div class="corpo">
                        <div class="mes">
                            <span onclick="mudarMes(-1)" style="cursor:pointer;">❮</span>
                            <span id="nomeMes"></span>
                            <span onclick="mudarMes(1)" style="cursor:pointer;">❯</span>
                        </div>

                        <div class="agenda">
                            <div class="calendario-container">
                                <div class="dias-semana">
                                    <div>S</div>
                                    <div>T</div>
                                    <div>Q</div>
                                    <div>Q</div>
                                    <div>S</div>
                                    <div>S</div>
                                    <div>D</div>
                                </div>
                                <div class="grade" id="calendario">
                                </div>
                            </div>

                            <div class="horarios">
                                <div class="titulo-horarios">Horários</div>
                                <div id="horas">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="base" style="display:flex; gap:10px; align-items:center;">
                        <button onclick="voltar()"
                            style="background:none; border:none; color:inherit; cursor:pointer; font-weight:700; font-size:10px; text-transform:uppercase; opacity:0.7;">
                            Voltar
                        </button>
                        <button class="botao pronto" onclick="mostrarResumo()">Confirmar</button>
                    </div>
                </div>

                <div id="etapa3" class="oculto">
                    <div class="corpo">
                        <div class="resumo-container">
                            <div class="resumo-titulo" style="font-weight:bold; margin-bottom:15px;">
                                Confirmar Dados do Agendamento
                            </div>
                            <div id="resumo-servicos" style="margin-bottom:10px; font-size:14px;">Corte Clássico - R$
                                50,00</div>
                            <div class="resumo-info"
                                style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:5px;">
                                <span>Data</span>
                                <span id="resumo-data"></span>
                            </div>
                            <div class="resumo-info"
                                style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:15px;">
                                <span>Horário</span>
                                <span id="resumo-hora"></span>
                            </div>
                            <div class="resumo-total"
                                style="border-top:1px dashed #ddd; padding-top:10px; display:flex; justify-content:space-between; font-weight:bold; color:#FD9585; font-size:18px;">
                                <span>Total</span>
                                <span id="total-agendamento">R$ 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="base">
                        <button onclick="irParaEtapa(2)"
                            style="background:none; border:none; color:#aaa; cursor:pointer; font-weight:700; font-size:10px; text-transform:uppercase; margin-right:15px;">
                            Voltar
                        </button>
                        <button class="botao pronto" onclick="irParaEtapa(4)">Continuar</button>
                    </div>
                </div>

                <div id="etapa4" class="oculto">
                    <div class="corpo">
                        <div class="confirmacao-container">
                            <h4 class="subtitulo-confirmacao" style="font-size:11px; color:#888; margin-bottom:10px;">
                                SEUS DADOS</h4>

                            <form id="form-agendamento" method="POST" action="salvar_agendamento.php">

                                <input type="text" name="nome" placeholder="Nome Completo" class="campo-confirmacao">
                                <input type="text" name="whatsapp" placeholder="Whatsapp" class="campo-confirmacao">

                                <h4 class="subtitulo-confirmacao"
                                    style="font-size:11px; color:#888; margin-top:15px; margin-bottom:5px;">
                                    Termos de Compromisso Mútuo
                                </h4>
                                <ol class="termos">
                                    <li>Aviso com antecedência o desmarque ou remarque de horário.</li>
                                    <li>Informe exatamente quais procedimentos você deseja realizar.</li>
                                    <li>Informe exatamente quais procedimentos você deseja realizar.</li>
                                    <li>Evite trazer acompanhantes, exceto situações especiais.</li>
                                    <li>Evite o uso constante de celular durante o atendimento.</li>
                                    <li>Tolerância de atraso 10 minutos.</li>
                                </ol>

                                <label class="checkbox-termo"
                                    style="font-size:11px; display:flex; align-items:center; gap:8px;">
                                    <input type="checkbox" id="aceite-termos" name="termos" required>
                                    Eu concordo com as regras
                                </label>


                                <button type="submit" class="botao">Confirmar Agendamento</button>

                            </form>
                        </div>
                    </div>

                    <div class="base">
                        <button onclick="irParaEtapa(3)"
                            style="background:none; border:none; color:#aaa; cursor:pointer; font-weight:700; font-size:10px; text-transform:uppercase; margin-right:15px;">
                            Voltar
                        </button>
                        <button class="botao" onclick="confirmarAgendamento()">Confirmar Agendamento</button>
                    </div>
                </div>

                <div id="notificacao" class="notificacao oculto">
                    Agendamento confirmado com sucesso!
                </div>
            </div>
        </section>

        <section id="resultados">
            <h2 class="section-title">NOSSOS <b><em>RESULTADOS</em></b></h2>
        </section>

        <section id="localizacao">
            <h2 class="section-title"><b><em>VISITE - NOS</em></b></h2>
        </section>

        <section id="contatos">
            <h2 class="section-title">Onde a beleza encontra o <b><em class="highlight-text">CUIDADO</em></b></h2>
        </section>


    </div>

    <script>
        // ==============================
        // INICIALIZAÇÃO DA APLICAÇÃO
        // ==============================

        document.addEventListener("DOMContentLoaded", function () {

            desenharCategorias();

            selecionarPrimeiraCategoria();

            carregarAgendamento();

            const elementoCalendario = document.getElementById("calendarioMini");
            if (elementoCalendario) {
                window.calendarioMini = new FullCalendar.Calendar(elementoCalendario, {
                    initialView: "dayGridMonth",
                    locale: "pt-br",
                    height: 380
                });
                window.calendarioMini.render();
            }
        });

        const checkbox = document.getElementById("aceite-termos");
        if (checkbox) {
            checkbox.addEventListener("change", () => {
                const btn = document.querySelector(".botao");
                if (btn) {
                    if (checkbox.checked) btn.classList.add("pronto");
                    else btn.classList.remove("pronto");
                }
                if (checkbox.checked) btn.classList.add("pronto");
                else btn.classList.remove("pronto");
            });
        }

        // ==============================
        // NAVEGAÇÃO MOBILE (ABRIR/FECHAR MENU)
        // ==============================

        const menuToggle = document.getElementById('mobile-menu');
        const navPrincipal = document.querySelector('.nav-principal');
        const linksParaFechar = document.querySelectorAll('.nav-link, .botao-agendar, .btn-logout, .btn-adm a');

        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            navPrincipal.classList.toggle('menu-aberto');
        });

        linksParaFechar.forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                navPrincipal.classList.remove('menu-aberto');
            });
        });

        // ==============================
        // CONTROLE DE USUÁRIO (LOGIN)
        // ==============================

        const USUARIO_NAME = "<?php echo $_SESSION['usuario_name'] ?? 'Visitante'; ?>";

        const IS_ADMIN = "<?php echo (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin') ? 'true' : 'false'; ?>";

        function abrirLogin() { document.getElementById('modalLogin').style.display = 'flex'; }
        function fecharLogin() { document.getElementById('modalLogin').style.display = 'none'; }
        function toggleVistas() {
            document.getElementById('containerLogin').classList.toggle('escondido');
            document.getElementById('containerRegistro').classList.toggle('escondido');
        }

        function handleCredentialResponse(response) {
            console.log("TOKEN:", response.credential);

            fetch("auth/login_google.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    credential: response.credential
                })
            })
                .then(res => res.json())
                .then(data => {
                    console.log("RESPOSTA:", data);

                    if (data.success) {
                        window.location.href = "index.php";
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => {
                    console.error("Erro:", err);
                });
        }

        // ==============================
        // CARREGAMENTO DE DADOS (AGENDA)
        // ==============================

        async function carregarHorariosDisponiveis(dataEscolhida) {

            const container = document.getElementById("horas");
            container.innerHTML = "Carregando...";

            try {

                const duracaoTotal = calcularDuracaoTotal();

                const res = await fetch(`/api/agendamento/buscar_horarios_disponiveis.php?data=${dataEscolhida}&duracao=${duracaoTotal}`);
                const horarios = await res.json();

                if (horarios.length === 0) {
                    container.innerHTML = "<p class='texto-vazio'>Sem horários disponíveis</p>";
                    return;
                }

                container.innerHTML = "";

                horarios.forEach(h => {
                    const div = document.createElement("div");
                    div.className = "item-horario";
                    div.innerText = h;

                    div.onclick = () => {
                        selectedTimeValue = h;
                        document.querySelectorAll(".item-horario").forEach(el => el.classList.remove("selecionado"));
                        div.classList.add("selecionado");
                    };

                    container.appendChild(div);
                });

            } catch (e) {
                console.error(e);
                container.innerHTML = "Erro ao carregar horários";
            }
        }


        const dados = {
            manicure: {
                nome: "Manicure",
                servicos: [
                    { nome: "Manicure", tempo: "45 MIN", preco: 35 },
                    { nome: "Pedicure", tempo: "45 MIN", preco: 50 },
                    { nome: "Alongamento de unhas", tempo: "120 MIN", preco: 120 },
                    { nome: "Banho de gel", tempo: "60 MIN", preco: 70 },
                    { nome: "Esmaltação permanente", tempo: "45 MIN", preco: 50 },
                    { nome: "Spa dos pés", tempo: "40 MIN", preco: 60 }
                ]
            },
            massoterapia: {
                nome: "Massoterapia",
                servicos: [
                    { nome: "Massagem relaxante", tempo: "60 MIN", preco: 130 },
                    { nome: "Massagem terapêutica", tempo: "60 MIN", preco: 130 },
                    { nome: "Drenagem e modeladora", tempo: "60 MIN", preco: 150 },
                    { nome: "Bandagem terapêutica (Taping)", tempo: "30 MIN", preco: 80 },
                    { nome: "Drenagem pós parto e operatório", tempo: "60 MIN", preco: 160 }
                ]
            },
            depilacao: {
                nome: "Depilação",
                filtro: true,
                subs: {
                    facial: {
                        nome: "Facial",
                        servicos: [
                            { nome: "Depilação de Buço", tempo: "15 MIN", preco: 25 },
                            { nome: "Depilação de Sobrancelha (Cera)", tempo: "20 MIN", preco: 35 },
                            { nome: "Depilação de Rosto Completo", tempo: "40 MIN", preco: 60 }
                        ]
                    },
                    corporal: {
                        nome: "Corporal",
                        servicos: [
                            { nome: "Depilação de Axilas", tempo: "20 MIN", preco: 30 },
                            { nome: "Depilação de Meia Perna", tempo: "30 MIN", preco: 45 },
                            { nome: "Depilação de Perna Inteira", tempo: "50 MIN", preco: 80 },
                            { nome: "Depilação de Braços", tempo: "30 MIN", preco: 40 }
                        ]
                    },
                    intima: {
                        nome: "Íntima",
                        servicos: [
                            { nome: "Depilação de Virilha Simples", tempo: "30 MIN", preco: 50 },
                            { nome: "Depilação de Virilha Completa", tempo: "50 MIN", preco: 90 },
                            { nome: "Depilação de Ânus", tempo: "20 MIN", preco: 30 }
                        ]
                    }
                }
            },
            lash: {
                nome: "Lash",
                servicos: [
                    { nome: "Extensão de cílios", tempo: "120 MIN", preco: 200 },
                    { nome: "Designer de sobrancelhas", tempo: "30 MIN", preco: 60 }
                ]
            },
            estetica: {
                nome: "Estética",
                servicos: [
                    { nome: "Preenchimento Labial", tempo: "40 MIN", preco: 1500 },
                    { nome: "Botox", tempo: "30 MIN", preco: 1000 },
                    { nome: "Aplicação em vasinhos", tempo: "30 MIN", preco: 250 },
                    { nome: "Aplicação de enzimas", tempo: "30 MIN", preco: 300 }
                ]
            }
        };

        // ==============================
        // ETAPA 1 - NAVEGAÇÃO ENTRE ETAPAS
        // ==============================

        function atualizarBotao() {
            const btn = document.getElementById("proximo");
            if (!btn) return;

            if (servicosSelecionados.length > 0) {
                btn.classList.add("pronto");
                btn.disabled = false;
            } else {
                btn.classList.remove("pronto");
                btn.disabled = true;
            }
        }

        function irParaEtapa(numero) {
            document.getElementById("etapa1").classList.add("oculto");
            document.getElementById("etapa2").classList.add("oculto");
            document.getElementById("etapa3").classList.add("oculto");
            document.getElementById("etapa4").classList.add("oculto"); // 👈 faltava isso

            document.getElementById("etapa" + numero).classList.remove("oculto");

            if (numero === 3) mostrarResumo();
        }

        function voltar() {
            document.getElementById("etapa2").classList.add("oculto");
            document.getElementById("etapa1").classList.remove("oculto");
        }

        // ==============================
        // ETAPA 1 - CATEGORIAS E SERVIÇOS
        // ==============================

        let categoriaAtual = null;
        let subAtual = null;
        let servicosSelecionados = [];

        function iniciar() {
            desenharCategorias();
            carregarAgendamento();
        }

        function desenharCategorias() {
            const div = document.getElementById("categorias");
            if (!div) return;
            div.innerHTML = "";

            Object.entries(dados).forEach(([chave, valor]) => {
                const btn = document.createElement("div");
                btn.className = "item";
                btn.innerText = valor.nome;
                btn.onclick = () => selecionarCategoria(chave, btn);
                div.appendChild(btn);
            });
        }


        function selecionarPrimeiraCategoria() {
            const btns = document.querySelectorAll("#categorias .item");
            if (btns.length > 0) {
                btns[0].click();
            }
        }

        function selecionarCategoria(chave, botao) {
            categoriaAtual = chave;

            document.querySelectorAll("#categorias .item").forEach(el => el.classList.remove("ativo"));

            botao.classList.add("ativo");
            if (dados[chave].filtro) {
                subAtual = Object.keys(dados[chave].subs)[0];
            } else {
                subAtual = null;
            }

            mostrarSubcategorias();
            mostrarServicos();
        }

        function mostrarSubcategorias() {
            const div = document.getElementById("subcategorias");
            div.innerHTML = "";

            const cat = dados[categoriaAtual];
            if (!cat.filtro) {
                div.classList.add("oculto");
                return;
            }

            div.classList.remove("oculto");

            let keys = Object.keys(cat.subs);

            keys.forEach((subKey, index) => {
                const btn = document.createElement("div");
                btn.className = "item";
                btn.innerText = cat.subs[subKey].nome;

                if (subKey === subAtual) {
                    btn.classList.add("ativo");
                }

                btn.onclick = () => {
                    subAtual = subKey;
                    document.querySelectorAll("#subcategorias .item").forEach(el => el.classList.remove("ativo"));
                    btn.classList.add("ativo");
                    mostrarServicos();
                };

                div.appendChild(btn);
            });
        }
        function mostrarServicos() {
            const div = document.getElementById("lista-servicos");
            div.innerHTML = "";
            if (!categoriaAtual) return;

            let lista = [];

            if (dados[categoriaAtual].filtro) {
                if (subAtual) {
                    lista = dados[categoriaAtual].subs[subAtual].servicos;
                }
            } else {
                lista = dados[categoriaAtual].servicos;
            }

            lista.forEach(serv => {
                const item = document.createElement("div");
                item.className = "servico";


                if (servicosSelecionados.some(s => s.nome === serv.nome)) {
                    item.classList.add("eleito");
                }

                item.innerHTML = `
        <div>
            <div class="nome">${serv.nome}</div>
            <div class="tempo">${serv.tempo}</div>
        </div>
        <div class="preco">R$ ${serv.preco}</div>
    `;

                item.onclick = () => selecionarServico(item, serv);

                div.appendChild(item);
            });
        }



        function selecionarServico(div, serv) {
            const index = servicosSelecionados.findIndex(s => s.nome === serv.nome);

            if (index > -1) {
                servicosSelecionados.splice(index, 1);
                div.classList.remove("eleito");
            } else {
                servicosSelecionados.push(serv);
                div.classList.add("eleito");
            }

            atualizarResumoSelecionados();
            atualizarBotao();
        }

        // ==============================
        // RESUMO DOS SERVIÇOS SELECIONADOS
        // ==============================

        function atualizarResumoSelecionados() {
            const lista = document.getElementById("lista-selecionados");
            const box = document.getElementById("resumo-selecionados");
            const totalEl = document.getElementById("total-geral");

            if (servicosSelecionados.length === 0) {
                box.classList.add("oculto");
                return;
            }

            box.classList.remove("oculto");
            lista.innerHTML = "";

            let total = 0;
            servicosSelecionados.forEach((serv, index) => {
                const li = document.createElement("li");
                const removerBtn = `<button class="remover" onclick="removerServico(${index})">×</button>`;
                li.innerHTML = `
    <div class="resumo-item-info">
        <span class="resumo-nome">${serv.nome}</span>
        <span class="resumo-preco">R$ ${serv.preco}</span>
    </div>
    <button class="remover" onclick="removerServico(${index})">×</button>
`;
                lista.appendChild(li);
                total += serv.preco;
            });

            totalEl.innerText = `Total: R$ ${total}`;
        }

        function removerServico(index) {
            servicosSelecionados.splice(index, 1);
            document.querySelectorAll(".servico")[index].classList.remove("eleito");
            atualizarResumoSelecionados();
            atualizarBotao();
        }

        function calcularTotal() {
            return servicosSelecionados.reduce((acc, s) => acc + s.preco, 0);
        }

        function mostrarResumo() {
            const container = document.getElementById("resumo-servicos");
            const totalEl = document.getElementById("total-agendamento");
            container.innerHTML = "";
            let total = 0;
            servicosSelecionados.forEach(serv => {
                const div = document.createElement("div");
                div.style.cssText = "display:flex; justify-content:space-between; margin-bottom:8px;";
                div.innerHTML = `<span>${serv.nome}</span><span>R$ ${serv.preco}</span>`;
                container.appendChild(div);
                total += serv.preco;
            });
            totalEl.innerText = "R$ " + total;
            document.getElementById("resumo-data").innerText = selectedFullDate;
            document.getElementById("resumo-hora").innerText = selectedTimeValue;
        }

        // ==============================
        // ETAPA 2 - DATA E HORÁRIO
        // ==============================

        const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        let data = new Date();
        let viewDate = new Date();
        let minDate = new Date();
        let maxDate = new Date();
        maxDate.setMonth(maxDate.getMonth() + 2);

        let selectedFullDate = null;
        let selectedTimeValue = null;
        let agendaVindaDoBanco = {};

        async function carregarAgendaDoBanco() {
            const mesAtual = viewDate.getMonth() + 1;
            const anoAtual = viewDate.getFullYear();

            try {
                const resposta = await fetch(`/api/agendamento/get_agenda.php?mes=${mesAtual}&ano=${anoAtual}`);
                agendaVindaDoBanco = await resposta.json();
                renderCalendar();
            } catch (erro) {
                console.error("Erro ao carregar agenda:", erro);
            }
        }

        function renderCalendar() {
            const container = document.getElementById("calendario");
            if (!container) return;

            container.innerHTML = "";

            let year = viewDate.getFullYear();
            let month = viewDate.getMonth();
            let daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let d = 1; d <= daysInMonth; d++) {

                const el = document.createElement('div');
                el.className = 'numero-dia';
                el.innerText = d;

                const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;

                const horariosOcupados = agendaVindaDoBanco[dateKey];

                if (!horariosOcupados) {
                    el.classList.add('dia-disponivel');

                    el.onclick = () => {
                        selectedFullDate = dateKey;
                        renderCalendar();
                        carregarHorariosDisponiveis(dateKey);
                    };

                } else {
                    el.classList.add('dia-disponivel');

                    el.onclick = () => {
                        selectedFullDate = dateKey;
                        renderCalendar();
                        carregarHorariosDisponiveis(dateKey);
                    };
                }

                const info = agendaVindaDoBanco[dateKey];

                if (!info || !info.ativo) {
                    el.classList.add('dia-desativado');

                } else if (info.lotado) {
                    el.classList.add('dia-lotado');

                } else {
                    el.classList.add('dia-disponivel');

                    el.onclick = () => {
                        selectedFullDate = dateKey;
                        renderCalendar();
                        carregarHorariosDisponiveis(dateKey);
                    };
                }

                if (selectedFullDate === dateKey) {
                    el.classList.add('dia-selecionado');
                }

                container.appendChild(el);
            }
        }

        async function carregarHorariosDisponiveis(dataEscolhida) {

            const duracaoTotal = calcularDuracaoTotal();

            const container = document.getElementById("horas");
            if (!container) return;

            container.innerHTML = "Carregando...";

            try {

                const res = await fetch(`/api/agendamento/buscar_horarios_disponiveis.php?data=${dataEscolhida}`);
                const horarios = await res.json();

                let horariosValidos = [];

                if (horariosValidos.length === 0) {
                    container.innerHTML = "<p class='texto-vazio'>Sem horários disponíveis</p>";
                    return;
                }

                container.innerHTML = "";

                horariosValidos.forEach(h => {
                    const div = document.createElement("div");
                    div.className = "item-horario";
                    div.innerText = h;

                    div.onclick = () => {
                        selectedTimeValue = h;
                        document.querySelectorAll(".item-horario").forEach(el => el.classList.remove("selecionado"));
                        div.classList.add("selecionado");
                    };

                    container.appendChild(div);
                });

            } catch (e) {
                console.error(e);
                container.innerHTML = "Erro ao carregar horários";
            }
        }

        // ==============================
        // ETAPA 3 - RESUMO FINAL
        // ==============================

        function converterParaMinutos(hora) {
            const [h, m] = hora.split(":").map(Number);
            return h * 60 + m;
        }

        function pegarMinutos(tempo) { return parseInt(tempo.replace(" MIN", "")); }

        function calcularDuracaoTotal() {
            let total = 0;
            servicosSelecionados.forEach(serv => { total += pegarMinutos(serv.tempo); });
            return total;
        }

        function formatarHora(min) {
            const h = String(Math.floor(min / 60)).padStart(2, "0");
            const m = String(min % 60).padStart(2, "0");
            return `${h}:${m}`;
        }

        // ==============================
        // ETAPA 4 - CONFIRMAÇÃO
        // ==============================

        function confirmarAgendamento() {
            const nome = document.querySelector('input[name="nome"]').value;
            const whatsapp = document.querySelector('input[name="whatsapp"]').value;
            if (!usuario) { alert("Você precisa estar logado!"); return; }
            const dadosParaEnviar = {
                cliente_nome: nome,
                whatsapp: whatsapp,
                data: selectedFullDate,
                hora_inicio: selectedTimeValue,
                duracao: calcularDuracaoTotal(),
                servicos: servicosSelecionados.map(s => s.nome),
                valor_total: calcularTotal()
            };
            fetch("/api/agendamento/salvar_agendamento.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(dadosParaEnviar)
            })
                .then(res => res.json())
                .then(resposta => {
                    if (resposta.status === "ok") mostrarNotificacao();
                    else alert("Erro ao salvar");
                });
        }

        function mostrarNotificacao() {
            const n = document.getElementById("notificacao");
            n.classList.remove("oculto");
            setTimeout(() => n.classList.add("oculto"), 3000);
        }

        function carregarAgendamento() {
            const usuario = JSON.parse(localStorage.getItem("usuarioLogado"));
            if (!usuario) return;
            fetch("/api/salvar_agendamento/" + usuario.id)
                .then(res => res.json())
                .then(agendamento => {
                    if (!agendamento) return;
                    const container = document.getElementById("meu-agendamento");
                    if (!container) return;
                    container.innerHTML = `<h3>Seu Agendamento</h3><p><b>Data:</b> ${agendamento.data}</p><p><b>Total:</b> ${agendamento.total}</p>`;
                    container.classList.remove("oculto");
                });
        }

        // ==============================
        // EXPOSIÇÃO GLOBAL (DEBUG / HTML)
        // ==============================

        window.mostrarServicos = mostrarServicos;

        window.addEventListener("scroll", function () {
            const nav = document.querySelector(".nav-principal");

            if (window.scrollY > 50) {
                nav.classList.add("nav-scroll");
            } else {
                nav.classList.remove("nav-scroll");
            }
        });


    </script>

</body>

</html>