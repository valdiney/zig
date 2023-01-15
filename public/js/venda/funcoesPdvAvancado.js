obterProdutosDaMesa();
obterValorTotalDosProdutosNaMesa();

/*Acrescenta um produto a seleção de venda*/
function colocarProdutosNaMesa(id, item, seProdutoEsgotado) {
    if (seProdutoEsgotado == 'esgotado') {
        modalValidacao('Validação', 'Produto esgotado. <br> Reabasteça o estoque.');
        return false;
    }

    const rota = getDomain() + "/pdvDiferencial/colocarProdutosNaMesa/" + id;
    modalMensagemAdicionandoProdutosAMessa();
    $.get(rota, function (data, status) {
        obterOultimoProdutoColocadoNaMesa('ultimo');
        calcularTroco();

    }).done(function() {
        setTimeout(modalValidacaoClose, 1000);
    });
}

/*
Acessa a rota que entrega um json com os produtos que foram selecionados
e popula a tabela HTMl com esses produtos
*/
function obterProdutosDaMesa() {
    var rota = getDomain() + "/pdvDiferencial/obterProdutosDaMesa";

    $('<center><span class="tabela-load">Carregando...</span></center>').insertAfter('.tabela-de-produto');

    $.get(rota, function (data, status) {
        var t = "";
        var produtos = JSON.parse(data);

        if (produtos.length != 0) {
            $.each(produtos, function (index, value) {
                t += "<tr id='id-tr-" + value.id + "'>";
                if (value.imagem == null || value.imagem == '') {
                    t += "<td><i class='fas fa-box-open' style='font-size:20px'></td>";
                } else {
                   t += "<td>" + '<img class="img-produto-seleionado" src="' + getDomain() + '/' + value.imagem + '">' + "</td>";
                }
                t += "<td>" + value.produto + "</td>";
                t += "<td class='hidden-when-mobile'>" + real(value.preco) + "</td>";
                t += "<td>" + '<input type="number" class="campo-quantidade" value="' + value.quantidade + '" onchange="alterarAquantidadeDeUmProdutoNaMesa(' + value.id + ', this.value, $(this))">' + "</td>";
                t += "<td class='pegarTotal'>" + real(value.total) + "</td>";
                t += "<td>" + '<button class="btn-sm btn-link" onclick="retirarProdutoDaMesa(' + value.id + ', this)"><i class="fas fa-times" style="color:#cc0000;font-size:18px"></i></button>' + "</td>";
                t += "</tr>";
            });
        }

        $('.tabela-load').hide();

        verificaSeTemProdutosNaMesa(t);
        $(".tabela-de-produto tbody").append(t);
    });
}

/*Obtem o ultimo produto selecionado para a venda.*/
function obterOultimoProdutoColocadoNaMesa() {
    var rota = getDomain() + "/pdvDiferencial/obterProdutosDaMesa/ultimo";

    $.get(rota, function (data, status) {
        var t = "";
        var value = JSON.parse(data);

        if ($("#id-tr-" + value.id).length == 0) {
            t += "<tr id='id-tr-" + value.id + "'>";
            if (value.imagem == null || value.imagem == '') {
                t += "<td><i class='fas fa-box-open' style='font-size:20px'></td>";
            } else {
               t += "<td>" + '<img class="img-produto-seleionado" src="' + getDomain() + '/' + value.imagem + '">' + "</td>";
            }
            t += "<td>" + value.produto + "</td>";
            t += "<td class='hidden-when-mobile'>" + real(value.preco) + "</td>";
            t += "<td>" + '<input type="number" class="campo-quantidade" value="' + value.quantidade + '" onchange="alterarAquantidadeDeUmProdutoNaMesa(' + value.id + ', this.value, $(this))">' + "</td>";
            t += "<td>" + real(value.total) + "</td>";
            t += "<td>" + '<button class="btn-sm btn-link" onclick="retirarProdutoDaMesa(' + value.id + ', this)"><i class="fas fa-times" style="color:#cc0000;font-size:18px"></i></button>' + "</td>";
            t += "</tr>";

            verificaSeTemProdutosNaMesa(t);
            $(".tabela-de-produto tbody").append(t);
        }

        obterValorTotalDosProdutosNaMesa();
    });
}

