<?php

namespace App\Containers\Auth\Repository;

use Rudra\Model\QBFacade;
use Rudra\Model\Repository;

class UsersRepository extends Repository
{
    public function getUser(string $email): ?array
    {
        $qString = QBFacade::select()
            ->from($this->table)
            ->where("email = :email")
            ->get();

        return $this->qBuilder($qString, [
            ':email' => $email,
        ]);
    }
}
