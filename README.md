# 📦 Sistema de Gerenciamento de Produtos

Sistema desenvolvido com **Laravel 9**, **Inertia.js** e **Vue 3**, focado na gestão de produtos, usuários e auditoria de ações do sistema.

---

## 🚀 Funcionalidades

- Visualizar produtos
- Editar produtos
- Ativar/Inativar produtos
- Cadastrar novos produtos
- Registrar logs de ações (criação/edição)
- Listar usuários do sistema

---

## 🧾 Regras de Negócio

### 🔐 Validação de Preço

O preço de venda **não pode ser inferior** ao preço de custo + 10%.

> Exemplo: Custo de R$ 100 → Venda mínima: R$ 110

### 📝 Descrição do Produto

Aceita apenas as seguintes tags HTML:
```html
<p>, <br>, <b>, <strong>
```
## 🖼️ Imagens do Produto

- **Formatos permitidos:** `.jpg`, `.png`
- **Tamanho ideal:** até **2MB** por imagem
- **Múltiplas imagens** são permitidas por produto

## 🧑‍💼 Logs de Ações

O sistema registra todas as ações importantes sobre os produtos para garantir **rastreabilidade e segurança** das operações:

| Ação    | Dados Registrados             |
|---------|-------------------------------|
| Criação | ID do usuário, data e hora    |
| Edição  | ID do usuário, data e hora    |

---

## 👥 Lista de Usuários

Disponível apenas para usuários autenticados, a tela de usuários exibe:

- **Nome**
- **E-mail**
- **Data de cadastro**

