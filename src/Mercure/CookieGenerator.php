<?php

namespace App\Mercure;

use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Symfony\Component\HttpFoundation\Cookie;

class CookieGenerator
{
    private $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function generate(): Cookie
    {
        $token = (new Builder(new JoseEncoder(), ChainedFormatter::default()))
            ->withClaim('mercure', ['subscribe' => ['*']])
            ->getToken(new Sha256(), InMemory::plainText($this->secret));


        return Cookie::create('mercureAuthorization', $token->toString(), 0, '/.well-known/mercure');
    }
}
