<?php

namespace App\Service;

use App\Service\AbstractService\AbstractSkillHelper;

class TopSkillHelper extends AbstractSkillHelper {

   /**
    * @access public
    * @return array
    */
    public function getList(): ?array {
      
      return $this->skillRepository->findAll();
    }
}