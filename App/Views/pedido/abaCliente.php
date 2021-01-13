<div id="aba1" class="col-md-12 aba" style="margin-top:20px;">
    <form>
        <div class="row">

            <?php if (isset($pedido->id)) : ?>
                <input type="hidden" name="id" value="<?php echo $pedido->id; ?>">
            <?php endif; ?>

            <div class="col-md-4 destaque1">
                <div class="form-group">
                    <label for="id_cliente">Clientes *</label>
                    <select class="form-control" name="id_cliente" id="id_cliente"
                            onchange="enderecoPorIdCliente(this.value);">
                        <option value="selecione">Selecione</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <?php if ($cliente->id == $pedido->id_cliente): ?>
                                <option value="<?php echo $cliente->id; ?>" selected="selected">
                                    <?php echo $cliente->nome; ?>
                                </option>
                            <?php else: ?>
                                <option value="<?php echo $cliente->id; ?>">
                                    <?php echo $cliente->nome; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div><!--end-->

            <div class="col-md-4 destaque1">
                <div class="form-group">
                    <label for="id_cliente_endereco">Endereços *</label>
                    <select class="form-control" name="id_cliente_endereco" id="id_cliente_endereco">
                        <option value="selecione">Selecione</option>
                        <?php if ($idPedido): ?>
                            <?php foreach ($clienteEnderecos as $endereco): ?>
                                <?php if ($pedido->id_cliente_endereco == $endereco->id): ?>
                                    <option value="<?php echo $endereco->id; ?>" selected="selected">
                                        <?php echo $endereco->endereco; ?>
                                    </option>
                                <?php else: ?>
                                    <option value="<?php echo $endereco->id; ?>">
                                        <?php echo $endereco->endereco; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div><!--end-->

            <div class="col-md-4 destaque1">
                <div class="form-group">
                    <a class="btn btn-success" style="margin-top:28px"
                       onclick="return salvarPrimeiroPasso()" id="salvar-endereco">
                        <i class="fas fa-save"></i> Salvar
                    </a>
                </div>
            </div><!--end-->

    </form>


</div>

</div>
</div>
