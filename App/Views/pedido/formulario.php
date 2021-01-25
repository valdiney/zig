<style>
    .destaque1 {
        border: 1px solid #e9ecef !important;
        background: #fffcf5;
        border-left: 0 !important;
        border-right: 0 !important;
        padding-top: 10px;
    }

    .imagem-perfil {
        width: 30px;
        height: 30px;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
    }

    @media only screen and (min-width: 600px) {
        #salvar-venda {
            margin-top: 25px;
        }
    }

    .card-two {
        margin-top: 10px;
        border-radius: 3px;
        box-shadow: none;
        border: 1px solid #dddddd;
        padding-left: 3px;
        padding-right: 3px;
    }

    .tabela-ajustada tr td {
        padding-top: 2px !important;
        padding-bottom: 2px !important;
        font-size: 12px;
    }

    .tabela-ajustada th {
        font-size: 13px !important;
    }

    .card-produtos {
        margin-top: 10px;
        border-left: 1px solid #dddddd;
        padding: 0;
        float: left;
    }

    .card-produtos img:hover {
        cursor: pointer;
        border: 2px solid #7fe3ca;
        filter: brightness(95%);
    }

    .card-produtos img:active {
        cursor: pointer;
        border: 1px solid #7fe3ca;
        box-shadow: silver 1px 1px 3px;
    }

    .card-produtos img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        object-position: center;
        margin: 0 auto;
        display: block;
        border-radius: 50%;
        border: 1px solid gray;
        padding: 3px;
        background: white;
    }

    .produto-titulo {
        font-size: 11px !important;
        text-align: center;
        display: block;
        margin-top: 3px;
    }

    .produto-valor {
        font-size: 13px !important;
        text-align: center;
        font-weight: bold;
    }

    .div-inter-produtos {
        background: #f4f3ef;
    }

    .img-produto-seleionado {
        width: 30px;
        height: 30px;
        object-fit: cover;
        object-position: center;
        border-radius: 50%;
        border: 1px solid #dee2e6;
    }

    .campo-quantidade {
        border: 1px solid #dee2e6;
        width: 50px;
        text-align: center;
        margin-left: 3px;
        margin-right: 3px;
    }

    .controle-quantidade {
        padding: 3px;
        background: #dddddd;
        width: 20px;
        height: 20px;
        cursor: pointer;
        text-align: center;
        border: 1px solid #cfcece !important;
    }

    .div-inter-produtos {
        overflow-y: scroll;
        height: 160px;
        padding-bottom: 10px;
    }

    .div-inter-produtos::-webkit-scrollbar-track {
        background-color: white;
    }

    .div-inter-produtos::-webkit-scrollbar {
        width: 3px;
        background: #f0f4f7;
    }

    .div-inter-produtos::-webkit-scrollbar-thumb {
        background: #d0d9e1;
    }

    .div-inter-produtos::-webkit-input-placeholder {
        color: #8198ac;
    }

    .table-produtos {
        border: 1px solid #6bd098 !important;
        border-left: 0 !important;
        border-right: 0 !important
    }

    .aba {
        display: none;
    }

    .botaoAbaAtual {
        background: #009933 !important;
    }

    .row-botoes-abas .col-md-4 {
        text-align: center;
    }

    .total-geral-produtos {
        margin-top: 10px;
        float: right;
        text-align: right;
    }

    .abaActive {
        border-top: 5px solid #6bd098;
    }

    .abaDesativada {
        opacity: 0.40 !important;
    }
</style>

<div class="row row-botoes-abas">
    <div class="col-md-4">
        <button id="button-aba-1" class="btn button-aba" onclick="abas('aba1', 1)">
            <i class="fas fa-user-tie" style="font-size:20px;"></i> Cliente
        </button>
    </div>
    <div class="col-md-4">
        <button id="button-aba-2" class="btn button-aba" onclick="abas('aba2', 2)">
            <i class="fas fa-box-open" style="font-size:20px;"></i> Produtos
        </button>
    </div>
    <div class="col-md-4">
        <button id="button-aba-3" class="btn button-aba" onclick="abas('aba3', 3)">
            <i class="fas fa-people-carry" style="font-size:20px;"></i> Finalizar
        </button>
    </div>
</div>

<div class="row">
    <?php require_once('abaCliente.php'); ?>
    <?php require_once('abaIncluirProduto.php'); ?>
    <?php require_once('abaFinalizarPedido.php'); ?>
</div>

