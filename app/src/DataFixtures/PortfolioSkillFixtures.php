<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use App\Entity\Portfolio;
use App\Entity\PortfolioSkill;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Yuu2
 * updated 2020.01.18
 */
class PortfolioSkillFixtures extends Fixture {

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

    /**
   * @access private
   * @param ObjectManager $manager
   * @param string $name
   * @param int $percentage
   * @param string $level
   * @param bool $visible
   * @return Skill
   */
  private function createSkill(ObjectManager $manager, string $name, int $percentage, string $level, bool $visible = true): Skill {
    
    $skill = new Skill();

    $skill->setName($name);
    $skill->setPercentage($percentage);
    $skill->setLevel($level);
    $skill->setVisible($visible);

    $manager->persist($skill);

    return $skill;
  }
  
  /**
   * @access private
   * @param ObjectManager $manager
   * @param string $title
   * @param string $subtitle
   * @param string $url
   * @param bool $visible
   * @return Portfolio
   */
  private function createPortfolio(ObjectManager $manager, string $title, string $subtitle, string $url, bool $visible = true): Portfolio {
    
    $portfolio = new Portfolio();
    $portfolio->setTitle($title);
    $portfolio->setSubtitle($subtitle);
    $portfolio->setUrl($url);
    $portfolio->setVisible($visible);
    $portfolio->setCreateAt(new \DateTime);
    
    $manager->persist($portfolio);

    return $portfolio;
  }

  /**
   * @access private
   * @param ObjectManager $manager
   * @param Portfolio $portfolio
   * @param Skill $skill
   */
  private function addPortfolioSkill(ObjectManager $manager, Portfolio $portfolio, Skill $skill) {

    $portfolio_skill = new PortfolioSkill();
    $portfolio_skill->setPortfolio($portfolio);
    $portfolio_skill->setSkill($skill);

    $manager->persist($portfolio_skill);
  }
}
