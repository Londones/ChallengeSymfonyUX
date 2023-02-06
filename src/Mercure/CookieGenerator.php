<?php

namespace App\Mercure;

use Symfony\Component\HttpFoundation\Cookie;
use \Firebase\JWT\JWT;

class CookieGenerator
{
    private $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function generate(): Cookie
    {
        $payload = [
            "mercure" => [
                "publish" => ["*"]
            ],
        ];
        $jwt = JWT::encode($payload, $this->secret, "HS256");

        return Cookie::create('mercureAuthorization', $jwt, 0, '/.well-known/mercure');
    }
}
