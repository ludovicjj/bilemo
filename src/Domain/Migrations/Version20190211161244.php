<?php

declare(strict_types=1);

namespace App\Domain\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190211161244 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_phone ADD maker_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE lj_phone ADD CONSTRAINT FK_B215A3D468DA5EC3 FOREIGN KEY (maker_id) REFERENCES lj_maker (id)');
        $this->addSql('CREATE INDEX IDX_B215A3D468DA5EC3 ON lj_phone (maker_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_phone DROP FOREIGN KEY FK_B215A3D468DA5EC3');
        $this->addSql('DROP INDEX IDX_B215A3D468DA5EC3 ON lj_phone');
        $this->addSql('ALTER TABLE lj_phone DROP maker_id');
    }
}
