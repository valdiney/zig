<?php

namespace System\Auth;

use System\Session\Session;

trait Auth
{
    public function loginExists($login = false)
    {
        $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE login = ?");
        $query->execute(array($login));

        if ($query->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function userExist(array $data)
    {
        if ($this->loginVerify($data)) {
            Session::set('logged', true);
            return true;
        }

        return false;
    }

    private function loginVerify(array $data)
    {
        $array = array_keys($data);
        $loginField = $array[0];
        $passwordField = $array[1];

        $query = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$loginField} = ? AND {$passwordField} = ?");
        $query->execute(array($data[$loginField], createHash($data[$passwordField])));
        return $query->rowCount();
    }
}
