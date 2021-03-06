<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180901123048 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE role role VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE genre_book DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE genre_book ADD PRIMARY KEY (book_id, genre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE genre_book DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE genre_book ADD PRIMARY KEY (genre_id, book_id)');
        $this->addSql('ALTER TABLE user CHANGE role role VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
