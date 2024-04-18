<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418104815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso_pays_produits (id_pays INTEGER NOT NULL, id_produit INTEGER NOT NULL, PRIMARY KEY(id_pays, id_produit), CONSTRAINT FK_2EDD5AB9BFBF20AC FOREIGN KEY (id_pays) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2EDD5AB9F7384557 FOREIGN KEY (id_produit) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2EDD5AB9BFBF20AC ON asso_pays_produits (id_pays)');
        $this->addSql('CREATE INDEX IDX_2EDD5AB9F7384557 ON asso_pays_produits (id_produit)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE asso_pays_produits');
    }
}
