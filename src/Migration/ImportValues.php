<?php

namespace Supsign\ContaoConnectorsBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Composer\Script\Event;


class ImportValues extends AbstractMigration
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        echo "1";
    }


    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();
        // If the database table itself does not exist we should do nothing
        if (!$schemaManager->tablesExist(['tl_ftp_protocols'])) {
            return false;
        }
        return true;
        $columns = $schemaManager->listTableColumns('tl_ftp_protocols');

        return
            isset($columns['title']) &&
            isset($columns['description']);
    }

    public function run(): MigrationResult
    {
        echo "3";
        var_dump("3");
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
