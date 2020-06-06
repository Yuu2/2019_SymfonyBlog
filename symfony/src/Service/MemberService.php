<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @author yuu2dev
 * updated 2020.06.03
 */
class MemberService {

  /**
   * @var EntityManagerInterface
   */
  protected $entityManager;

  /**
   * @var UserPasswordEncoderInterface
   */
  protected $passwordEncoder;

  /**
   * @var UserRepository
   */
  protected $userRepository;

  /**
   * @access public
   * @param EntityManagerInterface $entityManager
   * @param UserRepository $userRepository
   * @param UserPasswordEncoderInterface $passwordEncoder
   */
  public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository) {
    $this->entityManager = $entityManager;
    $this->passwordEncoder = $passwordEncoder;
    $this->userRepository = $userRepository;
  }

  /**
   * @todo 유저 중복 검사
   * @access public
   * @return bool
   */
  public function isDuplicated() : bool {}
  
  /**
   * 유저 영속화
   * @access public
   * @param User $user
   * @return void
   */
  public function saveUser(User $user) {
    
    $encryptedPw = $this->passwordEncoder->encodePassword($user, $user->getPassword());
    
    $user->setPassword($encryptedPw);
    $user->setRoles(['ROLE_USER']);
    $user->setCreatedAt(new \DateTime);

    $this->entityManager->persist($user);
    $this->entityManager->flush();
  }
}
