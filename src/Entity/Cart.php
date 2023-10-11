<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'cart', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Announcement::class, inversedBy: 'carts')]
    private Collection $announcements;

    public function __construct()
    {
        $this->announcements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(Announcement $announcement): static
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements->add($announcement);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): static
    {
        $this->announcements->removeElement($announcement);

        return $this;
    }
}
