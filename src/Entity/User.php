<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'lic_user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(
    fields: ['name', 'lastname'],
    message: 'Couple nom / prénom déjà présent',
    errorPath: false
)]
#[UniqueEntity(
    fields: ['login'],
    message: 'Login déjà utilisé',
    errorPath: false
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 180,
        maxMessage: 'La taille du login est trop grande ; la limite est {{ limit }}'
    )]
    private ?string $login = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 30,
        maxMessage: 'Le mot de passe doit avoir une longueur entre {{min}} et {{max}}'
    )]
    #[Assert\NotIdenticalTo(
        propertyPath: 'login',
        message: 'Le mot de passe ne peut pas être identique au login'
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column]
    private ?bool $admin = null;

    #[ORM\ManyToOne(
        targetEntity: Pays::class ,
        inversedBy: 'pays' ,
    )]
    #[ORM\JoinColumn(
        name : 'id_pays',
        referencedColumnName: 'id',
        nullable: true,
    )]
    private ?Pays $pays = null;

    /*
    #[Assert\Callback]
    public function verifDoublon(EntityManagerInterface $context): void
    {
        $em = $this->entityManager;
        $userRepository = $em->getRepository(User::class);

        if ($this->name != null && $this->lastname != null) {
            $users = $userRepository->findBy(['name' => $this->name, 'lastname' => $this->lastname]);
            foreach ($users as $user) {
                if ($user->getId() !== $this->getId()) {
                    $context->buildViolation('Le couple nom/prenom existe deja dans la base')
                        ->atPath('name')
                        ->addViolation();
                    break ;
                }
            }
        }
    }*/

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function isAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): static
    {
        $this->admin = $admin;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(Pays $pays): static
    {
        $this->pays = $pays;

        return $this;
    }
}
