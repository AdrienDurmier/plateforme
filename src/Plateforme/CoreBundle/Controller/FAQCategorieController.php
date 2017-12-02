<?php

namespace Plateforme\CoreBundle\Controller;

use Plateforme\CoreBundle\Entity\FAQCategorie;
use Plateforme\CoreBundle\Form\FAQCategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FAQCategorieController extends Controller {

  /**
   * Gestion des catégories
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $categories = $em->getRepository('PlateformeCoreBundle:FAQCategorie')->findAll();
    return $this->render('PlateformeCoreBundle:FAQCategorie:crud.html.twig', array(
          'categories' => $categories,
    ));
  }

  /**
   * Formulaire de création d'une catégorie
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = new FAQCategorie();
    $form = $this->get('form.factory')->create(FAQCategorieType::class, $categorie);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($categorie);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Catégorie créée avec succès");
        return $this->redirectToRoute('plateforme_core_page_faq_categorie_crud');
      }
    }
    return $this->render('PlateformeCoreBundle:FAQCategorie:add.html.twig', array(
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire d'édition d'une categorie
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCoreBundle:FAQCategorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create(FAQCategorieType::class, $categorie);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($categorie);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Question modifiée avec succès");
        return $this->redirectToRoute('plateforme_core_page_faq_categorie_crud');
      }
    }

    return $this->render('PlateformeCoreBundle:FAQCategorie:edit.html.twig', array(
          'categorie' => $categorie,
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire de suppression d'une categorie
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $categorie = $em->getRepository('PlateformeCoreBundle:FAQCategorie')->find($id);
    if (null === $categorie) {
      throw new NotFoundHttpException("La catégorie ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($categorie);
    $em->flush();
    $request->getSession()->getFlashBag()->add('info', "Catégorie supprimée avec succès");
    return $this->redirectToRoute('plateforme_core_page_faq_categorie_crud');
  }

}
