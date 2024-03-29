<?php

namespace App\Ship\Command;

use App\Ship\Utils\FileCreator;
use Rudra\Container\Facades\Rudra;
use Rudra\Cli\ConsoleFacade as Cli;

class CreateMigrationCommand extends FileCreator
{
    /**
     * Creates a file with Migration data
     * -----------------------------
     * Создает файл с данными Migration
     */
    public function actionIndex(): void
    {
        Cli::printer("Enter table name: ", "magneta");
        $table = str_replace(PHP_EOL, "", Cli::reader());

        Cli::printer("Enter container (empty for Ship): ", "magneta");
        $container = ucfirst(str_replace(PHP_EOL, "", Cli::reader()));

        $date      = date("_dmYHis");
        $className = ucfirst($table) . $date;

        if (!empty($container)) {

            $namespace = 'App\Containers\\' . $container . '\Migration';

            if (Rudra::get("DSN")->getAttribute(\PDO::ATTR_DRIVER_NAME) === "mysql") {
                $this->writeFile([str_replace('/', DIRECTORY_SEPARATOR, Rudra::config()->get('app.path') . "/app/Containers/" . $container . "/Migration/"), "{$className}_migration.php"],
                    $this->createMysqlMigration($className, $table, $namespace)
                );
            } elseif (Rudra::get("DSN")->getAttribute(\PDO::ATTR_DRIVER_NAME) === "pgsql") {
                $this->writeFile([str_replace('/', DIRECTORY_SEPARATOR, Rudra::config()->get('app.path') . "/app/Containers/" . $container . "/Migration/"), "{$className}_migration.php"],
                    $this->createPgsqlMigration($className, $table, $namespace)
                );
            } elseif (Rudra::get("DSN")->getAttribute(\PDO::ATTR_DRIVER_NAME) === "sqlite") {
                $this->writeFile([str_replace('/', DIRECTORY_SEPARATOR, Rudra::config()->get('app.path') . "/app/Containers/" . $container . "/Migration/"), "{$className}_migration.php"],
                    $this->createSqliteMigration($className, $table, $namespace)
                );
            }

        } else {

            $namespace = "App\Ship\Migration";

            if (Rudra::get("DSN")->getAttribute(\PDO::ATTR_DRIVER_NAME) === "mysql") {
                $this->writeFile([str_replace('/', DIRECTORY_SEPARATOR, Rudra::config()->get('app.path') . "/app/Ship/Migration/"), "{$className}_migration.php"],
                    $this->createMysqlMigration($className, $table, $namespace)
                );
            } elseif (Rudra::get("DSN")->getAttribute(\PDO::ATTR_DRIVER_NAME) === "pgsql") {
                $this->writeFile([str_replace('/', DIRECTORY_SEPARATOR, Rudra::config()->get('app.path') . "/app/Ship/Migration/"), "{$className}_migration.php"],
                    $this->createPgsqlMigration($className, $table, $namespace)
                );
            } elseif (Rudra::get("DSN")->getAttribute(\PDO::ATTR_DRIVER_NAME) === "sqlite") {
                $this->writeFile([str_replace('/', DIRECTORY_SEPARATOR, Rudra::config()->get('app.path') . "/app/Ship/Migration/"), "{$className}_migration.php"],
                    $this->createSqliteMigration($className, $table, $namespace)
                );
            }
        }
    }

    /**
     * Creates class data
     * ------------------
     * Создает данные класса
     *
     * @param string $className
     * @param string $table
     * @param string $namespace
     * @return string
     */
    private function createMysqlMigration(string $className, string $table, string $namespace): string
    {
        return <<<EOT
<?php

namespace $namespace;

use Rudra\Container\Facades\Rudra;

class {$className}_migration
{
    public function up(): void
    {
        \$table = "$table";

        \$query = Rudra::get("DSN")->prepare("
            CREATE TABLE {\$table} (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci
        ");

        \$query->execute();
    }
}\r\n
EOT;
    }

    /**
     * Creates class data
     * ------------------
     * Создает данные класса
     *
     * @param string $className
     * @param string $table
     * @param string $namespace
     * @return string
     */
    private function createPgsqlMigration(string $className, string $table, string $namespace): string
    {
        return <<<EOT
<?php

namespace $namespace;

use Rudra\Container\Facades\Rudra;

class {$className}_migration
{
    public function up(): void
    {
        \$table = "$table";

        \$query = Rudra::get("DSN")->prepare("

            CREATE TABLE {\$table} (
                id serial PRIMARY KEY,
                created_at TIMESTAMP NOT NULL,
                updated_at TIMESTAMP NOT NULL
            );
        ");

        \$query->execute();
    }
}\r\n
EOT;
    }

    /**
     * Creates class data
     * ------------------
     * Создает данные класса
     *
     * @param string $className
     * @param string $table
     * @param string $namespace
     * @return string
     */
    private function createSqliteMigration(string $className, string $table, string $namespace): string
    {
        return <<<EOT
<?php

namespace $namespace;

use Rudra\Container\Facades\Rudra;

class {$className}_migration
{
    public function up(): void
    {
        \$table = "$table";

        \$query = Rudra::get("DSN")->prepare("

            CREATE TABLE IF NOT EXISTS {\$table} (
                id INTEGER PRIMARY KEY,
                created_at TEXT NOT NULL,
                updated_at TEXT NOT NULL
            );
        ");

        \$query->execute();
    }
}\r\n
EOT;
    }
}
