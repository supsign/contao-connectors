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
    }


    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();
        // If the database table itself does not exist we should do nothing
        if (!$schemaManager->tablesExist(['tl_ftp_protocols'])) {
            return false;
        }

        $count = $this->connection->query('SELECT COUNT(*) FROM tl_ftp_protocols');
        $count->execute();

        return $count->fetchall()[0]['COUNT(*)'] < 2;
    }

    public function run(): MigrationResult
    {
        $this->connection->query('
        INSERT INTO tl_ftp_protocols (id,title,description,tstamp) 
            VALUES (1, "FTP", "FTP-Connection", CURRENT_TIMESTAMP) 
                ON DUPLICATE KEY UPDATE title="FTP", description="FTP-Connection"')->execute();

        $this->connection->query('
        INSERT INTO tl_ftp_protocols (id,title,description,tstamp)
            VALUES (2, "SFTP", "SFTP-Connection", CURRENT_TIMESTAMP)
                ON DUPLICATE KEY UPDATE title="SFTP", description="SFTP-Connection"')->execute();

        return new MigrationResult(
            true,
            'Set default Values in tl_ftp_protocols.'
        );
    }
}
