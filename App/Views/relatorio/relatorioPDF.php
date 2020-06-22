<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $titulo; ?></title>
  <style>
    table {
      border-collapse: collapse;
      width:100%;
      border:1px solid #666;
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
    
    <h2><?php echo $titulo; ?></h2>

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