<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MyNewMigration extends AbstractMigration
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
        $table = $this->table('posts');
        $table ->addColumn('first_name', 'string', ['limit' => 50])
              ->addColumn('last_name', 'string', ['limit' => 50])
              ->addColumn('role', 'enum', ['values' => ['0', '1'], 'default' => '1'])
              ->addColumn('password', 'string', ['limit' => 255])
              ->addColumn('userID', 'string', ['limit' => 50])
              ->addColumn('question1', 'string', ['limit' => 50])
              ->addColumn('question2', 'string', ['limit' => 50])
              ->addColumn('question3', 'string', ['limit' => 50]);
        $table->create();
    }

    /*public function up()
    {
        $exists = $this->hasTable('users');
        if ($exists) {
            // do something
        }
    }*/
}
