<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserFix extends AbstractMigration
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
            
        $users->save();
    }
}
