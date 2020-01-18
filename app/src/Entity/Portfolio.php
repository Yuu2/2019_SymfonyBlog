<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PortfolioRepository")
 */
class Portfolio
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PortfolioSkill", mappedBy="portfolio", orphanRemoval=true)
     */
    private $portfolio_skill;

    public function __construct()
    {
        $this->portfolio_skill = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|PortfolioSkill[]
     */
    public function getPortfolioSkill(): Collection
    {
        return $this->portfolio_skill;
    }

    public function addPortfolioSkill(PortfolioSkill $portfolioSkill): self
    {
        if (!$this->portfolio_skill->contains($portfolioSkill)) {
            $this->portfolio_skill[] = $portfolioSkill;
            $portfolioSkill->setPortfolio($this);
        }

        return $this;
    }

    public function removePortfolioSkill(PortfolioSkill $portfolioSkill): self
    {
        if ($this->portfolio_skill->contains($portfolioSkill)) {
            $this->portfolio_skill->removeElement($portfolioSkill);
            // set the owning side to null (unless already changed)
            if ($portfolioSkill->getPortfolio() === $this) {
                $portfolioSkill->setPortfolio(null);
            }
        }

        return $this;
    }
}
