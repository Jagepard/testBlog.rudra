<?php

namespace App\Containers\Blog\Migrations;

use Rudra\Container\Facades\Rudra;

class Materials_26012024191954_migration
{
    public function up()
    {
        $table = "materials";

        $query = Rudra::get("DSN")->prepare("
            CREATE TABLE {$table} (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `slug` VARCHAR(255) NOT NULL , 
            `title` VARCHAR(255) NOT NULL , 
            `text` TEXT ,
            `status` INT NOT NULL ,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci
        ");

        $query->execute();
    }
}