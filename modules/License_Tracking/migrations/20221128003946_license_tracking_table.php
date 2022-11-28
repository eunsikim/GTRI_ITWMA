<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

use Ramsey\Uuid\Uuid;

final class LicenseTrackingTable extends AbstractMigration
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
        $licenses = $this->table('License_Tracking', ['id' => false, 'primary_key' => 'id']);

        $licenses
            -> addColumn('id', 'uuid', ['null' => false])
            -> addColumn('name', 'string', ['limit' => 50, 'null' => false])
            -> addColumn('version', 'string', ['limit' => 50, 'null' => false])
            -> addColumn('totalPurchased', 'integer', ['null' => false])
            -> addColumn('managedInstallations', 'integer', ['null' => false])
            -> addColumn('complianceStatus', 'enum', ['values' => ['Under Licensed', 'Over Licensed', 'In Compliance'], 'default' => 'In Compliance'])
            -> addColumn('networkInstallations', 'integer', ['null' => false]);
        
        $licenses->create();

        //Inserting sample data
        $data = [
            [
                'id' => Uuid::uuid4(),
                'name' => '7-Zip 16.04 (x64 Edition)',
                'version' => '16.04.00.0',
                'totalPurchased' => 5,
                'managedInstallations' => 7,
                'complianceStatus' => 'Under Licensed',
                'networkInstallations' => 7
            ],
            [
                'id' => Uuid::uuid4(),
                'name' => 'Adobe Acrobat DC (2015)',
                'version' => '15.006.30306',
                'totalPurchased' => 22,
                'managedInstallations' => 1,
                'complianceStatus' => 'Over Licensed',
                'networkInstallations' => 1
            ],
            [
                'id' => Uuid::uuid4(),
                'name' => 'Microsoft Office',
                'version' => '15.0.4569.1506',
                'totalPurchased' => 25,
                'managedInstallations' => 0,
                'complianceStatus' => 'Over Licensed',
                'networkInstallations' => 0
            ],
            [
                'id' => Uuid::uuid4(),
                'name' => 'Microsoft Office 365 - en-us',
                'version' => '16.0.4693.1005',
                'totalPurchased' => 20,
                'managedInstallations' => 19,
                'complianceStatus' => 'Over Licensed',
                'networkInstallations' => 19
            ],
            [
                'id' => Uuid::uuid4(),
                'name' => 'Web Deployment Tool',
                'version' => '1.1.0618',
                'totalPurchased' => 2,
                'managedInstallations' => 1,
                'complianceStatus' => 'Over Licensed',
                'networkInstallations' => 1
            ],
            [
                'id' => Uuid::uuid4(),
                'name' => 'Windows 10 Professional Edition (x64)',
                'version' => '-',
                'totalPurchased' => 160,
                'managedInstallations' => 160,
                'complianceStatus' => 'In Compliance',
                'networkInstallations' => 160
            ]
        ];

        $licenses->insert($data)->saveData();
    }
}
