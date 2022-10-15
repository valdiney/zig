<?php use System\HtmlComponents\Modal\Modal; ?>
<?php require_once('menu.php');?>
<?php require_once('filtro_pesquisa.php');?>

<div class="card col-lg-12 content-div">
    <div id="div-tabela-vendas"></div>
    <br>
</div>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>

<script>
    $("#buscar-fluxo").click(function () {
        vendas();
        return false;
    });

    getFromLocalStorage();
    vendas();

    function vendas() {
        $('#div-tabela-vendas').html('<br><center><h3>Carregando...</h3></center>');
        var rota = $('#form').attr('action');
        $.post(rota, $('#form').serialize(), function (resultado) {
            $('#div-tabela-vendas').empty();
            $('#div-tabela-vendas').append(resultado);
        });
    }

    function incluirPDV(element) {
        if (element.prop('checked')) {
            $("#retirarPDV").val(1);
            vendas();
            setToLocalStorage(1);
        }

        if ( ! element.prop('checked')) {
            $("#retirarPDV").val(0);
            vendas();
            setToLocalStorage(0);
        }
    }

    function setToLocalStorage(status) {
        localStorage.setItem('retirarPDV', status);
    }

    function getFromLocalStorage() {
        $("#retirarPDV").val(localStorage.getItem('retirarPDV'));
    }
</script>
