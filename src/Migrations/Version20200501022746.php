<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501022746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sqlToppings = <<<SQL
INSERT INTO `toppings` (`id`, `name`, `description`, `k_cal`) VALUES
(1, 'Ham', 'Delicious turkey ham', 300),
(2, 'Pineapple', 'Make it Hawaiian!', 50),
(3, 'Bacon', 'We want meet!', 550),
(4, 'Pepperoni', 'Traditional but tasty', 330),
(5, 'Mushrooms', 'Mmm... delicious', 35),
(6, 'Olives', 'The perfect choice', 30),
(7, 'Onions', 'For make it special', 10),
(8, 'Sausage', 'More Meet', 190),
(9, 'Extra cheese', 'Never is enough', 180),
(10, 'Green peppers', 'For a colorful pizza', 70),
(11, 'Spinach', 'Popeye el marino soy!', 24);
SQL;
        $sqlPizzaListing = <<<SQL
INSERT INTO `pizza_listing` (`id`, `name`, `description`, `price`, `created_at`, `is_active`) VALUES
(1, 'Hawaiian', 'Aloha!', 120, '2020-05-01 04:09:31', 1),
(2, 'Traditional', 'Our speciality!', 100, '2020-05-01 04:10:14', 1),
(3, 'All meet', 'Mmmmmmmmmmmmm', 200, '2020-05-01 04:13:29', 1),
(4, 'Vegan', 'Healthy', 150, '2020-05-01 04:14:46', 1);
SQL;
        $sqlPizzaListingToppings = <<<SQL
INSERT INTO `pizza_listing_toppings` (`pizza_listing_id`, `toppings_id`) VALUES
(1, 1),
(1, 2),
(2, 4),
(3, 3),
(3, 4),
(3, 8),
(3, 9),
(4, 5),
(4, 6),
(4, 7),
(4, 10),
(4, 11);
SQL;
        $sqlOrders = <<<SQL
INSERT INTO `orders` (`id`, `client_name`, `send_address`, `status`, `created_at`) VALUES
(1, 'Juan', 'Street 9th', 4, '2020-05-01 04:18:10');
SQL;
        $sqlOrdersPizzaListing = <<<SQL
INSERT INTO `orders_pizza_listing` (`orders_id`, `pizza_listing_id`) VALUES
(1, 1),
(1, 3);
SQL;

        $this->addSql($sqlToppings);
        $this->addSql($sqlPizzaListing);
        $this->addSql($sqlPizzaListingToppings);
        $this->addSql($sqlOrders);
        $this->addSql($sqlOrdersPizzaListing);

    }

    public function down(Schema $schema) : void
    {
        $sqlToppings = <<<SQL
DELETE FROM  `toppings` WHERE `id` IN (1,2,3,4,5,6,7,8,9,10,11);
SQL;
        $sqlPizzaListing = <<<SQL
DELETE FROM  `pizza_listing` WHERE `id` IN (1,2,3,4);
SQL;
        $sqlOrders = <<<SQL
DELETE FROM  `orders` WHERE `id` = 1;
SQL;

        $this->addSql($sqlToppings);
        $this->addSql($sqlPizzaListing);
        $this->addSql($sqlOrders);
    }
}
