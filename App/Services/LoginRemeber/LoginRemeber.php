<?php

namespace App\Services\LoginRemeber;

use App\Models\Usuario;
use DateInterval;
use DateTime;
use Exception;

class LoginRemeber
{
    private $user;
    private $cookieName = "tonie_remember";
    private $expireDate = "P1M";

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function execute()
    {
        $data = $this->mountDataForUser();

        $this->saveUserData($data);
        $this->createCookieData($data);
    }

    /** @return array */
    private function mountDataForUser()
    {
        $hash = $this->getHashFromRemember();
        $date = $this->getExpirationDate();

        return [
            "remember_token" => $hash,
            "remember_expire_date" => $date,
        ];
    }

    /** @return string */
    private function getHashFromRemember()
    {
        return createHash(time() . $this->user->email);
    }

    /** @return string
     * @throws Exception
     */
    private function getExpirationDate()
    {
        $date = new DateTime();
        $interval = new DateInterval($this->expireDate);
        $date = $date->add($interval);
        $date = $date->format('Y-m-d H:i:s');

        return $date;
    }

    /**
     * @param array $data
     */
    private function saveUserData(array $data)
    {
        $usuario = new Usuario;
        $usuario->update($data, $this->user->id);
    }

    private function createCookieData(array $data)
    {
        $hash = $data["remember_token"];
        $expire = $data["remember_expire_date"];

        $date = new DateTime($expire);
        $expireTimestamp = $date->getTimestamp();

        $domain = pathinfo(BASEURL, PATHINFO_BASENAME);
        try {
            setcookie($this->cookieName, "{$hash}", time()+31556926, "/");

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getRememberCookie()
    {
        return isset($_COOKIE[$this->cookieName]) ? $_COOKIE[$this->cookieName] : null;
    }

    /** @return string */
    public function getCookieName(): string
    {
        return $this->cookieName;
    }

    public function deleteRememberCookie()
    {
        if (isset($_COOKIE[$this->cookieName])) {
            $domain = pathinfo(BASEURL, PATHINFO_BASENAME);

            unset($_COOKIE[$this->cookieName]);
            setcookie($this->cookieName, null, -1, "/", $domain);
        }
    }
}
