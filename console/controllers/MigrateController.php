<?php

namespace console\controllers;

use components\console\Controller;
use console\models\Migration;

/**
 * Class MigrateController
 * @package console\controllers
 */
class MigrateController extends Controller
{
    /**
     * @return string
     */
    public function actionInit()
    {
        $model = new Migration();
        if ($model->getIsTableExists()) {
            return 'Migrations table is already initialized';
        }

        $model->createTable($model->table, [
            'id INT(11) NOT NULL AUTO_INCREMENT',
            'migration VARCHAR(255) NOT NULL',
            'created_at DATETIME',
            'PRIMARY KEY(`id`)'
        ]);
        return 'Migrations table initialized successfully';
    }

    /**
     * @param string $name
     * @return string
     * @throws \Exception
     */
    public function actionCreate($name)
    {
        $model = new Migration();
        if ($model->isMigrationFileExists($name)) {
            throw new \Exception("Migration '{$name}' already exists");
        }

        $model->createMigrationFile($name);
        return "Migration {$name} created successfully";
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionUp()
    {
        $model = new Migration();
        $newMigrations = $model->getNewMigrations();
        if (empty($newMigrations)) {
            throw new \Exception('Got no migrations for execute');
        }

        foreach ($newMigrations as $migration) {
            $this->printOut("{$migration}...");

            $migrationClass = vsprintf('console\\migrations\\%s', [
                substr($migration, -4) == '.php' ? substr($migration, 0, -4) : $migration
            ]);
            if (!class_exists($migrationClass)) {
                throw new \Exception("Migration class '{$migrationClass}' is not exists");
            }

            $migrationObject = new $migrationClass();
            if (!method_exists($migrationObject, 'up')) {
                throw new \Exception("Method 'up' is not exists in migration class '{$migrationClass}'");
            }

            call_user_func([$migrationObject, 'up']);

            $model = new Migration();
            $model->load(['migration' => $migration]);
            $model->save();
        }

        return "Executed with {$this->getExecutionTime()} seconds";
    }

    /**
     * @param int $quantity
     * @return string
     * @throws \Exception
     */
    public function actionDown($quantity = 1)
    {
        $model = new Migration();
        $deprecatedMigrations = $model->getDeprecatedMigrations($quantity);
        if (empty($deprecatedMigrations)) {
            throw new \Exception('Got no migrations for downgrade');
        }

        foreach ($deprecatedMigrations as $migration) {
            $this->printOut("{$migration}...");

            $migrationName = preg_replace("/_[0-9]+\\.php$/", '', $migration);
            if (!$model->isMigrationFileExists($migrationName)) {
                throw new \Exception("Migration '{$migration}' is not exists");
            }

            $migrationClass = vsprintf('console\\migrations\\%s', [
                substr($migration, -4) == '.php' ? substr($migration, 0, -4) : $migration
            ]);
            if (!class_exists($migrationClass)) {
                throw new \Exception("Migration class '{$migrationClass}' is not exists");
            }

            $migrationObject = new $migrationClass();
            if (!method_exists($migrationObject, 'down')) {
                throw new \Exception("Method 'down' is not exists in migration class '{$migrationClass}'");
            }

            call_user_func([$migrationObject, 'down']);

            $model = new Migration();
            $model->delete(['migration' => $migration]);
        }

        return "Executed with {$this->getExecutionTime()} seconds";
    }
}
