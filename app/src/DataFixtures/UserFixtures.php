<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Yuu2
 * updated 2020.01.18
 */
class UserFixtures extends AbstractFixtures {

  /**
   * @access public
   * @param ObjectManager $manager
   * @return void
   */
  public function load(ObjectManager $manager): void {

    $this->createMember($manager, 'admin@yuu2.dev','admin', TRUE);
    $this->createMember($manager, 'user@yuu2.dev', 'user', FALSE);

    $manager->flush();
  }
}

