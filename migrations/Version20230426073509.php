<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426073509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_axis DROP FOREIGN KEY FK_4FFE7AA1237411EF');
        $this->addSql('ALTER TABLE quiz_axis DROP FOREIGN KEY FK_4FFE7AA1853CD175');
        $this->addSql('DROP TABLE quiz_axis');
        $this->addSql('ALTER TABLE quiz_questions CHANGE quiz_id quiz_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_axis (quiz_id INT NOT NULL, axis_id INT NOT NULL, INDEX IDX_4FFE7AA1237411EF (axis_id), INDEX IDX_4FFE7AA1853CD175 (quiz_id), PRIMARY KEY(quiz_id, axis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quiz_axis ADD CONSTRAINT FK_4FFE7AA1237411EF FOREIGN KEY (axis_id) REFERENCES axis (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_axis ADD CONSTRAINT FK_4FFE7AA1853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_questions CHANGE quiz_id quiz_id INT DEFAULT NULL');
    }
}
