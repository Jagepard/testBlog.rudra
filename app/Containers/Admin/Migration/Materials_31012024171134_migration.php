<?php

namespace App\Containers\Admin\Migration;

use Rudra\Container\Facades\Rudra;

class Materials_31012024171134_migration
{
    public function up()
    {
        $table = "materials";

        $query = Rudra::get("DSN")->prepare("
            ALTER TABLE {$table} ADD `image` VARCHAR(255) NOT NULL AFTER `text`; 
        ");

        $query->execute();
    }
}
