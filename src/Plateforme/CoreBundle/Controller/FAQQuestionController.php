<?php
namespace Plateforme\CoreBundle\Controller;

use Plateforme\CoreBundle\Entity\FAQQuestion;
use Plateforme\CoreBundle\Form\FAQQuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FAQQuestionController extends Controller
{
    /**
     * Gestion des questions
     */
    public function crudAction()
    {
      $em = $this->getDoctrine()->getManager();
      $questions = $em->getRepository('PlateformeCoreBundle:FAQQuestion')->findAll();
      return $this->render('PlateformeCoreBundle:FAQQuestion:crud.html.twig', array(
        'questions'   => $questions,
      ));
    }
  
    /**
     * Formulaire de création d'une question
     */
    public function addAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $question = new FAQQuestion();
      $form = $this->get('form.factory')->create(FAQQuestionType::class, $question);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($question);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Question créée avec succès");
          return $this->redirectToRoute('plateforme_core_page_faq_question_crud');
        }
      }
      return $this->render('PlateformeCoreBundle:FAQQuestion:add.html.twig', array(
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire d'édition d'une question
     */
    public function editAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $question = $em->getRepository('PlateformeCoreBundle:FAQQuestion')->find($id);
      if (null === $question) {
        throw new NotFoundHttpException("La question ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create(FAQQuestionType::class, $question);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($question);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Question modifiée avec succès");
          return $this->redirectToRoute('plateforme_core_page_faq_question_crud');
        }
      }
      
      return $this->render('PlateformeCoreBundle:FAQQuestion:edit.html.twig', array(
        'question' => $question,
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire de suppression d'une question
     */
    public function deleteAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $question = $em->getRepository('PlateformeCoreBundle:FAQQuestion')->find($id);
      if (null === $question) {
        throw new NotFoundHttpException("La question ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create();
      
      if ($request->isMethod('POST')) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Question supprimée avec succès");
        return $this->redirectToRoute('plateforme_core_page_faq_question_crud');
      }
      
      return $this->render('PlateformeCoreBundle:FAQQuestion:delete.html.twig', array(
        'question' => $question,
        'form' => $form->createView(),
      ));
    }
    
    
}
