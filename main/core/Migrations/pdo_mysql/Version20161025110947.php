<?php

namespace Claroline\CoreBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution.
 *
 * Generation date: 2016/10/25 11:09:48
 */
class Version20161025110947 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE claro_field_facet_value CHANGE user_id user_id INT DEFAULT NULL
        ');
        $this->addSql("
            ALTER TABLE claro_field_facet 
            ADD resource_node INT DEFAULT NULL, 
            ADD is_visible TINYINT(1) DEFAULT '1' NOT NULL, 
            CHANGE position position INT DEFAULT NULL, 
            CHANGE panelFacet_id panelFacet_id INT DEFAULT NULL
        ");
        $this->addSql('
            ALTER TABLE claro_field_facet 
            ADD CONSTRAINT FK_F6C21DB28A5F48FF FOREIGN KEY (resource_node) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ');
        $this->addSql('
            CREATE INDEX IDX_F6C21DB28A5F48FF ON claro_field_facet (resource_node)
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE claro_field_facet 
            DROP FOREIGN KEY FK_F6C21DB28A5F48FF
        ');
        $this->addSql('
            DROP INDEX IDX_F6C21DB28A5F48FF ON claro_field_facet
        ');
        $this->addSql('
            ALTER TABLE claro_field_facet 
            DROP resource_node, 
            DROP is_visible, 
            CHANGE position position INT NOT NULL, 
            CHANGE panelFacet_id panelFacet_id INT NOT NULL
        ');
        $this->addSql('
            ALTER TABLE claro_field_facet_value CHANGE user_id user_id INT NOT NULL
        ');
    }
}
