<?php
namespace Plateforme\EcommerceBundle\Controller;

use Plateforme\EcommerceBundle\Entity\TarifLaposteRecommande;
use Plateforme\EcommerceBundle\Form\TarifLaposteRecommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class TarifLaposteRecommandeController extends Controller
{
    /**
     * Gestion des tarifs de La Poste par recommandé
     * @Security("has_role('ROLE_WEBMASTER')")
     */
    public function crudAction()
    {
      $em = $this->getDoctrine()->getManager();
      $tarifs = $em->getRepository('PlateformeEcommerceBundle:TarifLaposteRecommande')->findAll();
      return $this->render('PlateformeEcommerceBundle:TarifLaposteRecommande:crud.html.twig', array(
        'tarifs'   => $tarifs,
      ));
    }
  
    /**
     * Formulaire de tarif de La Poste par recommandé
     * @Security("has_role('ROLE_WEBMASTER')")
     */
    public function addAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $tarif = new TarifLaposteRecommande();
      $form = $this->get('form.factory')->create(TarifLaposteRecommandeType::class, $tarif);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($tarif);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Tarif créé avec succès");
          return $this->redirectToRoute('plateforme_ecommerce_tariflaposterecommande_crud');
        }
      }
      return $this->render('PlateformeEcommerceBundle:TarifLaposteRecommande:add.html.twig', array(
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire d'édition d'un tarif de La Poste par recommandé
     * @Security("has_role('ROLE_WEBMASTER')")
     */
    public function editAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $tarif = $em->getRepository('PlateformeEcommerceBundle:TarifLaposteRecommande')->find($id);
      if (null === $tarif) {
        throw new NotFoundHttpException("La tarif ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create(TarifLaposteRecommandeType::class, $tarif);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($tarif);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Tarif modifié avec succès");
          return $this->redirectToRoute('plateforme_ecommerce_tariflaposterecommande_crud');
        }
      }
      
      return $this->render('PlateformeEcommerceBundle:TarifLaposteRecommande:edit.html.twig', array(
        'tarif' => $tarif,
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire de suppression d'un tarif de La Poste par recommandé
     * @Security("has_role('ROLE_WEBMASTER')")
     */
    public function deleteAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $tarif = $em->getRepository('PlateformeEcommerceBundle:TarifLaposteRecommande')->find($id);
      if (null === $tarif) {
        throw new NotFoundHttpException("Le tarif ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create();
      
      if ($request->isMethod('POST')) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($tarif);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Tarif supprimé avec succès");
        return $this->redirectToRoute('plateforme_ecommerce_tariflaposterecommande_crud');
      }
      
      return $this->render('PlateformeEcommerceBundle:TarifLaposteRecommande:delete.html.twig', array(
        'tarif' => $tarif,
        'form' => $form->createView(),
      ));
    }
    
  /**
   * Récupération du tarif à partir du pays de destination (passé en post via ajax)
   * @return type
   */
  public function tarifAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $tarif_livraison_obj = $em->getRepository('PlateformeEcommerceBundle:TarifLaposteRecommande')->findOneByPays($valeurs_recu['pays_destination']);
    $tarif_livraison = null;
    
    // Envoie vers tout pays ayant un tarif
    if (isset($tarif_livraison_obj)) {
      $tarif_livraison = $tarif_livraison_obj->getTarif();
    }
    
    $response = array(
      'tarif_livraison' => $tarif_livraison,
    );
    return new JsonResponse($response);
  }
}
