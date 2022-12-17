///////////////////////////////////////////////////////////////////////////////
function load(url, idElement) {
    var xhttp;
    if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
    } else {
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    document.getElementById(idElement).innerHTML = "<center><h3>Carregando...</h3></center>";

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
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

function getUrl() {
    return window.location.href;
}

function getHost() {
    return window.location.host;
}

function getPath() {
    return window.location.pathname;
}

function getDomain() {
    return document.querySelector('base').href;
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
    $(function () {
        $("#modal-validacao .modal-title").text(title);
        $("#modal-validacao #modal-body-content").html("<center><h3>" + mensagem + "</center></h3>");
        $("#modal-validacao").modal({backdrop: 'static'});
    });
}

function modalValidacaoClose() {
    $("#modal-validacao .close").click();
}

function closeModal(idModal) {
    var id = "#"+idModal;
    $(id).modal('hide');
}

//////////////////////////////////////////////////////////////////////////////

function real(valor) {
    valor = Number(valor);
    return valor.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
}

function usd(valor) {
    //valor = Number(valor);
    return valor.toLocaleString('pt-BR', {style: 'currency', currency: 'USD'});
}

//////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////
function in64(data) {
    return btoa('atzxyzendMosterw||zig' + data);
}

function out64(data) {
    return atob(data);
}

//////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////
function emailValido(mail) {
    var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
    if (typeof (mail) == "string") {
        if (er.test(mail)) {
            return true;
        }
    } else if (typeof (mail) == "object") {
        if (er.test(mail.value)) {
            return true;
        }
    } else {
        return false;
    }
}

//////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////
function cpfValido(strCPF) {
    strCPF = strCPF.replace(/\D/g, '');
    if (strCPF == '') {
        return false;
    }

    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF == "00000000000") return false;

    for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10))) return false;

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11))) return false;
    return true;
}

//////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////
function CNPJvalido(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g, '');
    if (cnpj == '')
        return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;
}

//////////////////////////////////////////////////////////////////////////////
function verificaExtensaoArquivo(arquivo) {
    extensoes_permitidas = new Array(".gif", ".png", ".jpeg", ".jpg", ".jfif");
    extensao = (arquivo.substring(arquivo.lastIndexOf("."))).toLowerCase();
    permite = false;
    $(extensoes_permitidas).each(function(i) {
        if (extensoes_permitidas[i] == extensao) {
            permite = true;
            return false;
        }
    });
    if( ! permite) {
        $.confirm({
            title: 'Validação!',
            content: "<b>("+extensao+")</b>" + ' Este formato não é permitido! <br> Tente .gif, .png, .jpeg, .jpg, .jfif!',
            buttons: {
                ok: function(){}
            }
        });

        return false;
    }
    return true;
}
