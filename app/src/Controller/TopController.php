<?php 

namespace App\Controller;

use App\Service\SkillHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 2019.12.21.Sat
 * @author Yuu2
 */
class TopController extends AbstractController {

    /**
     * 홈
     * @access public
     * 
     * @Route({"ko": "/", "jp": "/"}, name="home", methods={"GET"})
     * @Template("front/home.twig")
     */
    public function home() {
      
      return array();
    }
    /**
     * 자기소개
     * @access public
     * 
     * @Route({"ko": "/about", "jp": "/about"}, name="about", methods={"GET"})
     * @Template("front/about.twig")
     */
    public function about() {
      
      return array();
    }
}

?>