/*Acrescenta ou decrementa a quantidade de um produto*/
function alterarAquantidadeDeUmProdutoNaMesa(id, quantidade, element) {
    quantidade = Number(quantidade);

    if (quantidade <= 0) {
        element.val(1);
    }

    if (quantidade > 0 && quantidade != '') {
        modalValidacao('Aplicando', 'Aguarde');

        var rota = getDomain() + "/pdvDiferencial/alterarAquantidadeDeUmProdutoNaMesa/" + id + "/" + quantidade;
        $.get(rota, function (data, status) {
            var obj = JSON.parse(data);

            if (obj.quantidade_insuficiente == true) {
                var legendaUnidade = (obj.unidades > 1) ? 'unidades' : 'unidade';
                modalValidacao('Aplicando', 'Este Produto tem apenas '+obj.unidades+' '+legendaUnidade+' em estoque.');
                element.val(obj.unidades);
                return false;
            }

            $(".tabela-de-produto tbody").empty();
            obterProdutosDaMesa();
            obterValorTotalDosProdutosNaMesa();
            calcularTroco();
            setTimeout(modalValidacaoClose, 1000);
        });
    }
}

/*Retira um produto da seleção de venda*/
function retirarProdutoDaMesa(id, item) {
    var rota = getDomain() + "/pdvDiferencial/retirarProdutoDaMesa/" + id;
    $.get(rota, function (data, status) {
        var tr = $(item).closest('tr');
        tr.fadeOut(400, function () {
            tr.remove();
        });

        obterValorTotalDosProdutosNaMesa();
        verificaSeTemProdutosNaMesa($(".tabela-de-produto tbody tr").length);
        calcularTroco();

        return false;
    });
}

/*
Obtem o valor total de todos os produtos selecionados.
Leva em concideração o valor sobre a quantidade de produtos.
*/
function obterValorTotalDosProdutosNaMesa() {
    var rota = getDomain() + "/pdvDiferencial/obterValorTotalDosProdutosNaMesa/";
    $("#b-mostra-valor-total").val('Carregando...');

    $.get(rota, function (data, status) {
        var total = JSON.parse(data);
        $("#b-mostra-valor-total").val(real(total.total));
    });
}

/*Salva os produtos selecionados, ou seja, realiza a venda de fato!*/
function saveVendasViaSession(token) {
    var rota = getDomain() + "/pdvDiferencial/saveVendasViaSession";
    const meioPagamento = $('#id_meio_pagamento').val();
    const dataCompensacao = $('#data_compensacao_boleto').val();
    const valorRecebido = $("#valor_recebido").val();
    var  troco = $("#input_troco").val();

    if (meioPagamento == "selecione") {
        modalValidacao('Ops.', 'Selecione um meio de Pagamento.');
        $("#button-confirmar-venda").prop('disabled', false);
        return false;
    }

    // verifica se é boleto e preencheu a data de compensacao
    if (meioPagamento == 4 && dataCompensacao == "") {
        modalValidacao('Algo deu errado', 'Você precisa adiciona a data de compensação do boleto!');
        setTimeout(modalValidacaoClose, 2000);
        return;
    }

    modalValidacao('Salvando', 'Processando...');

    new Promise(function (resolve, reject) {
        setTimeout(resolve, 700);
    })
    .then(function () {
        return new Promise(function (resolve, reject) {
            setTimeout(modalValidacaoClose, 700);
            setTimeout(resolve, 1000);
        })
    })
    .then(function () {
        const payload = {
            'id_meio_pagamento': meioPagamento,
            'data_compensacao': dataCompensacao,
            'valor_recebido': valorRecebido,
            'troco': usd(troco),
            '_token': token
        };

        $.post(rota, payload, function (result) {
            var status = result? JSON.parse(result): null;
            if (status && status.status) {
                $(".tabela-de-produto tbody").empty();
                verificaSeTemProdutosNaMesa(1);
                obterValorTotalDosProdutosNaMesa();
                reiniciaElementosDePagamento();
                modalValidacao('Venda', 'Venda realizada com Sucesso!');
            }
        })
    })
    .finally(function () {
        setTimeout(modalValidacaoClose, 1000);
    })
}

