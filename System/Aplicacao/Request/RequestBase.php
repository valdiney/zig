<?php

namespace System\Aplicacao\Request;

use InvalidArgumentException;

abstract class RequestBase
{
    /** @var Request */
    protected $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->request->setDefaults();
    }

    protected function setRequest(Request $request = null): void
    {
        if ($request) {
            $this->request = $request;
        }
    }

    public function __destruct()
    {
        if (empty($this->campos())) {
            return;
        }
        $valoresAtuais = array_merge($this->request->get(), $this->request->post());

        $valoresNaoEncontrados = array_filter($this->campos(), function (string $campo) use ($valoresAtuais) {
            return $this->checkCampoExiste($campo, $valoresAtuais);
        });

        if (empty($valoresNaoEncontrados) === false) {
            $valores = implode(",", $valoresNaoEncontrados);
            throw new InvalidArgumentException("Alguns valores são obrigatórios na requisição: {$valores}");
        }
    }

    private function checkCampoExiste(string $value, array $data): bool
    {
        if (empty($data)) {
            return true;
        }
        return isset($data[$value]) === false;
    }

    /**
     * @return bool
     */
    abstract public function acessoAutorizado(): bool;

    /**
     * @return array
     */
    abstract public function campos(): array;
}
