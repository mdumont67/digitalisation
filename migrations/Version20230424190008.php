<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424190008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E3D608E42');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, axis_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_64C19C1237411EF (axis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, compagny_id INT NOT NULL, INDEX IDX_A412FA921224ABE0 (compagny_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_axis (quiz_id INT NOT NULL, axis_id INT NOT NULL, INDEX IDX_4FFE7AA1853CD175 (quiz_id), INDEX IDX_4FFE7AA1237411EF (axis_id), PRIMARY KEY(quiz_id, axis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_categories (id INT AUTO_INCREMENT NOT NULL, quiz_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_739C6154853CD175 (quiz_id), INDEX IDX_739C615412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_questions (id INT AUTO_INCREMENT NOT NULL, quiz_id INT NOT NULL, question_id INT NOT NULL, rating INT NOT NULL, INDEX IDX_8CBC2533853CD175 (quiz_id), INDEX IDX_8CBC25331E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1237411EF FOREIGN KEY (axis_id) REFERENCES axis (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA921224ABE0 FOREIGN KEY (compagny_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE quiz_axis ADD CONSTRAINT FK_4FFE7AA1853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_axis ADD CONSTRAINT FK_4FFE7AA1237411EF FOREIGN KEY (axis_id) REFERENCES axis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_categories ADD CONSTRAINT FK_739C6154853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_categories ADD CONSTRAINT FK_739C615412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE quiz_questions ADD CONSTRAINT FK_8CBC2533853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_questions ADD CONSTRAINT FK_8CBC25331E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE quiz_category DROP FOREIGN KEY FK_D088E084237411EF');
        $this->addSql('DROP TABLE quiz_category');
        $this->addSql('DROP INDEX IDX_B6F7494E3D608E42 ON question');
        $this->addSql('ALTER TABLE question DROP rating, CHANGE quiz_category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E12469DE2 ON question (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E12469DE2');
        $this->addSql('CREATE TABLE quiz_category (id INT AUTO_INCREMENT NOT NULL, axis_id INT DEFAULT NULL, label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, active TINYINT(1) NOT NULL, INDEX IDX_D088E084237411EF (axis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quiz_category ADD CONSTRAINT FK_D088E084237411EF FOREIGN KEY (axis_id) REFERENCES axis (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1237411EF');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA921224ABE0');
        $this->addSql('ALTER TABLE quiz_axis DROP FOREIGN KEY FK_4FFE7AA1853CD175');
        $this->addSql('ALTER TABLE quiz_axis DROP FOREIGN KEY FK_4FFE7AA1237411EF');
        $this->addSql('ALTER TABLE quiz_categories DROP FOREIGN KEY FK_739C6154853CD175');
        $this->addSql('ALTER TABLE quiz_categories DROP FOREIGN KEY FK_739C615412469DE2');
        $this->addSql('ALTER TABLE quiz_questions DROP FOREIGN KEY FK_8CBC2533853CD175');
        $this->addSql('ALTER TABLE quiz_questions DROP FOREIGN KEY FK_8CBC25331E27F6BF');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_axis');
        $this->addSql('DROP TABLE quiz_categories');
        $this->addSql('DROP TABLE quiz_questions');
        $this->addSql('DROP INDEX IDX_B6F7494E12469DE2 ON question');
        $this->addSql('ALTER TABLE question ADD rating INT NOT NULL, CHANGE category_id quiz_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E3D608E42 FOREIGN KEY (quiz_category_id) REFERENCES quiz_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6F7494E3D608E42 ON question (quiz_category_id)');
    }
}
