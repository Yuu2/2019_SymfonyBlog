<?php 

namespace App\Controller\Front;

use App\Service\SkillHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * updated 2019.12.22
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
}