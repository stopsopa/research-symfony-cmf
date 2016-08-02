<?php

namespace Test\TestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Test\TestBundle\Document\TestDocumentExample;

use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;


class FetchCommand extends ContainerAwareCommand {
    protected function configure()
    {
        $this
            ->setName('test:fetch')
        ;

    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $dp ManagerRegistry */
        $dp = $this->getContainer()->get('doctrine_phpcr');
                
//        die(var_dump(get_class($dp)));

        /* @var $dp ObjectManager */
        /* @var $dp ManagerRegistry */
        $man = $dp->getManagerForClass(TestDocumentExample::class);

        $doc = $man->find(null, '/cms/simple/name-value');

        $d = (array)$doc;
        print_r($d);
        die(var_dump(get_class($doc)));
    }
}