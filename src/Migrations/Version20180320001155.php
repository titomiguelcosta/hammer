<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180320001155 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $platform = $this->connection->getDatabasePlatform()->getName();
        if ('mysql' === $platform) {
            $this->addSql('CREATE TABLE oauth (id INT AUTO_INCREMENT NOT NULL, service VARCHAR(255) NOT NULL, access_token VARCHAR(1024) NOT NULL, refresh_token VARCHAR(1024) NOT NULL, expires_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        } elseif ('sqlite' === $platform) {
            $this->addSql('CREATE TABLE oauth (id INTEGER NOT NULL, service VARCHAR(255) NOT NULL, access_token VARCHAR(1024) NOT NULL, refresh_token VARCHAR(1024) NOT NULL, expires_at DATETIME NOT NULL, PRIMARY KEY(id))');
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE oauth');
    }
}
