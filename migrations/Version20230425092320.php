<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425092320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_categories DROP FOREIGN KEY FK_739C615412469DE2');
        $this->addSql('ALTER TABLE quiz_categories DROP FOREIGN KEY FK_739C6154853CD175');
        $this->addSql('DROP TABLE quiz_categories');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_categories (id INT AUTO_INCREMENT NOT NULL, quiz_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_739C615412469DE2 (category_id), INDEX IDX_739C6154853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quiz_categories ADD CONSTRAINT FK_739C615412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE quiz_categories ADD CONSTRAINT FK_739C6154853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
