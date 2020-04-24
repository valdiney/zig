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

function modalValidacao(mensagem) {
    $(function() {
        $("#modal-validacao .modal-title").text("Validação");
        $("#modal-validacao #modal-body-content").html("<center><h3>" + mensagem + "</center></h3>");
        $("#modal-validacao").modal({backdrop: 'static'});
    });
}

function emailValido(mail) {   
    var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);   
     if (typeof(mail) == "string") {       
        if (er.test(mail)) { 
            return true; 
        }  
    } else if(typeof(mail) == "object") {     
        if (er.test(mail.value)) {                   
            return true;                
        }   
    }
    else {      
        return false;       
    }
}

function CNPJvalido(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g,'');
    if(cnpj == '') 
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
    numeros = cnpj.substring(0,tamanho);
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
    numeros = cnpj.substring(0,tamanho);
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