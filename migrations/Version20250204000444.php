<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250204000444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE estilo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perfil (id INT AUTO_INCREMENT NOT NULL, foto VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, fecha_nacimiento VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cancion (id INT AUTO_INCREMENT NOT NULL, genero_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, duracion INT NOT NULL, album VARCHAR(255) NOT NULL, autor VARCHAR(255) NOT NULL, likes INT NOT NULL, INDEX IDX_E4620FA0BCE7B795 (genero_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, visibilidad VARCHAR(255) NOT NULL, likes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perfil_estilo (perfil_id INT NOT NULL, estilo_id INT NOT NULL, INDEX IDX_8C8A3EBE57291544 (perfil_id), INDEX IDX_8C8A3EBE43798DA7 (estilo_id), PRIMARY KEY(perfil_id, estilo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_cancion (id INT AUTO_INCREMENT NOT NULL, playlist_id INT DEFAULT NULL, cancion_id INT DEFAULT NULL, reproducciones INT NOT NULL, INDEX IDX_5B5D18BA6BBD148 (playlist_id), INDEX IDX_5B5D18BA9B1D840F (cancion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario_listen_playlist (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, playlist_id INT DEFAULT NULL, INDEX IDX_C6B35853DB38439E (usuario_id), INDEX IDX_C6B358536BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cancion ADD CONSTRAINT FK_E4620FA0BCE7B795 FOREIGN KEY (genero_id) REFERENCES estilo (id)');
        $this->addSql('ALTER TABLE perfil_estilo ADD CONSTRAINT FK_8C8A3EBE57291544 FOREIGN KEY (perfil_id) REFERENCES perfil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE perfil_estilo ADD CONSTRAINT FK_8C8A3EBE43798DA7 FOREIGN KEY (estilo_id) REFERENCES estilo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_cancion ADD CONSTRAINT FK_5B5D18BA6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE playlist_cancion ADD CONSTRAINT FK_5B5D18BA9B1D840F FOREIGN KEY (cancion_id) REFERENCES cancion (id)');
        $this->addSql('ALTER TABLE usuario_listen_playlist ADD CONSTRAINT FK_C6B35853DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario_listen_playlist ADD CONSTRAINT FK_C6B358536BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cancion DROP FOREIGN KEY FK_E4620FA0BCE7B795');
        $this->addSql('ALTER TABLE perfil_estilo DROP FOREIGN KEY FK_8C8A3EBE57291544');
        $this->addSql('ALTER TABLE perfil_estilo DROP FOREIGN KEY FK_8C8A3EBE43798DA7');
        $this->addSql('ALTER TABLE playlist_cancion DROP FOREIGN KEY FK_5B5D18BA6BBD148');
        $this->addSql('ALTER TABLE playlist_cancion DROP FOREIGN KEY FK_5B5D18BA9B1D840F');
        $this->addSql('ALTER TABLE usuario_listen_playlist DROP FOREIGN KEY FK_C6B35853DB38439E');
        $this->addSql('ALTER TABLE usuario_listen_playlist DROP FOREIGN KEY FK_C6B358536BBD148');
        $this->addSql('DROP TABLE cancion');
        $this->addSql('DROP TABLE estilo');
        $this->addSql('DROP TABLE perfil');
        $this->addSql('DROP TABLE perfil_estilo');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_cancion');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE usuario_listen_playlist');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
