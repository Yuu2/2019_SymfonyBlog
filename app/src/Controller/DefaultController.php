<?php 

namespace App\Controller;

use App\Service\AsideService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {

    /**
     * @access public
     */
    function __construct() {
     
    }

    /**
     * @access public
     * @Route("/", name="route")
     */
    function profile() {
      
      $this->data = AsideService::get($this->getDoctrine()->getManager());
      
      return $this->render('profile.html.twig', $this->data);
    }

    /**
     * @access public
     * @Route("/about", name="about")
     */
    function about() {
      
      $this->data = AsideService::get($this->getDoctrine()->getManager());
      
      return $this->render('abount.html.twig', $this->data);
    }
}

?>