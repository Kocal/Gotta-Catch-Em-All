<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260207230615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration for creating user and pokemon tables, and messenger messages table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE app_user (id BLOB NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON app_user (username)');
        $this->addSql('CREATE TABLE user_pokemon (user_id BLOB NOT NULL, pokemon_id INTEGER UNSIGNED NOT NULL, created_at VARCHAR(255) NOT NULL, PRIMARY KEY (user_id, pokemon_id))');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 ON messenger_messages (queue_name, available_at, delivered_at, id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE app_user');
        $this->addSql('DROP TABLE user_pokemon');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
