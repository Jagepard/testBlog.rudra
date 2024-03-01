<?php

namespace App\Containers\Auth\Repository;

use Rudra\Model\QBFacade;
use Rudra\Model\Repository;
use App\Containers\Auth\Models\Users;

class UsersRepository extends Repository
{
    public function getUser(string $email)
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
