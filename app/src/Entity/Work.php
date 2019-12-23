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
    private $join_year;

    /**
     * @ORM\Column(type="integer")
     */
    private $join_project;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJoinYear(): ?string
    {
        return $this->name;
    }

    public function setJoinYear(int $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getJoinProject(): ?int
    {
        return $this->join_project;
    }

    public function setJoinProejct(?int $join_project): self
    {
        $this->join_project = $join_project;

        return $this;
    }
}
