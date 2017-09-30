<?php
namespace Plateforme\CoreBundle\Controller;

use Plateforme\CoreBundle\Entity\PageContact;
use Plateforme\CoreBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageContactController extends Controller
{
  
    public function indexAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $page_contact = $em->getRepository('PlateformeCoreBundle:PageContact')->findOneByTitre('Nous contacter');
      
      if ($request->isMethod('POST')) {
        $valeurs_recu = $request->request->all();
        
        // Création du message
        $message = new Message();
        $message->setObjet($valeurs_recu['objet']);
        $message->setContenu($valeurs_recu['contenu']);
        $em->persist($message); 
        $em->flush();
        
        $request->getSession()->getFlashBag()->add('info', "Votre message a bien été envoyé, nous traiterons votre demande dans les plus bref délais.");
      }
      
      return $this->render('PlateformeCoreBundle:PageContact:index.html.twig', array(
        'page_contact' => $page_contact,
      ));
    }
    
}
