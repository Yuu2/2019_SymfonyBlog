<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @author Yuu2
 * updated 2020.01.18
 */
class InitFixtures extends Fixture {

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
    
    $this->createSkill($manager, 'Symfony', 70, "A");
    $this->createMember($manager, 'admin@yuu2.dev','admin', TRUE);
    $this->createMember($manager, 'user@yuu2.dev', 'user', FALSE);

    $manager->flush();
  }

  /**
   * @access private
   * @param ObjectManager $manager
   * @param string $email
   * @param string $password
   * @param bool $admin
   * @return void
   */
  private function createMember(Object $manager, string $email, string $password, bool $admin): void {

    $user = new User();
    // 이메일
    $user->setEmail($email);
    // 비밀번호
    $user->setPassword(
      $this->userPasswordEncoder->encodePassword($user, $password)
    );
    // 권한
    $admin ? $user->setRoles(['ROLE_ADMIN']) : $user->setRoles(['ROLE_USER']);
    // 가입일
    $user->setCreatedAt(new \DateTime);
    // 포트폴리오
    $this->createPortfolio($user);

    $manager->persist($user);
  }

  /**
   * @access private
   * @param ObjectManager $manager
   * @param string $name
   * @param int $percentage
   * @param string $level
   */
  private function createSkill(ObjectManager $manager, string $name, int $percentage, string $level) {
    
    $skill = new Skill();
    $skill->setName($name);
    $skill->setPercentage($percentage);
    $skill->setLevel($level);

    $manager->persist($skill);
  }
  
  /**
   * @access private
   * @param ObjectManager $manager
   * @param User $user
   * @return void
   */
  private function createPortfolio(ObjectManager $manager, User $user) {
    
    /* TODO: 일대다 관계 설정 후 작성

    $portfolio = new Portfolio();
    $portfolio->setTitle("JavaFx-Chat");
    $portfolio->setSubtitle("Windows/Mac 채팅앱");

    $portfolio->setUser($user);
    $portfolio->setCreateAt(new \DateTime);
    
    $manager->persist($portfolio);
    */
  }
}

