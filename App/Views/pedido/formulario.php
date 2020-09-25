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

    .componente-produto-pedido {
      display:none;

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
        <a class="btn btn-success" style="margin-top:18px"
        onclick="return salvarPrimeiroPasso()" id="salvar-endereco">
          <i class="fas fa-save"></i> Próximo
        </a>
      </div>
    </div>



    <div class="col-md-4 destaque1 componente-produto-pedido">
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

    <div class="col-md-4 destaque1 componente-produto-pedido">
        <div class="form-group">
          <label for="quantidade">Quantidade *</label>
          <input type="text" class="form-control" name="quantidade" id="quantidade" value="1">
        </div>
      </div>

      <div class="col-md-4 destaque1 componente-produto-pedido">
        <div class="form-group">
          <a class="btn btn-success" style="margin-top:30px"
          onclick="return adicionarProduto($('#id_produto').val(), $('#quantidade').val())">
            <i class="fas fa-plus"></i> Adicionar
          </a>
        </div>
      </div>

    </div><!--end row-->

    <div class="row componente-produto-pedido">
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

      <div class="col-md-3 componente-produto-pedido">
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

      <div class="col-md-3 componente-produto-pedido">
        <div class="form-group">
          <label for="valor_desconto">R$ Desconto</label>
          <input type="text" class="form-control campo-moeda" name="valor_desconto" id="valor_desconto" placeholder="Desconto..."
          value="<?php if (isset($pedido->id) && $pedido->valor_desconto != null):?><?php echo real($pedido->valor_desconto);?><?php endif;?>">
        </div>
      </div>

      <div class="col-md-3 componente-produto-pedido">
        <div class="form-group">
          <label for="valor_frete">R$ Frete</label>
          <input type="text" class="form-control campo-moeda" name="valor_frete" id="valor_frete" placeholder="Frete..."
          value="<?php if (isset($pedido->id) && $pedido->valor_frete != null):?><?php echo real($pedido->valor_frete);?><?php endif;?>">
        </div>
      </div>

      <div class="col-md-3 componente-produto-pedido">
        <div class="form-group">
          <label for="previsao_entrega">Previsão de entrega</label>
          <input type="date" class="form-control" name="previsao_entrega" id="previsao_entrega"
          value="<?php if (isset($pedido->id) && $pedido->previsao_entrega != null):?><?php echo $pedido->previsao_entrega;?><?php endif;?>">
        </div>
      </div>




    </div><!--end row-->

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

var idPedido = false;

function enderecoPorIdCliente(idCliente, idClienteEnderecoPedido = false) {
    var rota = getDomain()+"/pedido/enderecoPorIdCliente/"+idCliente;
    $('#id_cliente_endereco').html("<option>Carregando...</option>");

    $.get(rota, function(data, status) {
      var enderecos = JSON.parse(data);
      var options = false;

      if (enderecos.length != 0) {
        $('#id_cliente_endereco').empty();

        $('#id_cliente_endereco').html("<option value='selecione'>Selecione</option>");

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

  /*Salva Vendedor, Cliente e Endereço*/
  function salvarPrimeiroPasso() {
    var rota = getDomain()+"/pedido/salvarPrimeiroPasso";

    $.post(rota, {
      '_token': '<?php echo TOKEN; ?>',
      'id_cliente': $("#id_cliente").val(),
      'id_cliente_endereco': $("#id_cliente_endereco").val(),

      }, function(resultado) {
        var retorno = JSON.parse(resultado);
        if (retorno.status == true) {
          $(".componente-produto-pedido").show();
          $("#salvar-endereco").html('<i class="fas fa-save"></i> Salvar');
          idPedido = retorno.id_pedido;
        }

        console.log(resultado);
    })

    return false;
  }
</script>
