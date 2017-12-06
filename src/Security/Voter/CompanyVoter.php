<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CompanyVoter extends Voter
{
    public const UPDATE_PRICE = 'updatePrice';
    public const CREATE = 'create';
    public const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        return \in_array($attribute, [self::UPDATE_PRICE, self::EDIT], true)
            && $subject instanceof \App\Entity\Company;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'updatePrice':
                return true;
        }

        return false;
    }
}
