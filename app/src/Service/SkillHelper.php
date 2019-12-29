<?php

namespace App\Service;

use App\Service\AbstractService\AbstractSkillHelper;

class SkillHelper extends AbstractSkillHelper {

  /**
   * @access public
   * @return array
   */
  public function all(): ?array {
    return $this->skillRepository->findAll();
  }
}