<?php

namespace System\CommandLine;

use Exception;
use System\Model\Model;

class Hash extends Model
{
  protected $file;

  public function __construct()
  {
    parent::__construct();
    $this->file = __DIR__.'/../../.env';
    $this->verifyHasUsers();
    //
    if (!file_exists($this->file)) {
      echo "Arquivo .env não encontrado!";
      exit;
    }
    if (!getenv('HASH')) {
      return $this->colocaHashNoEnv();
    }
    echo "Você já possui um hash!\n";
  }

  protected function verifyHasUsers()
  {
    if (!$this->verifyDatabasexists()) {
      return;
    }
    $smtp  = $this->query("SELECT COUNT(*) as count FROM usuarios LIMIT 0,1;");
    $count = $smtp[0]->count;
    if (!$count) {
      return;
    }
    echo "\n-------------------- ATENÇÃO --------------------\n";
    echo "   Você possui registros no banco de dados!\n";
    echo "   Criar um novo hash de senhas fará com que\n";
    echo "   as antigas senhas não funcionem!\n\n";
    echo "   Caso deseje prosseguir todos os usuários\n";
    echo "   devem ser recadastrados utilizando o novo hash.";
    echo "\n-------------------------------------------------\n";
    $response = readline("Deseja prosseguir mesmo assim? [N/y]: ");
    $response = $response? $response: 'n';
    $response = strtolower($response);
    if ($response == 'n') {
      echo "Ok! Nada será mudado! ;)\n";
      exit;
    }
    echo "Criando novo hash de senha! :D\n";
  }

  protected function verifyDatabasexists()
  {
    $exists = false;
    try {
      $this->query("SHOW TABLES");
      $exists = true;
    } catch (Exception $e) {
      //
    }
    return $exists;
  }

  protected function colocaHashNoEnv()
  {
    $hash = $this->generateHash();
    $data = "\nHASH=\"{$hash}\"\n";
    file_put_contents($this->file, $data, FILE_APPEND);
    echo "HASH gerado com sucesso!\n";
    echo "--------------\n";
    echo "- HASH: {$hash}\n";
    echo "--------------\n";
  }

  protected function generateHash(int $length = 38): string
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#%*';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}
