<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251021092032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'création des entités et des relations entre celles ci';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biens (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, localisation_id INT NOT NULL, nom VARCHAR(255) NOT NULL, type_de_bien VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, surface DOUBLE PRECISION NOT NULL, nb_chambre INT NOT NULL, rue VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, disponibilite DATE NOT NULL, statut VARCHAR(255) NOT NULL, date_publication DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1F9004DDA76ED395 (user_id), INDEX IDX_1F9004DDC68BE09C (localisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bien_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, sujet VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, date_envoi DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', traite TINYINT(1) NOT NULL, INDEX IDX_33401573A76ED395 (user_id), INDEX IDX_33401573BD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criteres (id INT AUTO_INCREMENT NOT NULL, localisation_id INT DEFAULT NULL, type_transaction VARCHAR(255) DEFAULT NULL, type_bien VARCHAR(255) DEFAULT NULL, prix_min DOUBLE PRECISION DEFAULT NULL, prix_max DOUBLE PRECISION DEFAULT NULL, surface_min DOUBLE PRECISION DEFAULT NULL, surface_max DOUBLE PRECISION DEFAULT NULL, nb_chambres INT DEFAULT NULL, INDEX IDX_E913A5C5C68BE09C (localisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisations (id INT AUTO_INCREMENT NOT NULL, nom_localite VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bien_id INT DEFAULT NULL, url_photo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_876E0D9A76ED395 (user_id), INDEX IDX_876E0D9BD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recherches (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, critere_id INT NOT NULL, nom_recherche VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', alerte TINYINT(1) NOT NULL, INDEX IDX_84050CB5A76ED395 (user_id), INDEX IDX_84050CB59E5F45AB (critere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE biens ADD CONSTRAINT FK_1F9004DDA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE biens ADD CONSTRAINT FK_1F9004DDC68BE09C FOREIGN KEY (localisation_id) REFERENCES localisations (id)');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_33401573A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_33401573BD95B80F FOREIGN KEY (bien_id) REFERENCES biens (id)');
        $this->addSql('ALTER TABLE criteres ADD CONSTRAINT FK_E913A5C5C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisations (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9BD95B80F FOREIGN KEY (bien_id) REFERENCES biens (id)');
        $this->addSql('ALTER TABLE recherches ADD CONSTRAINT FK_84050CB5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE recherches ADD CONSTRAINT FK_84050CB59E5F45AB FOREIGN KEY (critere_id) REFERENCES criteres (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biens DROP FOREIGN KEY FK_1F9004DDA76ED395');
        $this->addSql('ALTER TABLE biens DROP FOREIGN KEY FK_1F9004DDC68BE09C');
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573A76ED395');
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573BD95B80F');
        $this->addSql('ALTER TABLE criteres DROP FOREIGN KEY FK_E913A5C5C68BE09C');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9A76ED395');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9BD95B80F');
        $this->addSql('ALTER TABLE recherches DROP FOREIGN KEY FK_84050CB5A76ED395');
        $this->addSql('ALTER TABLE recherches DROP FOREIGN KEY FK_84050CB59E5F45AB');
        $this->addSql('DROP TABLE biens');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE criteres');
        $this->addSql('DROP TABLE localisations');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE recherches');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
