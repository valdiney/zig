<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="<?php echo BASEURL; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="public/img/favicon_tonie.png"/>
    <title>ZigMoney - <?php echo $nomeEmpresa; ?></title>
    <link rel="shortcut icon" href="public/img/favicon.png"/>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #666;
            font-size:12px;
            margin-top:5px;
        }
        table, th, td {
            border: 1px solid black;
            text-align:center;
        }
        thead tr {
            background: #cccccc;
        }
        th {
            height: 20px;
        }
    </style>
</head>
<body>

<center><h2 style="margin-bottom:3"><?php echo $nomeEmpresa;?></h2></center>
<center>
    <h4 style="margin-top:0;opacity:0.70">Relatório de uma venda  especifica.</h4>
    <small style="opacity:0.50">Gerado em: <?php echo date('d/m/Y');?> às <?php echo date('H:i');?></small>
</center>
<hr style="border:1px dotted silver">
<br>
<center>
    <span style="opacity:0.70;font-size:15px;">
        <b>PAG: <?php echo $informacaoPagamento->meioPagamento;?></b> |
        <b>Total Geral: R$ <?php echo real($informacaoPagamento->total);?></b>
        <?php if ($informacaoPagamento->id_meio_pagamento == 1) :?>
            |
            <b>Recebido: R$ <?php echo real($informacaoPagamento->valor_recebido);?></b> |
            <b>Troco: R$ <?php echo real($informacaoPagamento->troco);?></b>
        <?php endif;?>
    </span>
</center>
<br>
<center><small style="opacity:0.70;font-size:13px;">Vendedor: <?php echo $informacaoPagamento->nomeUsuario;?></small></center>
<br>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Produto</th>
            <th>QTD</th>
            <th>Preço</th>
            <th>Sub Total</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;?>
        <?php foreach ($dadosVenda as $venda):?>
            <?php
                $i++;
                $styleTd = "style=''";
                if ($i % 2 == 0) {
                    $styleTd = "style='background:#eeeaea'";
                }
            ?>
            <tr <?php echo $styleTd;?>>
                <td><?php echo $i;?></td>
                <td><?php echo stringAbreviation($venda->produtoNome, 15, '...');?></td>
                <td><?php echo $venda->quantidade;?></td>
                <td><?php echo 'R$ ' . real($venda->valor);?></td>
                <td><?php echo 'R$ ' . real($venda->preco);?></td>
                <td>
                    <?php echo $venda->data . ' ' . $venda->hora;?>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>

</table>
</body>
</html>
