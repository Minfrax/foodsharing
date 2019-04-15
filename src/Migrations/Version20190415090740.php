<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415090740 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE canton (id INT AUTO_INCREMENT NOT NULL, canton_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, sharer_id_id INT NOT NULL, canton_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, picture_path VARCHAR(255) DEFAULT NULL, mime_type VARCHAR(50) DEFAULT NULL, expiration_date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_29D6873E8524DABE (sharer_id_id), INDEX IDX_29D6873E41DEC1B2 (canton_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, canton_id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, termaccepted TINYINT(1) NOT NULL, active TINYINT(1) DEFAULT NULL, active_token VARCHAR(36) DEFAULT NULL, roles VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, telephone VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D6498D070D0B (canton_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E8524DABE FOREIGN KEY (sharer_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E41DEC1B2 FOREIGN KEY (canton_id_id) REFERENCES canton (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498D070D0B FOREIGN KEY (canton_id) REFERENCES canton (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E41DEC1B2');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498D070D0B');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E8524DABE');
        $this->addSql('DROP TABLE canton');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE user');
    }
}
