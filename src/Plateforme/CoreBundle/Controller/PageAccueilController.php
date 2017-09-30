<?php
namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Plateforme\CoreBundle\Form\PageAccueilType;

class PageAccueilController extends Controller
{
    /**
     *  Page Accueil
     */
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $page_accueil = $em->getRepository('PlateformeCoreBundle:PageAccueil')->findOneByRepere('accueil');
      if (null === $page_accueil) {
        throw new NotFoundHttpException("La page d'accueil n'existe pas.");
      }
      return $this->render('PlateformeCoreBundle:PageAccueil:index.html.twig', array(
        'page_accueil' => $page_accueil,
      ));
    }
    
    /**
     * Formulaire d'édition de la page d'accueil
     */
    public function editAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $page_accueil = $em->getRepository('PlateformeCoreBundle:PageAccueil')->findOneByRepere('accueil');
      if (null === $page_accueil) {
        throw new NotFoundHttpException("La page d'accueil n'existe pas.");
      }
      $form = $this->get('form.factory')->create(PageAccueilType::class, $page_accueil);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($page_accueil);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Page d'accueil modifiée avec succès");
        }
      }
      
      return $this->render('PlateformeCoreBundle:PageAccueil:edit.html.twig', array(
        'page_accueil' => $page_accueil,
        'form' => $form->createView(),
      ));
    }
    
}
