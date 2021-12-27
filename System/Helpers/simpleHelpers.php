<?php

use System\Utils\Sanitize;

function createMessage($e)
{
    echo "
		<style>body{background:#f1f1f1;}</style>
		<center>
			<span style='border:1px solid red;display:block;padding:10px;background:white;font-family:arial;'>
			    Message: {$e->getMessage()}
			</span>
		</center>";
    exit;
}

function dd($data)
{
    if (is_null($data) && !defined('IS_TERMINAL')) {
        echo "<style>body {background:black;}</style>";
        echo "<pre style='background:#f4f5f7;border:3px solid #00cc99;padding:10px'>";
        print_r('bool(NULL)');
        exit;

    } elseif ($data === true && !defined('IS_TERMINAL')) {
        echo "<style>body {background:black;}</style>";
        echo "<pre style='background:#f4f5f7;border:3px solid #00cc99;padding:10px'>";
        print_r('bool(TRUE)');
        exit;

    } elseif ($data === false && !defined('IS_TERMINAL')) {
        echo "<style>body {background:black;}</style>";
        echo "<pre style='background:#f4f5f7;border:3px solid #00cc99;padding:10px'>";
        print_r('bool(FALSE)');
        exit;
    }

    if (!defined('IS_TERMINAL')) {
        echo "<style>body {background:black;}</style>";
        echo "<pre style='background:#f4f5f7;border:3px solid #00cc99;padding:10px'>";
    }
    print_r($data);
    exit;
}

function dump($data)
{
    var_dump($data);
    exit;
}

function createHash($password = null)
{
    $oldSalt = "dfddfdfddfd;dfdfd45654;df45541254sdsdw";
    $oldUnicSalt = "awsqkx12454788956sddef$";
    // adicionando verificação para os antigos sistemas que já tem senhas salvas no banco
    $hash = getenv('HASH');
    $salt = $hash ? $hash : $oldSalt;
    $unicSalt = $hash ? strrev($hash) : $oldUnicSalt;
    return sha1("{$password}{$salt}{$unicSalt}");
}

function uploadImageHelper($uploadClass, $folder, $image)
{
    $uploadClass->file($image);
    $uploadClass->folder($folder);
    $uploadClass->extensions(array("png", "jpg", "jpeg"));

    $error = null;
    switch ($uploadClass->getErrors()) {
        case 1:
            $error = "Formato não esperado";
            break;
        case 2:
            $error = "O tamanho limite para Upload é de 4MB";
            break;
        case 3:
            $error = "Formato não identificado. Por favor, tente novamente.";
            break;
        case 4:
            $error = "Erro interno. Diretório não encontrado.";
            break;
    }

    try {

        if ($error !== null) {
            throw new \Exception($error);
        }

        $uploadClass->move();

    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }

    return $uploadClass->destinationPath();
}

function in64($string)
{
    $string = "atzxyzendMosterw||zig" . $string;
    return base64_encode($string);
}

function out64($string)
{
    $auxiliar = base64_decode($string) ?? null;

    if ($string) {
        return explode('||zig', $auxiliar)[1];
    }
    return false;
}

/*
Formata o valor para Real antes de apresentar na View
*/
function real($valor)
{
    return number_format($valor, 2, ',', '.');
}

/*
Essa função prepara o valor da moeda pora ser gravado no banco
Exemplo: Tranforma o valor ( 2.440,80 ) em ( 2440.80 )
*/
function formataValorMoedaParaGravacao($valor)
{
    $verificaPonto = ".";
    if (strpos("[" . $valor . "]", "$verificaPonto")) {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
    } else {
        $valor = str_replace(',', '.', $valor);
    }

    return $valor;
}

function currentRouteFromMenu($route, $extraClass = false)
{
    $route = explode('/', $route);
    $controller = explode('Controller', CONTROLLER_NAME)[0];
    $method = METHOD_NAME;

    if (ucfirst($route[0]) == $controller && (!isset($route[1]) || $route[1] == $method)) {
        echo "currentRouteFromMenu {$extraClass}";
    }
}

function fileGet($url)
{
    $context = stream_context_create([
        'http' => [
            'ignore_errors' => true,
            'method' => 'GET'
        ]
    ]);

    $jsonFile = file_get_contents($url, false, $context);
    return json_decode($jsonFile, true);
}


function iconFilter()
{
    echo '<i class="fas fa-filter"></i>';
}

if (function_exists("sanitize") === false)
{
    /**
     * @param $value
     * @return mixed
     */
    function sanitize($value)
    {
        return Sanitize::value($value);
    }
}

if (function_exists("sanitizeMany") === false)
{
    /**
     * @param array $data
     * @return mixed
     */
    function sanitizeMany(array $data): array
    {
        return array_map("sanitize", $data);
    }
}

function gerarCodigoDeBarrasEmPng($codigo)
{
    $gerador = new \Picqer\Barcode\BarcodeGeneratorPNG();
    $barCode = $gerador->getBarcode($codigo, $gerador::TYPE_CODE_128);
    echo "data:image/png;base64,".base64_encode($barCode);
}

function stringAbreviation($string, $length, $end)
{
    $output = str_split($string, $length);
    return $output[0].$end;
}
