Código fonte desenvolvido na aulas: [Acessar as aulas](https://www.youtube.com/watch?v=ButD2QVZprE&list=PLmY5AEiqDWwB29FbhTfTh86Zr0yjeFBwO).<br>
Como criar um CRUD com Laravel 12 e Tailwind, ou seja, cadastrar, listar, editar e apagar.<br>

## Requisitos

* PHP 8.2 ou superior - Conferir a versão: php -v
* Composer - Conferir a instalação: composer --version
* Node.js 22 ou superior - Conferir a versão: node -v
* GIT - Conferir a instalação: git -v

## Como rodar o projeto baixado

Baixar os arquivos do GitHub.
```
git clone <repositorio_url> .
```
```
git clone https://github.com/celkecursos/tutorial-como-usar-laravel-12.git .
```

- Duplicar o arquivo ".env.example" e renomear para ".env".

Alterar no arquivo .env as credenciais do banco de dados.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco_de_dados
DB_USERNAME=usuario_do_banco_de_dados
DB_PASSWORD=senha_do_usuario_do_banco_de_dados
```

- Para a funcionalidade enviar e-mail funcionar, necessário alterar as credenciais do servidor de envio de e-mail no arquivo .env.
- Utilizar o servidor fake durante o desenvolvimento: [Acessar envio gratuito de e-mail](https://mailtrap.io?ref=celke)
- Utilizar o servidor Iagente no ambiente de produção: [Acessar envio gratuito de e-mail](https://login.iagente.com.br/solicitacao-conta-smtp/origin/celke)
- Configurar DNS da Iagente: [Acessar o tutorial](https://celke.com.br/artigo/como-configurar-o-dns-da-iagente-na-vps-da-hostinger)
```
# MAIL_MAILER=smtp
# MAIL_SCHEME=null
# MAIL_HOST=smart.iagentesmtp.com.br
# MAIL_PORT=587
# MAIL_USERNAME=nome-do-usuario-na-iagente
# MAIL_PASSWORD=senha-do-usuario-na-iagente
# MAIL_FROM_ADDRESS="colocar-email-remetente@meu-dominio.com.br"
# MAIL_FROM_NAME="${APP_NAME}"
```

Instalar as dependências do PHP
```
composer install
```

Instalar as dependências do Node.js.
```
npm install
```

Gerar a chave para o arquivo .env.
```
php artisan key:generate
```

Executar as migration para criar a base de dados e as tabelas.
```
php artisan migrate
```

Iniciar o projeto criado com Laravel.
```
php artisan serve
```

Executar as bibliotecas Node.js.
```
npm run dev
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000
```

## Sequência para criar o projeto

Criar o projeto com Laravel
```
composer create-project laravel/laravel .
```

Iniciar o projeto criado com Laravel.
```
php artisan serve
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000
```

Criar a Controller.
```
php artisan make:controller NomeController
```
```
php artisan make:controller UserController
```

Criar a View.
```
php artisan make:view nome
```
```
php artisan make:view users/create
```

Executar as migration para criar a base de dados e as tabelas.
```
php artisan migrate
```

Instalar as dependências do Node.js.
```
npm install
```

Executar as bibliotecas Node.js.
```
npm run dev
```

Criar um arquivo Request com validações do formulário.
```
php artisan make:request NomeDoRequest
```
```
php artisan make:request UserRequest
```

Traduzir para português [Módulo pt-BR](https://github.com/lucascudo/laravel-pt-BR-localization).

Instalar a biblioteca para apresentar o alerta personalizado.
```
npm install sweetalert2
```

Instalar a biblioteca para gerar PDF.
```
composer require barryvdh/laravel-dompdf
```

Gerar a classe para enviar e-mail.
```
php artisan make:mail NomeDaClasse
```
```
php artisan make:mail UserPdfMail
```

## Como enviar o projeto para o GitHub.

Inicializar um novo repositorio GIT.
```
git init
```

Adicionar todos os arquivos modificados na área de preparação.
```
git add .
```

Commit registra as alterações feitas nos arquivos que foram adicionados na área de preparação.
```
git commit -m "Base do projeto"
```

Verificar em qual branch está.
```
git branch
```

Renomear a branch atual no GIT para main.
```
git branch -M main
```

Adicionar um repositório remoto ao repositório local.
```
git remote add origin https://github.com/celkecursos/tutorial-como-usar-laravel-12.git
```

Enviar os commits locais para um repositório remoto.
```
git push -u origin main
```

## Autor

Este projeto foi desenvolvido por [Cesar Szpak](https://github.com/cesarszpak) e está hospedado no repositório da organização [Celke](https://github.com/celkecursos).

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE.txt) para mais detalhes.