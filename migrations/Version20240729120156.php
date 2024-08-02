<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729120156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE Captation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, keywords JSON DEFAULT NULL, views INT NOT NULL, captationId VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, recordId VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, startTime DATETIME DEFAULT NULL, endTime DATETIME DEFAULT NULL, publishState TINYINT(1) NOT NULL, available TINYINT(1) NOT NULL, created DATETIME NOT NULL, lastUpdate DATETIME DEFAULT NULL, userId_id INT NOT NULL, INDEX IDX_2EEAB61B99218D81 (userId_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE ResetPasswordRequest (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, hashedToken VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, requestedAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expiresAt DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_68B3564AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE Tasks (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, task VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dateCreated DATETIME NOT NULL, dateFinished DATETIME DEFAULT NULL, color VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, dueDate DATETIME DEFAULT NULL, INDEX IDX_91994A93A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE academie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_A9373E3D2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE availability (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, color VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, occurence VARCHAR(20) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_3FB7A2BF41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, user_id INT DEFAULT NULL, score INT NOT NULL, comment LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, createddate DATETIME NOT NULL, UNIQUE INDEX avis_utilisateur (user_id, event_id), INDEX IDX_8F91ABF041807E1D (teacher_id), INDEX IDX_8F91ABF071F7E88B (event_id), INDEX IDX_8F91ABF0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_94D4687F2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, eleve_id INT NOT NULL, starttime DATETIME DEFAULT NULL, endtime DATETIME DEFAULT NULL, course_url VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, note VARCHAR(10) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, creneaustart TIME DEFAULT NULL, creneauend TIME DEFAULT NULL, signature LONGBLOB DEFAULT NULL, certif TINYINT(1) DEFAULT 0 NOT NULL, signaturetime DATETIME DEFAULT NULL, externalId INT DEFAULT NULL, UNIQUE INDEX course_inscription (eleve_id, event_id), INDEX IDX_FDCA8C9C71F7E88B (event_id), INDEX IDX_FDCA8C9CA6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE cours_files (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, userfile_id INT NOT NULL, views INT DEFAULT NULL, shared TINYINT(1) NOT NULL, sharedDate DATETIME DEFAULT NULL, UNIQUE INDEX course_files (userfile_id, event_id), INDEX IDX_3653C98F71F7E88B (event_id), INDEX IDX_3653C98FFAA85D2 (userfile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, color VARCHAR(7) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, image_id INT DEFAULT NULL, first_name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, last_name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, address VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, codepostal VARCHAR(15) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, city VARCHAR(40) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, pays VARCHAR(40) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, phone VARCHAR(20) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, externalId INT DEFAULT NULL, INDEX IDX_ECA105F73DA5256D (image_id), UNIQUE INDEX UNIQ_ECA105F7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE eleve_groupe (eleve_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_DD70B6E07A45358C (groupe_id), INDEX IDX_DD70B6E0A6CC7B2 (eleve_id), PRIMARY KEY(eleve_id, groupe_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE eleve_parcours (eleve_id INT NOT NULL, parcours_id INT NOT NULL, INDEX IDX_8D5C38976E38C0DB (parcours_id), INDEX IDX_8D5C3897A6CC7B2 (eleve_id), PRIMARY KEY(eleve_id, parcours_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, school_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, discipline_id INT DEFAULT NULL, level_id INT DEFAULT NULL, tarif_id INT DEFAULT NULL, image_id INT DEFAULT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, color VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, participants_max INT NOT NULL, mcdescription LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, masterclass TINYINT(1) NOT NULL, status INT NOT NULL, id_availability INT NOT NULL, note_resultat TINYINT(1) DEFAULT NULL, invitations LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, creneau TINYINT(1) DEFAULT NULL, job TINYINT(1) NOT NULL, jobstart DATETIME DEFAULT NULL, jobend DATETIME DEFAULT NULL, lastUpdate DATETIME DEFAULT NULL, userUpdate_id INT DEFAULT NULL, externalId VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, signature LONGBLOB DEFAULT NULL, certif TINYINT(1) NOT NULL, signaturetime DATETIME DEFAULT NULL, INDEX IDX_3BAE0AA7357C0A59 (tarif_id), INDEX IDX_3BAE0AA73DA5256D (image_id), INDEX IDX_3BAE0AA741807E1D (teacher_id), INDEX IDX_3BAE0AA75FB14BA7 (level_id), INDEX IDX_3BAE0AA7992AC972 (userUpdate_id), INDEX IDX_3BAE0AA7A5522701 (discipline_id), INDEX IDX_3BAE0AA7C32A47EE (school_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE event_groupe (event_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_3620FB737A45358C (groupe_id), INDEX IDX_3620FB7371F7E88B (event_id), PRIMARY KEY(event_id, groupe_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE event_teacher (event_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_35A10F7A41807E1D (teacher_id), INDEX IDX_35A10F7A71F7E88B (event_id), PRIMARY KEY(event_id, teacher_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE favoris (school_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_8933C43241807E1D (teacher_id), INDEX IDX_8933C432C32A47EE (school_id), PRIMARY KEY(school_id, teacher_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, email VARCHAR(180) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, enabled TINYINT(1) NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci` COMMENT \'(DC2Type:array)\', createddate DATETIME NOT NULL, last_login DATETIME DEFAULT NULL, uuid VARCHAR(180) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, enabled TINYINT(1) NOT NULL, externalId INT DEFAULT NULL, UNIQUE INDEX UNIQ_4B98C21A4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE image_site (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, meeting_id VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, school_password VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, teacher_password VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, duration VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, meeting_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, record_id VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, start_time DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, views INT DEFAULT NULL, reason VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, autorecord TINYINT(1) DEFAULT 1 NOT NULL, webcamsonlyformoderator TINYINT(1) DEFAULT 1 NOT NULL, available TINYINT(1) DEFAULT 0 NOT NULL, publish_state TINYINT(1) DEFAULT 1 NOT NULL, replayOnlyForAdmin TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_F515E13971F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE parcours (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, image_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, user INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE progress (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, modules_id INT DEFAULT NULL, parcours_id INT DEFAULT NULL, INDEX IDX_2201F24660D6DC42 (modules_id), INDEX IDX_2201F2466E38C0DB (parcours_id), UNIQUE INDEX UNIQ_2201F24671F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE qcminfo (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, createddate DATETIME NOT NULL, INDEX IDX_D27C24A2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE qcminfo_event (qcminfo_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_7EE7216014E6905D (qcminfo_id), INDEX IDX_7EE7216071F7E88B (event_id), PRIMARY KEY(qcminfo_id, event_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE qcminfo_question (qcminfo_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_5B67CD9314E6905D (qcminfo_id), INDEX IDX_5B67CD931E27F6BF (question_id), PRIMARY KEY(qcminfo_id, question_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE qcminscrit (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, qcm_id INT DEFAULT NULL, event_id INT DEFAULT NULL, list_question VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, list_reponse VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, avancement INT DEFAULT NULL, start DATETIME DEFAULT NULL, pause INT DEFAULT NULL, retrie INT DEFAULT NULL, socketchannel VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_DB12F2C071F7E88B (event_id), INDEX IDX_DB12F2C0A76ED395 (user_id), INDEX IDX_DB12F2C0FF6241A6 (qcm_id), INDEX qcm_channel (socketchannel), UNIQUE INDEX qcm_register (user_id, event_id, qcm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, temps INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, description VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, correct TINYINT(1) NOT NULL, INDEX IDX_5FB6DEC71E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, image_id INT DEFAULT NULL, status_id INT DEFAULT NULL, academie_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, siret INT DEFAULT NULL, address VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, codepostal INT DEFAULT NULL, city VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, pays VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, valide TINYINT(1) NOT NULL, INDEX IDX_F99EDABB3DA5256D (image_id), INDEX IDX_F99EDABB6BF700BD (status_id), INDEX IDX_F99EDABBB38A0D28 (academie_id), UNIQUE INDEX UNIQ_F99EDABBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE share (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, userfile_id INT DEFAULT NULL, user_id INT NOT NULL, addDate DATETIME NOT NULL, INDEX IDX_EF069D5A71F7E88B (event_id), INDEX IDX_EF069D5AA76ED395 (user_id), INDEX IDX_EF069D5AFAA85D2 (userfile_id), UNIQUE INDEX share_idx (event_id, user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE siteconfig (id INT AUTO_INCREMENT NOT NULL, image_site_id INT DEFAULT NULL, analytics LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, twitter VARCHAR(20) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, facebook VARCHAR(40) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, siret VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, declarationnum VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, adresse1 VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, adresse2 VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, cp VARCHAR(20) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, ville VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, telephone VARCHAR(20) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_9AE813E563AD419A (image_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, user_type VARCHAR(50) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_7B00651C8CDE5729 (type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE tarif (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, UNIQUE INDEX UNIQ_E7189C92B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, image_id INT DEFAULT NULL, status_id INT DEFAULT NULL, academie_id INT DEFAULT NULL, first_name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, last_name VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, beneficiaire VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, adresse_beneficiaire VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, iban VARCHAR(30) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, bicswift VARCHAR(11) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, mail_academique VARCHAR(100) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, siret VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, valide TINYINT(1) NOT NULL, pricing INT DEFAULT NULL, address VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, codepostal VARCHAR(15) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, city VARCHAR(40) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, pays VARCHAR(40) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, titre_presentation VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, presentation LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, experience LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, cv LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, customurl VARCHAR(50) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, lien_fb VARCHAR(100) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, lien_twitter VARCHAR(100) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, lien_linkedin VARCHAR(100) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, externalId INT DEFAULT NULL, INDEX IDX_B0F6A6D53DA5256D (image_id), INDEX IDX_B0F6A6D56BF700BD (status_id), INDEX IDX_B0F6A6D5B38A0D28 (academie_id), UNIQUE INDEX UNIQ_B0F6A6D526E94372 (siret), UNIQUE INDEX UNIQ_B0F6A6D54A2C17E9 (mail_academique), UNIQUE INDEX UNIQ_B0F6A6D5A76ED395 (user_id), UNIQUE INDEX UNIQ_B0F6A6D5F37DE0A4 (customurl), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE teacher_discipline (disciplines_id INT NOT NULL, teachers_id INT NOT NULL, INDEX IDX_FFA14C9F84365182 (teachers_id), INDEX IDX_FFA14C9F90D3DF94 (disciplines_id), PRIMARY KEY(teachers_id, disciplines_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE user_file (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_size INT NOT NULL, file_mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_description VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, updated_at DATETIME NOT NULL, download TINYINT(1) NOT NULL, library TINYINT(1) NOT NULL, INDEX IDX_F61E7AD9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('CREATE TABLE whitemark (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, active TINYINT(1) NOT NULL, createddate DATETIME NOT NULL, updateddate DATETIME NOT NULL, attachment VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE Captation');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE ResetPasswordRequest');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE Tasks');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE academie');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE availability');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE avis');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE competence');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE cours');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE cours_files');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE discipline');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE eleve');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE eleve_groupe');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE eleve_parcours');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE event');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE event_groupe');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE event_teacher');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE favoris');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE fos_user');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE groupe');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE image');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE image_site');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE level');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE meeting');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE module');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE parcours');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE progress');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE qcminfo');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE qcminfo_event');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE qcminfo_question');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE qcminscrit');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE question');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE reponse');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE school');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE share');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE siteconfig');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE status');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE tarif');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE teacher');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE teacher_discipline');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE user_file');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySQL57Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MySQL57Platform'."
        );

        $this->addSql('DROP TABLE whitemark');
    }
}
