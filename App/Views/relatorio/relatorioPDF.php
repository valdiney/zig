<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #666;
        }

        table, th, td {
            border: 1px solid black;
        }

        thead tr {
            background: #339999;
            color: #fff;
        }

        th {
            height: 50px;
        }
    </style>
</head>
<body>

<center><h2 style="margin-bottom:3"><b>Empresa:</b> <?php echo $this->getEmpresa()->nome;?></h2></center>
<center>
    <h4 style="margin-top:0;opacity:0.80"><?php echo $titulo; ?></h4>
</center>

<center>
    <span><b>Total Vendido: R$ <?php echo real($this->getTotalVendas());?></b></span>
</center>
<br>
<table>
    <thead>
    <tr>
        <?php
        foreach ($head as $value) {
            echo "<th>{$value}</th>";
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($dados as $values) {
        echo "<tr>";
        foreach ($values as $value) {
            echo "<td align='center'>{$value}</td>";
        }
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<?php // var_dump($vendas); ?>

</body>
</html>
