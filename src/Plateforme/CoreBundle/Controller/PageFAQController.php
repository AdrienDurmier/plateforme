<?php
namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Plateforme\CoreBundle\Form\PageFAQType;

class PageFAQController extends Controller
{
    /**
     *  Page FAQ
     */
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $page_faq = $em->getRepository('PlateformeCoreBundle:PageFAQ')->findOneByRepere('faq');
      if (null === $page_faq) {
        throw new NotFoundHttpException("La page FAQ n'existe pas.");
      }
      
      // Récupération des categories et des questions
      $categories = $em->getRepository('PlateformeCoreBundle:FAQCategorie')->findAll();
      $questions = $em->getRepository('PlateformeCoreBundle:FAQQuestion')->findAllPublished();
      
      return $this->render('PlateformeCoreBundle:PageFAQ:index.html.twig', array(
        'page_faq' => $page_faq,
        'categories' => $categories,
        'questions' => $questions,
      ));
    }
    
    /**
     * Formulaire d'édition de la page faq
     */
    public function editAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $page_faq = $em->getRepository('PlateformeCoreBundle:PageFAQ')->findOneByRepere('faq');
      if (null === $page_faq) {
        throw new NotFoundHttpException("La page FAQ n'existe pas.");
      }
      $form = $this->get('form.factory')->create(PageFAQType::class, $page_faq);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($page_faq);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Page FAQ modifiée avec succès");
        }
      }
      
      return $this->render('PlateformeCoreBundle:PageFAQ:edit.html.twig', array(
        'page_faq' => $page_faq,
        'form' => $form->createView(),
      ));
    }
    
}
