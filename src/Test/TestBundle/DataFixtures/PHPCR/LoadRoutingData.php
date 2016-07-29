<?php

// src/Acme/DemoBundle/DataFixtures/PHPCR/LoadRoutingData.php
namespace Test\TestBundle\DataFixtures\PHPCR;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\ODM\PHPCR\DocumentManager;

use PHPCR\Util\NodeHelper;

use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class LoadRoutingData implements FixtureInterface, OrderedFixtureInterface
{

    public function load(ObjectManager $documentManager)
    {
        if (!$documentManager instanceof DocumentManager) {
            $class = get_class($documentManager);
            throw new \RuntimeException("Fixture requires a PHPCR ODM DocumentManager instance, instance of '$class' given.");
        }

        $session = $documentManager->getPhpcrSession();
        NodeHelper::createPath($session, '/cms/routes');

        $routesRoot = $documentManager->find(null, '/cms/routes');

        $route = new Route();
// set $routesRoot as the parent and 'new-route' as the node name,
// this is equal to:
// $route->setName('new-route');
// $route->setParentDocument($routesRoot);
        $route->setPosition($routesRoot, 'new-route');

        $page = $documentManager->find(null, '/cms/simple/quick_tour');
        $route->setContent($page);

        $documentManager->persist($route); // put $route in the queue
        $documentManager->flush(); // save it
    }
    public function getOrder()
    {
        return 20;
    }
}