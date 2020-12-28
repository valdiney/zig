<?php

namespace App\Services\JwtService;

use Lcobucci\JWT\Builder;

class JwtService
{
    public function createJwt($idUsuario)
    {
        $time = time();

        $token = (new Builder())->issuedBy('http://example.com')
            ->permittedFor('http://example.org')
            ->identifiedBy('zig3347Money', true)
            ->issuedAt($time)
            ->canOnlyBeUsedAfter($time + 60)
            ->expiresAt($time + 3600)
            ->withClaim('uid', $idUsuario);

        return $token->getToken();
    }

    public function tokenVerify($token)
    {

    }
}
