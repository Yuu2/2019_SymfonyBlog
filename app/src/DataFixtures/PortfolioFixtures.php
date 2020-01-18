<?php

namespace App\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Yuu2
 * updated 2020.01.18
 */
class PortfolioFixtures extends AbstractFixtures {

  public function load(ObjectManager $manager) {
    
    $portfolio = $this->createPortfolio($manager, "JavaFx-Chat", "Window/Mac 어플리케이션", "https://github.com/Yuu2/javafx-chat");

    $this->addPortfolioSkill(
      $manager, 
      $portfolio,
      $this->createSkill($manager, 'Java', 70, "A")
    );
    $this->addPortfolioSkill(
      $manager, 
      $portfolio,
      $this->createSkill($manager, 'MySQL', 50, "B", false)
    );
    
    $manager->flush();
  }
}
