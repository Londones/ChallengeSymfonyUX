<?php

namespace App\Mercure;

use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;

class JwtProvider
{
    private $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function __invoke(): string
    {
        return (new Builder(new JoseEncoder(), ChainedFormatter::default()))
            ->withClaim('mercure', ['publish' => ['*']])
            ->getToken(new Sha256(), InMemory::plainText($this->secret))
            ->toString();
    }
}
