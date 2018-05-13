<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180513173224 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recipe CHANGE summary summary LONGTEXT NOT NULL, CHANGE list_of_ingredients list_of_ingredients LONGTEXT NOT NULL, CHANGE sequence_of_steps sequence_of_steps LONGTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE recipe CHANGE summary summary VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE list_of_ingredients list_of_ingredients VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE sequence_of_steps sequence_of_steps VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
