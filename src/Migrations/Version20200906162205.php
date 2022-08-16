<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906162205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

       
        #$this->addSql('CREATE TABLE comentario (id INT AUTO_INCREMENT NOT NULL, orden_id INT DEFAULT NULL, descripcion VARCHAR(200) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_4B91E7029750851F (orden_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        #$this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E7029750851F FOREIGN KEY (orden_id) REFERENCES orden (id)');
        $this->addSql('ALTER TABLE cofiguracion CHANGE nombre nombre VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE orden ADD user_id INT DEFAULT NULL, CHANGE fecha fecha DATE DEFAULT  NULL');
        $this->addSql('ALTER TABLE orden ADD CONSTRAINT FK_E128CFD7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E128CFD7A76ED395 ON orden (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE comentario');
        $this->addSql('ALTER TABLE cofiguracion CHANGE nombre nombre VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE orden DROP FOREIGN KEY FK_E128CFD7A76ED395');
        $this->addSql('DROP INDEX IDX_E128CFD7A76ED395 ON orden');
        $this->addSql('ALTER TABLE orden DROP user_id, CHANGE fecha fecha DATE NOT NULL');
    }
}
