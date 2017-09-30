<?php
namespace Plateforme\CatalogueBundle\Controller;

use Plateforme\CatalogueBundle\Entity\Produit;
use Plateforme\CatalogueBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProduitController extends Controller
{
    /**
     * Produits
     */
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findAll();
      return $this->render('PlateformeCatalogueBundle:Produit:index.html.twig', array(
        'produits'   => $produits,
      ));
    }
    
    /**
     * Gestion des produits
     */
    public function crudAction()
    {
      $em = $this->getDoctrine()->getManager();
      $produits = $em->getRepository('PlateformeCatalogueBundle:Produit')->findAll();
      return $this->render('PlateformeCatalogueBundle:Produit:crud.html.twig', array(
        'produits'   => $produits,
      ));
    }
  
    /**
     * Formulaire de création d'un produit
     */
    public function addAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $produit = new Produit();
      $form = $this->get('form.factory')->create(ProduitType::class, $produit);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($produit);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Produit créé avec succès");
          return $this->redirectToRoute('plateforme_core_page_produits_view', array('slug' => $produit->getSlug()));
        }
      }
      return $this->render('PlateformeCatalogueBundle:Produit:add.html.twig', array(
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire d'édition d'un produit
     */
    public function editAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
      if (null === $produit) {
        throw new NotFoundHttpException("Le produit ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create(ProduitType::class, $produit);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($produit);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Produit modifié avec succès");
          return $this->redirectToRoute('plateforme_core_page_produits_view', array('slug' => $produit->getSlug()));
        }
      }
      
      return $this->render('PlateformeCatalogueBundle:Produit:edit.html.twig', array(
        'produit' => $produit,
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire pour cloner un produit
     */
    public function cloneAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
      if (null === $produit) {
        throw new NotFoundHttpException("Le produit ayant l'identifiant ".$id." n'existe pas.");
      }
      $produit_clone = new Produit();
      $produit_clone->setTitre("[CLONE] ".$produit->getTitre());
      $produit_clone->setContenu($produit->getContenu());
      $em->persist($produit_clone);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Produit cloné avec succès");
      return $this->redirectToRoute('plateforme_core_page_produits_crud');
    }
    
    /**
     * Formulaire de suppression d'un produit
     */
    public function deleteAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->find($id);
      if (null === $produit) {
        throw new NotFoundHttpException("Le produit ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create();
      
      if ($request->isMethod('POST')) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Produit supprimé avec succès");
        return $this->redirectToRoute('plateforme_core_page_produits_crud');
      }
      
      return $this->render('PlateformeCatalogueBundle:Produit:delete.html.twig', array(
        'produit' => $produit,
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Fiche produit
     */
    public function viewAction($slug, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $produit = $em->getRepository('PlateformeCatalogueBundle:Produit')->findOneBySlug($slug);
      if (null === $produit) {
        throw new NotFoundHttpException("Le produit ayant l'url ".$slug." n'existe pas.");
      }
      return $this->render('PlateformeCatalogueBundle:Produit:view.html.twig', array(
        'produit'   => $produit,
      ));
    }
    
    
}
