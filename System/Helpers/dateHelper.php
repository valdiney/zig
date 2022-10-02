<?php
function dateFormat($date = null)
{
    # Converting date to USA standard
    if (strpos($date, "/")) {
        $date = explode("/", $date);
        return $date[2] . "-" . $date[1] . "-" . $date[0];
    }

    # Converting date to BR standard
    if (strpos($date, "-")) {
        $date = explode("-", $date);
        return $date[2] . "/" . $date[1] . "/" . $date[0];
    }
}

function timestamp()
{
    return date('Y-m-d H:i:s');
}

function decrementDaysFromDate($returnFormat, $days = 1, $date = false)
{

    if (!$date) {
        $date = date('Y-m-d');
    }

    return date('Y-m-d', strtotime("-{$days} days", strtotime($date)));
}

function decrementMonthtFromDate($month = 1, $date = false)
{
    if (!$date) {
        $date = date('Y-m-d');
    }

    return date('m', strtotime("-{$month} month", strtotime($date)));
}

# Retorna os números dos meses juntamente com o nome do mês por Extenso
# Se vier com zero (0) o zero é retirado
function mesesPorExtensoEnumeroDoMes($mes = false)
{
    $explode = explode('0', $mes);
    $numeroMes = $mes;
    if (array_key_exists(1, $explode) && $mes != 10) {
        $numeroMes = $explode[1];
    }

    $meses = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];

    if ($mes) {
        return $meses[$numeroMes];
    }

    return $meses;
}

# Recebe o formato d/m/Y
function diaSemana($data)
{
    $dia = substr($data, 0, 2);
    $mes = substr($data, 3, 2);
    $ano = substr($data, 6, 9);
    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
    switch ($diasemana) {
        case "0":
            $diasemana = "Domingo";
            break;
        case "1":
            $diasemana = "Segunda-Feira";
            break;
        case "2":
            $diasemana = "Terça-Feira";
            break;
        case "3":
            $diasemana = "Quarta-Feira";
            break;
        case "4":
            $diasemana = "Quinta-Feira";
            break;
        case "5":
            $diasemana = "Sexta-Feira";
            break;
        case "6":
            $diasemana = "Sábado";
            break;
    }

    return $diasemana;
}
