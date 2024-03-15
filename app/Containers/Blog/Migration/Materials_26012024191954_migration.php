<?php

namespace App\Containers\Blog\Migration;

use Rudra\Container\Facades\Rudra;

class Materials_26012024191954_migration
{
    public function up(): void
    {
        $table = "materials";

        $query = Rudra::get("DSN")->prepare("
            CREATE TABLE {$table} (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `slug` VARCHAR(255) NOT NULL , 
            `title` VARCHAR(255) NOT NULL , 
            `text` TEXT ,
            `image` VARCHAR(255) NOT NULL DEFAULT '',
            `status` INT NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci
        ");

        $query->execute();
    }
}
