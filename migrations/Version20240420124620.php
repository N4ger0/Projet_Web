<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240420124620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lic_panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user INTEGER NOT NULL, id_produit INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_C66629206B3CA4B FOREIGN KEY (id_user) REFERENCES lic_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C6662920F7384557 FOREIGN KEY (id_produit) REFERENCES lic_produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C66629206B3CA4B ON lic_panier (id_user)');
        $this->addSql('CREATE INDEX IDX_C6662920F7384557 ON lic_panier (id_produit)');
        $this->addSql('CREATE TABLE lic_pays (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, shortname VARCHAR(2) NOT NULL)');
        $this->addSql('CREATE TABLE lic_produit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, prixunit DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE lic_asso_pays_produits (id_pays INTEGER NOT NULL, id_produit INTEGER NOT NULL, PRIMARY KEY(id_pays, id_produit), CONSTRAINT FK_2A53EEABFBF20AC FOREIGN KEY (id_pays) REFERENCES lic_produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2A53EEAF7384557 FOREIGN KEY (id_produit) REFERENCES lic_pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2A53EEABFBF20AC ON lic_asso_pays_produits (id_pays)');
        $this->addSql('CREATE INDEX IDX_2A53EEAF7384557 ON lic_asso_pays_produits (id_produit)');
        $this->addSql('CREATE TABLE lic_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_pays INTEGER DEFAULT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, admin BOOLEAN NOT NULL, CONSTRAINT FK_64BC4F10BFBF20AC FOREIGN KEY (id_pays) REFERENCES lic_pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64BC4F10AA08CB10 ON lic_user (login)');
        $this->addSql('CREATE INDEX IDX_64BC4F10BFBF20AC ON lic_user (id_pays)');
        $this->addSql('DROP TABLE asso_pays_produits');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asso_pays_produits (id_pays INTEGER NOT NULL, id_produit INTEGER NOT NULL, PRIMARY KEY(id_pays, id_produit), CONSTRAINT FK_2EDD5AB9BFBF20AC FOREIGN KEY (id_pays) REFERENCES produit (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2EDD5AB9F7384557 FOREIGN KEY (id_produit) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2EDD5AB9F7384557 ON asso_pays_produits (id_produit)');
        $this->addSql('CREATE INDEX IDX_2EDD5AB9BFBF20AC ON asso_pays_produits (id_pays)');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user INTEGER NOT NULL, id_produit INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_24CC0DF26B3CA4B FOREIGN KEY (id_user) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_24CC0DF2F7384557 FOREIGN KEY (id_produit) REFERENCES produit (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2F7384557 ON panier (id_produit)');
        $this->addSql('CREATE INDEX IDX_24CC0DF26B3CA4B ON panier (id_user)');
        $this->addSql('CREATE TABLE pays (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE "BINARY", shortname VARCHAR(2) NOT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TABLE produit (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL COLLATE "BINARY", prixunit DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_pays INTEGER DEFAULT NULL, login VARCHAR(180) NOT NULL COLLATE "BINARY", roles CLOB NOT NULL COLLATE "BINARY" --(DC2Type:json)
        , password VARCHAR(255) NOT NULL COLLATE "BINARY", name VARCHAR(255) DEFAULT NULL COLLATE "BINARY", lastname VARCHAR(255) DEFAULT NULL COLLATE "BINARY", birthdate DATE DEFAULT NULL, admin BOOLEAN NOT NULL, CONSTRAINT FK_8D93D649BFBF20AC FOREIGN KEY (id_pays) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON user (login)');
        $this->addSql('CREATE INDEX IDX_8D93D649BFBF20AC ON user (id_pays)');
        $this->addSql('DROP TABLE lic_panier');
        $this->addSql('DROP TABLE lic_pays');
        $this->addSql('DROP TABLE lic_produit');
        $this->addSql('DROP TABLE lic_asso_pays_produits');
        $this->addSql('DROP TABLE lic_user');
    }
}
