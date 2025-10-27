<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251027192210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout du champ imageFile + modification du champs urlPhoto + ajout d\'un trait pour la gestion de updated at';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos ADD updated_at DATETIME DEFAULT NULL, CHANGE url_photo url_photo VARCHAR(500) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos DROP updated_at, CHANGE url_photo url_photo VARCHAR(500) NOT NULL');
    }
}
