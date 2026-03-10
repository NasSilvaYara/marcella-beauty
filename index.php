<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcella Gonçalves | Home</title>
    
    <!-- Fontes do Google -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* ============================================================
           CSS - RESET E CONFIGURAÇÕES GERAIS
           ============================================================ */
        
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

        .rotulo-superior {
            color: #888;
            font-size: 11px;
            padding: 8px 5%;
            background-color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 110;
        }

        /* ============================================================
           CSS - NAVEGAÇÃO (NAV)
           ============================================================ */

        .nav-principal {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%; 
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(25px);
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
            background: linear-gradient(90deg, #9d85f7, #f789f4);
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

        .botao-agendar:hover {
            box-shadow: 0 6px 20px rgba(157, 133, 247, 0.6);
            transform: scale(1.05);
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
            background: linear-gradient(to top, rgba(253, 247, 252, 1) 0%, rgba(253, 247, 252, 0) 100%);
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
            max-height: 70vh;
            max-width: 100%;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(10px 10px 30px rgba(0,0,0,0.08));
        }

        /* ============================================================
           CSS - MODAL LOGIN & REGISTO
           ============================================================ */
        .modal-login {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
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
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
        }

        .vista-login, .vista-registo {
            transition: 0.3s ease;
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

        .divisor-modal::before, .divisor-modal::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .divisor-modal span {
            padding: 0 15px;
        }

        .botao-google {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #ddd;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: #555;
            transition: 0.3s;
        }

        .botao-google:hover {
            background: #f9f9f9;
            border-color: #ccc;
        }

        .google-icon {
            width: 18px;
            height: 18px;
        }

        .texto-alternar {
            margin-top: 25px;
            font-size: 13px;
            color: #666;
        }

        .link-toggle {
            color: #9B86FF;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        .link-toggle:hover {
            text-decoration: underline;
        }

        /* Feedback de Mensagem */
        #mensagemFeedback {
            margin-top: 15px;
            font-size: 12px;
            display: none;
        }

    </style>
</head>
<body>

    <div class="rotulo-superior">PÁGINA INICIAL</div>

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

                <div class="acoes-usuario">
                    <a href="javascript:void(0)" class="nav-link" onclick="abrirLogin()" style="font-weight: 800;">
                        <svg class="login-icon" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Login
                    </a>
                    <button class="botao-agendar">Agendar</button>
                </div>
            </nav>

            <section id="inicio">
                <div class="conteudo-hero">
                    <div class="texto-principal">
                        <p class="tagline">Bem - vinda ao seu momento</p>
                        <h1 class="nome-marcella">MARCELLA</h1>
                        <h1 class="nome-marcella" style="padding-left: 8%;">GONÇALVES</h1>
                        <h2 class="subtitulo-beauty">Beauty Expert & Educadora</h2>
                        <p class="descricao-bio">
                            Mais de 20 mil atendimentos e naturalidade com marca registrada
                        </p>
                    </div>
                    <div class="container-foto">
                        <img src="https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?auto=format&fit=crop&q=80&w=800" 
                             alt="Marcella Gonçalves" 
                             class="foto-recortada">
                    </div>
                </div>
            </section>
        </div>

        <section id="servicos">
            <h2 class="section-title">SERVIÇOS</h2>
        </section>
        
        <section id="cursos">
            <h2 class="section-title">CURSOS</h2>
        </section>

        <section id="resultados">
            <h2 class="section-title">RESULTADOS</h2>
        </section>

        <section id="localizacao">
            <h2 class="section-title">LOCALIZAÇÃO</h2>
        </section>

        <section id="contatos">
            <h2 class="section-title">CONTATOS</h2>
        </section>
    </div>

    <!-- Modal Login & Registo -->
    <div id="modalLogin" class="modal-login">
        <div class="caixa-login">
            
            <div id="mensagemFeedback"></div>

            <!-- VISTA DE LOGIN -->
            <div id="containerLogin" class="vista-login">
                <h3 style="margin-bottom: 25px; font-family: 'Playfair Display', serif; font-size: 26px; color: #3b2166;">Bem-vinda de volta</h3>
                <!-- Adicionado action e name para o PHP -->
                <form id="formLogin" method="POST" action="login.php">
                    <input type="email" name="email" class="input-login" placeholder="E-mail" required>
                    <input type="password" name="senha" class="input-login" placeholder="Senha" required>
                    <button type="submit" class="botao-agendar" style="width:100%; padding: 16px; margin-top: 10px;">Entrar</button>
                </form>
                
                <div class="divisor-modal"><span>ou entrar com</span></div>
                <button class="botao-google">Google</button>

                <p class="texto-alternar">Não tem conta? <span class="link-toggle" onclick="toggleVistas()">Criar conta agora</span></p>
            </div>

            <!-- VISTA DE REGISTO (NOVA CONTA) -->
            <div id="containerRegisto" class="vista-registo escondido">
                <h3 style="margin-bottom: 25px; font-family: 'Playfair Display', serif; font-size: 26px; color: #3b2166;">Criar sua conta</h3>
                <form id="formResgistro" method="POST" action="registro.php">
                    <input type="text" name="nome" class="input-login" placeholder="Nome Completo" required>
                    <input type="email" name="email" class="input-login" placeholder="Melhor E-mail" required>
                    <input type="password" name="senha" class="input-login" placeholder="Crie uma Senha" required>
                    <button type="submit" class="botao-agendar" style="width:100%; padding: 16px; margin-top: 10px;">Finalizar Registo</button>
                </form>

                <p class="texto-alternar">Já é cliente? <span class="link-toggle" onclick="toggleVistas()">Entrar na conta</span></p>
            </div>

        </div>
    </div>

    <script>
        function abrirLogin() {
            document.getElementById('modalLogin').style.display = 'flex';
        }

        function fecharLogin() {
            document.getElementById('modalLogin').style.display = 'none';
        }

        function toggleVistas() {
            const login = document.getElementById('containerLogin');
            const registo = document.getElementById('containerRegisto');
            login.classList.toggle('escondido');
            registo.classList.toggle('escondido');
        }
        
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalLogin')) {
                fecharLogin();
            }
        }

        // Exemplo de como você enviaria os dados via AJAX para o PHP sem recarregar a página
        document.getElementById('formResgistro').onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const response = await fetch('registrotro.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.text();
            alert(result); // O PHP retornaria uma mensagem de sucesso ou erro
        };
    
    </script>

</body>
</html>