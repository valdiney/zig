# ZigMoney
🚧 Projeto em desenvolvimento e recebendo commit todos os dias! ✊

# Descrição
<p>
O ZigMoney é um projeto que visa ajudar pequenos comércios que precisam registrar suas vendas diárias de forma simples e organizada. Trata-se de um sistema web escrito em PHP e Mysql. <br>
O intuito é disponibilizar uma plataforma com módulos que facilite e potencialize o controle de informações de vendas totalmente online. 
</p>

<p>
  Achou o projeto legal e gostaria de fazer uma doação? <a href="https://pag.ae/7W6_WBpg2" target="_blank">
  <b>Clique aqui! A sua ajuda é bem vinda!</b></a> 
</p>

# Persona do Projeto
<p>
A Lucia tem um pequeno comercio e luta bravamente para mantê-lo! Porém, a Lucia tem problemas em registrar suas vendas! Já usou papel, planilhas e até mesmo outros sistemas complicados! Será que nós da ZigMoney conseguiremos ajudar as varias Lucias espalhadas pelo nosso Brasil?
</p>

# Observações
1. O projeto está sendo escrito em PHP padrão MCV, não está sendo utilizado nenhum framework de mercado!  <br> 
*“Felizmente ou infelizmente”*! Porém, para quem conhece PHP e quer contribuir, o processe é bem simples! 

2. Há três certezas nessa vida! São elas: 
- [x] Todos nós iremos morrer um dia. 
- [x] Sabemos que não temos o melhor código do mundo.
- [x] A credite, sabemos que você também não! 😂


# Módulos
- [x] Login no Sistema
- [x] Cadastro de Usuários
- [x] Cadastro de Produtos
- [x] PDV Padrão 
- [x] PDV Diferencial (PDV com mais recursos)
- [x] Relatórios de vendas
- [ ] Dashboard
- [x] Cadastro de Clientes
- [ ] Pedidos
- [ ] Exportar relatórios para PDF
- [x] Exportar relatórios para Excel
- [ ] Definir tipos de perfis de Usuários

# Ponto de vendas Padrão
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/tela_de_venda.png"/>

# Ponto de vendas Diferencial
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/tela_de_venda_diferencial.png"/>

# Tela de Relatório de vendas por período
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/tela_de_relatorio_por_periodo.png"/>

# Instalação 
<p>
  Você deve criar um arquivo chamado .env na raiz da aplicação! Coloque esses valores dentro do arquivo e salve!
  Dentro desse arquivo também deve ser colocado as credenciais de acesso ao banco de dados.
</p>

```TEXT
  APP_ENV=local
  TIMEZONE=America/Sao_Paulo
  HTTPS=false

  DB_CONNECTION=mysql
  HOST_NAME=
  HOST_USERNAME=
  HOST_PASSWORD=
  HOST_DBNAME=syst
```

Tenha o composer instalado em sua máquina! Entre na pasta do projeto via linha de comando e execute
o comando para baixar as dependências do projeto!

```TEXT
composer install
```

Depois, rode o servidor php

```TEXT
php -S localhost:8000
```

# Usuário de teste
Email: admin@admin.com <br>
Password: 33473347