<script>
    $(function () {
        jQuery('.campo-moeda')
            .maskMoney({
                prefix: 'R$ ',
                allowNegative: false,
                thousands: '.', decimal: ',',
                affixesStay: false
            });
    });

    $("#aba1").show();
    $("#button-aba-1").addClass('abaActive');

    function abas(aba, botao) {
        $(".aba").hide();
        $("#" + aba).show();

        if (botao == 1) {
            $(".button-aba").removeClass('abaActive');
            $("#button-aba-1").addClass('abaActive');

        } else if (botao == 2) {
            $(".button-aba").removeClass('abaActive');
            $("#button-aba-2").addClass('abaActive');

        } else if (botao == 3) {
            $(".button-aba").removeClass('abaActive');
            $("#button-aba-3").addClass('abaActive');
        }
    }

    var idPedido = false;
    <?php if ($idPedido):?>
    idPedido = <?php echo $idPedido;?>
    <?php endif;?>

    if (!idPedido) {
        $("#button-aba-2").addClass('abaDesativada');
        $("#button-aba-3").addClass('abaDesativada');
        $("#button-aba-2").prop("disabled", true);
        $("#button-aba-3").prop("disabled", true);
    }

    function enderecoPorIdCliente(idCliente, idClienteEnderecoPedido = false) {
        var rota = getDomain() + "/pedido/enderecoPorIdCliente/" + idCliente;
        $('#id_cliente_endereco').html("<option>Carregando...</option>");

        $.get(rota, function (data, status) {
            var enderecos = JSON.parse(data);
            var options = false;

            if (enderecos.length != 0) {
                $('#id_cliente_endereco').empty();

                $('#id_cliente_endereco').html("<option value='selecione'>Selecione</option>");

                $.each(enderecos, function (index, value) {
                    if (idClienteEnderecoPedido && idClienteEnderecoPedido == value.id) {
                        options += "<option value='" + value.id + "' selected='selected'>" + value.endereco + "</option>";
                    } else {
                        options += "<option value='" + value.id + "'>" + value.endereco + "</option>";
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
        <?php if ($idPedido):?>
        var rota = getDomain() + "/pedido/alterarClienteEndereco";
        <?php else:?>
        var rota = getDomain() + "/pedido/adicionarClienteEendereco";
        <?php endif;?>

        if ($("#id_cliente").val() == 'selecione') {
            modalValidacao('Validação', 'Campo (Cliente) deve ser preenchido!');
            return false;

        } else if ($("#id_cliente_endereco").val() == 'selecione') {
            modalValidacao('Validação', 'Campo (Endereços) deve ser preenchido!');
            return false;
        }

        modalValidacao('Validação', 'Aguarde...');
        $.post(rota, {
            '_token': '<?php echo TOKEN; ?>',
            'id_cliente': $("#id_cliente").val(),
            'id_cliente_endereco': $("#id_cliente_endereco").val(),
            'id_pedido': idPedido

        }, function (resultado) {
            var retorno = JSON.parse(resultado);
            if (retorno.status == true) {
                abas('aba2');
                $(".button-aba-2").addClass('botaoAbaAtual');
                $(".componente-produto-pedido").show();
                $("#button-aba-1").removeClass('abaActive');
                $("#button-aba-2").addClass('abaActive');

                <?php if ( !$idPedido):?>
                idPedido = retorno.id_pedido;
                <?php endif;?>

                pedidos();
                setTimeout(modalValidacaoClose, 600);

                $("#button-aba-2").removeClass('abaDesativada');
                $("#button-aba-3").removeClass('abaDesativada');
                $("#button-aba-2").prop("disabled", false);
                $("#button-aba-3").prop("disabled", false);
            }
        })

        return false;
    }

    function adicionarProduto(idProduto, quantidade) {
        var rota = getDomain() + "/pedido/adicionarProduto";

        if (idProduto == "selecione") {
            modalValidacao('Validação', 'Selecione um Produto!');
            return false;
        }

        if (quantidade.val() <= 0 || quantidade.val() == '') {
            modalValidacao('Validação', 'Insira a quantidade do Produto!');
            return false;
        }

        quantidade = quantidade.val();
        modalValidacao('Validação', 'Aguarde...');
        $.post(rota, {
            '_token': '<?php echo TOKEN; ?>',
            'id_pedido': idPedido,
            'id_produto': idProduto,
            'quantidade': quantidade
        }, function (resultado) {
            var retorno = JSON.parse(resultado);
            var produto = retorno.produto[0];
            montaTabelaDeProdutos(produto);

            if (retorno.status) {
                obterValorTotalDopedido(idPedido);
                pedidos();
                setTimeout(modalValidacaoClose, 600);
            }
        })

        return false;
    }

    function montaTabelaDeProdutos(produto) {
        var t = "";
        t += "<tr id='id-tr-" + produto.idProduto + "' data-produto-id=" + produto.idProduto + ">";
        t += "<td>" + '<img class="img-produto-seleionado" src="' + getDomain() + '/' + produto.imagem + '">' + "</td>";
        t += "<td>" + produto.produto + "</td>";
        t += "<td>" + '<input type="number" class="campo-quantidade" value="' + produto.quantidade + '" id="campo-quantidade' + produto.idProdutoPedido + '" onchange="alterarAquantidadeDeUmProduto(' + produto.idProdutoPedido + ', $(this))">' + "</td>";
        t += "<td class='total-cada-produto' data-valor-produto=" + produto.total + " data-produto-id=" + produto.idProduto + ">" + real(produto.total) + "</td>";
        t += "<td>" + '<a class="btn-sm btn-link" onclick="excluirProdutoPedido(' + produto.idProdutoPedido + ', $(this))"><i class="fas fa-times" style="color:#cc0000;font-size:18px"></i></a>' + "</td>";
        t += "</tr>";
        $(".tabela-de-produto tbody").append(t);
    }

    function excluirProdutoPedido(idProdutoPedido, elemento) {
        var rota = getDomain() + "/pedido/excluirProdutoPedido/" + idProdutoPedido;

        modalValidacao('Validação', 'Aguarde...');
        $.get(rota, function (resultado) {
            var retorno = JSON.parse(resultado);
            if (retorno.status == true) {
                elemento.parent().parent().fadeOut(400, function () {
                    $(this).remove();
                })

                obterValorTotalDopedido(idPedido);
                pedidos();
                setTimeout(modalValidacaoClose, 600);
            }
        });

        return false;
    }

    function alterarAquantidadeDeUmProduto(idProdutoPerdido, quantidade) {
        var rota = getDomain() + "/pedido/alterarQuantidadeProdutoPedido";

        if (quantidade.val() > 0) {
            quantidade = quantidade.val();
            modalValidacao('Validação', 'Aguarde...');
            $.post(rota, {
                '_token': '<?php echo TOKEN; ?>',
                'idProdutoPedido': idProdutoPerdido,
                'quantidade': quantidade
            }, function (resultado) {
                var retorno = JSON.parse(resultado);
                if (retorno.status == true) {
                    carregaProdutosPedidos(idPedido);
                    obterValorTotalDopedido(idPedido);
                    pedidos();
                    setTimeout(modalValidacaoClose, 600);
                }
            });
        } else {
            quantidade.val(1);
            return false;
        }

        return false;
    }

    function carregaProdutosPedidos(idPedido) {
        var rota = getDomain() + "/pedido/produtosPorIdPedido/" + idPedido;

        $('<center><span class="tabela-load">Carregando...</span></center>').insertAfter('.tabela-de-produto');
        $(".tabela-de-produto tbody").empty();

        $.get(rota, function (resultado) {
            var produtos = JSON.parse(resultado);
            var t = "";

            $(".tabela-load").hide();

            $.each(produtos, function (index, produto) {
                montaTabelaDeProdutos(produto);
            });
        });

        obterValorTotalDopedido(idPedido);
        return false;
    }

    function meioPagamentoEhBoleto(idMeioPagamento) {
        return idMeioPagamento === 4;
    }

    function formaDePagamentoAlterado() {
        const meioPagamento = document.querySelector("#id_meio_pagamento") || null;
        if (!meioPagamento) return;
        const idMeioPagamento = parseInt(meioPagamento.value);
        const elmDataCompensacao = document.querySelector("#data_compensacao");
        if (meioPagamentoEhBoleto(idMeioPagamento)) {
            elmDataCompensacao.value = "";
            elmDataCompensacao.disabled = false;
            return;
        }
        elmDataCompensacao.value = "";
        elmDataCompensacao.disabled = true;
    }

    <?php if ($idPedido):?>
    carregaProdutosPedidos("<?php echo $idPedido;?>");
    <?php endif;?>

    function finalizarPedido() {
        var rota = getDomain() + "/pedido/finalizarPedido";

        if ($("#id_meio_pagamento").val() == "selecione") {
            modalValidacao('Validação', 'Selecione uma forma de Pagamento!');
            setTimeout(modalValidacaoClose, 3000)
            return false;
        }

        if ($("#id_meio_pagamento").val() === "4" && $("#data_compensacao").val() === "") {
            modalValidacao('Validação', 'Selecione a data de compensação do boleto!');
            setTimeout(modalValidacaoClose, 3000)
            return false;
        }

        modalValidacao('Validação', 'Aguarde...');

        $.post(rota, {
            '_token': '<?php echo TOKEN; ?>',
            'id_pedido': idPedido,
            'id_meio_pagamento': $("#id_meio_pagamento").val(),
            'data_compensacao': $("#data_compensacao").val(),
            'valor_desconto': $("#valor_desconto").val(),
            'valor_frete': $("#valor_frete").val(),
            'previsao_entrega': $("#previsao_entrega").val()
        }, function (resultado) {
            try {
                var retorno = JSON.parse(resultado);
                if (retorno.status == true) {
                    modalValidacao('Sucesso', 'Pedido adicionado com sucesso!');
                    setTimeout(() => {
                        window.location.reload();
                        pedidos();
                    }, 2000)
                }
            } catch (e) {
                modalValidacao('Ops', 'Não foi possível salvar o pedido!');
                setTimeout(modalValidacaoClose, 3000)
            }
        });
    }

    function obterValorTotalDopedido(idPedido) {
        var rota = getDomain() + "/pedido/obterValorTotalDosProdutos/" + idPedido;
        $(".total-geral-produtos").html("<b>Total:</b> <small>Carregando...</small>");
        $.get(rota, function (resultado) {
            var retorno = JSON.parse(resultado);

            $(".total-geral-produtos").empty();
            $(".total-geral-produtos").html("<b>Total:</b> " + real(retorno.totalGeral));
        });
    }
</script>
