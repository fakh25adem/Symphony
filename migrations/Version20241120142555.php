<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120142555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_environm (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, impact_carbon INT NOT NULL, points INT NOT NULL, INDEX IDX_F2EE724EBCF5E72D (categorie_id), INDEX IDX_F2EE724EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_environm_objectif_environm (action_environm_id INT NOT NULL, objectif_environm_id INT NOT NULL, INDEX IDX_1B2DE0A746FEB103 (action_environm_id), INDEX IDX_1B2DE0A739038E27 (objectif_environm_id), PRIMARY KEY(action_environm_id, objectif_environm_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_action (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectif_environm (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, statut VARCHAR(255) NOT NULL, pts_cible INT NOT NULL, pts_cummules INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_environm ADD CONSTRAINT FK_F2EE724EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_action (id)');
        $this->addSql('ALTER TABLE action_environm ADD CONSTRAINT FK_F2EE724EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE action_environm_objectif_environm ADD CONSTRAINT FK_1B2DE0A746FEB103 FOREIGN KEY (action_environm_id) REFERENCES action_environm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_environm_objectif_environm ADD CONSTRAINT FK_1B2DE0A739038E27 FOREIGN KEY (objectif_environm_id) REFERENCES objectif_environm (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action_environm DROP FOREIGN KEY FK_F2EE724EBCF5E72D');
        $this->addSql('ALTER TABLE action_environm DROP FOREIGN KEY FK_F2EE724EA76ED395');
        $this->addSql('ALTER TABLE action_environm_objectif_environm DROP FOREIGN KEY FK_1B2DE0A746FEB103');
        $this->addSql('ALTER TABLE action_environm_objectif_environm DROP FOREIGN KEY FK_1B2DE0A739038E27');
        $this->addSql('DROP TABLE action_environm');
        $this->addSql('DROP TABLE action_environm_objectif_environm');
        $this->addSql('DROP TABLE categorie_action');
        $this->addSql('DROP TABLE objectif_environm');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
