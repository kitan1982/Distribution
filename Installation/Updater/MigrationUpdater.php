<?php
/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\AgendaBundle\Installation\Updater;

use Claroline\InstallationBundle\Updater\Updater;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Version;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MigrationUpdater extends Updater
{
    private $container;
    private $conn;
    private $om;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->conn = $container->get('database_connection');
        $this->om = $container->get('claroline.persistence.object_manager');
    }

    public function preInstall()
    {
        $this->skipInstallIfMigratingFromCore();
    }

    public function postInstall()
    {
        $this->reusePreviousExtensionIfAny('tool');
        $this->reusePreviousExtensionIfAny('widget');
    }

    private function skipInstallIfMigratingFromCore()
    {
        if ($this->conn->getSchemaManager()->tablesExist(['claro_event'])) {
            $this->log('Found existing database schema: skipping install migration...');
            $config = new Configuration($this->conn);
            $config->setMigrationsTableName('doctrine_clarolineagendabundle_versions');
            $config->setMigrationsNamespace('claro_event'); // required but useless
            $config->setMigrationsDirectory('claro_event'); // idem
            $version = new Version($config, '20150429110105', 'stdClass');
            $version->markMigrated();
        }
    }

    private function reusePreviousExtensionIfAny($type)
    {
        if ($previous = $this->find($type, 'agenda')) {
            $this->log("Re-using previous agenda {$type}...");
            $current = $this->find($type, 'agenda_');
            $current->setName('agenda_tmp');
            $this->om->forceFlush();
            $previous->setName('agenda_');
            $previous->setPlugin($current->getPlugin());
            $this->om->remove($current);
            $this->om->forceFlush();
        }
    }

    private function find($type, $name)
    {
        $class = $type === 'tool' ?
            'Claroline\CoreBundle\Entity\Tool\Tool' :
            'Claroline\CoreBundle\Entity\Widget\Widget';

        return $this->om
            ->getRepository($class)
            ->findOneBy(['name' => $name]);
    }
}
