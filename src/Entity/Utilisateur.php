<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups ;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur implements UserInterface
{


    public const ROLE_ADMIN='ROLE_ADMIN';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")

     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email")
     * @Groups("post:read")

     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\Length(
     *      min = 6,
     *      minMessage = "the password must be at least {{ limit }} characters long",
     *
     * )
     * @Groups("post:read")

     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nom is required")
     * @Groups("post:read")

     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="prenom is required")
     * @Groups("post:read")

     */
    private $prenom;
     

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="genre is required")
     * @Groups("post:read")

     */
    private $genre;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer", nullable=true)

     *
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)

     */
    private $addresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")

     */
    private $role;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    
    private $imageuser;

/**
 * @ORM\Column(type="json", nullable=true)
 */
private $roles;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }


    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $Genre): self
    {
        $this->genre = $Genre;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTEL(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }


    public function getImageuser(): ?string
    {
        return $this->imageuser;
    }

    public function setImageuser(string $imageuser): self
    {
        $this->imageuser = $imageuser;

        return $this;
    }

    /////////
    public function getDatenaissance(): ?string
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(string $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */


    public function setRoles(array $roles): self
    {
        $this->role = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->mdp;
    }

    public function setPassword(string $password): self
    {
        $this->mdp = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
 /**
     * @see UserInterface
     */
    public function getRoles()
    {
       // $roles = json_decode($this->roles);
        // guarantee every user at least has ROLE_USER
        
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    } 


    public function isAdmin():bool{
        return in_array(self::ROLE_ADMIN, $this->getRoles());
    }

}

