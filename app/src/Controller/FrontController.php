<?php 

namespace App\Controller;

use App\Service\SkillHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 2019.12.12.Thu
 * @author Yuu2
 */
class FrontController extends AbstractController {


    /**
     * 메인
     * @access public
     * 
     * @Route({
     *  "ko": "/",
     *  "jp": "/",
     * }, name="home", methods={"GET"})
     * @Template("front/home.twig")
     */
    public function top(SkillHelper $skillHelper) {
      
      return array(
        'Skills' => $skillHelper->getMost(0, 2)
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
        'Skills' => $skillHelper->getList()
      );
    }
}

?>