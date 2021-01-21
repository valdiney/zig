<div id="aba3" class="col-md-12 aba" style="margin-top:20px;">
    <div class="row">
        <div class="col-md-6 destaque1">
            <div class="form-group">
                <label for="id_meio_pagamento">Forma Pagamento *</label>
                <select class="form-control" name="id_meio_pagamento" id="id_meio_pagamento" onchange="formaDePagamentoAlterado()">
                    <option value="selecione">Selecione</option>
                    <?php foreach ($meiosPagamentos as $meiosPagamento): ?>
                        <?php if ($pedido->id_meio_pagamento == $meiosPagamento->id): ?>
                            <option value="<?php echo $meiosPagamento->id; ?>" selected="selected">
                                <?php echo $meiosPagamento->legenda; ?>
                            </option>
                        <?php else: ?>
                            <option value="<?php echo $meiosPagamento->id; ?>">
                                <?php echo $meiosPagamento->legenda; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-6 destaque1">
            <div class="form-group">
                <label for="data_compensacao text-muted">Data de compensacao</label>
                <input

                    type="date"
                    class="form-control"
                    id="data_compensacao"
                    name="data_compensacao"
                    placeholder="Data de compensação"
                    value="<?php if (isset($pedido->id) && $pedido->data_compensacao != null): ?><?php echo $pedido->data_compensacao; ?><?php endif; ?>"
                    <?php if (isset($pedido->id) && $pedido->id_meio_pagamento !== 4 && $pedido->data_compensacao === null) { echo 'disabled'; } ?>
                />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 destaque1">
            <div class="form-group">
                <label for="valor_desconto">R$ Desconto</label>
                <input type="text" class="form-control campo-moeda" name="valor_desconto" id="valor_desconto"
                    placeholder="Desconto..."
                    value="<?php if (isset($pedido->id) && $pedido->valor_desconto != null): ?><?php echo real($pedido->valor_desconto); ?><?php endif; ?>"
                    onchange="somaTotalComDescontoSomenteParaMostrarNaView($(this))">
            </div>
        </div>

        <div class="col-md-4 destaque1">
            <div class="form-group">
                <label for="valor_frete">R$ Frete</label>
                <input type="text" class="form-control campo-moeda" name="valor_frete" id="valor_frete"
                       placeholder="Frete..."
                       value="<?php if (isset($pedido->id) && $pedido->valor_frete != null): ?><?php echo real($pedido->valor_frete); ?><?php endif; ?>">
            </div>
        </div>

        <div class="col-md-4 destaque1">
            <div class="form-group">
                <label for="previsao_entrega">Previsão de entrega</label>
                <input type="date" class="form-control" name="previsao_entrega" id="previsao_entrega"
                       value="<?php if (isset($pedido->id) && $pedido->previsao_entrega != null): ?><?php echo $pedido->previsao_entrega; ?><?php endif; ?>"
                       onchange="somaTotalComFreteSomenteParaMostrarNaView($(this))">
            </div>
        </div>
    </div>
    <!--end row-->

    <div class="col-md-12" style="float:right!important;padding-right:0">
      <span class="total-geral-produtos" style="float:right!important" class="pull-right">
        <b>Total:</b> R$ 00,00
      </span>
    </div>

    <button type="submit" class="btn btn-success btn-sm button-salvar-empresa"
            style="float:right" onclick="return finalizarPedido()">
        <i class="fas fa-save"></i> Salvar
    </button>

    <!--<button type="submit" class="btn btn-warning btn-sm"
    style="float:right">
      <i class="fas fa-undo-alt"></i> Cancelar
    </button>-->
</div>
