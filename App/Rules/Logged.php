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

    public function isValid()
    {
        if (Session::hasSession('logged')) {
            return true;  
        } else {
            $this->get->redirectTo("");
        }  
    }
}