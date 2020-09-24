
<style>
.destaque1 {
  border:1px solid #e9ecef!important;
  background:#fffcf5;
  border-left:0!important;
  border-right:0!important;
  padding-top:10px;
}


.imagem-perfil {
		width:30px;
	    height:30px;
	    object-fit:cover;
	    object-position:center;
	    border-radius:50%;
	}
	@media only screen and (min-width: 600px) {
	  #salvar-venda {
	  	margin-top:25px;
	  }
	}
	.card-two {
		margin-top:10px;
		border-radius:3px;
		box-shadow:none;
		border:1px solid #dddddd;
		padding-left:3px;
		padding-right:3px;
	}
	.tabela-ajustada tr td {
		padding-top:2px!important;
		padding-bottom:2px!important;
		font-size:12px;
	}
	.tabela-ajustada th {
		font-size:13px!important;

	}
    .card-produtos {
     	margin-top:10px;
        border-left:1px solid #dddddd;
     	padding:0;
     	float:left;
     }
     .card-produtos img:hover {
     	cursor:pointer;
     	border:2px solid #7fe3ca;
     	filter: brightness(95%);
    }
     .card-produtos img:active {
     	cursor:pointer;
     	border:1px solid #7fe3ca;
     	box-shadow:silver 1px 1px 3px;
    }
	.card-produtos img {
		width:100px;
	    height:100px;
	    object-fit:cover;
	    object-position:center;
	    margin:0 auto;
	    display:block;
	    border-radius:50%;
	    border:1px solid gray;
	    padding:3px;
	    background:white;
	}
	.produto-titulo {
		font-size:11px!important;
		text-align:center;
		display:block;
		margin-top:3px;
	}
	.produto-valor {
		font-size:13px!important;
		text-align:center;
		font-weight:bold;
	}
	.div-inter-produtos {
		background:#f4f3ef;
	}
	.img-produto-seleionado {
		width:30px;
	    height:30px;
	    object-fit:cover;
	    object-position:center;
	    border-radius:50%;
	    border:1px solid #dee2e6;
	}
	.campo-quantidade {
		border:1px solid #dee2e6;
		width:50px;
		text-align:center;
    margin-left:3px;
    margin-right:3px;
	}
  .controle-quantidade {
    padding:3px;
    background:#dddddd;
    width:20px;
    height:20px;
    cursor:pointer;
    text-align:center;
    border:1px solid #cfcece!important;
  }
	.div-inter-produtos {
		overflow-y: scroll;
		height:160px;
		padding-bottom:10px;
	}
	.div-inter-produtos::-webkit-scrollbar-track {
        background-color:white;
    }
    .div-inter-produtos::-webkit-scrollbar {
        width: 3px;
        background:#f0f4f7;
    }
    .div-inter-produtos::-webkit-scrollbar-thumb {
        background:#d0d9e1;
    }
    .div-inter-produtos::-webkit-input-placeholder {
        color: #8198ac;
    }
    .table-produtos {
      border:1px solid #6bd098!important;
      border-left:0!important;
      border-right:0!important
    }
