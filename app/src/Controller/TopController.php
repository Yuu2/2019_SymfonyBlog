<?php 

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Yuu2
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
     * @Route("/", name="home", methods={"GET"})
     * @Template("home.twig")
     */
    public function main() {
      $em = $this->entityManager;

      return array();
    }

    /**
     * 자기 소개
     * @access public
     * @Route("/about", name="about", methods={"GET"})
     * @Template("about.twig")
     */
    public function about() {

      return array();
    }

    /**
     * 보유 기술
     * @access public
     * @Route("/skill", name="skill", methods={"GET"})
     * @Template("skill.twig")
     */
    public function skill() {
      
      return array();
    }
}

?>