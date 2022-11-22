<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PermissionsTableMigration extends AbstractMigration
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
        $user_roles = $this->table('userRoles');
        $user_roles -> addColumn('role_id', 'integer', ['null' => true,'signed' => false]) 
                    -> addColumn('user_id', 'integer', ['null' => true, 'signed' => false])   
                    ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
                    ->addForeignKey('role_id', 'roles', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
                    ->save();
    }
}
