# Teste DevOps - Ambiente PHP + Nginx com Docker

Resolução teste técnico proposto que consiste em 

- Implantar uma aplicação PHP com Nginx e PHP-FPM
- Utilizar MySQL como banco de dados
- Gerenciar toda a infraestrutura usando Docker e Docker Compose
- Garantir a persistência de dados no banco de dados

## Tecnologias e Versões Utilizadas

| Tecnologia     | Versão           |
|----------------|------------------|
| Docker         | 28.2.2           |
| Docker Compose | v2.36.2          |
| Nginx          | latest 1.29      |
| PHP-FPM        | 8.1              |
| MySQL          | 8.0              |
| SO Host        | Ubuntu 24.04 LTS |

## Resolução exercício 1

Para funcionar em meu ambiente local tenho preferencia em usar o Linux Ubuntu para rodar o docker engine

Para essa primeira parte fiz a criação manual de um container usando Nginx e outro com o PHP-FPM com um arquivo simples index.php para exibir Olá mundo usando uma estrutura simples

- Criação do arquivo default.conf para definir qual porta escutar, onde estão os arquivos do site, como tratar arquivos PHP via PHP-FPM

- docker network create nginx-php
Cria a rede que usamos para comunicar os containers

- docker run -d --name nginx --network nginx-php -p 80:80 -v $PWD:/var/www/html -v $PWD/default.conf:/etc/nginx/conf.d/default.conf nginx
Cria o container nginx, mapeia a rede a porta e o volume

- docker run -d --name php --network nginx-php -v $PWD:/var/www/html php:8.1-fpm
Cria o container php, mapeia a rede e o volume

com isso é possivel pesquisar nosso local host no navegador e exibir Olá Mundo.
![execucao_ola_mundo_local](/home/renan/teste-sci/img/ola-mundo.png)

## Resolução exercício 2