<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PortfolioSkillRepository")
 */
class PortfolioSkill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Portfolio", inversedBy="portfolio_skill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $portfolio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Skill", inversedBy="portfolio_skill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }
}
