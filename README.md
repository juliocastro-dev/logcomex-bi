# LOGCOMEX BI

Foi desenvolvido um sitema de BI utilizando as tecnologias solicitadas no teste:

- Laravel PHP
- Vuejs 3
- OAuth 2.0
- Docker

## Instruções de instalação do sistema

É válido ressaltar que foi utilizado o Laravel Sail para trabalharmos com dockerização do ambiente.

### 1º Passo - montar os containers

Para montar os conteires dê o seguinte comando:

~~~bash
./vendor/bin/sail up -d
~~~

### 2º Passo

Acesse o conteiner do sistema

~~~bash
./vendor/bin/sail exec -it laravel.test bash
~~~

E agora dentro do conteiner execute o seguinte comando para que as tabelas sejam criadas e já populadas.

~~~bash
php artisan migrate --seed
~~~

### 3º Passo

Ainda dentro do conteiner execute o seguinte comando

~~~bash
yarn install && yarn dev
~~~

Com esse comando será instalado as dependencias do projeto e também inicia-lo.

** Obs: o terminal que se iniciou o serviço deve permanecer aberto executando o mesmo.

O sistema estará disponível na seguinte url 

<http://localhost>

### Usuários de acesso

**Email:** <teste1@email.com>

**Password:** 12345678
