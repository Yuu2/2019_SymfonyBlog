<?php

namespace App\Services;

class CategoryHelper {
    
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @access public
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
      CategoryRepository $categoryRepository
    ) {
      $this->categoryRepository = $categoryRepository;
    }

    /**
     * @access public
     */
    public function onHeader() {
        return $this->$categoryRepository;
    }
    
    

}