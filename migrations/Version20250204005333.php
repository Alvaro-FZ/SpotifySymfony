<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204005333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist ADD usuario_propietario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D32559FE1 FOREIGN KEY (usuario_propietario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_D782112D32559FE1 ON playlist (usuario_propietario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D32559FE1');
        $this->addSql('DROP INDEX IDX_D782112D32559FE1 ON playlist');
        $this->addSql('ALTER TABLE playlist DROP usuario_propietario_id');
    }
}
