<?php

namespace AppBundle\Entity;

use AppBundle\Form\SubjectType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * User Entity
 *
 * @ORM\Table(name="Users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser implements AdvancedUserInterface, \Serializable
{
    //Role constants
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_MOD = "ROLE_MOD";
    const ROLE_USER = "ROLE_USER";

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    protected $facebook_id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true)
     */
    protected $facebook_access_token;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    protected $google_id;

    /**
     * @var string
     *
     * @ORM\Column(name="google_access_token", type="string", length=255, nullable=true)
     */
    protected $google_access_token;

    /**
     * @OneToMany(targetEntity="Subject", mappedBy="user")
     */
    private $subjects;

    /**
     * @OneToMany(targetEntity="Post", mappedBy="user")
     */
    private $posts;

    /**
     * @OneToMany(targetEntity="Activity", mappedBy="user")
     */
    private $activities;

    /**
     * @OneToMany(targetEntity="Evaluation", mappedBy="user")
     */
    private $evaluations;

    /**
     * @var ArrayCollection
     *
     * @OneToMany(targetEntity="Contact", mappedBy="user")
     */
    private $contacts;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $phoneNumber;

    /**
     * @Assert\File(
     *     maxSize="2048k",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Only the filetypes jpeg and png are allowed.")
     */
    private $profilePictureFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilePicturePath;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $fidelity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $moderator;

    /**
     * @ORM\Column(type="boolean")
     */
    private $administrator;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->subjects = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->setRoles(array(self::ROLE_USER));
        $this->fidelity = 0;
        $this->enabled = true;
        $this->createdAt = new \DateTime();
        $this->administrator = false;
        $this->moderator = false;
    }

    /**
     * Add a subject to the user
     * @param Subject $subject
     * @return User $this
     */
    public function addSubject($subject)
    {
        $this->subjects->add($subject);
        $subject->setUser($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * @param ArrayCollection $subjects
     */
    public function setSubjects($subjects)
    {
        $this->subjects = $subjects;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function addPost($post)
    {
        $this->posts->add($post);
        $post->setUser($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param ArrayCollection $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @param Activity $activity
     * @return $this
     */
    public function addActivity(Activity $activity)
    {
        $this->activities->add($activity);
        $activity->setUser($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * @param ArrayCollection $activities
     */
    public function setActivities($activities)
    {
        $this->activities = $activities;
    }

    /**
     * @param Evaluation $evaluation
     * @return $this
     */
    public function addEvaluation($evaluation)
    {
        $this->evaluations->add($evaluation);
        $evaluation->setUser($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * @param ArrayCollection $evaluations
     */
    public function setEvaluations($evaluations)
    {
        $this->evaluations = $evaluations;
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function addContact($contact)
    {
        $this->contacts->add($contact);
        $contact->setUser($this);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param ArrayCollection $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * @param mixed $facebook_id
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
    }

    /**
     * @return mixed
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * @param mixed $facebook_access_token
     */
    public function setFacebookAccessToken($facebook_access_token)
    {
        $this->facebook_access_token = $facebook_access_token;
    }

    /**
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * @param mixed $google_id
     */
    public function setGoogleId($google_id)
    {
        $this->google_id = $google_id;
    }

    /**
     * @return mixed
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * @param mixed $google_access_token
     */
    public function setGoogleAccessToken($google_access_token)
    {
        $this->google_access_token = $google_access_token;
    }


    /**
     * Set firstname
     *
     * @param $firstName
     * @return User
     *
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastname
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastName;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getProfilePictureFile()
    {
        return $this->profilePictureFile;
    }

    /**
     * @param mixed $profilePictureFile
     */
    public function setProfilePictureFile($profilePictureFile)
    {
        $this->profilePictureFile = $profilePictureFile;
    }

    /**
     * @return mixed
     */
    public function getTempProfilePicturePath()
    {
        return $this->tempProfilePicturePath;
    }

    /**
     * @param mixed $tempProfilePicturePath
     */
    public function setTempProfilePicturePath($tempProfilePicturePath)
    {
        $this->tempProfilePicturePath = $tempProfilePicturePath;
    }

    /**
     * @return mixed
     */
    public function getProfilePicturePath()
    {
        return $this->profilePicturePath;
    }

    /**
     * @param mixed $profilePicturePath
     */
    public function setProfilePicturePath($profilePicturePath)
    {
        $this->profilePicturePath = $profilePicturePath;
    }



    /**
     * Set description
     *
     * @param string $description
     *
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set fidelity
     *
     * @param integer $fidelity
     *
     * @return User
     */
    public function setFidelity($fidelity)
    {
        $this->fidelity = $fidelity;

        return $this;
    }

    /**
     * Get fidelity
     *
     * @return integer
     */
    public function getFidelity()
    {
        return $this->fidelity;
    }

    /**
     * Set moderator
     *
     * @param boolean $moderator
     *
     * @return User
     */
    public function setModerator($moderator)
    {
        $this->moderator = $moderator;

        return $this;
    }

    /**
     * Get moderator
     *
     * @return boolean
     */
    public function isModerator()
    {
        return $this->moderator;
    }

    /**
     * Set administrator
     *
     * @param boolean $administrator
     *
     * @return User
     */
    public function setAdministrator($administrator)
    {
        $this->administrator = $administrator;

        return $this;
    }

    /**
     * Get administrator
     *
     * @return boolean
     */
    public function isAdministrator()
    {
        return $this->administrator;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }


    /**
     * Return the Json representation of the User
     *
     * @return array
     */
    public function toJson()
    {
        return json_encode(
            array(
                $this->id,
                $this->username,
                $this->password,
                $this->email,
                $this->firstName,
                $this->lastName,
                $this->birthday,
                $this->city,
                $this->country,
                $this->phoneNumber,
                $this->profilePicturePath,
                $this->description,
                $this->fidelity,
                $this->moderator,
                $this->administrator,
                $this->createdAt,
                $this->enabled
            )
        );
    }


}
