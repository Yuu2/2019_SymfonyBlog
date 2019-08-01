<?php

namespace App\Util;

class Paginator {
  /**
   * @var Array $data
   * @var 
   */
  public $data;

  /**
   * @param Integer $page
   * @param Integer $total
   */
  function __construct($page, $total) {
    $this->execute($page, $total);
  }

  /**
   * @access private
   * @param Integer $page
   * @param Integer $total
   */
  function execute($page, $total) {
    
    $firstPage = 1;
    $lastPage = $total / 10;

    try {
      $this->data['lastPage'] = $lastPage;
      $this->data['total'] = (int) $total;

      if($page == $firstPage) {
        $this->data['nextPage'] = $page + 1;
        return;
      } else {
        $this->data['prevPage'] = $page - 1;
        $this->data['nextPage'] = $page + 1;
        return;
      }

      if($page == $lastPage) {
        $this->data['prevPage'] = $page - 1;
      } else {
        $this->data['prevPage'] = $page - 1;
        $this->data['nextPage'] = $page + 1;
      }
      
    } catch(Exception $e) {
      dump('Paginator : ' . $e);
    }
  }
} 




