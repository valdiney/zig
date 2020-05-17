<?php if (count($vendas) > 0):?>
	<table class="table tabela-ajustada">
		<thead>
			<tr>
				<th>#</th>
	    		<th>Valor</th>
	    		<th>Pagamento</th>
	    		<th>Hora</th>
	    		<th>Data</th>
			</tr>
		</thead>
		<tbody>	        		
			<?php foreach($vendas as $venda):?>
				<tr>
					<td><img class="imagem-perfil" src="<?php echo $venda->imagem;?>"></td>
					<td>R$ <?php echo number_format($venda->valor, 2,',','.');?></td>
					<td><?php echo $venda->legenda;?></td>
					<td><?php echo $venda->hora;?>h</td>
					<td><?php echo $venda->data;?></td>
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