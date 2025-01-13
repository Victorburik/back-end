# Back-end Laravel Project

Este é o projeto de **back-end** da aplicação, desenvolvido utilizando o **Laravel**. Ele fornece uma API que interage com o banco de dados, permitindo as funcionalidades essenciais para o funcionamento da aplicação.

## Tecnologias Usadas

- **Laravel**: Framework PHP para o desenvolvimento do back-end.
- **MySQL**: Banco de dados relacional utilizado para persistência de dados.
- **Docker**: Contêineres para empacotar a aplicação e suas dependências.
- **Docker Compose**: Ferramenta para orquestrar múltiplos contêineres Docker.

## Funcionalidades

### 1. **Autenticação**
A aplicação permite o registro e a autenticação de usuários, utilizando o sistema de autenticação nativo do Laravel (Sanctum ou Passport para autenticação via API).

### 2. **API RESTful**
A API expõe várias rotas que permitem realizar operações CRUD, além de interações complexas com o banco de dados.

### 3. **Interação com o Front-end**
Este back-end será consumido por um front-end, que envia e recebe dados via requisições HTTP.


obs: Após configurar o contairner rode: docker exec -it laravel-backend php artisan serve --host=0.0.0.0 --port=8000

## Estrutura do Projeto

```bash
├── app
│   ├── Http/Controllers/       # Controladores que lidam com as requisições HTTP
│   ├── Models/                # Modelos de banco de dados
│   ├── Providers/             # Fornecedores de serviços do Laravel
│   └── ...
├── database
│   ├── migrations/            # Arquivos de migração para criação do banco de dados
│   ├── seeds/                 # Seeds para preenchimento de dados iniciais
├── routes/                     # Arquivos de definição das rotas da API
│   └── api.php                # Definição das rotas da API
├── .env                        # Variáveis de ambiente do Laravel
├── Dockerfile                  # Arquivo Docker para containerizar a aplicação
├── docker-compose.yml          # Arquivo Docker Compose para orquestrar contêineres
└── artisan                     # CLI do Laravel para executar comandos no back-end
