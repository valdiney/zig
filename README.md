# ZigMoney
Relatório de vendas simples, rápido e acessível! 

# Descrição
<p>
O ZigMoney é um projeto que visa ajudar pequenos comércios e comerciantes que precisam registrar suas vendas diárias de forma simples e organizada. Trata-se de um sistema web escrito em PHP e Mysql. 
O intuito é disponibilizar uma plataforma com módulos que facilite e potencialize o controle de informações de vendas totalmente online.
</p>

<p>
  Achou o projeto legal e gostaria de fazer uma doação? <a href="https://pag.ae/7W6_WBpg2" target="_blank">
  <b>Clique aqui! A sua ajuda é bem vinda!</b></a> <br>
  Nos acompanhe no <a href="https://twitter.com/ZigMoneyProjeto">Twitter</a> <br>
  🚧 Projeto em desenvolvimento e recebendo commit todos os dias! ✊ 
</p>

# Persona do Projeto
<p>
A Lucia tem um pequeno comercio e luta bravamente para mantê-lo! Porém, a Lucia tem problemas em registrar suas vendas! Já usou papel, planilhas e até mesmo outros sistemas complicados! Será que nós da ZigMoney conseguiremos ajudar as varias Lucias espalhadas pelo nosso Brasil? Este é o nosso real foco e faremos o possível para alcançá-lo! Que tal nos ajudar nesta empreitada? 
</p>

# Módulos
- [x] Login no Sistema e Recuperação de Senha
- [x] Cadastro de Usuários
- [x] Cadastro de Produtos
- [x] Cadastro de Clientes
- [x] PDV Padrão
- [x] PDV Diferencial (PDV com mais recursos)
- [x] Relatórios de vendas
- [x] Dashboard
- [ ] Pedidos
- [x] Exportar relatórios para PDF
- [x] Exportar relatórios para Excel
- [x] Logs de Acessos

# Tela de Login
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/login.png"/>

# Ponto de vendas Padrão
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/tela_de_venda.png"/>

# Ponto de vendas Diferencial
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/tela_de_venda_diferencial.png"/>

# Tela de Relatório de vendas por período
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/tela_de_relatorio_por_periodo.png"/>

# Dashboard ainda em construção
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/dashboard.png"/>

# Tela de pedidos ainda em construção
<img src="https://raw.githubusercontent.com/valdiney/zig/master/prints/pedido.png"/>

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
  
  MAIL_DRIVER=smtp
  MAIL_HOST=
  MAIL_PORT=587
  MAIL_USERNAME=
  MAIL_PASSWORD=
  MAIL_ENCRYPTION=tls

```

Tenha o composer instalado em sua máquina! Entre na pasta do projeto via linha de comando e execute
o comando para baixar as dependências do projeto!

```TEXT
composer install
```

#### Configuração do banco de dados

> Crie o banco de dados \
> Edite o arquivo .env na raiz do projeto \
> Dê o seguinte comando para migrar a base de dados

```bin
php command migrate
```

**AVISO**: Não se esqueça de rodar o comando para criar uma nova migration todas as vezes que alterar o banco:

```bin
php command create migration [descreva as mudanças]
```

Entre no diretório que será exibido no console, ou vá até o último arquivo do diretório ´./dump/migrations/´.

Caso se trate de uma nova tabela você deverá buscar pelo `sql` da criação da tabela.  No `phpmyadmin`, por exemplo, você deve abrir a tabela > Export > dump all rows (caso só precise da estrutura e não dos dados) > Go. Salve o conteúdo dentro da migration que acabou de criar. Quando der a opção de salvar, vá até o diretório onde estão as migrations > duplo clique no arquivo > substituir e pronto!

Caso se trate de uma nova coluna ou edição de uma existente, você verá que logo após a edição o `phpmyadmin` exibirá o comando executado, como o exemplo:

```sql
ALTER TABLE `clientes` CHANGE `telefone` `telefone4` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
```

Cole este valor dentro da migration que acabou de criar e pronto!

#### Execute o projeto

Depois, rode o servidor php

```TEXT
php -S localhost:8000
```

# Usuário de teste
Email: admin@admin.com <br>
Password: 33473347
