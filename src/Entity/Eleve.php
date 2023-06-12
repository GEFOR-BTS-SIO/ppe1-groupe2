<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
class Eleve implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Formation $idCursus = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Marital = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passeword3 = null;

   

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($hashedPassword)
    {
        $this->password = $hashedPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

   

    



    

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getIdCursus(): ?Formation
    {
        return $this->idCursus;
    }

    public function setIdCursus(?Formation $idCursus): self
    {
        $this->idCursus = $idCursus;

        return $this;
    }

    public function getMarital(): ?string
    {
        return $this->Marital;
    }

    public function setMarital(?string $Marital): self
    {
        $this->Marital = $Marital;

        return $this;
    }

    public function getPassword2(): ?string
    {
        return $this->password2;
    }

    public function setPassword2(?string $password2): self
    {
        $this->password2 = $password2;

        return $this;
    }

    public function getPasseword3(): ?string
    {
        return $this->passeword3;
    }

    public function setPasseword3(?string $passeword3): self
    {
        $this->passeword3 = $passeword3;

        return $this;
    }
}
