<?php

namespace App\Models;

use App\Config\ConfigPerfil;
use System\Auth\Auth;
use System\Model\Model;

class Usuario extends Model
{
    use Auth;

    protected $table = 'usuarios';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function usuarios($idEmpresa, $idUsuarioLogado = false, $idPerfilUsuarioLogado = false)
    {
        $superAdmin = ConfigPerfil::superAdmin();
        $administrador = ConfigPerfil::adiministrador();
        $gerente = ConfigPerfil::gerente();
        $vendedor = ConfigPerfil::vendedor();

        # Se o perfil do Usuário logado não for (superAdmin), não traz Usuários com perfil (superAdmin)
        $queryCondicional = false;
        if ($idPerfilUsuarioLogado && $idPerfilUsuarioLogado != $superAdmin) {
            $queryCondicional = " AND usuarios.id_perfil NOT IN({$superAdmin})";
        }

        # Se o perfil do Usuário logado for de vendedor, mostra apenas os dados do proprio Usuário
        if ($idPerfilUsuarioLogado && $idPerfilUsuarioLogado == $vendedor) {
            $queryCondicional = " AND usuarios.id = {$idUsuarioLogado}";
        }

        return $this->query(
            "SELECT
            usuarios.id AS id, usuarios.nome,
            usuarios.email, usuarios.id_sexo,
            usuarios.created_at, usuarios.imagem,
            usuarios.deleted_at,
            sexos.descricao, perfis.descricao AS perfil

            FROM usuarios INNER JOIN sexos ON
                usuarios.id_sexo = sexos.id
            INNER JOIN perfis ON usuarios.id_perfil = perfis.id
            WHERE usuarios.id_empresa = {$idEmpresa} {$queryCondicional}"
        );
    }

    public function verificaSeEmailExiste($email)
    {
        if (!$email) {
            return false;
        }

        $query = $this->query("SELECT * FROM usuarios WHERE email = '{$email}'");
        if (count($query) > 0) {
            return true;
        }

        return false;
    }

    public function seDadoNaoPertenceAoUsuarioEditado($nomeDoCampo, $valor, $idUsuario)
    {
        $dadosUsuario = $this->findBy("{$nomeDoCampo}", $valor);
        if ($dadosUsuario && $idUsuario != $dadosUsuario->id) {
            return true;
        }

        return false;
    }

    public function usuariosPorIdEmpresa($idEmpresa)
    {
        return $this->query("SELECT * FROM usuarios WHERE id = {$idEmpresa}");
    }
}
