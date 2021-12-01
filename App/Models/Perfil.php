<?php

namespace App\Models;

use App\Config\ConfigPerfil;
use System\Model\Model;

class Perfil extends Model
{
    protected $table = 'perfis';
    protected $timestamps = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function perfis($idUsuarioLogado = false, $idUsuarioEditado = false, $idPerfilUsuarioLogado = false)
    {
        $superAdmin = ConfigPerfil::superAdmin();
        $administrador = ConfigPerfil::adiministrador();
        $gerente = ConfigPerfil::gerente();

        /**
         * Se o usuario logado for o mesmo que está sendo editado, traz apenas o perfil vinculado a ele anteriormente
         * pois um usuario não pode mudar o seu proprio perfil.
         */
        if ($idUsuarioLogado && $idUsuarioEditado) {
            if ($idUsuarioLogado == $idUsuarioEditado) {
                return $this->query("SELECT * FROM perfis WHERE id = {$idPerfilUsuarioLogado}");
            }
        }

        /**
         * Se o usuário for um gerente, traz apenas o perfil de vendedor.
         * Pois somente o administrador pode cadastrar usuarios com outros perfis.
         */
        if ($idPerfilUsuarioLogado && $idPerfilUsuarioLogado == $gerente) {
            return $this->query("SELECT * FROM perfis WHERE id NOT IN({$superAdmin},{$administrador},{$gerente})");
        }

        /**
         * Se o usuário logado for um super admin, traz todos os perfis
         */
        if ($superAdmin == $idPerfilUsuarioLogado) {
            return $this->query("SELECT * FROM perfis");
        }

        return $this->query("SELECT * FROM perfis WHERE id != 1");
    }
}
