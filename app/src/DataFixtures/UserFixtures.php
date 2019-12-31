<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * 테스트 계정 생성
 * 
 * updated 2019.12.31
 * @author Yuu2
 */
class UserFixtures extends Fixture {

  /**
   * @var UserPasswordEncoderInterface
   */
  protected $userPasswordEncoder;

  /**
   * @access public
   * @param UserPasswordEncoderInterface $userPasswordEncoder
   */
  public function __construct(UserPasswordEncoderInterface $userPasswordEncoder) {
    $this->userPasswordEncoder = $userPasswordEncoder;
  }

  /**
   * @access public
   * @param ObjectManager $manager
   * @return void
   */
  public function load(ObjectManager $manager): void {
    
    $this->createTestAccount('admin@yuu2.dev','admin', TRUE, $manager);

    $this->createTestAccount('user@yuu2.dev', 'user', FALSE, $manager);
  }

  /**
   * 테스트 계정 생성
   * @access private
   * @param ObjectManager $manager
   * @param string $email
   * @param string $password
   * @param bool $admin
   * @return void
   */
  private function createTestAccount(string $email, string $password, bool $admin, Object $manager): void {

    $user = new User();
    $user->setEmail($email);
    
    $user->setPassword(
      $this->userPasswordEncoder->encodePassword($user, $password)
    );

    $admin ? $user->setRoles(['ROLE_ADMIN']) : $user->setRoles(['ROLE_USER']);

    $manager->persist($user);
    $manager->flush();
  }
}

