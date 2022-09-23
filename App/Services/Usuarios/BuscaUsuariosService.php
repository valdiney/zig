<?php

namespace App\Services\Usuarios;

use App\Models\Usuario;
use stdClass;

class BuscaUsuariosService
{
    /** Usuario */
    private $usuariosModel;

    public function __construct()
    {
        $this->usuariosModel = new Usuario();
    }

    public function ativos(int $idEmpresa, int $idPerfilUsuarioLogado): array
    {
        $usuarios = $this->usuariosModel->usuarios($idEmpresa, $idPerfilUsuarioLogado);
        $usuarios = $usuarios && is_array($usuarios) === false? []: $usuarios;

        if (empty($usuarios)) {
            return $usuarios;
        }
        return array_filter($usuarios, static function (stdClass $usuario) {
            return $usuario->deleted_at === null || $usuario->deleted_at == '0000-00-00 00:00:00';
        });
    }
}
