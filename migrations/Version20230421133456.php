<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421133456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_contents ADD product_id INT NOT NULL, ADD cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart_contents ADD CONSTRAINT FK_2A655E1C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart_contents ADD CONSTRAINT FK_2A655E1C1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_2A655E1C4584665A ON cart_contents (product_id)');
        $this->addSql('CREATE INDEX IDX_2A655E1C1AD5CDBF ON cart_contents (cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_contents DROP FOREIGN KEY FK_2A655E1C4584665A');
        $this->addSql('ALTER TABLE cart_contents DROP FOREIGN KEY FK_2A655E1C1AD5CDBF');
        $this->addSql('DROP INDEX IDX_2A655E1C4584665A ON cart_contents');
        $this->addSql('DROP INDEX IDX_2A655E1C1AD5CDBF ON cart_contents');
        $this->addSql('ALTER TABLE cart_contents DROP product_id, DROP cart_id');
    }
}