/*Se não tiver podutos selecionados, mostra uma mensagem*/
function verificaSeTemProdutosNaMesa(t) {
    if (t.length == 0 || t == 1) {
        t += "<td class='colspan' colspan='6' style='text-align:center'>Nenhum produto selecionado!</td>";
        $(".tabela-de-produto tbody").append(t);
        reiniciaElementosDePagamento();
        $("#id_meio_pagamento").prop('disabled', true);
        $("#button-confirmar-venda").prop('disabled', true);

    } else {
        $(".colspan").hide();
        $("#id_meio_pagamento").prop('disabled', false);
        $("#button-confirmar-venda").prop('disabled', false);
    }
}

function modalMensagemAdicionandoProdutosAMessa() {
    modalValidacao('Validação', 'Adicionando...');
}

function handleAoMudarMeioDePagamento() {
    const dataCompensacao = document.querySelector("#data-compensacao");
    const elmtMeiosDePagamento = document.querySelector("#id_meio_pagamento");
    const meiosDePagamento = parseInt(elmtMeiosDePagamento.value);

    // 1 = meio de pagamento (Dinheiro)
    if (meiosDePagamento == 1) {
        $("#div-valor-recebido").show('fast');
        $("#div-troco").show('fast');
        calcularTroco();
    } else {
        $("#div-valor-recebido").hide('fast');
        $("#div-troco").hide('fast');
        $("#button-confirmar-venda").prop('disabled', false);
    }

    if (meiosDePagamento !== 4) {
        dataCompensacao.classList.remove("visivel");
        dataCompensacao.value = "";
        return;
    }

    dataCompensacao.classList.add("visivel");
}

function calcularTroco() {
    var valorRecebido = $("#valor_recebido").val();
    var rota = getDomain() + "/pdvDiferencial/calcularTroco/"+in64(valorRecebido);
    var meioPagamento = $("#id_meio_pagamento").val();

    // Mostra a opção de troco somente se for pagamento via dinheiro
    if (meioPagamento != 'selecione' && meioPagamento == 1) {
        $("#div-troco").show('fast');
        $("#input_troco").val('Carregando...');

        $.get(rota, function (data, status) {
            var troco = JSON.parse(data);

            if (troco.message != false) {
                $("#button-confirmar-venda").prop('disabled', true);
                $("#valor_recebido").css("background", '#f6e1e1');
                $("#label-valor-pago").html("<br> <b style=color:#c34747>" + troco.message + "</b>");
            } else {
                $("#button-confirmar-venda").prop('disabled', false);
                $("#valor_recebido").css("background", 'transparent');
                $("#label-valor-pago").text("Valor pago");
            }

            $("#input_troco").val(troco.valor.toLocaleString('pt-BR',  { minimumFractionDigits: 2}));
        });
    }
}

function reiniciaElementosDePagamento() {
    $("#id_meio_pagamento").prop('selectedIndex', 0);
    $("#valor_recebido").val('');
    $("#input_troco").val('');
    $("#div-troco").hide('fast');
    $("#div-valor-recebido").hide('fast');

    $("#valor_recebido").css("background", 'transparent');
    $("#label-valor-pago").text("Valor pago");
}

handleAoMudarMeioDePagamento();