</style>
<form>
  <!-- token de segurança -->
  <input type="hidden" name="_token" value="<?php echo TOKEN; ?>" />

  <div class="row">

    <?php if (isset($pedido->id)) : ?>
      <input type="hidden" name="id" value="<?php echo $pedido->id; ?>">
    <?php endif; ?>

    <div class="col-md-4">
      <div class="form-group">
        <label for=id_vendedor">Vendedor *</label>
        <select class="form-control" name="id_vendedor" id="id_vendedor" disabled>
          <option value="<?php echo $usuario->id;?>"><?php echo $usuario->nome;?></option>
        </select>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label for="id_cliente">Clientes *</label>
        <select class="form-control" name="id_cliente" id="id_cliente"
        onchange="enderecoPorIdCliente(this.value);">
          <option value="selecione">Selecione</option>
          <?php foreach ($clientes as $cliente):?>
            <?php if ($cliente->id == $pedido->id_cliente):?>
              <option value="<?php echo $cliente->id; ?>" selected="selected">
                <?php echo $cliente->nome; ?>
              </option>
            <?php else:?>
              <option value="<?php echo $cliente->id; ?>">
                <?php echo $cliente->nome; ?>
              </option>
            <?php endif;?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

     <div class="col-md-4">
      <div class="form-group">
        <label for="id_cliente_endereco">Endereços *</label>
        <select class="form-control" name="id_cliente_endereco" id="id_cliente_endereco">
          <option value="selecione">Selecione</option>

        </select>
      </div>
    </div>

    <div class="col-md-4 destaque1">
      <div class="form-group">
        <label for="id_produto">Produtos *</label>
        <select class="form-control" name="id_produto" id="id_produto">
          <option value="selecione">Selecione</option>
          <?php foreach ($produtos as $produto):?>
            <option value="<?php echo $produto->id; ?>">
              <?php echo $produto->nome; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="col-md-4 destaque1">
      <div class="form-group">
        <label for="quantidade">Quantidade *</label>
        <input type="text" class="form-control" name="quantidade" id="quantidade" value="1">
      </div>
    </div>

    <div class="col-md-4 destaque1">
      <div class="form-group">
        <a class="btn btn-success" style="margin-top:30px"
        onclick="return adicionarProduto($('#id_produto').val(), $('#quantidade').val())">
          <i class="fas fa-plus"></i> Adicionar
        </a>
      </div>
    </div>

  </div>
  <!--end row-->

  <div class="row">
    <div class="col-md-12 table-produtos">
       <table class="table table tabela-ajustada tabela-de-produto table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Produto</th>
              <th>Qtd</th>
              <th>Total</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
       </table>
    </div>
  </div>
  <!--end row-->

  <br>

  <div class="row">
  <div class="col-md-3">
      <div class="form-group">
        <label for="id_meio_pagamento">Forma Pagamento *</label>
        <select class="form-control" name="id_meio_pagamento" id="id_meio_pagamento">
          <option value="selecione">Selecione</option>
          <?php foreach ($meiosPagamentos as $meiosPagamento):?>
            <?php if ($pedido->id_meio_pagamento == $meiosPagamento->id):?>
              <option value="<?php echo $meiosPagamento->id; ?>" selected="selected">
                <?php echo $meiosPagamento->legenda; ?>
              </option>
            <?php else:?>
              <option value="<?php echo $meiosPagamento->id; ?>">
                <?php echo $meiosPagamento->legenda; ?>
              </option>
            <?php endif;?>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="valor_desconto">R$ Desconto</label>
        <input type="text" class="form-control campo-moeda" name="valor_desconto" id="valor_desconto" placeholder="Desconto..."
        value="<?php if (isset($pedido->id) && $pedido->valor_desconto != null):?><?php echo real($pedido->valor_desconto);?><?php endif;?>">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="valor_frete">R$ Frete</label>
        <input type="text" class="form-control campo-moeda" name="valor_frete" id="valor_frete" placeholder="Frete..."
        value="<?php if (isset($pedido->id) && $pedido->valor_frete != null):?><?php echo real($pedido->valor_frete);?><?php endif;?>">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="previsao_entrega">Previsão de entrega</label>
        <input type="date" class="form-control" name="previsao_entrega" id="previsao_entrega"
        value="<?php if (isset($pedido->id) && $pedido->previsao_entrega != null):?><?php echo $pedido->previsao_entrega;?><?php endif;?>">
      </div>
    </div>
  </div>
  <!--end row-->
  <br>
  <br>
  <div class="row">
    <div class="col-md-12">

      <span id="total-geral" style="float:right">
         <b>Total:</b> R$ 00,00
      </span>
    </div>
  </div>

  <button type="submit" class="btn btn-success btn-sm button-salvar-empresa"
  style="float:right" onclick="return savePedidos()">
    <i class="fas fa-save"></i> Salvar
  </button>

  <button type="submit" class="btn btn-warning btn-sm"
  style="float:right">
    <i class="fas fa-undo-alt"></i> Cancelar
  </button>

</form>

