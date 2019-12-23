<?php

namespace App\Service\AbstractService;

use App\Repository\SkillRepository;

/**
 * updated 2019.12.23
 * @author Yuu2
 */
abstract class AbstractSkillHelper {

  /**
   * @var SkillRepository
   */
  protected $skillRepository;

  /**
   * @access public
   * @param SkillRepository $skillRepository
   */
  public function __construct(SkillRepository $skillRepository) {
    $this->skillRepository = $skillRepository;
  }

  /** 
   * @abstract
   * @access public
   */
  abstract public function getList();
}