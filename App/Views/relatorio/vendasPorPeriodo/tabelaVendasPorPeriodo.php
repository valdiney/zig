<?php if (count($vendas) > 0):?>
	<br>

	<div style="float:right;">

		<h6 style="text-align:right;">
			Total:
			<span style="color:#666666!important">R$ <?php echo real($totalDasVendas);?></span>
		</h6>

		<?php foreach ($meiosDePagamento as $tipo):?>
			<?php if ($tipo->idMeioPagamento == 1):?>
				 <span class="badge" style="background:#83e6cd;padding:5px">
				      <?php echo $tipo->legenda;?> R$ <?php echo real($tipo->totalVendas);?>
				 </span>
			<?php elseif($tipo->idMeioPagamento == 2):?>
			     <span class="badge" style="background:#9be6e6;padding:5px">
				      <?php echo $tipo->legenda;?> R$ <?php echo real($tipo->totalVendas);?>
				 </span>
			<?php elseif($tipo->idMeioPagamento == 3):?>
			     <span class="badge" style="background:#ff9b9b;padding:5px">
				      <?php echo $tipo->legenda;?> R$ <?php echo real($tipo->totalVendas);?>
				 </span>
			<?php endif;?>
	    <?php endforeach; ?>
	</div>

	<div style="clear:both;"></div>
	<hr>

	<table class="table tabela-ajustada table-striped">
		<thead>
			<tr>
				<th>#</th>
		        <!--<th>Preço</th>-->
		        <th>Qtd</th>
		        <th>Total</th>
		        <th>Pagamento</th>
		        <th>Data</th>
		        <!--<th>Data</th>-->
			</tr>
		</thead>
		<tbody>
			<?php foreach($vendas as $venda):?>
				<tr>
					<td>
						<img class="imagem-perfil" src="<?php echo BASEURL.'/'.$venda->imagem;?>"
						title="<?php echo $venda->nomeUsuario;?>">
					</td>

					<?php //if ($venda->preco != 0):?>
					    <!--<td>R$ <?php //echo number_format($venda->preco, 2,',','.');?></td>-->
					<?php //else:?>
						<!--<td><small>Não consta produto</small></td>-->
					<?php //endif;?>

                    <?php if ( ! is_null($venda->quantidade)):?>
					    <td><?php echo $venda->quantidade;?></td>
					<?php else:?>
						<td><small>Não consta</small></td>
					<?php endif;?>

					<td>R$ <?php echo number_format($venda->valor, 2,',','.');?></td>
					<td><?php echo $venda->legenda;?></td>
					<td>
          <?php echo date('d/m', strtotime($venda->data));?>
          <?php echo $venda->hora;?>h
          </td>

				</tr>
			<?php endforeach;?>
		</tbody>
	</table>

<?php else:?>
	<br><br><br>
	<center>
	    <i class="fas fa-sad-tear" style="font-size:40px;opacity:0.70"></i>
	    <br><br>
		<h6 style="opacity:0.70">Vendas não encontradas!</h6>
	</center>
<?php endif;?>
