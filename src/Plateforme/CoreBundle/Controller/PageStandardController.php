<?php

namespace Plateforme\CoreBundle\Controller;

use Plateforme\CoreBundle\Entity\PageStandard;
use Plateforme\CoreBundle\Entity\Version;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PageStandardController extends Controller {

  /**
   * Gestion des pages standards
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $pages = $em->getRepository('PlateformeCoreBundle:PageStandard')->findAll();
    return $this->render('PlateformeCoreBundle:PageStandard:crud.html.twig', array(
          'pages' => $pages,
    ));
  }

  /**
   * Formulaire de création d'une page standard
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $page = new PageStandard();

    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      $page->setTitre($valeurs_recu['titre']);
      $page->setContenu($valeurs_recu['contenu']);
      if ($valeurs_recu['metatitle'] == null || $valeurs_recu['metatitle'] == '') {
        $page->setMetatitle($valeurs_recu['titre']);
      }
      else {
        $page->setMetatitle($valeurs_recu['metatitle']);
      }
      if ($valeurs_recu['metadescription'] == null || $valeurs_recu['metadescription'] == '') {
        $page->setMetadescription(substr($valeurs_recu['contenu'], 0, 165));
      }
      else {
        $page->setMetadescription($valeurs_recu['metadescription']);
      }
      $em->persist($page);
      $em->flush();
      if ($valeurs_recu['mode_page'] == 'mode_page_version') {
        $version = new Version();
        $version->setNumero(1);
        $version->setPage($page);
        $version->setIdGroupe($page->getId());
        $em->persist($version);
        $em->flush();
      }
      $request->getSession()->getFlashBag()->add('success', "Page créée avec succès");
      return $this->redirectToRoute('plateforme_core_page_pages_crud');
    }
    return $this->render('PlateformeCoreBundle:PageStandard:add.html.twig');
  }

  /**
   * Formulaire d'édition d'une page
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $page_original = $em->getRepository('PlateformeCoreBundle:PageStandard')->find($id);
    if (null === $page_original) {
      throw new NotFoundHttpException("La page ayant l'identifiant " . $id . " n'existe pas.");
    }
    $versions = null;
    if($page_original->getVersion()){
      $id_groupe = $page_original->getVersion()->getIdGroupe();
      $versions = $em->getRepository('PlateformeCoreBundle:Version')->findByIdGroupe($id_groupe);
    }

    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      // Si c'est une nouvelle version
      $page = new PageStandard();
      $version = new Version();
      $version->setNumero($page_original->getVersion()->getNumero() + 1);
      $version->setPage($page);
      $version->setIdGroupe($page_original->getId());
      $em->persist($version);
      $page->setTitre($valeurs_recu['titre']);
      $page->setContenu($valeurs_recu['contenu']);
      if ($valeurs_recu['metatitle'] == null || $valeurs_recu['metatitle'] == '') {
        $page->setMetatitle($valeurs_recu['titre']);
      }
      else {
        $page->setMetatitle($valeurs_recu['metatitle']);
      }
      if ($valeurs_recu['metadescription'] == null || $valeurs_recu['metadescription'] == '') {
        $page->setMetadescription(substr($valeurs_recu['contenu'], 0, 165));
      }
      else {
        $page->setMetadescription($valeurs_recu['metadescription']);
      }
      $em->persist($page);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Page modifiée avec succès");
      return $this->redirectToRoute('plateforme_core_page_pages_crud');
    }

    return $this->render('PlateformeCoreBundle:PageStandard:edit.html.twig', array(
          'page' => $page_original,
          'versions' => $versions,
    ));
  }

  /**
   * Formulaire pour cloner une page
   */
  public function cloneAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $page = $em->getRepository('PlateformeCoreBundle:PageStandard')->find($id);
    if (null === $page) {
      throw new NotFoundHttpException("La page ayant l'identifiant " . $id . " n'existe pas.");
    }
    $page_clone = new PageStandard();
    $page_clone->setTitre("[CLONE] " . $page->getTitre());
    $page_clone->setContenu($page->getContenu());
    $page_clone->setMetatitle($page->getMetatitle());
    $page_clone->setMetadescription($page->getMetadescription());
    $em->persist($page_clone);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Page clonée avec succès");
    return $this->redirectToRoute('plateforme_core_page_pages_crud');
  }

  /**
   * Formulaire de suppression d'une page
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $page = $em->getRepository('PlateformeCoreBundle:PageStandard')->find($id);
    if (null === $page) {
      throw new NotFoundHttpException("La page ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($page);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Page supprimée avec succès");
    return $this->redirectToRoute('plateforme_core_page_pages_crud');
  }

  /**
   * Voir la page
   */
  public function viewAction($slug, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $page = $em->getRepository('PlateformeCoreBundle:PageStandard')->findOneBySlug($slug);
    if (null === $page) {
      throw new NotFoundHttpException("La page ayant l'url " . $slug . " n'existe pas.");
    }
    return $this->render('PlateformeCoreBundle:PageStandard:view.html.twig', array(
          'page' => $page,
    ));
  }

}
