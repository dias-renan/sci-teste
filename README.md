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

Para essa primeira parte fiz a criação manual de um container usando Nginx e outro com o PHP-FPM com um arquivo simples index.php para exibir "Olá mundo" usando uma estrutura simples \

- Criação do arquivo default.conf para definir qual porta escutar, onde estão os arquivos do site, como tratar arquivos PHP via PHP-FPM

- docker network create nginx-php \
Cria a rede que usamos para comunicar os containers

- docker run -d --name nginx --network nginx-php -p 80:80 -v $PWD:/var/www/html -v $PWD/default.conf:/etc/nginx/conf.d/default.conf nginx \
Cria o container nginx, mapeia a rede a porta e o volume

- docker run -d --name php --network nginx-php -v $PWD:/var/www/html php:8.1-fpm \
Cria o container php, mapeia a rede e o volume 

com isso é possivel pesquisar nosso local host no navegador e exibir Olá Mundo. \
![execucao_ola_mundo_local](/sci-teste/img/ola-mundo.png)

## Resolução exercício 2

Foi criado uma instancia EC2 t2.micro para usar o free tier usando Ubuntu
Como medida de segurança foi deixado apenas a porta 80 liberada através de um security group nomeado como SG-web lembrando que em caso de uso http precisária também deixar a porta 443 liberada

- Feito a instalação do docker e clonado o repositorio para a instancia

- Mantive a mesma estrutura de arquivos e fiz a criação do arquivo docker-compose.yml para criar os containers de maneira automatizada e para facilitar a criação do container do php usei um dockerfile para subir com todas as ferramentas necessárias. Também criei um entrypoint para garantir que o banco esteja up antes de executar o processo padrão do PHP-FPM que será usado ao criar o container com mysql

- A criação do container com o Mysql também é feita com o compose e usei um volume para garantir a persistencia dos dados caso o container seja reniciado/recriado mysql_data:/var/lib/mysql. Também adicionado o restart always para caso parar o docker tente reinicia-lo novamente. O conteúdo do index.php também foi alterado para se conectar ao banco que quando subir o Mysql pela primeira vez ele deve criar:
    - Um banco de dados 
    - Um usuário com permissões nesse banco
    - A senha do root

- Agora ao pesquisar pelo ip da EC2 no navegador e possivel visualizar a mensagem "Conectado ao banco de dados com sucesso!" confirmando a conexão com o banco

### Observação com relação a segurança:
Para ter uma infraestrutura melhor deveriamos criar uma VPC personalida a adaptar ao nosso uso separando-a em redes publicas e privadas deixando as instancias que a aplicação roda na rede privada porém acarretaria em custos pois seria necessário a utilização de NAT gateway e o uso de um Elastic IP