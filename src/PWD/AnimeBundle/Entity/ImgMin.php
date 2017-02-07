<?php

namespace PWD\AnimeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * ImgMin
 *
 * @ORM\Table(name="img_min")
 * @ORM\Entity(repositoryClass="PWD\AnimeBundle\Repository\ImgMinRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ImgMin
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
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    private $file;
    
    private $tempFilename;
    
    public function getFile(){
        return $this->file;
    }
    
    /**
     * 
     * @param UploadedFile $file
     */
    
    public function setFile(UploadedFile $file){
        $this->file=$file;
        if(null !== $this->url){
            $this->tempFilename = $this->url;
            $this->url=null;
            $this->alt=null;
        }
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){
        if(null === $this->file){
            return;
        }
        $this->url=$this->file->guessExtension();
        $this->alt=$this->file->getClientOriginalName();
    }
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if(null === $this->file){
            return;
        }
        if(null !== $this->tempFilename){
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'min.'.$this->tempFilename;
            if(file_exists($oldFile)){
                unlink($oldFile);
            }
        }
        $this->file->move(
            $this->getUploadRootDir(),
            $this->id.'min.'.$this->url
        );
    }
    /**
    * @ORM\PreRemove()
    */
    public function preRemoveUpload(){
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'min.'.$this->url;
    }
    /**
    * @ORM\PostRemove()
    */
    public function removeUpload(){
        if(file_exists($this->tempFilename)){
            unlink($this->tempFilename);
        }
    }
    public function getUploadDir(){
        return 'uploads/img';
    }
    protected function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
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
     * Set name
     *
     * @param string $name
     *
     * @return ImgMin
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return ImgMin
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ImgMin
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    public function getWebPath(){
        return $this->getUploadDir().'/'.$this->getId().'min.'.$this->getUrl();
    }
}

