<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{

    public function onCheckPassport(CheckPassportEvent $event)
    {
        //* le passeport contient l'objet user
        $passport = $event->getPassport();
        $user = $passport->getUser();

        if (!$user instanceof User) {
            throw new \Exception('Unexpected user type');
        }

        //*si l'émail n'est pas vérifié, renvoyer une erreur et throw une exception
        if (!$user->isIsEmailVerified()) {
            throw new CustomUserMessageAuthenticationException(
                'Veuillez valider votre compte afin de pouvoir vous connecter :)'
            );
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10]
        ];
    }
}
