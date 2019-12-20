<?php

namespace App\Service;

use App\Repository\SkillRepository;

class SkillHelper {
    
    /**
     * @var SkillRepository
     */
    private $skillRepository;

    /**
     * @access public
     * @param SkillRepository $skillRepository
     */
    public function __construct(
      SkillRepository $skillRepository
    ) {
      $this->skillRepository = $skillRepository;
    }

    /**
     * @access public
     * @param int $offset
     * @param int @limit
     */
    public function getMost(int $offset, int $limit) {
        return $this->skillRepository->findBy(
          array(),
          array('id' => 'DESC'),
          $offset,
          $limit
        );
    }

    /**
     * @access public
     */
    public function getList() {
      return $this->skillRepository->findAll();
    }
    
    

}