<?php

namespace App\Security;

use App\Entity\Items;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class VerificationRequestVoter extends Voter
{
    const EDIT = 'edit';
    const CREATE = 'create';


    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::CREATE, self::EDIT])) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        /** @var Items $item */
        $item = $subject;

        return match($attribute) {
            self::CREATE => $this->canCreate($item, $user),
            self::EDIT => $this->canEdit($user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canCreate(Items $item, User $user): bool
    {
       if ($user->getId() === $item->getOwner()) {
           return true;
       }

       return false;

    }

    private function canEdit(User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        if (in_array('ROLE_AUTHENTIFICATOR', $user->getRoles())) {
            return true;
        }   

        return false;
    }
}