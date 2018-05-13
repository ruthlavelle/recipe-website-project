<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180513193913 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment CHANGE comment comment TEXT NOT NULL');
        $this->addSql('ALTER TABLE recipe CHANGE image image LONGTEXT NOT NULL, CHANGE title title LONGTEXT NOT NULL, CHANGE tags tags TEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment CHANGE comment comment VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE recipe CHANGE image image VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE title title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE tags tags VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
