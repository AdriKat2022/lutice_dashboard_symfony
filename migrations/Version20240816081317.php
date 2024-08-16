<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816081317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_teacher DROP FOREIGN KEY FK_35A10F7A41807E1D');
        $this->addSql('ALTER TABLE event_teacher DROP FOREIGN KEY FK_35A10F7A71F7E88B');
        $this->addSql('ALTER TABLE event_teacher ADD CONSTRAINT FK_35A10F7A41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE event_teacher ADD CONSTRAINT FK_35A10F7A71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE UNIQUE INDEX event_teacher ON event_teacher (teacher_id, event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_teacher DROP FOREIGN KEY FK_35A10F7A71F7E88B');
        $this->addSql('ALTER TABLE event_teacher DROP FOREIGN KEY FK_35A10F7A41807E1D');
        $this->addSql('DROP INDEX event_teacher ON event_teacher');
        $this->addSql('ALTER TABLE event_teacher ADD CONSTRAINT FK_35A10F7A71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_teacher ADD CONSTRAINT FK_35A10F7A41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
