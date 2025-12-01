# CentralCoffee – Aplicação Web Full Stack  
Somativa 2 – Fundamentos de Programação Web  
Autora: Francine Basagni

Este repositório apresenta a versão completa do sistema CentralCoffee, desenvolvido para a Atividade Somativa 2 da disciplina de Fundamentos da Programação Web.

O projeto transforma o site inicial em uma aplicação web funcional, incluindo autenticação, CRUD de reservas e integração com banco de dados MySQL. O objetivo é demonstrar domínio de front-end, back-end e banco de dados em um único projeto, mantendo clareza, boas práticas e estrutura organizada.

---

## 1. Objetivo do Projeto

O sistema foi desenvolvido para demonstrar, de forma prática, os principais elementos de uma aplicação web completa:

- Tela inicial com apresentação do site.
- Sistema de login e controle de sessão.
- Cadastro de novos usuários.
- Área autenticada com gerenciamento de reservas.
- CRUD de reservas (criar, listar, editar e excluir).
- Integração total com banco de dados MySQL.
- Separação clara entre lógica, interface e persistência.
- Estrutura organizada para facilitar evolução e manutenção.

O projeto mostra como um site estático pode ser evoluído para um sistema funcional, aplicando conceitos fundamentais de desenvolvimento full stack.

---

## 2. Recursos Implementados

### 2.1 Autenticação
- Login com validação no banco de dados.
- Cadastro de novos usuários.
- Proteção de páginas internas com controle de sessão.
- Logout com destruição da sessão.

### 2.2 Sistema de Reservas
- Formulário para criação de reservas.
- Edição de registros existentes.
- Exclusão de reservas.
- Listagem completa com dados essenciais.
- Validações simples nos formulários.

### 2.3 Organização do Código
- Separação de arquivos PHP por responsabilidade.
- Conexão única com o banco de dados (`config/db.php`).
- Estrutura de diretórios organizada.
- HTML, CSS e JavaScript separados de forma limpa.

---

## 3. Estrutura do Projeto

```

centralcoffee-fullstack/
│
├── about.php
├── cadastro.php
├── index.php
├── login.php
├── logout.php
│
├── reservas_listar.php
├── reservas_excluir.php
├── reservas_editar.php
├── reserva_form.php
├── reservas_salvar.php
│
├── auth.php
│
├── config/
│ └── db.php
│
├── assets/
│ ├── css/
│ ├── images/
│ └── js/
│
└── database.sql


```

## 4. Banco de Dados

O arquivo database.sql contém:
  - Criação das tabelas necessárias.
  - Estrutura para:
      Usuários do sistema
      Reservas

  - Inserts iniciais (caso necessários).

O banco utiliza MySQL e segue estrutura simples para manipulação dos dados da aplicação.


## 5. Como Executar o Projeto

  1. Inicie o servidor local (XAMPP, WAMP ou similar).
  2. Copie o projeto para a pasta htdocs (no caso do XAMPP).
  3. Importe o arquivo database.sql no phpMyAdmin.

  4. Ajuste o arquivo (com o seu usuário e senha local do MySQL):

```
config/db.php

```

 5. Acesse no navegador:

```
 http://localhost/centralcoffee-fullstack/
 ```

 6. Realize login ou crie um novo usuário.
 7. Utilize o sistema normalmente.
 

##  6. Funcionalidades Atendidas (Checklist)

 - Estrutura completa HTML, CSS e JS.
 - Sistema de login funcional.
 - Cadastro de novos usuários.
 - Sessão ativa e controle de acesso.
 - CRUD completo de reservas.
 - Separação de arquivos PHP por responsabilidade.
 - Conexão com MySQL via db.php.
 - Script SQL pronto para importação.
 - Layout responsivo simples e funcional.
 - Projeto organizado seguindo boas práticas solicitadas.


##  7. Considerações Finais

Este projeto marca a evolução do CentralCoffee: de um site estático para uma aplicação web completa.
Foi desenvolvido com foco em aprendizado, clareza e estrutura, aplicando conceitos essenciais de desenvolvimento full stack.

Além de atender integralmente a atividade solicitada, também funciona como um exemplo real de como integrar interface, regras de negócio e banco de dados em um sistema simples, mas completo o suficiente para demonstrar domínio prático da disciplina.
