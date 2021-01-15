<style>
.obs {
    background:#fffcf5;
    padding-10px;
    margin-bottom:20px;
    opacity:0.80;
}
</style>

<form method="post"
      action="<?php echo isset($cliente->id) ? BASEURL . '/cliente/update' : BASEURL . '/cliente/save'; ?>"
      enctype='multipart/form-data'>
    <div class="row">

        <div class="col-md-12 obs">
            <span>
            Obs: Ao cadastrar um Cliente, é recomendável que cadastre também o endereço!
            <br> Esta informação será usada no modulo de pedidos!
            </span>
        </div>

        <input type="hidden" name="_token" value="<?php echo TOKEN; ?>"/>

        <?php if (isset($cliente->id)): ?>
            <input type="hidden" name="id" value="<?php echo $cliente->id; ?>">
        <?php endif; ?>

        <div class="col-md-4">
            <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite aqui..."
                       value="<?php echo isset($cliente->id) ? $cliente->nome : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="email">E-mail * <span class="label-email"></span></label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Digite o e-mail!"
                       value="<?php echo isset($cliente->id) ? $cliente->email : '' ?>"
                       onchange="verificaSeEmailExiste(this, <?php echo isset($cliente->id) ? $cliente->id : false; ?>)">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="id_cliente_tipo">Pessoa Física ou Jurídica *</label>
                <select class="form-control" name="id_cliente_tipo" id="id_cliente_tipo"
                        onchange="selecionarTipoDeCliente(this)">
                    <option value="selecione">Selecione</option>
                    <?php foreach ($clientesTipos as $clienteTipo): ?>
                        <?php if (isset($cliente->id) && $cliente->id_cliente_tipo == $clienteTipo->id): ?>
                            <option value="<?php echo $cliente->id_cliente_tipo; ?>"
                                    selected="selected"><?php echo $clienteTipo->descricao; ?>
                            </option>
                        <?php else: ?>
                            <option
                                value="<?php echo $clienteTipo->id; ?>"><?php echo $clienteTipo->descricao; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="id_cliente_segmento">Segmento *</label>
                <select class="form-control" name="id_cliente_segmento" id="id_cliente_segmento">
                    <option value="selecione">Selecione</option>
                    <?php foreach ($clientesSegmentos as $clienteSegmento): ?>
                        <?php if (isset($cliente->id) && $cliente->id_cliente_segmento == $clienteSegmento->id): ?>
                            <option value="<?php echo $cliente->id_cliente_segmento; ?>"
                                    selected="selected"><?php echo $clienteSegmento->descricao; ?>
                            </option>
                        <?php else: ?>
                            <option value="<?php echo $clienteSegmento->id; ?>">
                                <?php echo $clienteSegmento->descricao; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-4 elemento-quando-for-pessoa-juridica">
            <div class="form-group">
                <label for="cnpj">CNPJ * <span class="label-cnpj"></span></label>
                <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="Digite o CNPJ"
                       value="<?php echo isset($cliente->id) ? $cliente->cnpj : '' ?>"
                       onchange="verificaSeCnpjExiste(this, <?php echo isset($cliente->id) ? $cliente->id : false; ?>)">
            </div>
        </div>

        <div class="col-md-4 elemento-quando-for-pessoa-fisica">
            <div class="form-group">
                <label for="cpf">CPF * <span class="label-cpf"></span></label>
                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="Digite o CPF"
                       value="<?php echo isset($cliente->id) ? $cliente->cpf : '' ?>"
                       onchange="verificaSeCpfExiste(this, <?php echo isset($cliente->id) ? $cliente->id : false; ?>)">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" name="telefone" id="telefone"
                       placeholder="Digite o número de Telefone"
                       value="<?php echo isset($cliente->id) ? $cliente->telefone : '' ?>">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="celular">Celular</label>
                <input type="text" class="form-control" name="celular" id="celular"
                       placeholder="Digite o número de Celular"
                       value="<?php echo isset($cliente->id) ? $cliente->celular : '' ?>">
            </div>
        </div>

    </div><!--end row-->

    <button type="submit" class="btn btn-success btn-sm button-salvar-clientes" style="float:right"
            onclick="return salvarClientes()">
        <i class="fas fa-save"></i> Salvar
    </button>

</form>

