<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221231111048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biens (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, ville VARCHAR(255) NOT NULL, codepostal VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, surface DOUBLE PRECISION NOT NULL, illustration VARCHAR(255) NOT NULL, INDEX IDX_1F9004DD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE safer (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, categorie_id INT NOT NULL, reference VARCHAR(255) NOT NULL, intitule VARCHAR(255) NOT NULL, descriptif LONGTEXT NOT NULL, localisation VARCHAR(255) NOT NULL, surface VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, illustration VARCHAR(255) DEFAULT NULL, INDEX IDX_1111C504C54C8C93 (type_id), INDEX IDX_1111C504BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE biens ADD CONSTRAINT FK_1F9004DD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE safer ADD CONSTRAINT FK_1111C504C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE safer ADD CONSTRAINT FK_1111C504BCF5E72D FOREIGN KEY (categorie_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user ADD contacts VARCHAR(255) NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biens DROP FOREIGN KEY FK_1F9004DD12469DE2');
        $this->addSql('ALTER TABLE safer DROP FOREIGN KEY FK_1111C504C54C8C93');
        $this->addSql('ALTER TABLE safer DROP FOREIGN KEY FK_1111C504BCF5E72D');
        $this->addSql('DROP TABLE biens');
        $this->addSql('DROP TABLE safer');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE `user` DROP contacts, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
