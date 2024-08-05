<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805081545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Captation');
        $this->addSql('DROP TABLE ResetPasswordRequest');
        $this->addSql('DROP TABLE Tasks');
        $this->addSql('DROP TABLE academie');
        $this->addSql('DROP TABLE availability');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE cours_files');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE eleve_groupe');
        $this->addSql('DROP TABLE eleve_parcours');
        $this->addSql('DROP TABLE event_groupe');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE image_site');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE parcours');
        $this->addSql('DROP TABLE progress');
        $this->addSql('DROP TABLE qcminfo');
        $this->addSql('DROP TABLE qcminfo_event');
        $this->addSql('DROP TABLE qcminfo_question');
        $this->addSql('DROP TABLE qcminscrit');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE share');
        $this->addSql('DROP TABLE siteconfig');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE tarif');
        $this->addSql('DROP TABLE teacher_discipline');
        $this->addSql('DROP TABLE user_file');
        $this->addSql('DROP TABLE whitemark');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('DROP INDEX UNIQ_ECA105F7A76ED395 ON eleve');
        $this->addSql('DROP INDEX IDX_ECA105F73DA5256D ON eleve');
        $this->addSql('ALTER TABLE eleve DROP user_id, DROP image_id');
        $this->addSql('DROP INDEX IDX_3BAE0AA7357C0A59 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA73DA5256D ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA75FB14BA7 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7992AC972 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7A5522701 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA7C32A47EE ON event');
        $this->addSql('ALTER TABLE event DROP school_id, DROP discipline_id, DROP level_id, DROP tarif_id, DROP image_id, DROP userUpdate_id, CHANGE certif certif TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA741807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE event_teacher ADD CONSTRAINT FK_35A10F7A71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_teacher ADD CONSTRAINT FK_35A10F7A41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meeting ADD CONSTRAINT FK_F515E13971F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('DROP INDEX UNIQ_B0F6A6D5A76ED395 ON teacher');
        $this->addSql('DROP INDEX IDX_B0F6A6D53DA5256D ON teacher');
        $this->addSql('DROP INDEX IDX_B0F6A6D56BF700BD ON teacher');
        $this->addSql('DROP INDEX IDX_B0F6A6D5B38A0D28 ON teacher');
        $this->addSql('ALTER TABLE teacher DROP user_id, DROP image_id, DROP status_id, DROP academie_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Captation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, keywords JSON DEFAULT NULL, views INT NOT NULL, captationId VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, recordId VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, startTime DATETIME DEFAULT NULL, endTime DATETIME DEFAULT NULL, publishState TINYINT(1) NOT NULL, available TINYINT(1) NOT NULL, created DATETIME NOT NULL, lastUpdate DATETIME DEFAULT NULL, userId_id INT NOT NULL, INDEX IDX_2EEAB61B99218D81 (userId_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ResetPasswordRequest (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, hashedToken VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, requestedAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expiresAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_68B3564AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Tasks (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, task VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dateCreated DATETIME NOT NULL, dateFinished DATETIME DEFAULT NULL, color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, dueDate DATETIME DEFAULT NULL, INDEX IDX_91994A93A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE academie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_A9373E3D2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE availability (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, color VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, occurence VARCHAR(20) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_3FB7A2BF41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, user_id INT DEFAULT NULL, score INT NOT NULL, comment LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, createddate DATETIME NOT NULL, UNIQUE INDEX avis_utilisateur (user_id, event_id), INDEX IDX_8F91ABF041807E1D (teacher_id), INDEX IDX_8F91ABF071F7E88B (event_id), INDEX IDX_8F91ABF0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_94D4687F2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cours_files (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, userfile_id INT NOT NULL, views INT DEFAULT NULL, shared TINYINT(1) NOT NULL, sharedDate DATETIME DEFAULT NULL, UNIQUE INDEX course_files (userfile_id, event_id), INDEX IDX_3653C98F71F7E88B (event_id), INDEX IDX_3653C98FFAA85D2 (userfile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, color VARCHAR(7) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE eleve_groupe (eleve_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_DD70B6E07A45358C (groupe_id), INDEX IDX_DD70B6E0A6CC7B2 (eleve_id), PRIMARY KEY(eleve_id, groupe_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE eleve_parcours (eleve_id INT NOT NULL, parcours_id INT NOT NULL, INDEX IDX_8D5C38976E38C0DB (parcours_id), INDEX IDX_8D5C3897A6CC7B2 (eleve_id), PRIMARY KEY(eleve_id, parcours_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE event_groupe (event_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_3620FB737A45358C (groupe_id), INDEX IDX_3620FB7371F7E88B (event_id), PRIMARY KEY(event_id, groupe_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE favoris (school_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_8933C43241807E1D (teacher_id), INDEX IDX_8933C432C32A47EE (school_id), PRIMARY KEY(school_id, teacher_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, email VARCHAR(180) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, enabled TINYINT(1) NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci` COMMENT \'(DC2Type:array)\', createddate DATETIME NOT NULL, last_login DATETIME DEFAULT NULL, uuid VARCHAR(180) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, enabled TINYINT(1) NOT NULL, externalId INT DEFAULT NULL, UNIQUE INDEX UNIQ_4B98C21A4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE image_site (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE parcours (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, image_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, user INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE progress (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, modules_id INT DEFAULT NULL, parcours_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2201F24671F7E88B (event_id), INDEX IDX_2201F24660D6DC42 (modules_id), INDEX IDX_2201F2466E38C0DB (parcours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE qcminfo (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, createddate DATETIME NOT NULL, INDEX IDX_D27C24A2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE qcminfo_event (qcminfo_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_7EE7216014E6905D (qcminfo_id), INDEX IDX_7EE7216071F7E88B (event_id), PRIMARY KEY(qcminfo_id, event_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE qcminfo_question (qcminfo_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_5B67CD9314E6905D (qcminfo_id), INDEX IDX_5B67CD931E27F6BF (question_id), PRIMARY KEY(qcminfo_id, question_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE qcminscrit (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, qcm_id INT DEFAULT NULL, event_id INT DEFAULT NULL, list_question VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, list_reponse VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, avancement INT DEFAULT NULL, start DATETIME DEFAULT NULL, pause INT DEFAULT NULL, retrie INT DEFAULT NULL, socketchannel VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX qcm_register (user_id, event_id, qcm_id), INDEX IDX_DB12F2C071F7E88B (event_id), INDEX IDX_DB12F2C0A76ED395 (user_id), INDEX IDX_DB12F2C0FF6241A6 (qcm_id), INDEX qcm_channel (socketchannel), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, temps INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, description VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, correct TINYINT(1) NOT NULL, INDEX IDX_5FB6DEC71E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, image_id INT DEFAULT NULL, status_id INT DEFAULT NULL, academie_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, siret INT DEFAULT NULL, address VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, codepostal INT DEFAULT NULL, city VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, pays VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, valide TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_F99EDABBA76ED395 (user_id), INDEX IDX_F99EDABB3DA5256D (image_id), INDEX IDX_F99EDABB6BF700BD (status_id), INDEX IDX_F99EDABBB38A0D28 (academie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE share (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, userfile_id INT DEFAULT NULL, user_id INT NOT NULL, addDate DATETIME NOT NULL, UNIQUE INDEX share_idx (event_id, user_id), INDEX IDX_EF069D5A71F7E88B (event_id), INDEX IDX_EF069D5AA76ED395 (user_id), INDEX IDX_EF069D5AFAA85D2 (userfile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE siteconfig (id INT AUTO_INCREMENT NOT NULL, image_site_id INT DEFAULT NULL, analytics LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, twitter VARCHAR(20) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, facebook VARCHAR(40) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, siret VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, declarationnum VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, adresse1 VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, adresse2 VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, cp VARCHAR(20) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, ville VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, telephone VARCHAR(20) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_9AE813E563AD419A (image_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, user_type VARCHAR(50) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_7B00651C8CDE5729 (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tarif (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_E7189C92B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE teacher_discipline (disciplines_id INT NOT NULL, teachers_id INT NOT NULL, INDEX IDX_FFA14C9F84365182 (teachers_id), INDEX IDX_FFA14C9F90D3DF94 (disciplines_id), PRIMARY KEY(teachers_id, disciplines_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_file (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_size INT NOT NULL, file_mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_description VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, updated_at DATETIME NOT NULL, download TINYINT(1) NOT NULL, library TINYINT(1) NOT NULL, INDEX IDX_F61E7AD9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE whitemark (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, active TINYINT(1) NOT NULL, createddate DATETIME NOT NULL, updateddate DATETIME NOT NULL, attachment VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C71F7E88B');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CA6CC7B2');
        $this->addSql('ALTER TABLE eleve ADD user_id INT NOT NULL, ADD image_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ECA105F7A76ED395 ON eleve (user_id)');
        $this->addSql('CREATE INDEX IDX_ECA105F73DA5256D ON eleve (image_id)');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA741807E1D');
        $this->addSql('ALTER TABLE event ADD school_id INT DEFAULT NULL, ADD discipline_id INT DEFAULT NULL, ADD level_id INT DEFAULT NULL, ADD tarif_id INT DEFAULT NULL, ADD image_id INT DEFAULT NULL, ADD userUpdate_id INT DEFAULT NULL, CHANGE certif certif TINYINT(1) NOT NULL');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7357C0A59 ON event (tarif_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA73DA5256D ON event (image_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA75FB14BA7 ON event (level_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7992AC972 ON event (userUpdate_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A5522701 ON event (discipline_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7C32A47EE ON event (school_id)');
        $this->addSql('ALTER TABLE event_teacher DROP FOREIGN KEY FK_35A10F7A71F7E88B');
        $this->addSql('ALTER TABLE event_teacher DROP FOREIGN KEY FK_35A10F7A41807E1D');
        $this->addSql('ALTER TABLE meeting DROP FOREIGN KEY FK_F515E13971F7E88B');
        $this->addSql('ALTER TABLE teacher ADD user_id INT DEFAULT NULL, ADD image_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL, ADD academie_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B0F6A6D5A76ED395 ON teacher (user_id)');
        $this->addSql('CREATE INDEX IDX_B0F6A6D53DA5256D ON teacher (image_id)');
        $this->addSql('CREATE INDEX IDX_B0F6A6D56BF700BD ON teacher (status_id)');
        $this->addSql('CREATE INDEX IDX_B0F6A6D5B38A0D28 ON teacher (academie_id)');
    }
}