<script src="<?php echo BASEURL; ?>/public/js/maskedInput.js"></script>
<script>
    // Anula duplo click em salvar
    anulaDuploClick($('form'));

    // Aplica as regras quando carregar a modal no modo edição
    <?php if (isset($cliente->id)):?>
    <?php if ($cliente->id_cliente_tipo == 1):?>
    $(".elemento-quando-for-pessoa-juridica").hide();
    $(".elemento-quando-for-pessoa-fisica").show();
    <?php elseif ($cliente->id_cliente_tipo == 2):?>
    $(".elemento-quando-for-pessoa-fisica").hide();
    $(".elemento-quando-for-pessoa-juridica").show();
    <?php endif;?>
    <?php endif;?>

    function selecionarTipoDeCliente(item) {
        // Quando for pessoa fisica
        if (item.value == 1) {
            $(".elemento-quando-for-pessoa-juridica").hide();
            $(".elemento-quando-for-pessoa-fisica").show();

            // Quando for pessoa juridica
        } else if (item.value == 2) {
            $(".elemento-quando-for-pessoa-fisica").hide();
            $(".elemento-quando-for-pessoa-juridica").show();
        }
    }

    // Aplica as mascas nos elementos
    jQuery(function ($) {
        jQuery("#cnpj").mask("99.999.999/9999-99");
        jQuery("#cpf").mask("999.999.999-99");
        jQuery("#telefone").mask("(99) 9999-9999");
        jQuery("#celular").mask("(99) 99999-9999");
    });

    function salvarClientes() {
        var idClienteTipo = $("#id_cliente_tipo");

        if ($('#nome').val() == '') {
            modalValidacao('Validação', 'Campo (Nome) deve ser preenchido!');
            return false;

        } else if ($('#email').val() == '') {
            modalValidacao('Validação', 'Campo (Email) deve ser preenchido!');
            return false;

        } else if (!emailValido($('#email').val())) {
            modalValidacao('Validação', 'Digite um Email valido!');
            return false;

        } else if ($('#id_cliente_tipo').val() == 'selecione') {
            modalValidacao('Validação', 'Este cliente é Pessoa Física ou Jurídica?');
            return false;

        } else if ($('#id_cliente_segmento').val() == 'selecione') {
            modalValidacao('Validação', 'Em qual segmento este cliente atua?');
            return false;

        } else if (idClienteTipo.val() == 1 && $('#cpf').val() == '') {
            modalValidacao('Validação', 'Campo (CPF) deve ser preenchido!');
            return false;

        } else if (idClienteTipo.val() == 1 && !cpfValido($('#cpf').val())) {
            modalValidacao('Validação', 'Digite um (CPF) valido!');
            return false;

        } else if (idClienteTipo.val() == 2 && $('#cnpj').val() == '') {
            modalValidacao('Validação', 'Campo (CNPJ) deve ser preenchido!');
            return false;

        } else if (idClienteTipo.val() == 2 && !CNPJvalido($('#cnpj').val())) {
            modalValidacao('Validação', 'Digite um (CNPJ) valido!');
            return false;

        }

        return true;
    }

    function verificaSeEmailExiste(email, id) {
        var rota = getDomain() + "/cliente/verificaSeEmailExiste";
        if (id) {
            rota += '/' + in64(email.value) + '/' + id;
        } else {
            rota += '/' + in64(email.value);
        }

        $.get(rota, function (data, status) {
            var retorno = JSON.parse(data);

            if (retorno.status == true) {
                modalValidacao('Validação', 'Este Email já existe! Por favor, informe outro!');
                $('.button-salvar-clientes').attr('disabled', 'disabled');
                $('.label-email').html('<small style="color:#cc0000!important">Este Email já existe!</small>');
            } else {
                $('.button-salvar-clientes').attr('disabled', false);
                $('.label-email').html('');
            }
        });
    }

    function verificaSeCnpjExiste(cnpj, id) {
        var rota = getDomain() + "/cliente/verificaSeCnpjExiste";
        if (id) {
            rota += '/' + in64(cnpj.value) + '/' + id;
        } else {
            rota += '/' + in64(cnpj.value);
        }

        $.get(rota, function (data, status) {
            var retorno = JSON.parse(data);

            if (retorno.status == true) {
                modalValidacao('Validação', 'Este CNPJ já existe! Por favor, informe outro!');
                $('.button-salvar-clientes').attr('disabled', 'disabled');
                $('.label-cnpj').html('<small style="color:#cc0000!important">Este CNPJ já existe!</small>');
            } else {
                $('.button-salvar-clientes').attr('disabled', false);
                $('.label-cnpj').html('');
            }
        });
    }

    function verificaSeCpfExiste(cpf, id) {
        var rota = getDomain() + "/cliente/verificaSeCpfExiste";
        if (id) {
            rota += '/' + in64(cpf.value) + '/' + id;
        } else {
            rota += '/' + in64(cpf.value);
        }

        $.get(rota, function (data, status) {
            var retorno = JSON.parse(data);
            if (retorno.status == true) {
                modalValidacao('Validação', 'Este CPF já existe! Por favor, informe outro!');
                $('.button-salvar-clientes').attr('disabled', 'disabled');
                $('.label-cpf').html('<small style="color:#cc0000!important">Este CPF já existe!</small>');
            } else {
                $('.button-salvar-clientes').attr('disabled', false);
                $('.label-cpf').html('');
            }
        });
    }

// Select2
jQuery('#id_cliente_segmento').select2();
</script>
