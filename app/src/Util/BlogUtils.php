<?php

namespace App\Util;

/**
 * updated 2020.03.19
 */
class BlogUtils {

  /**
   * @access public
   */
  public function __construct() {

  }

  /**
   * 해시태그 문자열 -> 배열 가공
   * @access public
   * @param string $hashtag
   * @return array
   */
  public function hashtagStringToArray(?string $hashtag): array {
    
    $hashtagArr = [];

    if (!empty($hashtag)) {
      $hashtagArr = explode(',', $hashtag);
    }

    return $hashtagArr;
  }
}

