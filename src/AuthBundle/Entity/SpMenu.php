<?php

namespace AuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="sp_menu")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\SpMenuRepository")
 */
class SpMenu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="parent", type="integer")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="root", type="string", length=255)
     */
    private $root;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255)
     */
    private $class;

    /**
     * @var bool
     *
     * @ORM\Column(name="isadmin", type="boolean")
     */
    private $isadmin;

    /**
     * @var string
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort;

    public static function spectroFun()
    {
        return array(
            '  ########   ########   ########   ########   ########   ########   ########',
            '  ########   ########   ########   ########   ########   ########   ########',
            '  ###        ##    ##   ##         ####          ##      ##    ##   ##    ##',
            '  ###        ##    ##   ##         ###           ##      ##    ##   ##    ##',
            '  ########   ########   ########   ##            ##      ########   ##    ##',
            '  ########   ########   ########   ##            ##      ########   ##    ##',
            '       ###   ###        ##         ###           ##      ## ##      ##    ##',
            '       ###   ###        ##         ####          ##      ##  ##     ##    ##',
            '  ########   ###        ########   ########      ##      ##   ##    ########',
            '  ########   ###        ########   ########      ##      ##    ##   ########',
            '                                                           © Youssef    2018',
        );
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return SpMenu
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parent.
     *
     * @param int $parent
     *
     * @return SpMenu
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set root.
     *
     * @param string $root
     *
     * @return SpMenu
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root.
     *
     * @return string
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set class.
     *
     * @param string $class
     *
     * @return SpMenu
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set isadmin.
     *
     * @param bool $isadmin
     *
     * @return SpMenu
     */
    public function setIsadmin($isadmin)
    {
        $this->isadmin = $isadmin;

        return $this;
    }

    /**
     * Get isadmin.
     *
     * @return bool
     */
    public function getIsadmin()
    {
        return $this->isadmin;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return SpMenu
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set sort.
     *
     * @param int $sort
     *
     * @return SpMenu
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort.
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }
}
