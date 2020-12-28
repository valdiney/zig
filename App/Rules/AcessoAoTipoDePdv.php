<?php

namespace App\Rules;

use App\Models\ConfigPdv;
use System\Get\Get;
use System\Session\Session;

class AcessoAoTipoDePdv
{
    protected $get;

    public function __construct()
    {
        $this->get = new Get();
    }

    public function validate()
    {
        $configPdv = new ConfigPdv();
        $configPdv = $configPdv->findBy('id_empresa', Session::get('idEmpresa'));
        $rotaAtual = CONTROLLER_NAME . '/' . METHOD_NAME;

        /*
        * Se a configuração estiver setada para o PDV Diferencial e tentar acessar o PDV Padrão,
          redireciona para o PDV diferencial
        */
        if ($rotaAtual == 'PdvPadraoController/index' && $configPdv->id_tipo_pdv == 2) {
            $this->get->redirectTo("pdvDiferencial");

            /*
            * Se a configuração estiver setada para o PDV padrão e tentar acessar o PDV Diferencial,
              redireciona para o PDV padrão
            */
        } elseif ($rotaAtual == 'PdvDiferencialController/index' && $configPdv->id_tipo_pdv == 1) {
            $this->get->redirectTo("pdvPadrao");
        }

        return false;
    }
}
