<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131073438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces_users (annonces_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_F60119834C2885D7 (annonces_id), INDEX IDX_F601198367B3B43D (users_id), PRIMARY KEY(annonces_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces_users ADD CONSTRAINT FK_F60119834C2885D7 FOREIGN KEY (annonces_id) REFERENCES annonces (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_users ADD CONSTRAINT FK_F601198367B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces DROP image');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annonces_users');
        $this->addSql('ALTER TABLE annonces ADD image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
