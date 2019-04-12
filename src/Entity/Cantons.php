<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CantonsRepository")
 */
class Cantons
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
    private $canton_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantonName(): ?string
    {
        return $this->canton_name;
    }

    public function setCantonName(string $canton_name): self
    {
        $this->canton_name = $canton_name;

        return $this;
    }
}