A rota [`/usuarios`](#) permite a visualização completa de todos os usuários cadastrados no sistema.

## 📂 Tecnologias Utilizadas

- ✅ **PHP 8.x** + **Laravel 9**
- ✅ **Vue 3** + **Inertia.js**
- ✅ **Laravel Sanctum** (API Authentication)
- ✅ **MySQL**
- ✅ **Axios**
- ✅ **Eloquent ORM** com:
  - Migrations
  - Seeders
  - Factories
- ✅ **PHPUnit** + Laravel Test Utilities

---

## ✅ Requisitos para Rodar o Projeto

- **PHP >= 8.1**
- **Composer**
- **Node.js** + **npm**
- **MySQL**

### 📦 Extensões PHP necessárias

- `pdo`
- `openssl`
- `mbstring`
- `tokenizer`
- `xml`
- `ctype`
- `json`
- `bcmath`

## ⚙️ Instalação

Siga os passos abaixo para configurar o projeto localmente:

### 1. Clone o repositório

```bash
gh repo clone carlosnoroes/laravel_app
cd laravel_app
```
### 2. Instale as dependências do backend (PHP)

```bash
composer install
```
### 3. Instale as dependências do frontend (Vue)

```bash
npm install
npm run dev
```
### 4. Configure o ambiente

```bash
cp .env.example .env
php artisan key:generate
```
### Execute as migrations e seeders

```bash
php artisan migrate --seed
```
### Inicie o servidor

```bash
php artisan serve
```
## 🧪 Testes

Para rodar os testes automatizados, execute o seguinte comando:

```bash
php artisan test
```
## ✅ Cobertura dos Testes

O projeto cobre as seguintes funcionalidades:

- **API de Produtos**
  - 📄 **Listagem** (`GET`)
  - ➕ **Criação** (`POST`)
  - ✏️ **Atualização** (`PUT`)
  - 🔄 **Ativação/Inativação** (`PATCH`)

- **API de Usuários**
  - Acesso autenticado via **Laravel Sanctum**

- **Regras de Negócio**
  - Validação de **preço mínimo** (custo + 10%)

- **Logs de Produto**
  - Registros de **criação e edição**

- **Testes de Unidade**
  - Uso de **Factories**
  - Assertivas de **criação e remoção de entidades**

  ## 🛡️ Segurança

- **Autenticação** com **Laravel Sanctum** (token-based)
- **Uploads validados** (tipos e tamanho)
- **HTML** na descrição é **sanitizado**
- Acesso a rotas sensíveis **restrito** via `auth:sanctum`

# 📊 Arquitetura do Sistema de Gerenciamento de Produtos

Esta seção descreve a arquitetura do sistema de gerenciamento de produtos, abordando seus componentes principais, fluxos de dados e tecnologias utilizadas.

---

## 🏗️ Arquitetura Geral

A arquitetura do sistema segue o padrão **MVC (Model-View-Controller)** e utiliza os seguintes componentes principais:

- **Frontend**: Responsável pela interface do usuário, utilizando **Vue 3** com **Inertia.js** para comunicação eficiente entre o frontend e o backend.
- **Backend**: Implementado com **Laravel 9**, o backend é responsável por fornecer APIs RESTful que o frontend consome.
- **Banco de Dados**: Utiliza **MySQL** para armazenar dados persistentes do sistema.
- **Autenticação**: O sistema utiliza **Laravel Sanctum** para autenticação de APIs.

---

## 🔧 Componentes e Tecnologias

### 1. **Frontend (Vue 3 + Inertia.js)**

- **Vue 3**: Framework JavaScript para construção de interfaces reativas.
- **Inertia.js**: Biblioteca que permite a construção de aplicações monolíticas modernas, sem a necessidade de renderização de páginas completas no lado do servidor. Facilita a comunicação entre o frontend e o backend.

### 2. **Backend (Laravel 9)**

- **Laravel**: Framework PHP para o backend, fornece uma estrutura robusta e escalável para construir APIs RESTful e interfaces de administração.
- **Eloquent ORM**: Utilizado para interagir com o banco de dados de forma simples e intuitiva.
- **Laravel Sanctum**: Sistema de autenticação baseado em tokens para autenticar APIs de maneira segura e escalável.

### 3. **Banco de Dados (MySQL)**

- **MySQL**: Sistema de gerenciamento de banco de dados relacional utilizado para armazenar os dados do sistema, como produtos, usuários e logs de ações.
- **Migrations e Seeders**: O Laravel utiliza **migrations** para controle de versão do banco de dados e **seeders** para popular o banco com dados iniciais.

---

## 🔄 Fluxos de Dados

### 1. **Fluxo de Criação de Produto**

1. O usuário preenche um formulário no frontend com os dados do produto.
2. O frontend envia uma requisição `POST` para a API backend.
3. A API do Laravel valida e cria um novo produto no banco de dados.
4. O sistema registra a criação no log de ações.

### 2. **Fluxo de Edição de Produto**

1. O usuário edita um produto existente no frontend.
2. O frontend envia uma requisição `PUT` para atualizar os dados do produto.
3. A API do Laravel valida os dados e atualiza o produto no banco de dados.
4. O sistema registra a edição no log de ações.

### 3. **Fluxo de Autenticação e Acesso de Usuário**

1. O usuário realiza login utilizando Laravel Sanctum.
2. O backend valida o token de autenticação e retorna um token válido.
3. O token é utilizado para autenticar futuras requisições de API.

---

## 🔐 Segurança e Autenticação

O sistema utiliza **Laravel Sanctum** para autenticação baseada em tokens. O processo de autenticação envolve:

1. O usuário fornece suas credenciais de login.
2. O backend valida as credenciais e gera um **token** de autenticação.
3. O token é enviado para o frontend e deve ser incluído em cada requisição subsequente.

Além disso, o sistema possui as seguintes práticas de segurança:

- **Validação de uploads**: O sistema valida o tipo e tamanho das imagens enviadas.
- **Sanitização de HTML**: Ao permitir HTML na descrição do produto, o conteúdo é sanitizado para evitar a inserção de código malicioso.
- **Autorização via Laravel Sanctum**: Apenas usuários autenticados podem acessar rotas sensíveis, como a visualização da lista de usuários.

---

## 🛠️ Arquitetura de Banco de Dados

A estrutura do banco de dados é composta pelas seguintes tabelas principais:

### 1. **Tabela `products`**

Armazena os dados dos produtos.

| Coluna        | Tipo           | Descrição                          |
|---------------|----------------|------------------------------------|
| id            | bigint         | Identificador único do produto    |
| name          | varchar(255)   | Nome do produto                   |
| description   | text           | Descrição do produto              |
| image         | varchar(255)   | Imagem do produto
| price_sale    | decimal(10, 2) | Preço de venda                    |
| price_cost    | decimal(10, 2) | Preço de custo                    |
| active        | boolean        | Status de ativação/inativação      |
| created_at    | timestamp      | Data de criação                   |
| updated_at    | timestamp      | Data de atualização               |

### 2. **Tabela `users`**

Armazena os dados dos usuários.

| Coluna            | Tipo            | Descrição                          |
|-------------------|-----------------|------------------------------------|
| id                | bigint unsigned | Identificador único do usuário    |
| name              | varchar(255)    | Nome do usuário                   |
| email             | varchar(255)    | E-mail do usuário (único)         |
| email_verified_at | timestamp       | Data de verificação do e-mail     |
| password          | varchar(255)    | Senha do usuário                  |
| remember_token    | varchar(100)    | Lembra token de usuario
| created_at        | timestamp       | Data de criação                   |
| updated_at        | timestamp       | Data de atualização               |

---
