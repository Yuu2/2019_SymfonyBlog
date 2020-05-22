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
}
