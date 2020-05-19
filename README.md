# ZigMoney
Projeto em desenvolvimento!
<p>
O ZigMoney é um projeto que visa ajudar pequenos comércios que precisam registrar suas vendas diárias de forma simples e organizada. Trata-se de um sistema web escrito em PHP e Mysql. 
</p>

<p>
O intuito é disponibilizar uma plataforma com módulos que facilite e potencialize o controle de informações de vendas totalmente online e sem perda de tempo em planilhas eletrônicas. 
</p>

# Módulos
- [x] Criação de Usuários
- [x] Login
- [x] Tela de vendas
- [ ] Dashboard
- [x] Relatórios de vendas

# Tela de Vendas
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/tela_de_venda.png"/>

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
