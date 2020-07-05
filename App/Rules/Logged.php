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

    public function isValid($automaticRedirection = true)
    {
        if (Session::hasSession('logged')) {
            return true;
        }
        if ($automaticRedirection) {
          $this->get->redirectTo("");
        }
    }
}
