<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220710194016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE prevention_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE prevention (id INT NOT NULL, catastrophe_id INT NOT NULL, prevent_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_492AE6E550560F60 ON prevention (catastrophe_id)');
        $this->addSql('CREATE INDEX IDX_492AE6E5DF43315F ON prevention (prevent_id)');
        $this->addSql('COMMENT ON COLUMN prevention.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE prevention ADD CONSTRAINT FK_492AE6E550560F60 FOREIGN KEY (catastrophe_id) REFERENCES catastrophe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE prevention ADD CONSTRAINT FK_492AE6E5DF43315F FOREIGN KEY (prevent_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE catastrophe ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE catastrophe ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN catastrophe.created_at IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE prevention_id_seq CASCADE');
        $this->addSql('DROP TABLE prevention');
        $this->addSql('ALTER TABLE catastrophe ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE catastrophe ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN catastrophe.created_at IS \'(DC2Type:datetime_immutable)\'');
    }
}
