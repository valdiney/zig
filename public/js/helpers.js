///////////////////////////////////////////////////////////////////////////////
function load(url, idElement) {
  var xhttp;
  if (window.XMLHttpRequest) {
    xhttp = new XMLHttpRequest();
  } else {
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  document.getElementById(idElement).innerHTML = "<center><h3>Carregando...</h3></center>";

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    	console.log(this.responseText);
      document.getElementById(idElement).innerHTML = this.responseText;
    }
  };
  
  xhttp.open("GET", url, true);
  xhttp.send();
}
//////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////
function getProtocol() {
   return window.location.protocol;
}
function getUrl(){
   return window.location.href;
}
function getHost() {
   return window.location.host;
}
function getPath() {
   return window.location.pathname;
}
function getDomain() {
   return getProtocol()+'//'+getHost();
}
function link(url) {
   location.href = url;
}
//////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////
/*
Previne Submeter mais de uma vez o form no mesmo post
Parametro: form: representa o elemento. Pode ser uma classe ou um id
*/
function anulaDuploClick(form) {
    $(form).submit(function (event) {
        if ($(form).hasClass('submitted')) {
            event.preventDefault();
        } else {
            $(form).find(':submit').html('Salvando...');
            $(form).addClass('submitted');
        }
    });
}
//////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////
function modalValidacao(title = false, mensagem) {
    $(function() {
        $("#modal-validacao .modal-title").text(title);
        $("#modal-validacao #modal-body-content").html("<center><h3>" + mensagem + "</center></h3>");
        $("#modal-validacao").modal({backdrop: 'static'});
    });
}

function modalValidacaoClose() {
  $(function() {
    $("#modal-validacao .close").click();
  });
}
//////////////////////////////////////////////////////////////////////////////

function real(valor) {
  valor = Number(valor);
  return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}
//////////////////////////////////////////////////////////////////////////////