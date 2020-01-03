<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Work
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $join_year;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $join_project;

    public function getJoinYear(): ?\DateTimeInterface {
      return $this->join_year;
    }

    public function setJoinYear(\DateTimeInterface $join_year): self {
      $this->join_year = $join_year;
      return $this;
    }

    public function getJoinProject(): ?\DateTimeInterface {
      return $this->join_project;
    }

    public function setJoinProject(\DateTimeInterface $join_project): self {
      $this->join_project = $join_project;
      return $this;
    }
}
