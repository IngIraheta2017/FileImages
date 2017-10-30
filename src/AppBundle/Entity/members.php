<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * members
 *
 * @ORM\Table(name="members")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\membersRepository")
 */
class members {

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
     * @ORM\Column(name="image_path", type="string", length=255)
     */
    private $imagePath;
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     *
     * @return members
     */
    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath() {
        return $this->imagePath;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return members
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return members
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return members
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    function getImage() {
        return $this->image;
    }

    function setImage(UploadedFile $image) {
        $this->image = $image;
    }

    public function getUploadDir() {
        return 'images/events';
    }

    public function getAbsolutePath() {
        return $this->getUploadedPath() . $this->imagePath;
    }

    public function getWebPath() {

        return $this->getUploadDir() . $this->imagePath;
    }

    public function getUploadedPath() {
        return __DIR__ . '/../../../web/' . $this->getUploadDir() . '/';
    }

    public function upload() {
        if ($this->image === null) {
            return;
        } else {
            $this->imagePath = $this->image->getClientOriginalName();
            $this->image->move($this->getUploadedPath(), $this->imagePath);
            unset($this->image);
        }
    }

}
