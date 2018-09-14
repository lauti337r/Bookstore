<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180911174151 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE votebook (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, book_id INT NOT NULL, vote INT NOT NULL, INDEX IDX_5923B0B5A76ED395 (user_id), INDEX IDX_5923B0B516A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voteauthor (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, author_id INT NOT NULL, vote INT NOT NULL, INDEX IDX_66FE569FA76ED395 (user_id), INDEX IDX_66FE569FF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE votebook ADD CONSTRAINT FK_5923B0B5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE votebook ADD CONSTRAINT FK_5923B0B516A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE voteauthor ADD CONSTRAINT FK_66FE569FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE voteauthor ADD CONSTRAINT FK_66FE569FF675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE author DROP rating, DROP votes');
        $this->addSql('ALTER TABLE detail CHANGE quantity quantity INT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE votebook');
        $this->addSql('DROP TABLE voteauthor');
        $this->addSql('ALTER TABLE author ADD rating DOUBLE PRECISION DEFAULT NULL, ADD votes INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detail CHANGE quantity quantity INT NOT NULL');
    }
}
