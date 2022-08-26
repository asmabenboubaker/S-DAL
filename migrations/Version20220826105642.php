<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826105642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marque ADD cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CEE6ADA943 FOREIGN KEY (cat_id) REFERENCES cat (id)');
        $this->addSql('CREATE INDEX IDX_5A6F91CEE6ADA943 ON marque (cat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CEE6ADA943');
        $this->addSql('DROP TABLE cat');
        $this->addSql('DROP INDEX IDX_5A6F91CEE6ADA943 ON marque');
        $this->addSql('ALTER TABLE marque DROP cat_id');
    }
}
