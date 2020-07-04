<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author yuu2dev
 * updated 2020.06.10
 */
class UserFixtures extends AbstractFixtures {

  /**
   * @access public
   * @param ObjectManager $manager
   * @return void
   */
  public function load(ObjectManager $manager): void {

    $this->createMember($manager, 'admin@yuu2dev.me','admin', 'admin', true);

    $manager->flush();
  }
}

