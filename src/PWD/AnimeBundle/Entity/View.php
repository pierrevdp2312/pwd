<?php

namespace PWD\AnimeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * View
 *
 * @ORM\Table(name="view")
 * @ORM\Entity(repositoryClass="PWD\AnimeBundle\Repository\ViewRepository")
 */
class View
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
     * @ORM\ManyToOne(targetEntity="PWD\UserBundle\Entity\User", cascade={"persist"})
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="PWD\AnimeBundle\Entity\Anime", cascade={"persist"})
     */
    private $anime;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \PWD\UserBundle\Entity\User $user
     *
     * @return View
     */
    public function setUser(\PWD\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PWD\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set anime
     *
     * @param \PWD\AnimeBundle\Entity\Anime $anime
     *
     * @return View
     */
    public function setAnime(\PWD\AnimeBundle\Entity\Anime $anime = null)
    {
        $this->anime = $anime;

        return $this;
    }

    /**
     * Get anime
     *
     * @return \PWD\AnimeBundle\Entity\Anime
     */
    public function getAnime()
    {
        return $this->anime;
    }
}
