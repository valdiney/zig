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
            font-size:12px;
        }
        table, th, td {
            border: 1px solid black;
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

<center><h2 style="margin-bottom:3"><?php echo $this->getEmpresa()->nome;?></h2></center>
<center>
    <h4 style="margin-top:0;opacity:0.70"><?php echo $titulo; ?></h4>
    <small style="opacity:0.50">Gerado em: <?php echo date('d/m/Y');?> às <?php echo date('H:i');?></small>
</center>
<hr style="border:1px dotted silver">

<center>
    <span style="opacity:0.70"><b>Total Vendido: R$ <?php echo real($this->getTotalVendas());?></b></span>
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
            $i = 0;
            foreach ($dados as $values) {
                $i++;
                echo "<tr>";
                foreach ($values as $value) {

                    if ($i % 2 == 0) {
                        echo "<td align='center' style='background:#eeeaea'>{$value}</td>";
                    } else {
                        echo "<td align='center'>{$value}</td>";
                    }
                }
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

</body>
</html>
