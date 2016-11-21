<?php

namespace Claroline\ClacoFormBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2016/11/21 09:44:52
 */
class Version20161121094450 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_comment (
                id INT AUTO_INCREMENT NOT NULL, 
                user_id INT DEFAULT NULL, 
                entry_id INT DEFAULT NULL, 
                content LONGTEXT NOT NULL, 
                creation_date DATETIME NOT NULL, 
                edition_date DATETIME DEFAULT NULL, 
                comment_status INT NOT NULL, 
                INDEX IDX_23B30E0A76ED395 (user_id), 
                INDEX IDX_23B30E0BA364942 (entry_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_entry (
                id INT AUTO_INCREMENT NOT NULL, 
                claco_form_id INT NOT NULL, 
                user_id INT DEFAULT NULL, 
                title VARCHAR(255) NOT NULL, 
                entry_status INT NOT NULL, 
                INDEX IDX_889DAEDFF7D9CC0C (claco_form_id), 
                INDEX IDX_889DAEDFA76ED395 (user_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_entry_value (
                entry_id INT NOT NULL, 
                fieldfacetvalue_id INT NOT NULL, 
                INDEX IDX_1B3C48E4BA364942 (entry_id), 
                INDEX IDX_1B3C48E49F093814 (fieldfacetvalue_id), 
                PRIMARY KEY(entry_id, fieldfacetvalue_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_entry_category (
                entry_id INT NOT NULL, 
                category_id INT NOT NULL, 
                INDEX IDX_2009A6BEBA364942 (entry_id), 
                INDEX IDX_2009A6BE12469DE2 (category_id), 
                PRIMARY KEY(entry_id, category_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_entry_keyword (
                entry_id INT NOT NULL, 
                keyword_id INT NOT NULL, 
                INDEX IDX_C61CA20BBA364942 (entry_id), 
                INDEX IDX_C61CA20B115D4552 (keyword_id), 
                PRIMARY KEY(entry_id, keyword_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_claco_form (
                id INT AUTO_INCREMENT NOT NULL, 
                template LONGTEXT DEFAULT NULL, 
                details LONGTEXT DEFAULT NULL COMMENT '(DC2Type:json_array)', 
                resourceNode_id INT DEFAULT NULL, 
                UNIQUE INDEX UNIQ_ACB82378B87FAB32 (resourceNode_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_field (
                id INT AUTO_INCREMENT NOT NULL, 
                claco_form_id INT NOT NULL, 
                field_facet_id INT DEFAULT NULL, 
                field_name VARCHAR(255) NOT NULL, 
                field_type INT NOT NULL, 
                required TINYINT(1) NOT NULL, 
                searchable TINYINT(1) NOT NULL, 
                is_metadata TINYINT(1) NOT NULL, 
                INDEX IDX_F84976F7F7D9CC0C (claco_form_id), 
                UNIQUE INDEX UNIQ_F84976F72AB018E9 (field_facet_id), 
                UNIQUE INDEX field_unique_name (claco_form_id, field_name), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_keyword (
                id INT AUTO_INCREMENT NOT NULL, 
                claco_form_id INT NOT NULL, 
                keyword_name VARCHAR(255) NOT NULL, 
                INDEX IDX_CCDC13B7F7D9CC0C (claco_form_id), 
                UNIQUE INDEX field_unique_name (claco_form_id, keyword_name), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_category (
                id INT AUTO_INCREMENT NOT NULL, 
                claco_form_id INT NOT NULL, 
                category_name VARCHAR(255) NOT NULL, 
                details LONGTEXT DEFAULT NULL COMMENT '(DC2Type:json_array)', 
                INDEX IDX_E2D499A8F7D9CC0C (claco_form_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE claro_clacoformbundle_category_manager (
                category_id INT NOT NULL, 
                user_id INT NOT NULL, 
                INDEX IDX_562FC19412469DE2 (category_id), 
                INDEX IDX_562FC194A76ED395 (user_id), 
                PRIMARY KEY(category_id, user_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_comment 
            ADD CONSTRAINT FK_23B30E0A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_comment 
            ADD CONSTRAINT FK_23B30E0BA364942 FOREIGN KEY (entry_id) 
            REFERENCES claro_clacoformbundle_entry (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry 
            ADD CONSTRAINT FK_889DAEDFF7D9CC0C FOREIGN KEY (claco_form_id) 
            REFERENCES claro_clacoformbundle_claco_form (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry 
            ADD CONSTRAINT FK_889DAEDFA76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_value 
            ADD CONSTRAINT FK_1B3C48E4BA364942 FOREIGN KEY (entry_id) 
            REFERENCES claro_clacoformbundle_entry (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_value 
            ADD CONSTRAINT FK_1B3C48E49F093814 FOREIGN KEY (fieldfacetvalue_id) 
            REFERENCES claro_field_facet_value (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_category 
            ADD CONSTRAINT FK_2009A6BEBA364942 FOREIGN KEY (entry_id) 
            REFERENCES claro_clacoformbundle_entry (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_category 
            ADD CONSTRAINT FK_2009A6BE12469DE2 FOREIGN KEY (category_id) 
            REFERENCES claro_clacoformbundle_category (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_keyword 
            ADD CONSTRAINT FK_C61CA20BBA364942 FOREIGN KEY (entry_id) 
            REFERENCES claro_clacoformbundle_entry (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_keyword 
            ADD CONSTRAINT FK_C61CA20B115D4552 FOREIGN KEY (keyword_id) 
            REFERENCES claro_clacoformbundle_keyword (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_claco_form 
            ADD CONSTRAINT FK_ACB82378B87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_field 
            ADD CONSTRAINT FK_F84976F7F7D9CC0C FOREIGN KEY (claco_form_id) 
            REFERENCES claro_clacoformbundle_claco_form (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_field 
            ADD CONSTRAINT FK_F84976F72AB018E9 FOREIGN KEY (field_facet_id) 
            REFERENCES claro_field_facet (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_keyword 
            ADD CONSTRAINT FK_CCDC13B7F7D9CC0C FOREIGN KEY (claco_form_id) 
            REFERENCES claro_clacoformbundle_claco_form (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_category 
            ADD CONSTRAINT FK_E2D499A8F7D9CC0C FOREIGN KEY (claco_form_id) 
            REFERENCES claro_clacoformbundle_claco_form (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_category_manager 
            ADD CONSTRAINT FK_562FC19412469DE2 FOREIGN KEY (category_id) 
            REFERENCES claro_clacoformbundle_category (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_category_manager 
            ADD CONSTRAINT FK_562FC194A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_comment 
            DROP FOREIGN KEY FK_23B30E0BA364942
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_value 
            DROP FOREIGN KEY FK_1B3C48E4BA364942
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_category 
            DROP FOREIGN KEY FK_2009A6BEBA364942
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_keyword 
            DROP FOREIGN KEY FK_C61CA20BBA364942
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry 
            DROP FOREIGN KEY FK_889DAEDFF7D9CC0C
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_field 
            DROP FOREIGN KEY FK_F84976F7F7D9CC0C
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_keyword 
            DROP FOREIGN KEY FK_CCDC13B7F7D9CC0C
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_category 
            DROP FOREIGN KEY FK_E2D499A8F7D9CC0C
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_keyword 
            DROP FOREIGN KEY FK_C61CA20B115D4552
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_entry_category 
            DROP FOREIGN KEY FK_2009A6BE12469DE2
        ");
        $this->addSql("
            ALTER TABLE claro_clacoformbundle_category_manager 
            DROP FOREIGN KEY FK_562FC19412469DE2
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_comment
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_entry
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_entry_value
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_entry_category
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_entry_keyword
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_claco_form
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_field
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_keyword
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_category
        ");
        $this->addSql("
            DROP TABLE claro_clacoformbundle_category_manager
        ");
    }
}