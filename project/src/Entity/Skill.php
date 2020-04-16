<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $percentage;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PortfolioSkill", mappedBy="skill", orphanRemoval=true)
     */
    private $portfolio_skill;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $visible = true;

    public function __construct()
    {
        $this->portfolio_skill = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getPercentage(): ?int
    {
        return $this->percentage;
    }

    public function setPercentage(?int $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }
    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolio $portfolio): self
    {
        $this->portfolio = $portfolio;

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
            $portfolioSkill->setSkill($this);
        }

        return $this;
    }

    public function removePortfolioSkill(PortfolioSkill $portfolioSkill): self
    {
        if ($this->portfolio_skill->contains($portfolioSkill)) {
            $this->portfolio_skill->removeElement($portfolioSkill);
            // set the owning side to null (unless already changed)
            if ($portfolioSkill->getSkill() === $this) {
                $portfolioSkill->setSkill(null);
            }
        }

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
}
