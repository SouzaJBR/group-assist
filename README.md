# group-assist
Ferramenta para gerencimento de grupos de alunos desenvolvido para a disciplina de Teste de Software

[![Build Status](https://travis-ci.org/capybara-team/group-assist-api.svg?branch=develop)](https://travis-ci.org/capybara-team/group-assist-api)

## Desenvolvimento

1. Clonar o repositório

```sh
  git clone https://github.com/SouzaJBR/group-assist && cd group-assist
 ```
 
 2. Instalar as dependências do projeto
 ```sh
  composer install
 ```
 
 3. Configurar a aplicação
 ```sh
  cp .env.example .env
  php artisan key:generate
  php artisan jwt:secret
 ```
 Caso seja necessário edite o arquivo `.env` para configurar os dados de banco de dados e etc.
 E após crie o banco de dados:

```sh
   php artisan migrate --seed
```  
 ## Executando o servidor
 Para executar o servidor de desenvolvimento digite no terminal
 ```sh
  php artisan serve
 ```
 Ele será executado na porta 8000 na máquina local

