<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkRepository")
 */
class Work
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $join_years;

    /**
     * @ORM\Column(type="integer")
     */
    private $join_projects;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJoinYears(): ?int
    {
        return $this->join_years;
    }

    public function setJoinYears(int $join_years): self
    {
        $this->join_years = $join_years;

        return $this;
    }

    public function getJoinProjects(): ?int
    {
        return $this->join_projects;
    }

    public function setJoinProjects(int $join_projects): self
    {
        $this->join_projects = $join_projects;

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
}
