<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409124946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, id_pays, login, roles, password, name, lastname, birthdate, admin FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_pays INTEGER DEFAULT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, admin BOOLEAN NOT NULL, CONSTRAINT FK_8D93D649BFBF20AC FOREIGN KEY (id_pays) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, id_pays, login, roles, password, name, lastname, birthdate, admin) SELECT id, id_pays, login, roles, password, name, lastname, birthdate, admin FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649BFBF20AC ON user (id_pays)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON user (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, id_pays, login, roles, password, name, lastname, birthdate, admin FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_pays INTEGER DEFAULT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthdate DATE DEFAULT NULL, admin BOOLEAN NOT NULL, CONSTRAINT FK_8D93D649BFBF20AC FOREIGN KEY (id_pays) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, id_pays, login, roles, password, name, lastname, birthdate, admin) SELECT id, id_pays, login, roles, password, name, lastname, birthdate, admin FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON user (login)');
        $this->addSql('CREATE INDEX IDX_8D93D649BFBF20AC ON user (id_pays)');
    }
}