<script>
  $(function() {
    jQuery('.campo-moeda')
    .maskMoney({
      prefix:'R$ ',
      allowNegative: false,
      thousands:'.', decimal:',',
      affixesStay: false
    });
  });

  produtosAdicionados();
  obterValorTotalDoPedido();

  function enderecoPorIdCliente(idCliente, idClienteEnderecoPedido = false) {
    var rota = getDomain()+"/pedido/enderecoPorIdCliente/"+idCliente;
    $('#id_cliente_endereco').html("<option>Carregando...</option>");

    $.get(rota, function(data, status) {
      var enderecos = JSON.parse(data);
      var options = false;

      if (enderecos.length != 0) {
        $('#id_cliente_endereco').empty();

        $.each(enderecos, function(index, value) {
          if (idClienteEnderecoPedido && idClienteEnderecoPedido == value.id) {
            options += "<option value='"+value.id+"' selected='selected'>"+value.endereco+"</option>";
          } else {
            options += "<option value='"+value.id+"'>"+value.endereco+"</option>";
          }
        });

        $('#id_cliente_endereco').append(options);
      } else {
        $('#id_cliente_endereco').html("<option value='selecione'>Não encontrado</option>");
      }
    });
  }

  function adicionarProduto(idProduto, quantidade) {
    var rota = getDomain()+"/pedido/adicionarProduto/"+idProduto+"/"+quantidade;
    $.get(rota, function(data, status) {
      obterOultimoProdutoAdicionado();

    });

    return false;
  }

  function obterOultimoProdutoAdicionado() {
    var rota = getDomain()+"/pedido/obterOultimoProdutoAdicionado";

    $.get(rota, function(data, status) {
      var produto = JSON.parse(data);
      var t = "";

      if (produto.length != 0) {
        t += "<tr id='id-tr-"+produto.id+"' data-produto-id="+produto.id+">";
        t += "<td>"+'<img class="img-produto-seleionado" src="'+getDomain()+'/'+produto.imagem+'">'+"</td>";
        t += "<td>"+produto.produto+"</td>";
        t += "<td>"+'<a class="controle-quantidade">-</a><input type="number" class="campo-quantidade" value="'+produto.quantidade+'" id="campo-quantidade'+produto.id+'" onchange="alterarAquantidadeDeUmProduto('+produto.id+', $(this).val())"><a class="controle-quantidade" onclick="incrementarQuantidadeDoProduto('+produto.id+')">+</a>'+"</td>";
        t += "<td class='total-cada-produto' data-valor-produto="+produto.total+" data-produto-id="+produto.id+">"+real(produto.total)+"</td>";
        t += "<td>"+'<a class="btn-sm btn-link" onclick="retirarProduto('+produto.id+', $(this))"><i class="fas fa-times" style="color:#cc0000;font-size:18px"></i></a>'+"</td>";
        t += "</tr>";
      }

      $(".tabela-de-produto tbody").append(t);
      obterValorTotalDoPedido();

    });

    return false;
  }

  function produtosAdicionados() {
    var rota = getDomain()+"/pedido/produtosAdicionados";

    $.get(rota, function(data, status) {
      var produtos = JSON.parse(data);
      var t = "";

      if (produtos.length != 0) {
        $.each(produtos, function(index, produto) {
          t += "<tr id='id-tr-"+produto.id+"' data-produto-id="+produto.id+">";
          t += "<td>"+'<img class="img-produto-seleionado" src="'+getDomain()+'/'+produto.imagem+'">'+"</td>";
          t += "<td>"+produto.produto+"</td>";
          t += "<td>"+'<a class="controle-quantidade">-</a><input type="number" class="campo-quantidade" value="'+produto.quantidade+'" id="campo-quantidade'+produto.id+'" onchange="alterarAquantidadeDeUmProduto('+produto.id+', $(this).val())"><a class="controle-quantidade" onclick="incrementarQuantidadeDoProduto('+produto.id+')">+</a>'+"</td>";
          t += "<td class='total-cada-produto' data-valor-produto="+produto.total+" data-produto-id="+produto.id+">"+real(produto.total)+"</td>";
          t += "<td>"+'<a class="btn-sm btn-link" onclick="retirarProduto('+produto.id+', $(this))"><i class="fas fa-times" style="color:#cc0000;font-size:18px"></i></a>'+"</td>";
          t += "</tr>";
        });
      }

      $(".tabela-de-produto tbody").append(t);
      obterValorTotalDoPedido();

    });

    return false;
  }



  /*function incrementarQuantidadeDoProduto(idProduto) {
    var campoQuantidade = $("#campo-quantidade"+idProduto);

    // Incrementa o campo quantidade
    campoQuantidade.val(Number(campoQuantidade.val())+1);

    var rota = getDomain()+"/pedido/obterAQuantidadeDoProdutoNoPedido/"+idProduto;
    $.get(rota, function(data, status) {
      var produto = JSON.parse(data);
      var valorIncrementado = valorTotalDoPedido += Number(produto.preco);
      $("#total-geral").html(real(valorIncrementado));
    });
  }*/

  function savePedidos() {
    <?php if (isset($pedido->id)):?>
      var rota = getDomain()+"/pedido/update";
    <?php else:?>
      var rota = getDomain()+"/pedido/save";
    <?php endif;?>

    $.post(rota, {
      '_token': '<?php echo TOKEN; ?>',
      'id_vendedor': $("#id_vendedor").val(),
      'id_cliente': $("#id_cliente").val(),
      'id_cliente_endereco': $("#id_cliente_endereco").val(),
      'id_meio_pagamento': $("#id_meio_pagamento").val(),
      'valor_frete': $("#valor_frete").val(),
      'valor_desconto': $("#valor_desconto").val(),
      'previsao_entrega': $("#previsao_entrega").val(),
      <?php if (isset($pedido->id)):?>
      'id_pedido': '<?php echo $pedido->id;?>'
      <?php endif;?>
      }, function(resultado) {
        var retorno = JSON.parse(resultado);
        if (retorno.status == true) {
          location.reload();
        }

        console.log(resultado);
    })

    return false;
  }

  function retirarProduto(idProduto, elemento) {
    <?php if (isset($pedido->id)):?>
      var rota = getDomain()+"/pedido/retirarProduto/"+idProduto+"/<?php echo $pedido->id;?>";
    <?php else:?>
      var rota = getDomain()+"/pedido/retirarProduto/"+idProduto;
    <?php endif;?>
    $.get(rota, function(data, status) {
      elemento.parent().parent().fadeOut(400, function() {
        $(this).remove();
        obterValorTotalDoPedido();
      })
    });

    return false;
  }

  /*Acrescenta ou decrementa a quantidade de um produto*/
  function alterarAquantidadeDeUmProduto(idProduto, quantidade) {
    quantidade = Number(quantidade);

    if (quantidade <= 0) {
      $(".campo-quantidade").val(1);
    }

    if (quantidade > 0 && quantidade != '') {
      //modalValidacao('Aplicando', "<button class='btn btn-sm' data-dismiss='modal'>Fechar</button>");

      var rota = getDomain()+"/pedido/alterarAquantidadeDeUmProduto/"+idProduto+"/"+quantidade;
      $.get(rota, function(data, status) {

        if (status == 'success') {
          $(".tabela-de-produto tbody").empty();
          produtosAdicionados();
          obterValorTotalDoPedido();
        }

      });
    }
  }

  function obterValorTotalDoPedido() {
    var rota = getDomain()+"/pedido/obterValorTotalDoPedido";
    $.get(rota, function(data, status) {
      var total = JSON.parse(data);
      $("#total-geral").html("<b>Total:</b> " + real(total.total));
    });
  }

  /*Quando existe id_cliente_endereco, significa que é o usuário está na modal para editar os dados dos pedidos
  Então, chama os endereços do cliente do pedido com o intuito de colocar no campo select o endereço escolhido anteriormenter
  */
  <?php if (isset($pedido->id_cliente_endereco)):?>
    enderecoPorIdCliente($("#id_cliente").val(), "<?php echo $idClienteEnderecoPedido->id;?>");
  <?php endif;?>
</script>
