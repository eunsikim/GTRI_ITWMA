<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserRolesTableMigration extends AbstractMigration
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
        $roles = $this->table('roles');
        $roles
              ->addColumn('role_name', 'string', ['limit' => 50])
              ->addColumn('create_user', 'boolean', ['default' => 0,'signed' => false])
              ->addColumn('create_table', 'boolean', ['default' => 0,'signed' => false])
              ->addColumn('delete_user', 'boolean', ['default' => 0,'signed' => false])
              ->addColumn('delete_table', 'boolean', ['default' => 0,'signed' => false])
              ->addColumn('view_users', 'boolean', ['default' => 0, 'signed' => false])
              ->addColumn('updatedatabase', 'boolean', ['default' => 0, 'signed' => false]);
        $roles->save();
    }
}
