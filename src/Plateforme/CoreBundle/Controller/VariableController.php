<?php
namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Plateforme\CoreBundle\Entity\Variable;
use Plateforme\CoreBundle\Form\VariableType;

class VariableController extends Controller
{
    /**
     * Gestion des variables
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function crudAction()
    {
      $em = $this->getDoctrine()->getManager();
      $variables = $em->getRepository('PlateformeCoreBundle:Variable')->findAll();
      return $this->render('PlateformeCoreBundle:Variable:crud.html.twig', array(
        'variables'   => $variables,
      ));
    }
    
    /**
     * Formulaire de création d'une variable
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      
      $variable = new Variable();
      $form = $this->get('form.factory')->create(VariableType::class, $variable);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($variable);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Variable créée avec succès");
          return $this->redirectToRoute('plateforme_core_variables_crud');
        }
      }
      return $this->render('PlateformeCoreBundle:Variable:add.html.twig', array(
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire d'édition d'une variable
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $variable = $em->getRepository('PlateformeCoreBundle:Variable')->find($id);
      if (null === $variable) {
        throw new NotFoundHttpException("La variable ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create(VariableType::class, $variable);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($variable);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Variable modifiée avec succès");
          return $this->redirectToRoute('plateforme_core_variables_crud');
        }
      }
      
      return $this->render('PlateformeCoreBundle:Variable:edit.html.twig', array(
        'variable' => $variable,
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire de suppression d'une variable
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $variable = $em->getRepository('PlateformeCoreBundle:Variable')->find($id);
      if (null === $variable) {
        throw new NotFoundHttpException("La variable ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create();
      
      if ($request->isMethod('POST')) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($variable);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Variable supprimée avec succès");
        return $this->redirectToRoute('plateforme_core_variables_crud');
      }
      
      return $this->render('PlateformeCoreBundle:Variable:delete.html.twig', array(
        'variable' => $variable,
        'form' => $form->createView(),
      ));
    }
    
    
}
