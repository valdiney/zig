<?php
namespace App\Models;

use System\Database\Model;

class Clientes extends Model
{
  protected $table = 'clientes';
  protected $timestamps = true;

  public function clientes($idEmpresa)
  {
    return $this->as('cl')
    ->select(
      'cl.id', 'cl.nome', 'cl.email', 'cl.cnpj', 'cl.cpf', 'cl.telefone', 'cl.celular', 'cl.deleted_at',
      'cs.id AS idSegmento', 'cs.descricao AS descricaoSegmento',
      'ct.id AS idClienteTipo', 'ct.descricao AS descricaoClienteTipo'
    )
    ->join('LEFT JOIN clientes_segmentos AS cs ON cl.id_cliente_segmento = cs.id')
    ->join('LEFT JOIN clientes_tipos AS ct ON cl.id_cliente_tipo = ct.id')
    ->where('cl.id_empresa', $idEmpresa)
    ->get();
  }

  public function verificaSeEmailExiste($email)
  {
    if ( ! $email) {
      return false;
    }

    $query = $this->query("SELECT * FROM clientes WHERE email = '{$email}'");
    if (count($query) > 0) {
      return true;
    }

    return false;
  }

  public function verificaSeCnpjExiste($cnpj)
  {
    if ( ! $cnpj) {
      return false;
    }

    $query = $this->query("SELECT * FROM clientes WHERE cnpj = '{$cnpj}'");
    if (count($query) > 0) {
      return true;
    }

    return false;
  }

  public function verificaSeCpfExiste($cpf)
  {
    if ( ! $cpf) {
      return false;
    }

    $query = $this->query("SELECT * FROM clientes WHERE cpf = '{$cpf}'");
    if (count($query) > 0) {
      return true;
    }

    return false;
  }

  public function seDadoNaoPertenceAoClienteEditado($nomeDoCampo, $valor, $idCliente)
  {
    $dadosCliente = $this->findBy("{$nomeDoCampo}", $valor);
    if ($dadosCliente && $idCliente != $dadosCliente->id) {
      return true;
    }

    return false;
  }
}
