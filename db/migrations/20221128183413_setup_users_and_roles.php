<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Ramsey\Uuid\Uuid;
use Bcrypt\Bcrypt;

final class SetupUsersAndRoles extends AbstractMigration
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
        $users = $this->table('users', ['id' => false, 'primary_key' => 'id']);
        $users
            ->addColumn('id', 'uuid', ['null' => false]) 
            ->addColumn('firstName', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('lastName', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('approved', 'enum', ['values' => ['0', '1'], 'default' => '0'])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('question1', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('question2', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('question3', 'string', ['limit' => 50, 'null' => false])
            ->addIndex(['email'], ['unique' => true]);
        $users->create();

        $roles = $this->table('roles', ['id' => false, 'primary_key' => 'id']);
        $roles
            ->addColumn('id', 'uuid', ['null' => false]) 
            ->addColumn('role_name', 'string', ['limit' => 50])
            ->addColumn('create_user', 'boolean', ['default' => 0,'signed' => false])
            ->addColumn('create_table', 'boolean', ['default' => 0,'signed' => false])
            ->addColumn('delete_user', 'boolean', ['default' => 0,'signed' => false])
            ->addColumn('delete_table', 'boolean', ['default' => 0,'signed' => false])
            ->addColumn('view_users', 'boolean', ['default' => 0, 'signed' => false])
            ->addColumn('updatedatabase', 'boolean', ['default' => 0, 'signed' => false]);
        $roles->create();

        $user_roles = $this->table('userRoles');
        $user_roles 
            ->addColumn('role_id', 'uuid', ['null' => true,'signed' => false]) 
            ->addColumn('user_id', 'uuid', ['null' => true, 'signed' => false])   
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
            ->addForeignKey('role_id', 'roles', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION']);
        $user_roles->create();

        $bcrypt = new Bcrypt();

        $adminRole = [
            'id' => Uuid::uuid4(),
            'role_name' => 'Admin',
            'create_user' => 1,
            'create_table' => 1,
            'delete_user' => 1,
            'delete_table' => 1,
            'view_users' => 1,
            'updatedatabase' => 1
        ];

        $defaultRole = [
            'id' => Uuid::uuid4(),
            'role_name' => 'Default',
            'create_user' => 0,
            'create_table' => 0,
            'delete_user' => 0,
            'delete_table' => 0,
            'view_users' => 0,
            'updatedatabase' => 0
        ];

        $adminUser = [
            'id' => Uuid::uuid4(),
            'firstName' => 'Admin',
            'lastName' => '',
            'approved' => '1',
            'password' => $bcrypt->encrypt('admin', '2y'),
            'email' => 'Admin@Admin.com',
            'question1' => '',
            'question2' => '',
            'question3' => ''
        ];

        $adminUserRole = [
            'role_id' => $adminRole['id'],
            'user_id' => $adminUser['id']
        ];

        $users->insert($adminUser)->saveData();
        $roles->insert($adminRole)->saveData();
        $roles->insert($defaultRole)->saveData();
        $user_roles->insert($adminUserRole)->saveData();
    }
}
