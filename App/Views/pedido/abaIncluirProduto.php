<div id="aba2" class="col-md-12 aba" style="margin-top:20px;">

    <div class="row">
        <div class="col-md-4 destaque1">
            <div class="form-group">
                <label for="id_produto">Produtos *</label>
                <select class="form-control" name="id_produto" id="id_produto">
                    <option value="selecione">Selecione</option>
                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?php echo $produto->id; ?>">
                            <?php echo $produto->nome; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-4 destaque1">
            <div class="form-group">
                <label for="quantidade">Quantidade *</label>
                <input type="text" class="form-control" name="quantidade" id="quantidade" value="1">
            </div>
        </div>

        <div class="col-md-4 destaque1">
            <div class="form-group">
                <a class="btn btn-success" style="margin-top:30px"
                   onclick="return adicionarProduto($('#id_produto').val(), $('#quantidade'))">
                    <i class="fas fa-plus"></i> Adicionar
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 table-produtos">
            <table class="table table tabela-ajustada tabela-de-produto table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="col-md-12" style="float:right!important">
      <span class="total-geral-produtos" style="float:right!important" class="pull-right">
        <b>Total:</b> R$ 00,00
      </span>
        </div>

    </div>
</div>

