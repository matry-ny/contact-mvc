<?php

namespace console\models;

use components\Model;
use helpers\Config;
use helpers\Files;

/**
 * Class Migration
 * @package console\models
 */
class Migration extends Model
{
    /**
     * @var string
     */
    public $primaryKey = 'id';

    /**
     * @var string
     */
    public $table  = 'migrations';

    /**
     * @var array
     */
    protected $attributes = ['id' => null, 'migration' => null, 'created_at' => null];

    /**
     * @param string $name
     * @return bool
     */
    public function isMigrationFileExists($name)
    {
        $migrations = Files::getDirectoryContent(Config::getInstance()->get('migrationsDir'));
        $pattern ="/^m[0-9]+_{$name}\\.php$/";
        foreach ($migrations as $migration) {
            preg_match($pattern, $migration, $matches);
            if ($matches) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $name
     * @return int
     */
    public function createMigrationFile($name)
    {
        $className = 'm' . time() . '_' . $name;
        $content = <<<PHP
<?php

namespace console\migrations;

use components\Model;

/**
 * Class $className
 * @package console\migrations;
 */
class $className extends Model
{
    public function up()
    {
    }
    
    public function down()
    {
    }
}
PHP;
        return Files::create(Config::getInstance()->get('migrationsDir'), "{$className}.php", $content);

    }

    /**
     * @return array
     */
    public function getNewMigrations()
    {
        $allMigrations = Files::getDirectoryContent(Config::getInstance()->get('migrationsDir'));
        $executedMigrations = [];
        foreach ($this->query("SELECT migration FROM migrations") as $row) {
            $executedMigrations[] = $row['migration'];
        }


        return array_diff($allMigrations, $executedMigrations);
    }

    /**
     * @param $quantity
     * @return array
     */
    public function getDeprecatedMigrations($quantity)
    {
        $deprecatedMigrations = [];
        foreach ($this->query("SELECT migration FROM migrations ORDER BY created_at DESC LIMIT {$quantity}") as $row) {
            $deprecatedMigrations[] = $row['migration'];
        }

        return $deprecatedMigrations;
    }
}