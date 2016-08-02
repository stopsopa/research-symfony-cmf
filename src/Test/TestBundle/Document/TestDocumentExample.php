<?php

namespace Test\TestBundle\Document;

use LogicException;
use Knp\Menu\NodeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishTimePeriodInterface;
use Symfony\Cmf\Bundle\CoreBundle\PublishWorkflow\PublishableInterface;
use Symfony\Cmf\Bundle\CoreBundle\Translatable\TranslatableInterface;
use Symfony\Cmf\Bundle\MenuBundle\Model\MenuOptionsInterface;
use Symfony\Cmf\Bundle\MenuBundle\Model\Page;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use PHPCR\NodeInterface as PHPCRNodeInterface;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * http://symfony.com/doc/current/cmf/bundles/phpcr_odm/introduction.html#doctrine-phpcr-odm-configuration
 * Test\TestBundle\PHPCR\TestDocumentExample
 */
class TestDocumentExample{
    protected $id;
    protected $name;
    protected $surname;
    protected $multi;

    public function __construct()
    {
        $this->multi = array();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return TestDocumentExample
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return TestDocumentExample
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     * @return TestDocumentExample
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMulti()
    {
        return $this->multi;
    }

    /**
     * @param mixed $multi
     * @return TestDocumentExample
     */
    public function setMulti($multi)
    {
        $this->multi = $multi;
        return $this;
    }

}
