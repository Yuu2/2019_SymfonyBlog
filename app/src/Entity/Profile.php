<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Embeddable
 */
class Profile
{
    /** 
     * @ORM\Column(type = "string", nullable=true) 
     */
    private $name;

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
