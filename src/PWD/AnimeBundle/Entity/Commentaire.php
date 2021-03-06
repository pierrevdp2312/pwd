<?php

namespace PWD\AnimeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="PWD\AnimeBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\Column(name="text", type="text")
     */
    private $text;
    
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
     * Set text
     *
     * @param string $text
     *
     * @return Commentaire
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set user
     *
     * @param \PWD\UserBundle\Entity\User $user
     *
     * @return Commentaire
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
     * @return Commentaire
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
