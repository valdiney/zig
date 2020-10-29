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
      /*display:none;*/

    }

    .aba {
      display:none;
    }
</style>


<div class="row">
    <div class="col-md-4">
      <button class="btn btn-sucess" id="open-1" onclick="abas('aba1')">Selecionar Cliente</button>
    </div>
    <div class="col-md-4" id="open-2" onclick="abas('aba2')">
      <button class="btn btn-sucess">Incluir Produtos</button>
    </div>
    <div class="col-md-4" id="open-3" onclick="abas('aba3')">
      <button class="btn btn-sucess">Finalizar Pedido</button>
    </div>
</div>

<div class="row">
  <?php require_once('abaCliente.php');?>
  <?php require_once('abaIncluirProduto.php');?>
</div>





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

function abas(aba) {
  $(".aba").hide();
  $("#"+aba).show();
}

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
    })

    return false;
  }

  function adicionarProduto(idProduto, quantidade) {
    var rota = getDomain()+"/pedido/adicionarProduto";
    $.post(rota, {
      '_token': '<?php echo TOKEN; ?>',
      'id_pedido': idPedido,
      'id_produto': idProduto,
      'quantidade': quantidade

      }, function(resultado) {
        var retorno = JSON.parse(resultado);
       // if (retorno.status == true) {
          //$(".componente-produto-pedido").show();
          //$("#salvar-endereco").html('<i class="fas fa-save"></i> Salvar');
          //idPedido = retorno.id_pedido;
        //}

        //alert(retorno.produto[0].idProdutoPedido);
        var produto = retorno.produto[0];
        var t = "";

          t += "<tr id='id-tr-"+produto.idProduto+"' data-produto-id="+produto.idProduto+">";
          t += "<td>"+'<img class="img-produto-seleionado" src="'+getDomain()+'/'+produto.imagem+'">'+"</td>";
          t += "<td>"+produto.produto+"</td>";
          t += "<td>"+'<a class="controle-quantidade">-</a><input type="number" class="campo-quantidade" value="'+produto.quantidade+'" id="campo-quantidade'+produto.idProdutoPedido+'" onchange="alterarAquantidadeDeUmProduto('+produto.idProdutoPedido+', $(this).val())"><a class="controle-quantidade" onclick="incrementarQuantidadeDoProduto('+produto.idProdutoPedido+')">+</a>'+"</td>";
          t += "<td class='total-cada-produto' data-valor-produto="+produto.total+" data-produto-id="+produto.id+">"+real(produto.total)+"</td>";
          t += "<td>"+'<a class="btn-sm btn-link" onclick="retirarProduto('+produto.idProdutoPedido+', $(this))"><i class="fas fa-times" style="color:#cc0000;font-size:18px"></i></a>'+"</td>";
          t += "</tr>";


        $(".tabela-de-produto tbody").append(t);
    })

    return false;


  }
</script>
