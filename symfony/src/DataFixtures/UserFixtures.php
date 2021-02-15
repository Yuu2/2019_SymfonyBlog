<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @author yuu2dev
 * updated 2020.12.24
 */
class UserFixtures extends AbstractFixtures {
  
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
   * @param ObjectManager $objectManager
   * @return void
   */
  public function load(ObjectManager $objectManager): void {

    $this->createUser($objectManager, 'admin@yuu2dev.me','admin', 'admin', true);

    $objectManager->flush();
  }
  /**
   * @access protected
   * @param ObjectManager $objectManager
   * @param string $email
   * @param string $password
   * @param string $username
   * @param string $thumbnail
   * @param bool $admin
   * @return User
   */
  protected function createUser(ObjectManager $objectManager, string $email, string $password, string $username, bool $admin, ?string $thumbnail = null): ?User {

    $user = new User();
    $user->setEmail($email);
    $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));
    $admin ? $user->setRoles(['ROLE_ADMIN']) : $user->setRoles(['ROLE_USER']);
    $user->setCreatedAt(new \DateTime);
    $user->setUsername($username);
    $user->setThumbnail($thumbnail);
    $user->setIsVerified(true);

    $objectManager->persist($user);

    return $user;
  }
}

