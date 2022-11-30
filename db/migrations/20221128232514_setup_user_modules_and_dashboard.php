<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SetupUserModulesAndDashboard extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $modules = $this->table('modules', ['id' => false, 'primary_key' => 'id']);
        $modules
            ->addColumn('id', 'uuid', ['null' => false]) 
            ->addColumn('module_name', 'string', ['limit' => 50]);
        $modules->create();

        $user_modules = $this->table('userModules');
        $user_modules
            ->addColumn('module_id', 'uuid', ['null' => true,'signed' => false]) 
            ->addColumn('user_id', 'uuid', ['null' => true, 'signed' => false])   
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
            ->addForeignKey('module_id', 'modules', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION']);
        $user_modules->create();

    }
}
