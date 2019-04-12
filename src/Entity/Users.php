<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

     /**
     * @ORM\ManyToOne(targetEntity="Cantons")
     * @ORM\JoinColumn(name="canton_id", referencedColumnName="id")
     */
    private $canton;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $term_accepted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active_user;

    /**
     * @ORM\Column(type="guid", nullable=true)
     */
    private $token_active;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=36, nullable=true)
     */
    private $phone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getCanton(): ?int
    {
        return $this->canton;
    }

    public function setCanton(Cantons $canton): self
    {
        $this->canton = $canton;

        return $this;
    }

    public function getTermAccepted(): ?bool
    {
        return $this->term_accepted;
    }

    public function setTermAccepted(bool $term_accepted): self
    {
        $this->term_accepted = $term_accepted;

        return $this;
    }

    public function getActiveUser(): ?bool
    {
        return $this->active_user;
    }

    public function setActiveUser(?bool $active_user): self
    {
        $this->active_user = $active_user;

        return $this;
    }

    public function getTokenActive(): ?string
    {
        return $this->token_active;
    }

    public function setTokenActive(?string $token_active): self
    {
        $this->token_active = $token_active;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
