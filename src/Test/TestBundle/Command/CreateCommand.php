<?php

namespace Test\TestBundle\Command;

use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Test\TestBundle\Document\TestDocumentExample;

class CreateCommand extends ContainerAwareCommand {
    protected function configure()
    {
        $this
            ->setName('test:create')
        ;

    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
//        string(43) "Doctrine\Bundle\PHPCRBundle\ManagerRegistry" -> doctrine_phpcr
//string(34) "Doctrine\ODM\PHPCR\DocumentManager" doctrine_phpcr.odm.default_document_manager or
//
//      $registry = $this->get('doctrine_phpcr');
//      $docMan = $registry->getManagerForClass('Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page')

        /* @var $dp ManagerRegistry */
        $dp = $this->getContainer()->get('doctrine_phpcr');

//        $docMan = $dp->getManagerForClass(Page::class);
        $man = $dp->getManagerForClass(TestDocumentExample::class);

        $example = new TestDocumentExample();

        $example
            ->setName('name vale23')
            ->setSurname('surname val')
            ->setMulti(array('one', 'two'))
        ;

        $man->persist($example);
        $man->flush();
    }
}