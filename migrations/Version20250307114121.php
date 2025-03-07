<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307114121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE usuario_play_list (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, playlist_id INT NOT NULL, reproducida INT NOT NULL, INDEX IDX_C6F6ECDBDB38439E (usuario_id), INDEX IDX_C6F6ECDB6BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE usuario_play_list ADD CONSTRAINT FK_C6F6ECDBDB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE usuario_play_list ADD CONSTRAINT FK_C6F6ECDB6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist CHANGE nombre nombre VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE user DROP INDEX FK_2265B05D57291544, ADD UNIQUE INDEX UNIQ_8D93D64957291544 (perfil_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario_play_list DROP FOREIGN KEY FK_C6F6ECDBDB38439E');
        $this->addSql('ALTER TABLE usuario_play_list DROP FOREIGN KEY FK_C6F6ECDB6BBD148');
        $this->addSql('DROP TABLE usuario_play_list');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE user DROP INDEX UNIQ_8D93D64957291544, ADD INDEX FK_2265B05D57291544 (perfil_id)');
        $this->addSql('ALTER TABLE playlist CHANGE nombre nombre VARCHAR(255) NOT NULL');
    }
}
