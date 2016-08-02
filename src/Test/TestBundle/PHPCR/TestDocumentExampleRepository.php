<?php

namespace Test\TestBundle\PHPCR;
use Doctrine\ODM\PHPCR\Id\RepositoryIdInterface;
use Test\TestBundle\Lib\Urlizer;

/**
 * Test\TestBundle\PHPCR\TestDocumentExampleRepository
 */
class TestDocumentExampleRepository implements RepositoryIdInterface
{

    /**
     * Generate a document id
     *
     * @param object $document
     * @param object $parent
     *
     * @return string the id for this document
     */
    public function generateId($document, $parent = null)
    {
        return '/cms/simple/'.Urlizer::urlizeTrim($document->getName());
    }
}