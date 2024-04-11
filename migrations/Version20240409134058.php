<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409134058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user INTEGER NOT NULL, id_produit INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_24CC0DF26B3CA4B FOREIGN KEY (id_user) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_24CC0DF2F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_24CC0DF26B3CA4B ON panier (id_user)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2F7384557 ON panier (id_produit)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE panier');
    }
}
