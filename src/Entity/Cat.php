<?php

namespace App\Entity;

use App\Repository\CatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CatRepository::class)
 */
class Cat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *   
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *   
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Marque::class, mappedBy="cat")
     */
    private $marque;

    public function __construct()
    {
        $this->marque = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Marque>
     */
    public function getMarque(): Collection
    {
        return $this->marque;
    }

    public function addMarque(Marque $marque): self
    {
        if (!$this->marque->contains($marque)) {
            $this->marque[] = $marque;
            $marque->setCat($this);
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        if ($this->marque->removeElement($marque)) {
            // set the owning side to null (unless already changed)
            if ($marque->getCat() === $this) {
                $marque->setCat(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->nom;
    }
}
