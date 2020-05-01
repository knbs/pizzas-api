<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501012125 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pizza_listing_toppings (pizza_listing_id INT NOT NULL, toppings_id INT NOT NULL, INDEX IDX_AC2863A6D0382555 (pizza_listing_id), INDEX IDX_AC2863A6BE2B4234 (toppings_id), PRIMARY KEY(pizza_listing_id, toppings_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toppings (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, k_cal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pizza_listing_toppings ADD CONSTRAINT FK_AC2863A6D0382555 FOREIGN KEY (pizza_listing_id) REFERENCES pizza_listing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pizza_listing_toppings ADD CONSTRAINT FK_AC2863A6BE2B4234 FOREIGN KEY (toppings_id) REFERENCES toppings (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders DROP total_price');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pizza_listing_toppings DROP FOREIGN KEY FK_AC2863A6BE2B4234');
        $this->addSql('DROP TABLE pizza_listing_toppings');
        $this->addSql('DROP TABLE toppings');
        $this->addSql('ALTER TABLE orders ADD total_price INT NOT NULL');
    }
}
