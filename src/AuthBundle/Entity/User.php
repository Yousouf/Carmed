<?php
/**
 * Created by PhpStorm.
 * User: majdi
 * Date: 12/02/2018
 * Time: 14:17
 */

namespace AuthBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToMany;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use FOS\UserBundle\Model\UserInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="sp_user")
 * @ORM\Entity(repositoryClass="AuthBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id_user", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @Groups({"user"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user"})
     */
    protected $firstname;

    /**
     * @Groups({"user"})
     * @var string
     */
    protected $role;

    /**
     * @Groups({"user"})
     */
    protected $plainPassword;

    /**
     * @Groups({"user"})
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user"})
     */
    protected $lastname;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user"})
     */
    protected $menu;



    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }


    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }


    public function setRole($role)
    {
        parent::addRole($role);
    }

    public function isUser(?UserInterface $user = null): bool
    {
        return $user instanceof self && $user->id === $this->id;
    }


    /**
     * Set menu.
     *
     * @param string|null $menu
     *
     * @return User
     */
    public function setMenu($menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu.
     *
     * @return string|null
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
