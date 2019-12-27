<?php

namespace App\Service\AbstractService;

use App\Repository\WorkRepository;

/**
 * updated 2019.12.27
 * @author Yuu2
 */
abstract class AbstractWorkHelper {

  /**
   * @var WorkRepository
   */
  protected $workRepository;

  /**
   * @access public
   * @param WorkRepository $workRepository
   */
  public function __construct(WorkRepository $workRepository) {
    $this->workRepository = $workRepository;
  }
}