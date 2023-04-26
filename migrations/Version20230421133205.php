<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421133205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_contents DROP FOREIGN KEY FK_2A655E1C1AD5CDBF');
        $this->addSql('DROP INDEX UNIQ_2A655E1C1AD5CDBF ON cart_contents');
        $this->addSql('ALTER TABLE cart_contents DROP cart_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD6A9D7A03');
        $this->addSql('DROP INDEX IDX_D34A04AD6A9D7A03 ON product');
        $this->addSql('ALTER TABLE product DROP cart_contents_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_contents ADD cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart_contents ADD CONSTRAINT FK_2A655E1C1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2A655E1C1AD5CDBF ON cart_contents (cart_id)');
        $this->addSql('ALTER TABLE product ADD cart_contents_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD6A9D7A03 FOREIGN KEY (cart_contents_id) REFERENCES cart_contents (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD6A9D7A03 ON product (cart_contents_id)');
    }
}
