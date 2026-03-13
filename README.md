<div align="center">
  <h1>MARCELLA GONÇALVES</h1>
</div>

<p align="justify">
  Este projeto consiste na estruturação completa e criação do site institucional para a empresa Marcella Gonçalves Nails, localizada em Suzano. O sistema foi desenvolvido para consolidar a marca no mercado local, oferecendo uma plataforma profissional para divulgação de serviços e facilitação de agendamentos.
</p>

<br>

## Descrição do Projeto
<p align="justify">
  O desenvolvimento visa resolver a limitação de visibilidade digital da empresa, criando uma presença online robusta através de um site profissional. O sistema conta com áreas de apresentação, serviços e um sistema de autenticação de usuários para garantir a integridade dos dados.
</p>

<br>

## Equipe de Desenvolvimento

<div align="center">

| INTEGRANTES | FUNÇÃO | REDES SOCIAIS |
| :---: | :---: | :---: |
| **Yara da Silva** | Gerente de Projeto, responsável pelo protótipo e UI/UX Layout, modelagem e estruturação do Banco de Dados e elaboração de diagramas UML| [GitHub](https://github.com/NasSilvaYara) / [LinkedIn](https://www.linkedin.com/in/nassilvayara) |
| **Gabriel Alves** | Responsável pela comunicação com a parceria (stakeholders) e suporte na elaboração da documentação do projeto | [GitHub](#) / [LinkedIn](https://www.linkedin.com/in/gabriel-alves-798160382/) |
| **Livia Schendroski** | Desenvolvedora Front-end e Back-end, com participação na elaboração da documentação | [GitHub](#) / [LinkedIn](https://www.linkedin.com/in/livia-de-queiroz-schendroski-606b3926b/) |
| **Paulo Henrique** | Desenvolvedor Front-end e Back-end, com participação na elaboração da documentação | [GitHub](#) / [LinkedIn](#) |
</div>

<br>

## Tecnologias Utilizadas

<div align="center">

  A infraestrutura tecnológica do sistema é composta pelas seguintes ferramentas:

![Figma](https://img.shields.io/badge/Figma-%238A2BE2.svg?style=for-the-badge&logo=figma&logoColor=white)
![XAMPP](https://img.shields.io/badge/XAMPP-%23FB7A24.svg?style=for-the-badge&logo=xampp&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23F7DF1E.svg?style=for-the-badge&logo=javascript&logoColor=black)
</div>

<br>

## Especificações Técnicas e Cronograma

<div align="center">

<p align="justify">
Em conformidade com o planejamento estratégico detalhado no Termo de Abertura do Projeto (Revisão 01), as definições técnicas e prazos seguem os parâmetros abaixo:
</p>

| PARÂMETRO TÉCNICO | DETALHAMENTO DO PROJETO |
| :---: | :---:|
| **Tecnologia Back-end** | PHP 8.x para processamento de dados e gestão de sessões |
| **Banco de Dados** | MySQL para armazenamento seguro de informações |
| **Protocolo de Segurança** | Implementação de Hash (BCRYPT) para proteção de senhas |
| **Inicio do Projeto** | 23 de fevereiro de 2026 |
| **Previsão de Término** | 25 de junho de 2026 |

</div>

<br>

## Guia de Instalação e Execução

<p align="justify">
Para a correta replicação do ambiente de desenvolvimento e execução do sistema institucional, siga rigorosamente os procedimentos técnicos detalhados abaixo:
</p>

<br>

### 1. Clonagem do Repositório

Direcione o terminal para o diretório `htdocs` do seu servidor local (XAMPP) e execute o comando de clonagem:

```bash
git clone https://github.com/NasSilvaYara/marcella_nails.git
```

### 2. Configuração do Ambiente de Dados

Localize o arquivo de conexão e insira as credenciais do seu servidor local:

```php
// db_config.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "marcella_db";
```

### 3. Importação do Schema SQL

Acesse o **phpMyAdmin**, crie um banco de dados e importe o arquivo contido na pasta:

```bash
/database/marcella_nails.sql
```

### 4. Inicialização do Sistema

Certifique-se de que os módulos **Apache** e **MySQL** do **XAMPP** estejam ativos e acesse:

```bash
http://localhost/marcella_nails
```

<p align="center">
<i>Projeto desenvolvido com base nas diretrizes do Termo de Abertura do Projeto.</i>
</p>
