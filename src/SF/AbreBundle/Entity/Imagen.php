<?php

namespace SF\AbreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Imagen
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
  
    /**
     * @Assert\Image(
     *     maxSize = "4M",
     *     mimeTypesMessage = "El archivo no es una imagen."
     * )
     */
    public $fileref;

    private $uploadDir = 'recursos';
    
    private $rootDir = '.';

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->fileref) {
            // do whatever you want to generate a unique name
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->fileref->guessExtension();
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }
    
    /**
     * Set upload directory
     */
    public function setUploadDir($path) 
    {
        $this->uploadDir = $path;
    }
    
    /**
     * Set root directory
     */
    public function setRootDir($path)
    {
        $this->rootDir = $path;
    }
    
    /**
     * Get root directory
     */
    private function getRootDir()
    {
        return $this->rootDir;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return $this->getRootDir() . '/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return $this->uploadDir;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
	
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->fileref) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->fileref->move($this->getUploadRootDir(), $this->path);

        unset($this->fileref);
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
    
    public function __toString() {
      return (string) $this->getId();
    }
    
}