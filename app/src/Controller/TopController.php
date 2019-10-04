<?php 

namespace App\Controller;

use App\Service\AsideService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TopController extends AbstractController {

    /**
     * @access public 
     * 
     */
    public function __construct() {
      
    }

    /**
     * 메인화면
     * @access public
     * @Route("/", name="home")
     * @Template("home.twig")
     */
    function main() {
      
      $entityManager = $this->getDoctrine()->getManager();
      $aside = new AsideService($entityManager);

      return array(
        'Aside' => $aside->execute()
      );
    }

    /**
     * @access public
     * @Route("/about", name="about")
     */
    function about() {

      $entityManager = $this->getDoctrine()->getManager();
      $aside = new AsideService($entityManager);
      $data['Aside'] = $aside->execute();

      return $this->render('about.html.twig', $data);
    }
}

?>