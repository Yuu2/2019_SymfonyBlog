<?php 

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author yuu2
 */
class TopController extends AbstractController implements ApplicationController {

    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * @access public 
     */
    public function __construct(EntityManagerInterface $entityManager) {
      $this->entityManager = $entityManager;
    }

    /**
     * 메인
     * @access public
     * @Route("/", name="home")
     * @Template("home.twig")
     */
    public function main() {
      $em = $this->entityManager;

      return array();
    }

    /**
     * 자기 소개
     * @access public
     * @Route("/about", name="about")
     * @Template("about.twig")
     */
    public function about() {

      return array();
    }

    /**
     * 보유 기술
     * @access public
     * @Route("/skill", name="skill")
     * @Template("skill.twig")
     */
    public function skill() {
      
      return array();
    }

    /**
     * 방명록
     * @access public
     * @Route("/guestbook", name="guestbook")
     * @Template("/guestbook.twig")
     */
    public function guestbook() {
      
      return array();
    }
}

?>