<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240813090154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting
            ADD dashboardReady BOOLEAN DEFAULT FALSE,
            ADD onlineTime INT DEFAULT NULL,
            ADD talkTime INT DEFAULT NULL,
            ADD webcamTime INT DEFAULT NULL,
            ADD messageCount INT DEFAULT NULL,
            ADD connectionCount INT DEFAULT NULL,
            ADD emojis JSON DEFAULT NULL');

        $this->addSql('ALTER TABLE cours
            ADD onlineTime INT DEFAULT NULL,
            ADD talkTime INT DEFAULT NULL,
            ADD webcamTime INT DEFAULT NULL,
            ADD messageCount INT DEFAULT NULL,
            ADD connectionCount INT DEFAULT NULL,
            ADD emojis JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meeting DROP dashboardReady, DROP onlineTime, DROP talkTime, DROP webcamTime, DROP messageCount, DROP connectionCount, DROP emojis');
        $this->addSql('ALTER TABLE cours DROP onlineTime, DROP talkTime, DROP webcamTime, DROP messageCount, DROP connectionCount, DROP emojis');
    }
}
