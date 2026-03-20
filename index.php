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
            
            --agendador-gradient: linear-gradient(
                225deg, 
                #FFA461 0%, 
                #FD987E 30%, 
                #FD9585 61%, 
                #FAA7D5 97%
            );
            --cor-branco: #ffffff;
            --cor-texto: #333333;
            --raio-borda: 25px;
        }

        /* Container Principal */
        .agendador {
            width: 100%;
            max-width: 420px;
            margin: 20px auto;
            border-radius: var(--raio-borda);
            overflow: hidden;
            position: relative;
            font-family: 'Segoe UI', sans-serif;
            transition: all 0.4s ease;
        }

        /* Estados Visuais (Gradiente vs Branco) */
        .agendador.tema-colorido {
            background: var(--agendador-gradient);
            color: var(--cor-branco);
            box-shadow: 0 15px 35px rgba(253, 152, 126, 0.3);
        }

        .agendador.tema-branco {
            background: var(--cor-branco);
            color: var(--cor-texto);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 2px;
        }

        .agendador.tema-branco::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border-radius: var(--raio-borda);
            padding: 3px; 
            background: var(--agendador-gradient);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Estrutura Interna */
        .topo {
            padding: 35px 25px 15px;
            text-align: center;
            font-weight: 800;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .corpo {
            padding: 0 25px 20px;
        }

        .base {
            padding: 20px 25px 30px;
            display: flex;
            justify-content: center;
        }

        /* Filtros e Listas */
        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .lista {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Calendário e Grade */
        .mes {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .dias-semana {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            font-size: 0.7rem;
            margin-bottom: 10px;
            opacity: 0.8;
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

        /* Formulários e Termos */
        .campo-confirmacao {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .termos {
            font-size: 0.75rem;
            margin: 15px 0;
            padding-left: 20px;
            color: #666;
        }

        /* Botões */
        .botao {
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s;
        }

        .tema-colorido .botao {
            background: var(--cor-branco);
            color: #FD9585;
        }

        .tema-branco .botao {
            background: var(--agendador-gradient);
            color: var(--cor-branco);
        }

        .oculto { display: none !important; }

        .notificacao {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.8rem;
            z-index: 10;
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

            <div class="agendador tema-colorido" id="container-principal">

            <div class="topo">AGENDE SEU HORARIO</div>

            <!-- ETAPA 1 -->
            <div id="etapa1">
                <div class="corpo">
                    <div class="filtros" id="categorias">
                    </div>

                    <div id="subcategorias" class="sub oculto"></div>

                    <div class="lista" id="lista-servicos">
                        <div style="background:rgba(255,255,255,0.1); padding:15px; border-radius:12px; display:flex; justify-content:space-between;">
                        </div>
                    </div>
                </div>

                <div class="base">
                    <button class="botao" id="proximo" onclick="irParaEtapa(2)">Próximo</button>
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
                            <div class="dias-semana">
                                <div>S</div><div>T</div><div>Q</div><div>Q</div><div>S</div><div>S</div><div>D</div>
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

            <!-- ETAPA 3 -->
            <div id="etapa3" class="oculto">
                <div class="corpo">
                    <div class="resumo-container">
                        <div class="resumo-titulo" style="font-weight:bold; margin-bottom:15px;">
                            Confirmar Dados do Agendamento
                        </div>
                        <div id="resumo-servicos" style="margin-bottom:10px; font-size:14px;">Corte Clássico - R$ 50,00</div>
                        <div class="resumo-info" style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:5px;">
                            <span>Data</span>
                            <span id="resumo-data"></span>
                        </div>
                        <div class="resumo-info" style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:15px;">
                            <span>Horário</span>
                            <span id="resumo-hora"></span>
                        </div>
                        <div class="resumo-total" style="border-top:1px dashed #ddd; padding-top:10px; display:flex; justify-content:space-between; font-weight:bold; color:#FD9585; font-size:18px;">
                            <span>Total</span>
                            <span id="total-agendamento">R$ 0</span>
                        </div>
                    </div>
                </div>

                <div class="base">
                    <button onclick="irParaEtapa(2)" style="background:none; border:none; color:#aaa; cursor:pointer; font-weight:700; font-size:10px; text-transform:uppercase; margin-right:15px;">
                        Voltar
                    </button>
                    <button class="botao pronto" onclick="irParaEtapa(4)">Continuar</button>
                </div>
            </div>

            <!-- ETAPA 4 -->
            <div id="etapa4" class="oculto">
                <div class="corpo">
                    <div class="confirmacao-container">
                        <h4 class="subtitulo-confirmacao" style="font-size:11px; color:#888; margin-bottom:10px;">SEUS DADOS</h4>
                        <input type="text" placeholder="Nome Completo" class="campo-confirmacao">
                        <input type="text" placeholder="Whatsapp" class="campo-confirmacao">

                        <h4 class="subtitulo-confirmacao" style="font-size:11px; color:#888; margin-top:15px; margin-bottom:5px;">
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

                        <label class="checkbox-termo" style="font-size:11px; display:flex; align-items:center; gap:8px;">
                            <input type="checkbox" id="aceite-termos">
                            Eu concordo com as regras
                        </label>
                    </div>
                </div>

                <div class="base">
                    <button onclick="irParaEtapa(3)" style="background:none; border:none; color:#aaa; cursor:pointer; font-weight:700; font-size:10px; text-transform:uppercase; margin-right:15px;">
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

        // Inicialização e Listeners
        document.addEventListener('DOMContentLoaded', function () {
            const elementoCalendario = document.getElementById('calendarioMini');

            window.calendarioMini = new FullCalendar.Calendar(elementoCalendario, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                height: 380,
                headerToolbar: { left: 'prev,next', center: 'title', right: '' },
                eventDidMount: function (info) {
                    // Destaca os eventos de "Agenda Fechada"
                    if (info.event.title === 'Agenda Fechada') {
                        info.el.style.backgroundColor = '#ef4444';
                        info.el.style.color = 'white';
                        info.el.style.fontWeight = '700';
                        info.el.style.textAlign = 'center';
                    }
                }
            });
            window.calendarioMini.render();

            carregarDisponibilidade();
            iniciar();
        });

        const checkbox = document.getElementById("aceite-termos");
        if (checkbox) {
            checkbox.addEventListener("change", () => {
                const btn = document.getElementById("btn-confirmar-final");
                if (checkbox.checked) btn.classList.add("pronto");
                else btn.classList.remove("pronto");
            });
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

        function iniciar() {
            desenharCategorias();
            carregarAgendaDoBanco();
            carregarAgendamento(); // Função que carrega agendamentos do localStorage
        }

        function desenharCategorias() {
            const div = document.getElementById("categorias");
            if (!div) return;
            div.innerHTML = "";

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
         * FUNÇÕES DE BACKEND (FETCH)
         */
        async function carregarAgendaDoBanco() {
            const mesAtual = viewDate.getMonth() + 1;
            const anoAtual = viewDate.getFullYear();
            try {
                const resposta = await fetch(`get_agenda.php?mes=${mesAtual}&ano=${anoAtual}`)};
                agendaVindaDoBanco = await resposta.json();
                renderCalendar();
            } catch (erro) { console.error("Erro ao carregar agenda:", erro); }
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

                const temAgenda = agendaVindaDoBanco[dateKey];

                if (!temAgenda) {
                    el.classList.add('dia-desativado');
                } else {
                    el.classList.add('dia-disponivel');

                    el.onclick = () => {
                        selectedFullDate = dateKey;
                        renderCalendar();
                        carregarHorariosDisponiveis(dateKey); // 🔥 ESSENCIAL
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

                const disp = await fetch(`backend/buscar_disponibilidade_dia.php?data=${dataEscolhida}`);
                const disponibilidade = await disp.json();

                const ag = await fetch(`backend/buscar_agendamentos_dia.php?data=${dataEscolhida}`);
                const ocupados = await ag.json();

                let horariosValidos = [];

                disponibilidade.forEach(d => {

                    let inicio = converterParaMinutos(d.hora_inicio);
                    let fim = converterParaMinutos(d.hora_fim);

                    for (let h = inicio; h <= fim - duracaoTotal; h += 15) {

                        let conflito = false;

                        ocupados.forEach(o => {
                            let oInicio = converterParaMinutos(o.hora_inicio);
                            let oFim = oInicio + parseInt(o.duracao);

                            if (h < oFim && (h + duracaoTotal) > oInicio) {
                                conflito = true;
                            }
                        });

                        if (!conflito) {
                            horariosValidos.push(formatarHora(h));
                        }
                    }
                });

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

        function converterParaMinutos(hora) {
            const [h, m] = hora.split(":").map(Number);
            return h * 60 + m;
        }

        function formatarHora(min) {
            const h = String(Math.floor(min / 60)).padStart(2, "0");
            const m = String(min % 60).padStart(2, "0");
            return `${h}:${m}`;
        }

    </script>
</body>

</html>