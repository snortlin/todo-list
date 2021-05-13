<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210511000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tasks (id UUID NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, completion_date TEXT DEFAULT NULL, priority INT DEFAULT NULL, completed BOOLEAN DEFAULT \'false\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE tasks IS \'ToDo Tasks\'');
        $this->addSql('COMMENT ON COLUMN tasks.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tasks.created_at IS \'Date of creation\'');
        $this->addSql('COMMENT ON COLUMN tasks.updated_at IS \'Date of last change\'');
        $this->addSql('CREATE INDEX idx_tasks_completion_date ON tasks (completion_date)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tasks');
    }
}
