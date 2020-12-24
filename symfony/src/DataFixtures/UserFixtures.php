<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

/**
 * @author yuu2dev
 * updated 2020.12.24
 */
class UserFixtures extends AbstractFixtures {

  /**
   * @access public
   * @param ObjectManager $manager
   * @return void
   */
  public function load(ObjectManager $manager): void {

    $this->createUser($manager, 'admin@yuu2dev.me','admin', 'admin', true);

    $manager->flush();
  }
  /**
   * @access protected
   * @param ObjectManager $manager
   * @param string $email
   * @param string $password
   * @param string $username
   * @param string $thumbnail
   * @param bool $admin
   * @return User
   */
  protected function createUser(ObjectManager $manager, string $email, string $password, string $username, bool $admin, ?string $thumbnail = null): ?User {

    $user = new User();
    $user->setEmail($email);
    $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));
    $admin ? $user->setRoles(['ROLE_ADMIN']) : $user->setRoles(['ROLE_USER']);
    $user->setCreatedAt(new \DateTime);
    $user->setUsername($username);
    $user->setThumbnail($thumbnail);
    $user->setIsVerified(true);

    $manager->persist($user);

    return $user;
  }
}

