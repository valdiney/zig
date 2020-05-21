obterProdutosDaMesa();

function colocarProdutosNaMesa(id) {
   var rota = getDomain()+"/venda/colocarProdutosNaMesa/"+id;
   $.get(rota, function(data, status) {
   	   $(".tabela-de-produto tbody").empty();
   	   obterProdutosDaMesa();
   });
}

function obterProdutosDaMesa() {
   var rota = getDomain()+"/venda/obterProdutosDaMesa";
   $.get(rota, function(data, status) {

    var produto = JSON.parse(data);
   	    var t = "";
   	    $.each(produto, function(index, value) {
	   	   	t += "<tr>";
            t += "<td>"+'<img class="img-produto-seleionado" src="'+value.imagem+'">'+"</td>";
            t += "<td>"+value.produto+"</td>";
            t += "<td>R$ "+value.preco+"</td>";
            t += "<td>"+'<input type="number" class="campo-quantidade" value="'+value.quantidade+'" onchange="alterarAquantidadeDeUmProdutoNaMesa('+value.id+', this.value)">'+"</td>";  
            t += "<td>R$ "+value.total+"</td>";
            t += "<td>"+'<button class="btn-sm btn-link" onclick="retirarProdutoDaMesa('+value.id+', this)"><i class="fas fa-times" style="color:#cc0000;font-size:18px"></i></button>'+"</td>";
            t += "</tr>";
   	    });

   	   $(".tabela-de-produto tbody").append(t);
   });
}

function alterarAquantidadeDeUmProdutoNaMesa(id, quantidade) {
	if (quantidade != 0 || quantidade != '') {
		var rota = getDomain()+"/venda/alterarAquantidadeDeUmProdutoNaMesa/"+id+"/"+quantidade;
	    $.get(rota, function(data, status) {
	   	    $(".tabela-de-produto tbody").empty();
	   	    obterProdutosDaMesa();
	    });
	}
}

function retirarProdutoDaMesa(id, item) {
	var rota = getDomain()+"/venda/retirarProdutoDaMesa/"+id;
	$.get(rota, function(data, status) {
	   	var tr = $(item).closest('tr');     
        tr.fadeOut(400, function() {              
            tr.remove();              
        });  

	   	return false;
	});
}