<?php

namespace App\Service;

use App\Repository\SkillRepository;

/**
 * @author Yuu2
 * updated 2020.01.18
 */
class SkillService {

  /**
   * @var SkillReposiotry
   */
  private $skillRepository;

  /**
   * @access public
   * @param SkillRepository $skillRepository
   */
  public function __construct(SkillRepository $skillRepository) {
    $this->skillRepository = $skillRepository;
  }

  /**
   * @access public
   * @return array
   */
  public function all(): ?array {
    return $this->skillRepository->findAll();
  }
}