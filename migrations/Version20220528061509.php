<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528061509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE catastrophe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE categorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE continent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE images_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pays_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE souscategorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE catastrophe (id INT NOT NULL, catastrophe_id INT NOT NULL, continent_id INT NOT NULL, categorie_id INT NOT NULL, souscategorie_id INT NOT NULL, pays_id INT NOT NULL, localisation VARCHAR(255) NOT NULL, description TEXT NOT NULL, nombre_mort INT NOT NULL, nombre_blesses INT NOT NULL, ville VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, nom_catastrophe VARCHAR(255) NOT NULL, autres_victimes INT DEFAULT NULL, sans_abris INT DEFAULT NULL, dimension DOUBLE PRECISION DEFAULT NULL, cause_catastrophe VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_44F3D1D450560F60 ON catastrophe (catastrophe_id)');
        $this->addSql('CREATE INDEX IDX_44F3D1D4921F4C77 ON catastrophe (continent_id)');
        $this->addSql('CREATE INDEX IDX_44F3D1D4BCF5E72D ON catastrophe (categorie_id)');
        $this->addSql('CREATE INDEX IDX_44F3D1D4A27126E0 ON catastrophe (souscategorie_id)');
        $this->addSql('CREATE INDEX IDX_44F3D1D4A6E44244 ON catastrophe (pays_id)');
        $this->addSql('COMMENT ON COLUMN catastrophe.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE categorie (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE continent (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE images (id INT NOT NULL, images_select_id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E01FBE6AAD087056 ON images (images_select_id)');
        $this->addSql('CREATE TABLE pays (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE souscategorie (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, user_select_id INT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, slug VARCHAR(255) NOT NULL, image_user VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D6492C5689 ON "user" (user_select_id)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE catastrophe ADD CONSTRAINT FK_44F3D1D450560F60 FOREIGN KEY (catastrophe_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE catastrophe ADD CONSTRAINT FK_44F3D1D4921F4C77 FOREIGN KEY (continent_id) REFERENCES continent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE catastrophe ADD CONSTRAINT FK_44F3D1D4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE catastrophe ADD CONSTRAINT FK_44F3D1D4A27126E0 FOREIGN KEY (souscategorie_id) REFERENCES souscategorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE catastrophe ADD CONSTRAINT FK_44F3D1D4A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AAD087056 FOREIGN KEY (images_select_id) REFERENCES catastrophe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6492C5689 FOREIGN KEY (user_select_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE images DROP CONSTRAINT FK_E01FBE6AAD087056');
        $this->addSql('ALTER TABLE catastrophe DROP CONSTRAINT FK_44F3D1D4BCF5E72D');
        $this->addSql('ALTER TABLE catastrophe DROP CONSTRAINT FK_44F3D1D4921F4C77');
        $this->addSql('ALTER TABLE catastrophe DROP CONSTRAINT FK_44F3D1D4A6E44244');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6492C5689');
        $this->addSql('ALTER TABLE catastrophe DROP CONSTRAINT FK_44F3D1D4A27126E0');
        $this->addSql('ALTER TABLE catastrophe DROP CONSTRAINT FK_44F3D1D450560F60');
        $this->addSql('DROP SEQUENCE catastrophe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE categorie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE continent_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE images_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pays_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE souscategorie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE catastrophe');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE continent');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE souscategorie');
        $this->addSql('DROP TABLE "user"');
    }
}
