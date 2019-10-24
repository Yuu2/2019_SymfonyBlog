<?php 

namespace App\Controller;

use App\Services\SkillHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 2019.10.23
 * @author Yuu2
 */
class TopController extends AbstractController implements ApplicationController {

    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * @access public
     * @param EntityManagerInterface
     */
    public function __construct(
      EntityManagerInterface $entityManager
    ) {
      $this->entityManager = $entityManager;
    }

    /**
     * 메인
     * 
     * @access public
     * @param SkillHelper $skillHelper
     * 
     * @Route("/", name="home", methods={"GET"})
     * @Template("home.twig")
     */
    public function top(SkillHelper $skillHelper) {
      
      return array(
        'Skills' => $skillHelper->top(0, 2)
      );
    }

    /**
     * 자기 소개
     * 
     * @access public
     * 
     * @Route("/about", name="about", methods={"GET"})
     * @Template("about.twig")
     */
    public function about() {

      return array();
    }

    /**
     * 보유 기술
     * 
     * @access public
     * @param SkillHelper $skillHelper
     * 
     * @Route("/skill", name="skill", methods={"GET"})
     * @Template("skill.twig")
     */
    public function skill(SkillHelper $skillHelper) {

      return array(
        'Skills' => $skillHelper->skill()
      );
    }
}

?>