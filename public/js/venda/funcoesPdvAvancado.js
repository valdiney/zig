obterProdutosDaMesa();

function colocarProdutosNaMesa(id) {
   var rota = getDomain()+"/venda/colocarProdutosNaMesa/"+id;
   $.get(rota, function(data, status) {
   	   obterOultimoProdutoColocadoNaMesa('ultimo');
   });
}

function obterProdutosDaMesa() {
   var rota = getDomain()+"/venda/obterProdutosDaMesa";

   $.get(rota, function(data, status) {
   	    var t = "";
   	    var produtos = JSON.parse(data);
   	    $.each(produtos, function(index, value) {
    		  t += "<tr id='id-tr-"+value.id+"'>";
	        t += "<td>"+'<img class="img-produto-seleionado" src="'+value.imagem+'">'+"</td>";
	        t += "<td>"+value.produto+"</td>";
	        t += "<td>R$ "+real(value.preco)+"</td>";
	        t += "<td>"+'<input type="number" class="campo-quantidade" value="'+value.quantidade+'" onchange="alterarAquantidadeDeUmProdutoNaMesa('+value.id+', this.value)">'+"</td>";  
	        t += "<td class='pegarTotal'>R$ "+real(value.total)+"</td>";
	        t += "<td>"+'<button class="btn-sm btn-link" onclick="retirarProdutoDaMesa('+value.id+', this)"><i class="fas fa-times" style="color:#cc0000;font-size:18px"></i></button>'+"</td>";
	        t += "</tr>";
   	    });
   	    
   	   $(".tabela-de-produto tbody").append(t);
   });
}

function obterOultimoProdutoColocadoNaMesa(posicao) {
   var rota = getDomain()+"/venda/obterProdutosDaMesa/ultimo";

   $.get(rota, function(data, status) {
   	    var t = "";
   	    var value = JSON.parse(data);
   	  
        if ($("#id-tr-"+value.id).length == 0) {

          t += "<tr id='id-tr-"+value.id+"'>";
  		    t += "<td>"+'<img class="img-produto-seleionado" src="'+value.imagem+'">'+"</td>";
  		    t += "<td>"+value.produto+"</td>";
  		    t += "<td>R$ "+real(value.preco)+"</td>";
  		    t += "<td>"+'<input type="number" class="campo-quantidade" value="'+value.quantidade+'" onchange="alterarAquantidadeDeUmProdutoNaMesa('+value.id+', this.value)">'+"</td>";  
  		    t += "<td>R$ "+real(value.total)+"</td>";
  		    t += "<td>"+'<button class="btn-sm btn-link" onclick="retirarProdutoDaMesa('+value.id+', this)"><i class="fas fa-times" style="color:#cc0000;font-size:18px"></i></button>'+"</td>";
  		    t += "</tr>";

        	$(".tabela-de-produto tbody").append(t);
        }
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

function somarTotalDosProdutosSelecionados() {
    var totalCompras = 0;
    console.log($(".pegarTotal").text());
    $(".calcular-total").each(function() {
            //totalCompras += Number($(this).text());
            alert($(this).text());
    });
    //$("#total_pagar").text("Total a pagar: R$ "+totalCompras);
}

somarTotalDosProdutosSelecionados();