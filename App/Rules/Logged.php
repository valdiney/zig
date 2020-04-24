<?php
namespace App\Rules;
use System\Get\Get;
use System\Session\Session;

class Logged
{
    protected $get;

    public function __construct()
    {
        $this->get = new Get();
    }

    public function validate()
    {
        if ( ! Session::hasSession('logged')) {
            $this->get->redirectTo("");
        } 

        return false;
    }
}