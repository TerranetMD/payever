<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->truncateTable($manager, ['AppBundle:Album', 'AppBundle:Picture']);

        Fixtures::load(__DIR__ . '/albums.yml', $manager);

        Fixtures::load(__DIR__ . '/pictures.yml', $manager);
    }

    /**
     * @param ObjectManager $manager
     * @param $repositories
     */
    protected function truncateTable(ObjectManager $manager, array $repositories = [])
    {
        $connection = $manager->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');

        foreach ($repositories as $repository) {
            $cmd = $manager->getClassMetadata($repository);
            $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
            $connection->executeUpdate($q);
        }

        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }
}