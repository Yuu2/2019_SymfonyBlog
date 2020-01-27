<?php

namespace App\Util;

use App\Entity\User;
use App\Repository\UserRepository;

/**
 * @author yuu2
 * updated 2020.01.27
 */
class SecurityService {

  /**
   * @var UserRepository
   */
  protected $userRepository;

  /**
   * @access public
   * @param UserRepository $userRepository
   */
  public function __construct(UserRepository $userRepository) {
    $this->userRepository = $userRepository;
  }

  /**
   * @todo 유저 중복 검사
   * @access public
   * @return bool
   */
  public function isDuplicated() : bool {}
  /**
   * @todo 유저 영속화
   * @access public
   */
  public function save() {}
}
