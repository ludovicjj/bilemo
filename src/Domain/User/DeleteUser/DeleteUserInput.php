<?php

namespace App\Domain\User\DeleteUser;

use App\Domain\Entity\User;

class DeleteUserInput
{
    /** @var User */
    protected $user;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return DeleteUserInput
     */
    public function setUser(User $user): DeleteUserInput
    {
        $this->user = $user;
        return $this;
    }
}