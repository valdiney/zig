<?php

namespace System\Infra\Request;

use System\Aplicacao\Request\Request;
use System\Aplicacao\Request\RequestBase;

class CadastroExemploRequest extends RequestBase
{
    public function __construct(Request $request = null)
    {
        parent::__construct();
        $this->setRequest($request);
    }

    public function acessoAutorizado(): bool
    {
        return (int) $this->request->get("role_id") === 1;
    }

    public function campos(): array
    {
        return [
            "role_id",
        ];
    }
}
