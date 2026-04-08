# 🚀 Laravel API

API REST desenvolvida com Laravel, seguindo boas práticas de
arquitetura, organização de código e padronização de respostas.

------------------------------------------------------------------------

## 📌 Sobre o projeto

Este projeto consiste em uma API backend construída com Laravel, com
foco em:

-   Organização em camadas (Controller, Service, Repository)
-   Separação de responsabilidades (SRP)
-   Código limpo e de fácil manutenção
-   Estrutura preparada para crescimento

A API pode ser utilizada como base para aplicações web ou mobile.

------------------------------------------------------------------------

## 🛠️ Tecnologias utilizadas

-   PHP 8+
-   Laravel 11
-   MySQL
-   Laravel Sanctum (autenticação)
-   Composer

------------------------------------------------------------------------

## 📂 Estrutura do projeto

app/ ├── Http/ │ ├── Controllers/ │ ├── Middleware/ │ └── Requests/ │
├── Services/ ├── Repositories/ ├── Models/ │ routes/ ├── api.php

------------------------------------------------------------------------

## ⚙️ Como rodar o projeto

### 1. Clonar o repositório

git clone https://github.com/kakabraga/laravel-api.git cd laravel-api

------------------------------------------------------------------------

### 2. Instalar dependências

composer install

------------------------------------------------------------------------

### 3. Configurar ambiente

cp .env.example .env

------------------------------------------------------------------------

### 4. Gerar chave da aplicação

php artisan key:generate

------------------------------------------------------------------------

### 5. Rodar migrations

php artisan migrate

------------------------------------------------------------------------

### 6. Iniciar servidor

php artisan serve

A API estará disponível em:

http://127.0.0.1:8000

------------------------------------------------------------------------

## 🔐 Autenticação

A API utiliza Laravel Sanctum para autenticação.

Envie o token no header:

Authorization: Bearer {token}

------------------------------------------------------------------------

## 📡 Padrão de resposta

### ✅ Sucesso

{ "success": true, "message": "Operação realizada com sucesso", "data":
{} }

### ❌ Erro

{ "success": false, "message": "Erro na requisição", "errors": \[\] }

------------------------------------------------------------------------

## 📌 Boas práticas aplicadas

-   Clean Code
-   SOLID
-   Separation of Concerns
-   Controllers enxutos
-   Services para regra de negócio
-   Repository para acesso a dados
-   Tratamento global de exceções

------------------------------------------------------------------------

## 🤝 Contribuição

1.  Fork do projeto
2.  Crie uma branch
3.  Commit suas alterações
4.  Abra um Pull Request

------------------------------------------------------------------------

## 📄 Licença

MIT

------------------------------------------------------------------------

## 👨‍💻 Autor

https://github.com/kakabraga
