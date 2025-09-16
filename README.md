# 📊 A2 - Atividade 2 - Projeto de Programação Web

Projeto desenvolvido como parte da disciplina de **Programação Web**, utilizando o framework **Laravel** para construção de uma aplicação de controle de ações.

---

## 🚀 Funcionalidades

- 📥 Cadastro e login de usuários
- 👤 Edição de perfil
- 📈 Compra e venda de ações
- 📂 Histórico de transações
- 🔒 Sistema de autenticação com verificação de e-mail
- 📊 Consulta de carteira e saldo

---

## 🛠️ Tecnologias utilizadas

- [PHP](https://www.php.net/)
- [Laravel](https://laravel.com/)
- [MySQL](https://www.mysql.com/)
- [Blade](https://laravel.com/docs/blade) (Template engine)
- [Tailwind CSS](https://tailwindcss.com/)
- [Composer](https://getcomposer.org/)
- [Vite](https://vitejs.dev/)

---

## 📦 Instalação e execução local

### Pré-requisitos:

- PHP 8.1+
- Composer
- MySQL
- Node.js + NPM

### Passo a passo:

```bash
# 1. Clone o repositório
git clone https://github.com/laurismmm08/A2-Atividade2.git

# 2. Acesse o diretório do projeto
cd A2-Atividade2

# 3. Instale as dependências PHP
composer install

# 4. Copie o arquivo de exemplo do ambiente
cp .env.example .env

# 5. Gere a chave da aplicação
php artisan key:generate

# 6. Configure seu banco de dados no arquivo .env

# 7. Rode as migrations
php artisan migrate

# 8. Instale dependências front-end
npm install && npm run dev

# 9. Inicie o servidor local
php artisan serve
