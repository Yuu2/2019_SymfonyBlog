<?php 

namespace App\Controller;

use App\Service\CategoryHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param CategoryHelper $categoryHelper
     * @Route("/", name="home")
     * @Template("home.twig")
     */
    public function main() {
      $em = $this->entityManager;
      // $aside = new AsideService($em);

      return array(
        // 'Aside' => $aside->execute()
      );
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


    // /**
    //  * @access public
    //  * @Route("/about", name="about")
    //  */
    // function about() {

    //   $entityManager = $this->getDoctrine()->getManager();
    //   $aside = new AsideService($entityManager);
    //   $data['Aside'] = $aside->execute();

    //   return $this->render('about.html.twig', $data);
    // }
}

?>