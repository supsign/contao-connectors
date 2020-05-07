<?php

namespace Supsign\ContaoConnectorsBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;

class ImportValues extends AbstractMigration
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();

        // If the database table itself does not exist we should do nothing
        if (!$schemaManager->tablesExist(['tl_ftp_protocols'])) {
            var_dump('Vorhanden');
            return false;
        }

        /*   $columns = $schemaManager->listTableColumns('tl_ftp_protocols');

        return 
	        isset($columns['firstName']) &&
	        isset($columns['lastName']) &&
            !isset($columns['name']);
            
    */
    }

    public function run(): MigrationResult
    {
        $stmt = $this->connection->query('
            UPDATE or INSERT into tl_ftp_protocols (title,description)
                values ("FTP", "")
                matching (title)');

        $stmt->execute();

        return new MigrationResult(
            true,
            'Combined ' . $stmt->rowCount() . ' customer names.'
        );
    }
}
