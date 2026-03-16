<?php
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: #3b2166;
            background-color: #FDF7FC;
        }

        .site-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* ============================================================
           CSS - NAVEGAÇÃO (NAV)
           ============================================================ */
        .nav-principal {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            background: rgba(255, 255, 255, 0.31);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-wrapper {
            background: linear-gradient(135deg, #9B86FF 0%, #FF86F8 100%);
            position: relative;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .links-institucionais {
            display: flex;
            gap: clamp(12px, 2vw, 25px);
        }

        .acoes-usuario {
            display: flex;
            align-items: center;
            gap: clamp(15px, 2.5vw, 35px);
            padding-left: 40px;
            border-left: 1px solid rgba(59, 33, 102, 0.15);
        }

        .nav-link {
            font-size: 10px;
            font-weight: 600;
            color: #3b2166;
            text-transform: uppercase;
            text-decoration: none;
            letter-spacing: 1.5px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .nav-link:hover {
            color: #d946ef;
            transform: translateY(-1px);
        }

        .login-icon {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2.5;
            fill: none;
        }

        .botao-agendar {
            background: linear-gradient(90deg, #8c77d8, #e07ddd);
            color: white;
            padding: 10px 28px;
            border-radius: 50px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(157, 133, 247, 0.4);
            flex-shrink: 0;
            transition: all 0.3s;
        }

        /* Estilos Novos para Usuário Logado */
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .user-greeting {
            font-weight: 800;
            font-size: 11px;
            color: #3b2166;
        }

        .btn-logout {
            font-size: 9px;
            color: #000000;
            text-decoration: none;
            font-weight: bold;
            margin-top: 2px;
        }

        /* ============================================================
           CSS - SEÇÕES
           ============================================================ */
        section {
            min-height: 100vh;
            width: 100%;
            padding: 80px 10%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 5vw, 48px);
            margin-bottom: 20px;
            color: #3b2166;
        }

        /* Seção Inicio*/

        #inicio {
            flex: 1;
            position: relative;
            min-height: 0;
            padding: 0 10%;
            display: flex;
            align-items: center;
        }

        #inicio::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(253, 247, 252, 1) 0%, rgba(253, 247, 252, 0.09) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .conteudo-hero {
            position: relative;
            z-index: 5;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .texto-principal {
            flex: 1;
            max-width: 600px;
        }

        .tagline {
            color: #3b2166;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .nome-marcella {
            font-family: 'Playfair Display', serif;
            font-size: clamp(45px, 6.5vw, 95px);
            color: #3b2166;
            line-height: 0.85;
            margin: 0;
            letter-spacing: -2px;
        }

        .subtitulo-beauty {
            font-family: 'Playfair Display', serif;
            font-size: clamp(22px, 3.5vw, 48px);
            color: #3b2166;
            margin-top: 15px;
            font-weight: 400;
        }

        .descricao-bio {
            color: #444;
            font-size: 15px;
            line-height: 1.6;
            margin-top: 40px;
            max-width: 380px;
        }

        .container-foto {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .foto-recortada {
            max-height: 90vh;
            max-width: 100%;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(10px 10px 30px rgba(0, 0, 0, 0.08));
        }

        .modal-login {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 200;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
        }

        .caixa-login {
            background: white;
            padding: 40px;
            border-radius: 30px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .escondido {
            display: none;
        }

        .input-login {
            width: 100%;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid #eee;
            border-radius: 12px;
            outline: none;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            transition: 0.3s;
        }

        .input-login:focus {
            border-color: #9B86FF;
            box-shadow: 0 0 0 4px rgba(155, 134, 255, 0.1);
        }

        .divisor-modal {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #aaa;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .divisor-modal::before,
        .divisor-modal::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .divisor-modal span {
            padding: 0 15px;
        }

        .link-toggle {
            color: #9B86FF;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        .alerta-erro {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 15px;
        }

        /* Seção Serviços*/

        /* Card de Agendamento */
        :root {
            --primary-gradient: linear-gradient(90deg, #ff80ed 0%, #a066ff 100%);
            --bg-color: #fdfafd;
            --text-main: #333;
            --text-muted: #b0b0b0;
            --accent-purple: #a066ff;
            --accent-purple-light: #f5efff;
            --border-light: #eeeeee;
        }

        .agendador {
            background: #fff;
            width: 100%;
            max-width: 480px;
            margin: 20px auto;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* HEADER */

        .topo {
            font-family: 'Playfair Display', sans-serif;
            background: var(--primary-gradient);
            padding: 30px 20px;
            text-align: center;
            color: white;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: 2px;
        }

        /* BODY */

        .corpo {
            padding: 25px 20px;
        }

        /* CATEGORIAS */

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin-bottom: 15px;
        }

        .item {
            padding: 8px 14px;
            border-radius: 20px;
            border: 1px solid var(--border-light);
            font-size: 0.7rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.2s;
        }

        .item.ativo {
            background: var(--accent-purple-light);
            color: var(--accent-purple);
            border-color: var(--accent-purple);
        }

        /* SUBCATEGORIA */

        .sub {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 15px;
        }

        /* LISTA SERVIÇOS */

        .lista {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* SERVIÇO */

        .servico {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            border: 1px solid var(--border-light);
            border-radius: 15px;
            cursor: pointer;
            transition: .2s;
        }

        .servico:hover {
            border-color: var(--accent-purple);
            background: #fafafa;
        }

        .servico.eleito {
            border-color: var(--accent-purple);
            background: var(--accent-purple-light);
        }

        .nome {
            font-size: .9rem;
            font-weight: 500;
            color: var(--text-main);
        }

        .tempo {
            font-size: .65rem;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .preco {
            font-weight: 700;
            color: var(--accent-purple);
            font-size: .95rem;
        }

        /* CALENDÁRIO */

        .agenda {
            display: grid;
            grid-template-columns: 1.3fr .7fr;
            gap: 15px;
        }

        .mes {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .grade {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            text-align: center;
        }

        .calendario-container {
            width: 100%;
        }

        .dias-semana {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-size: .65rem;
            font-weight: 700;
            color: #999;
            margin-bottom: 6px;
        }

        .dias-semana div {
            padding: 6px 0;
        }

        .titulo-horarios {
            font-size: .75rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--text-muted);
        }

        .dia {
            font-size: .75rem;
            padding: 10px 0;
            cursor: pointer;
            border-radius: 8px;
            transition: .2s;
        }

        .dia:hover:not(.vazio) {
            background: var(--accent-purple-light);
        }

        .dia.marcado {
            background: var(--primary-gradient);
            color: white;
            font-weight: 700;
        }

        /* HORÁRIOS */

        .horarios {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .hora {
            padding: 8px;
            border: 1px solid var(--border-light);
            border-radius: 10px;
            text-align: center;
            font-size: .8rem;
            cursor: pointer;
        }

        .hora:hover {
            border-color: var(--accent-purple);
        }

        .hora.marcado {
            border-color: var(--accent-purple);
            background: var(--accent-purple-light);
            color: var(--accent-purple);
            font-weight: 700;
        }

        /* Estilo geral do botão de hora */
        .botao-hora {
            background-color: #fff;
            border: 1px solid #007bff;
            color: #007bff;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 5px;
        }

        /* Estilo para quando o horário estiver OCUPADO */
        .horario-indisponivel {
            background-color: #f8d7da !important;
            /* Vermelho bem claro */
            border-color: #f5c6cb !important;
            color: #721c24 !important;
            /* Texto vinho */
            cursor: not-allowed !important;
            opacity: 0.7;
            position: relative;
        }

        .horario-indisponivel span {
            font-size: 0.8em;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* FOOTER */

        .base {
            padding: 20px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* BOTÃO */

        .botao {
            flex: 1;
            background: #e0e0e0;
            color: #999;
            border: none;
            padding: 16px;
            border-radius: 15px;
            font-weight: 700;
            font-size: .95rem;
            cursor: not-allowed;
            transition: .3s;
        }

        .botao.pronto {
            background: var(--primary-gradient);
            color: white;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(160, 102, 255, .3);
        }

        .oculto {
            display: none;
        }

        /* ETAPA 3 */

        /* CONTAINER */

        .resumo-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: .85rem;
        }

        /* TÍTULO */

        .resumo-titulo {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        /* SERVIÇOS */

        #resumo-servicos {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 10px;
        }

        .item-resumo {
            display: flex;
            justify-content: space-between;
        }

        /* INFO */

        .resumo-info {
            display: flex;
            justify-content: space-between;
            color: var(--text-muted);
        }

        /* TOTAL */

        .resumo-total {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid var(--border-light);
            padding-top: 10px;
            font-weight: 700;
            color: var(--accent-purple);
        }

        /* BOTÃO VOLTAR */

        .voltar {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
        }

        /* ETAPA 4 */

        .confirmacao-container {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .subtitulo-confirmacao {
            font-size: .75rem;
            font-weight: 700;
            text-align: center;
            margin-top: 10px;
        }

        .campo-confirmacao {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            font-size: .8rem;
        }

        .termos {
            font-size: .9rem;
            color: #666;
            padding-left: 18px;
        }

        .checkbox-termo {
            font-size: .7rem;
            color: #777;
            display: flex;
            gap: 6px;
            align-items: center;
        }

        /** CONFIRMAÇÃO DE AGENDAMENTO */

        .notificacao {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #6c5cff;
            color: white;
            padding: 14px 20px;
            border-radius: 10px;
            font-size: .85rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .15);
            z-index: 999;
        }

        .oculto {
            display: none;
        }

        .btn-adm a {
            background: linear-gradient(90deg, #8c77d8, #e07ddd);
            color: white;
            padding: 10px 28px;
            border-radius: 50px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(157, 133, 247, 0.4);
            flex-shrink: 0;
            transition: all 0.3s;
        }

        a {
        text-decoration: none;
        }
</style>
</head>

<body>

    <div class="site-container">

        <div class="header-wrapper">
            <nav class="nav-principal">
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
                            <span class="user-greeting">
                                Olá, <?php echo htmlspecialchars(explode(' ', $_SESSION['usuario_nome'])[0]); ?>!
                            </span>

                            <a href="auth/logout.php" class="btn-logout">SAIR DA CONTA</a>
                        </div>
                    <?php else: ?>
                        <a href="javascript:void(0)" class="nav-link" onclick="abrirLogin()" style="font-weight: 800;">
                            Login
                        </a>
                    <?php endif; ?>

                    <button class="botao-agendar">Agendar</button>
                </div>

            </nav>
            <!-- Modal Login & Registro -->
            <div id="modalLogin" class="modal-login">
                <div class="caixa-login">

                    <?php if (isset($_GET['erro'])): ?>
                        <div class="alerta-erro">E-mail ou palavra-passe incorretos.</div>
                    <?php endif; ?>

                    <!-- Vista de Login -->
                    <div id="containerLogin" class="vista-login <?php echo $logado ? 'escondido' : ''; ?>">
                        <h3
                            style="margin-bottom: 25px; font-family: 'Playfair Display', serif; font-size: 26px; color: #3b2166;">
                            Bem-vinda de volta</h3>
                        <form id="formLogin" method="POST" action="auth/login.php">
                            <input type="email" name="email" class="input-login" placeholder="E-mail" required>
                            <input type="password" name="senha" class="input-login" placeholder="Palavra-passe"
                                required>
                            <button type="submit" class="botao-agendar"
                                style="width:100%; padding: 16px; margin-top: 10px;">Entrar</button>
                        </form>

                        <div class="divisor-modal"><span>ou</span></div>
                        <div id="g_id_onload"
                            data-client_id="821436734385-382dk4ipi7d31dlllfogujl1o1jbo2i7.apps.googleusercontent.com"
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

                    <!-- Vista de Registro Corrigida -->
                    <div id="containerRegistro" class="vista-registro escondido">
                        <h3
                            style="margin-bottom: 25px; font-family: 'Playfair Display', serif; font-size: 26px; color: #3b2166;">
                            Criar a sua conta</h3>
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
                        <p class="tagline">Bem-vinda ao seu momento</p>
                        <h1 class="nome-marcella">MARCELLA</h1>
                        <h1 class="nome-marcella" style="padding-left: 8%;">GONÇALVES</h1>
                        <h2 class="subtitulo-beauty">Beauty Expert & Educadora</h2>
                        <p class="descricao-bio">
                            Mais de 20 mil atendimentos e naturalidade com marca registrada.
                        </p>
                    </div>
                    <div class="container-foto">
                        <img src="fotoMarcella.png" alt="Marcella Gonçalves" class="foto-recortada">
                    </div>

                    <div id="meu-agendamento" class="meu-agendamento oculto"></div>
                </div>
            </section>
        </div>

        <section id="servicos">
            <h2 class="section-title">SERVIÇOS</h2>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <p>Olá
                    <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>, explore os nossos serviços exclusivos
                    abaixo.
                </p>
            <?php else: ?>
                <p>Inicie sessão para aceder a opções exclusivas de agendamento.</p>
            <?php endif; ?>

            <div class="agendador">

                <div class="topo">AGENDE SEU HORARIO</div>

                <!-- ETAPA 1 -->
                <div id="etapa1">

                    <div class="corpo">
                        <div class="filtros" id="categorias"></div>

                        <div id="subcategorias" class="sub oculto"></div>

                        <div class="lista" id="lista-servicos"></div>
                    </div>

                    <div class="base">
                        <button class="botao" id="proximo">Próximo</button>
                    </div>

                </div>


                <!-- ETAPA 2 -->
                <div id="etapa2" class="oculto">

                    <div class="corpo">

                        <div class="mes">
                            <span onclick="mudarMes(-1)" style="cursor:pointer;">❮</span>
                            <span id="nomeMes"></span>
                            <span onclick="mudarMes(1)" style="cursor:pointer;">❯</span>
                        </div>

                        <div class="agenda">

                            <div class="calendario-container">

                                <!-- DIAS DA SEMANA -->
                                <div class="dias-semana">
                                    <div>S</div>
                                    <div>T</div>
                                    <div>Q</div>
                                    <div>Q</div>
                                    <div>S</div>
                                    <div>S</div>
                                    <div>D</div>
                                </div>

                                <!-- DIAS DO CALENDÁRIO -->
                                <div class="grade" id="calendario"></div>

                            </div>

                            <div class="horarios">

                                <div class="titulo-horarios">Horários</div>

                                <div id="horas"></div>

                            </div>

                        </div>

                    </div>

                    <div class="base" style="display:flex; gap:10px; align-items:center;">

                        <button onclick="voltar()"
                            style="background:none; border:none; color:#aaa; cursor:pointer; font-weight:700; font-size:10px; text-transform:uppercase;">
                            Voltar
                        </button>

                        <button class="botao pronto" onclick="mostrarResumo()">Confirmar</button>

                    </div>

                </div>

                <div id="etapa3" class="oculto">

                    <div class="corpo">

                        <div class="resumo-container">

                            <div class="resumo-titulo">
                                Confirmar Dados do Agendamento
                            </div>

                            <div id="resumo-servicos"></div>

                            <div class="resumo-info">
                                <span>Data</span>
                                <span id="resumo-data"></span>
                            </div>

                            <div class="resumo-info">
                                <span>Horário</span>
                                <span id="resumo-hora"></span>
                            </div>

                            <div class="resumo-total">
                                <span>Total</span>
                                <span id="total-agendamento">R$ 0</span>
                            </div>

                        </div>

                    </div>

                    <div class="base">

                        <button onclick="irParaEtapa(2)" class="voltar">
                            Voltar
                        </button>

                        <button class="botao pronto" onclick="irParaEtapa(4)">
                            Continuar
                        </button>

                    </div>

                </div>

                <div id="etapa4" class="oculto">

                    <div class="corpo">

                        <div class="confirmacao-container">

                            <h4 class="subtitulo-confirmacao">SEUS DADOS</h4>

                            <input type="text" placeholder="Nome Completo" class="campo-confirmacao">
                            <input type="text" placeholder="Whatsapp" class="campo-confirmacao">

                            <h4 class="subtitulo-confirmacao">
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

                            <label class="checkbox-termo">
                                <input type="checkbox" id="aceite-termos">
                                Eu concordo com as regras de atendimento
                            </label>

                        </div>

                    </div>

                    <div class="base">

                        <button onclick="irParaEtapa(3)" class="voltar">
                            Voltar
                        </button>

                        <button class="botao" onclick="confirmarAgendamento()">
                            Confirmar Agendamento
                        </button>

                    </div>

                </div>

                <div id="notificacao" class="notificacao oculto">
                    Agendamento confirmado com sucesso!
                </div>
        </section>

        <section id="resultados">
            <h2 class="section-title">Resultados</h2>
        </section>

        <section id="localização">
            <h2 class="section-title">Localização</h2>
        </section>

        <section id="contatos">
            <h2 class="section-title">Contatos</h2>
        </section>


    </div>

    <script>
    /**
     * ESTADO GLOBAL
     */
    let viewDate = new Date();
    let minDate = new Date();
    let maxDate = new Date();
    maxDate.setMonth(maxDate.getMonth() + 2);

    let selectedFullDate = null;
    let selectedTimeValue = null;
    let agendaVindaDoBanco = {}; 

    // Integração PHP
    const USUARIO_NAME = "<?php echo $_SESSION['usuario_name'] ?? 'Visitante'; ?>";
    const IS_ADMIN = "<?php echo (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin') ? 'true' : 'false'; ?>";

    /**
     * DADOS DOS SERVIÇOS
     */
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

    let categoriaAtual = null;
    let subAtual = null;
    let servicosSelecionados = [];
    const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    let data = new Date();

    /**
     * FUNÇÕES DE BACKEND (FETCH)
     */
    async function carregarAgendaDoBanco() {
        const mesAtual = viewDate.getMonth() + 1;
        const anoAtual = viewDate.getFullYear();
        try {
            const resposta = await fetch(`get_agenda.php?mes=${mesAtual}&ano=${anoAtual}`);
            agendaVindaDoBanco = await resposta.json();
            renderCalendar();
        } catch (erro) { console.error("Erro ao carregar agenda:", erro); }
    }

    async function salvarHorarioNoBanco(dataSelecionada, horaDigitada, acao = 'adicionar') {
        const payload = { dados: dataSelecionada, hora: horaDigitada, acao: acao };
        try {
            const resposta = await fetch('salvar_agenda.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const resultado = await resposta.json();
            if (resultado.status === 'sucesso') carregarAgendaDoBanco();
        } catch (erro) { console.error(erro); }
    }

    async function carregarHorariosDisponiveis(dataEscolhida) {
        try {
            const res = await fetch(`backend/buscar_disponibilidade.php?data=${dataEscolhida}`);
            const horarios = await res.json();
            const container = document.getElementById('horas');
            if (!container) return;

            if (horarios.length === 0) {
                container.innerHTML = '<p class="texto-vazio">Nenhum horário disponível.</p>';
                selectedTimeValue = null;
                return;
            }

            container.innerHTML = '';
            horarios.forEach(hora => {
                const div = document.createElement('div');
                div.className = `item-horario ${selectedTimeValue === hora ? 'selecionado' : ''}`;
                div.innerText = hora;
                div.onclick = () => {
                    selectedTimeValue = hora;
                    renderTimes(); 
                };
                container.appendChild(div);
            });
        } catch (erro) { console.error("Erro ao buscar horários:", erro); }
    }

    /**
     * MÓDULO ADMIN
     */
    let listaTemporariaAdmin = [];

    function abrirEditorAdmin(dateKey) {
        selectedFullDate = dateKey;
        document.getElementById('gerenciador-horarios').classList.remove('escondido');
        document.getElementById('data-texto-admin').innerText = dateKey;
        listaTemporariaAdmin = agendaVindaDoBanco[dateKey] || [];
        renderizarPreviewAdmin();
    }

    function adicionarHoraManual() {
        const hora = document.getElementById('input-nova-hora').value;
        if (hora && !listaTemporariaAdmin.includes(hora)) {
            listaTemporariaAdmin.push(hora);
            listaTemporariaAdmin.sort();
            renderizarPreviewAdmin();
        }
    }

    function renderizarPreviewAdmin() {
        const cont = document.getElementById('lista-preview-admin');
        cont.innerHTML = listaTemporariaAdmin.map(h => `
            <span style="background: #f5efff; color: #a066ff; padding: 5px 10px; border-radius: 20px; font-size: 0.7rem; border: 1px solid #a066ff;">
                ${h} <b onclick="removerHoraLista('${h}')" style="color:red; cursor:pointer; margin-left:5px;">&times;</b>
            </span>
        `).join('');
    }

    function removerHoraLista(h) {
        listaTemporariaAdmin = listaTemporariaAdmin.filter(item => item !== h);
        renderizarPreviewAdmin();
    }

    async function finalizarDiaAdmin() {
        const payload = { dados: selectedFullDate, horarios: listaTemporariaAdmin };
        const resp = await fetch('salvar_agenda_completa.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const res = await resp.json();
        if (res.status === 'sucesso') {
            alert("Agenda do dia " + selectedFullDate + " atualizada!");
            carregarAgendaDoBanco();
        }
    }

    /**
     * INTERFACE E NAVEGAÇÃO
     */
    function iniciar() {
        desenharCategorias();
        carregarAgendaDoBanco();
        carregarAgendamento(); // Função que carrega agendamentos do localStorage
    }

    function desenharCategorias() {
        const div = document.getElementById("categorias");
        if (!div) return;
        div.innerHTML = "";

        if (IS_ADMIN === "true") {
            dados["administrado"] = {
                nome: "MINHA AGENDA",
                isDynamic: true,
                services: [{ name: "Horário de Atendimento", duration: "--", price: 0 }]
            };
        }

        for (let chave in dados) {
            const btn = document.createElement("div");
            btn.className = "item";
            btn.innerText = dados[chave].nome;
            btn.onclick = () => selecionarCategoria(chave, btn);
            div.appendChild(btn);
        }
    }

    function selecionarCategoria(chave, botao) {
        categoriaAtual = chave;
        subAtual = null;
        document.querySelectorAll(".item").forEach(el => el.classList.remove("ativo"));
        botao.classList.add("ativo");
        mostrarSubcategorias();
        mostrarServicos();
    }

    function mostrarSubcategorias() {
        const div = document.getElementById("subcategorias");
        div.innerHTML = "";
        const cat = dados[categoriaAtual];
        if (!cat.filtro) { div.style.display = "none"; return; }
        div.style.display = "flex";
        for (let sub in cat.subs) {
            const btn = document.createElement("div");
            btn.className = "item";
            btn.innerText = cat.subs[sub].nome;
            btn.onclick = () => {
                subAtual = sub;
                document.querySelectorAll("#subcategorias .item").forEach(el => el.classList.remove("ativo"));
                btn.classList.add("ativo");
                mostrarServicos();
            };
            div.appendChild(btn);
        }
    }

    function mostrarServicos() {
        const div = document.getElementById("lista-servicos");
        div.innerHTML = "";
        if (!categoriaAtual) return;
        let lista = dados[categoriaAtual].filtro ? (subAtual ? dados[categoriaAtual].subs[subAtual].servicos : []) : dados[categoriaAtual].servicos;
        lista.forEach(serv => {
            const item = document.createElement("div");
            item.className = "servico";
            item.innerHTML = `<div><div class="nome">${serv.nome}</div><div class="tempo">${serv.tempo}</div></div><div class="preco">R$ ${serv.preco}</div>`;
            item.onclick = () => selecionarServico(item, serv);
            div.appendChild(item);
        });
    }

    function renderCalendar() {
        const container = document.getElementById("calendario");
        container.innerHTML = "";
        let year = viewDate.getFullYear();
        let month = viewDate.getMonth();
        let daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let d = 1; d <= daysInMonth; d++) {
            const el = document.createElement('div');
            el.className = 'numero-dia';
            el.innerText = d;
            const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;

            if (dados[categoriaAtual] && dados[categoriaAtual].isDynamic) {
                if (IS_ADMIN === "true") {
                    el.classList.add('visao-admin');
                    if (selectedFullDate === dateKey) el.classList.add('dia-selecionado');
                    el.onclick = () => {
                        selectedFullDate = dateKey;
                        abrirEditorAdmin(dateKey);
                        renderCalendar();
                        carregarHorariosDisponiveis(dateKey);
                    };
                } else {
                    const temHorarios = agendaVindaDoBanco[dateKey] && agendaVindaDoBanco[dateKey].length > 0;
                    if (!temHorarios) el.classList.add('dia-desativado');
                    else {
                        el.classList.add('dia-disponivel');
                        if (selectedFullDate === dateKey) el.classList.add('dia-selecionado');
                        el.onclick = () => {
                            selectedFullDate = dateKey;
                            renderCalendar();
                        };
                    }
                }
            }
            container.appendChild(el);
        }
    }

    /**
     * LÓGICA DE TEMPO E AGENDAMENTO
     */
    function selecionarServico(div, serv) {
        if (div.classList.contains("eleito")) {
            div.classList.remove("eleito");
            servicosSelecionados = servicosSelecionados.filter(s => s.nome !== serv.nome);
        } else {
            div.classList.add("eleito");
            servicosSelecionados.push(serv);
        }
        atualizarBotao();
    }

    function atualizarBotao() {
        const btn = document.getElementById("proximo");
        if (servicosSelecionados.length > 0) {
            btn.classList.add("pronto");
            btn.onclick = () => irParaEtapa(2);
        }
    }

    function irParaEtapa(numero) {
        document.getElementById("etapa1").classList.add("oculto");
        document.getElementById("etapa2").classList.add("oculto");
        document.getElementById("etapa3").classList.add("oculto");
        document.getElementById("etapa" + numero).classList.remove("oculto");
        if (numero === 3) mostrarResumo();
    }

    function voltar() {
        document.getElementById("etapa2").classList.add("oculto");
        document.getElementById("etapa1").classList.remove("oculto");
    }

    function pegarMinutos(tempo) { return parseInt(tempo.replace(" MIN", "")); }

    function calcularDuracaoTotal() {
        let total = 0;
        servicosSelecionados.forEach(serv => { total += pegarMinutos(serv.tempo); });
        return total;
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

    /**
     * AUTENTICAÇÃO E MODAIS
     */
    function abrirLogin() { document.getElementById('modalLogin').style.display = 'flex'; }
    function fecharLogin() { document.getElementById('modalLogin').style.display = 'none'; }
    function toggleVistas() {
        document.getElementById('containerLogin').classList.toggle('escondido');
        document.getElementById('containerRegistro').classList.toggle('escondido');
    }

    function handleCredentialResponse(response) {
        fetch("auth/login_google.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id_token: response.credential })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) window.location.href = "index.php";
            else alert("Erro: " + data.message);
        });
    }

    /**
     * FINALIZAÇÃO E NOTIFICAÇÃO
     */
    function confirmarAgendamento() {
        const usuario = JSON.parse(localStorage.getItem("usuarioLogado"));
        if (!usuario) { alert("Você precisa estar logado!"); return; }

        const dadosParaEnviar = {
            cliente_nome: usuario.nome,
            data: selectedFullDate,
            hora_inicio: selectedTimeValue,
            duracao: calcularDuracaoTotal(),
            servicos: servicosSelecionados.map(s => s.nome),
            valor_total: calcularTotal()
        };

        fetch("backend/salvar_agendamento.php", {
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

    function renderizarHorarios(horasOcupadas) {
        const container = document.getElementById('horas');
        container.innerHTML = "";
        const horariosFuncionamento = ["09:00", "10:00", "11:00", "14:00", "15:00", "16:00"]; // Exemplo
        horariosFuncionamento.forEach(hora => {
            const botao = document.createElement('button');
            botao.className = 'botao-hora';
            botao.innerHTML = hora;
            if (horasOcupadas.includes(hora)) {
                botao.classList.add('horario-indisponivel');
                botao.disabled = true;
                botao.innerHTML += " <span>(Ocupado)</span>";
            } else {
                botao.onclick = () => { selectedTimeValue = hora; };
            }
            container.appendChild(botao);
        });
    }

    // Inicialização e Listeners
    document.addEventListener('DOMContentLoaded', function() {
    const elementoCalendario = document.getElementById('calendarioMini');
    
    window.calendarioMini = new FullCalendar.Calendar(elementoCalendario, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        height: 380,
        headerToolbar: { left: 'prev,next', center: 'title', right: '' },
        eventDidMount: function(info){
            // Destaca os eventos de "Agenda Fechada"
            if(info.event.title === 'Agenda Fechada'){
                info.el.style.backgroundColor = '#ef4444';
                info.el.style.color = 'white';
                info.el.style.fontWeight = '700';
                info.el.style.textAlign = 'center';
            }
        }
    });
    window.calendarioMini.render();

    carregarDisponibilidade(); // busca do banco
});

    const checkbox = document.getElementById("aceite-termos");
    if (checkbox) {
        checkbox.addEventListener("change", () => {
            const btn = document.getElementById("btn-confirmar-final");
            if (checkbox.checked) btn.classList.add("pronto");
            else btn.classList.remove("pronto");
        });
    }

    function carregarDisponibilidade(mes = null, ano = null) {
    // usa os filtros se não vierem
    if(!mes) mes = document.getElementById('filtroMes').value;
    if(!ano) ano = document.getElementById('filtroAno').value;

    fetch(`backend/buscar_disponibilidade.php?mes=${mes}&ano=${ano}`)
    .then(r => r.json())
    .then(data => {
        const eventos = data.map(d => {
            if(d.liberado == 1){ // horário liberado
                return { 
                    title: `${d.inicio} - ${d.fim}`,
                    start: d.data,
                    allDay: false
                };
            } else { // bloqueado
                return {
                    title: 'Agenda Fechada',
                    start: d.data,
                    allDay: true,
                    color: '#ef4444'
                };
            }
        });

        // Limpa e adiciona os eventos
        window.calendarioMini.removeAllEvents();
        window.calendarioMini.addEventSource(eventos);
    });

}

    // Chamadas de Teste/API
    fetch("api/buscar_disponibilidade.php").then(r => r.json()).then(d => console.log(d));
</script>
</body>

</html>