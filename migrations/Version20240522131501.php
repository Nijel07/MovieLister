<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240522121543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add genre table and movie_genre relationship, and update is_featured column in movie table';
    }

    public function up(Schema $schema): void
    {
        // Ensure all existing records have a non-null value for 'is_featured'
        $this->addSql('UPDATE movie SET is_featured = 0 WHERE is_featured IS NULL');

        // Create the 'genre' and 'movie_genre' tables
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_genre (movie_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_FD1229648F93B6FC (movie_id), INDEX IDX_FD1229644296D31F (genre_id), PRIMARY KEY(movie_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie_genre ADD CONSTRAINT FK_FD1229648F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_genre ADD CONSTRAINT FK_FD1229644296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');

        // Change the 'is_featured' column to NOT NULL
        $this->addSql('ALTER TABLE movie CHANGE is_featured is_featured TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Revert the 'is_featured' column to allow NULL values
        $this->addSql('ALTER TABLE movie CHANGE is_featured is_featured TINYINT(1) DEFAULT NULL');

        // Drop the 'genre' and 'movie_genre' tables
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE movie_genre');
    }
}