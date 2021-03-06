<?php

namespace Icap\PortfolioBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/10/31 04:51:42
 */
class Version20141031165140 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE icap__portfolio_teams (
                id INT AUTO_INCREMENT NOT NULL, 
                team_id INT NOT NULL, 
                portfolio_id INT NOT NULL, 
                INDEX IDX_BBC17F49296CD8AE (team_id), 
                INDEX IDX_BBC17F49B96B5643 (portfolio_id), 
                UNIQUE INDEX portfolio_teams_unique_idx (portfolio_id, team_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE icap__portfolio_comments (
                id INT AUTO_INCREMENT NOT NULL, 
                portfolio_id INT NOT NULL, 
                sender_id INT NOT NULL, 
                message LONGTEXT NOT NULL, 
                sending_date DATETIME NOT NULL, 
                INDEX IDX_D4662DE3B96B5643 (portfolio_id), 
                INDEX IDX_D4662DE3F624B39D (sender_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE icap__portfolio_guides (
                id INT AUTO_INCREMENT NOT NULL, 
                user_id INT NOT NULL, 
                portfolio_id INT NOT NULL, 
                comments_view_at DATETIME NOT NULL, 
                INDEX IDX_27EAB640A76ED395 (user_id), 
                INDEX IDX_27EAB640B96B5643 (portfolio_id), 
                UNIQUE INDEX portfolio_users_unique_idx (portfolio_id, user_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE icap__portfolio_widget_text (
                id INT NOT NULL, 
                text LONGTEXT DEFAULT NULL, 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio_teams 
            ADD CONSTRAINT FK_BBC17F49296CD8AE FOREIGN KEY (team_id) 
            REFERENCES claro_team (id)
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio_teams 
            ADD CONSTRAINT FK_BBC17F49B96B5643 FOREIGN KEY (portfolio_id) 
            REFERENCES icap__portfolio (id)
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio_comments 
            ADD CONSTRAINT FK_D4662DE3B96B5643 FOREIGN KEY (portfolio_id) 
            REFERENCES icap__portfolio (id)
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio_comments 
            ADD CONSTRAINT FK_D4662DE3F624B39D FOREIGN KEY (sender_id) 
            REFERENCES claro_user (id)
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio_guides 
            ADD CONSTRAINT FK_27EAB640A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id)
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio_guides 
            ADD CONSTRAINT FK_27EAB640B96B5643 FOREIGN KEY (portfolio_id) 
            REFERENCES icap__portfolio (id)
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio_widget_text 
            ADD CONSTRAINT FK_89550C61BF396750 FOREIGN KEY (id) 
            REFERENCES icap__portfolio_abstract_widget (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio 
            ADD comments_view_at DATETIME NOT NULL
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio_abstract_widget 
            ADD `label` VARCHAR(255) NOT NULL
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE icap__portfolio_teams
        ");
        $this->addSql("
            DROP TABLE icap__portfolio_comments
        ");
        $this->addSql("
            DROP TABLE icap__portfolio_guides
        ");
        $this->addSql("
            DROP TABLE icap__portfolio_widget_text
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio 
            DROP comments_view_at
        ");
        $this->addSql("
            ALTER TABLE icap__portfolio_abstract_widget 
            DROP `label`
        ");
    }
}