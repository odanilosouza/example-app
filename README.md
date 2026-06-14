# Portal Cliente

Portal Cliente é um sistema web composto por um backend em Laravel 13 e um frontend em Next.js 14.

O objetivo do projeto é oferecer um portal de cliente com autenticação por CNPJ, cadastro de clientes, painel de métricas, documentos, relatórios, imagens e notificações.

## Arquitetura

- **Backend**: Laravel 13 com Sanctum, API RESTful e controle de acesso.
- **Frontend**: Next.js 14 com React, Tailwind e Axios para consumir a API.
- **Banco de dados**: SQLite por padrão no ambiente local.
- **Autenticação**: login por CNPJ + senha. O frontend usa token Bearer gerado pelo Sanctum.

## Funcionalidades

- Registro de clientes com criação de `Client` e `User` associados.
- Login utilizando os 4 primeiros dígitos do CNPJ do cliente.
- Pagina de portal com painel de métricas de documentos, relatórios, imagens e visitas.
- API protegida com `auth:sanctum`.
- Endpoints para clientes, documentos, relatórios, imagens, notificações e histórico.

## Instalação

### Backend

```bash
cd /home/danilo/laravel/example-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder
```

### Frontend

```bash
cd /home/danilo/laravel/example-app/frontend
npm install
```

## Variáveis de ambiente

- `APP_URL` deve apontar para o servidor Laravel local, por exemplo `http://127.0.0.1:8002`.
- `NEXT_PUBLIC_API_URL` pode ser configurado para `http://127.0.0.1:8002` para garantir que o frontend consuma o backend correto.

Se não estiver definido, o frontend usa `http://127.0.0.1:8002` como padrão.

## Como executar

### Opcional: rodar backend e frontend separados

```bash
cd /home/danilo/laravel/example-app
php artisan serve --host=127.0.0.1 --port=8002
```

```bash
cd /home/danilo/laravel/example-app/frontend
npm run dev
```

### Rodar ambiente completo

```bash
cd /home/danilo/laravel/example-app
composer run dev
```

> O frontend deve iniciar em `http://localhost:3000` ou em outra porta disponível, como `3001`.

## Endpoints principais

### Autenticação

- `POST /api/auth/login`
- `POST /api/auth/register`
- `GET /api/auth/me`
- `POST /api/auth/logout`
- `POST /api/auth/change-password`

### Dashboard

- `GET /api/dashboard/client`
- `GET /api/dashboard/admin`

### Clientes e recursos

- `GET /api/clients`
- `GET /api/clients/{client}`
- `GET /api/documents`
- `POST /api/documents`
- `GET /api/reports`
- `GET /api/images`
- `GET /api/notifications`

## Credenciais de teste

O seeder já cria clientes e usuários de teste. Use um desses pares para login:

- `1234` / `password` (CNPJ: `12.345.678/0001-99`)
- `1111` / `password` (CNPJ: `11.111.111/0001-11`)
- `2222` / `password` (CNPJ: `22.222.222/0001-22`)

No frontend, informe apenas os 4 primeiros dígitos do CNPJ no campo de login.

## Observações

- O Laravel foi configurado para redirecionar a raiz `/` para o frontend.
- A aplicação usa migrations para criar as tabelas de `personal_access_tokens` e `notifications` necessárias para autenticação e dashboard.
- Arquivos de build e dependências do frontend não devem ser versionados. Use `npm install` localmente para gerar `node_modules`.

## Deploy

Para deploy, mantenha o backend e o frontend separados. O backend expõe a API e o frontend consome os endpoints via `NEXT_PUBLIC_API_URL`.

## Licença

Projeto sob licença MIT.
