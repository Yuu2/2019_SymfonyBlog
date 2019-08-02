<?php

namespace App\Util;

class Paginator {
  /**
   * @var Array $data
   * @var 
   */
  public $data;

  /**
   * @param Integer $board
   * @param Integer $page
   * @param Integer $total
   */
  function __construct($board, $page, $total) {
    $this->execute($board, $page, $total);
  }

  /**
   * @access private
   * @param Integer $board
   * @param Integer $page
   * @param Integer $total
   */
  function execute($board, $page, $total) {

    if($total == 0) { 
      return; 
    }

    $firstPage = 1;
    $lastPage = (int) ceil($total / 10);

    if($page > $lastPage) {
      return;
    }
    
    $this->data['board'] = $board;
    $this->data['firstPage'] = 1;
    $this->data['lastPage'] = $lastPage;
    $this->data['curPage'] = $page;
    $this->data['total'] =  (int) $total;


    if($page == $firstPage) {
      $this->data['prevPage'] = null;
      if($page ==$lastPage) {
        $this->data['nextPage'] = null;
      } else {  
        $this->data['nextPage'] = $page + 1;
      }
      return;
    } else {
      $this->data['prevPage'] = $page - 1;
      $this->data['nextPage'] = $page + 1;
    }

    if($page == $lastPage) {
      $this->data['prevPage'] = $page - 1;
      $this->data['nextPage'] = null;
    } else {
      $this->data['prevPage'] = $page - 1;
      $this->data['nextPage'] = $page + 1;
    }
  }
} 




