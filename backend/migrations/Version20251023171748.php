<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251023171748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modification de la relation entre User et Photo';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9A76ED395');
        $this->addSql('DROP INDEX UNIQ_876E0D9A76ED395 ON photos');
        $this->addSql('ALTER TABLE photos DROP user_id');
        $this->addSql('ALTER TABLE users ADD photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E97E9E4C8C FOREIGN KEY (photo_id) REFERENCES photos (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E97E9E4C8C ON users (photo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_876E0D9A76ED395 ON photos (user_id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E97E9E4C8C');
        $this->addSql('DROP INDEX UNIQ_1483A5E97E9E4C8C ON users');
        $this->addSql('ALTER TABLE users DROP photo_id');
    }
}
