<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationRepository")
 */
class Application
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_application", type="date", nullable=true)
     */
    private $dateApplication;

    /**
     * @var string
     *
     * @ORM\Column(name="cv_file", type="string", length=255, nullable=true)
     */
    private $cvFile;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="applications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="JobOffer", inversedBy="applications")
     * @ORM\JoinColumn(name="job_offer_id", referencedColumnName="id")
     */
    private $jobOffer;


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
     * Set dateApplication
     *
     * @param \DateTime $dateApplication
     *
     * @return Application
     */
    public function setDateApplication($dateApplication)
    {
        $this->dateApplication = $dateApplication;

        return $this;
    }

    /**
     * Get dateApplication
     *
     * @return \DateTime
     */
    public function getDateApplication()
    {
        return $this->dateApplication;
    }

    /**
     * Set cvFile
     *
     * @param string $cvFile
     *
     * @return Application
     */
    public function setCvFile($cvFile)
    {
        $this->cvFile = $cvFile;

        return $this;
    }

    /**
     * Get cvFile
     *
     * @return string
     */
    public function getCvFile()
    {
        return $this->cvFile;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Application
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Application
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set jobOffer
     *
     * @param \AppBundle\Entity\JobOffer $jobOffer
     *
     * @return Application
     */
    public function setJobOffer(\AppBundle\Entity\JobOffer $jobOffer = null)
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }

    /**
     * Get jobOffer
     *
     * @return \AppBundle\Entity\JobOffer
     */
    public function getJobOffer()
    {
        return $this->jobOffer;
    }
}
