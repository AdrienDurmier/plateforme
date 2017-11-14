<?php
// src/Plateforme/UserBundle/Controller/ClientController.php

namespace Plateforme\UserBundle\Controller;

use Plateforme\UserBundle\Entity\Client;
use Plateforme\UserBundle\Form\ClientType;
use Plateforme\CoreBundle\Entity\Adresse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Intl\Intl;

class ClientController extends Controller
{
  /**
   * Formulaire d'inscription d'un client
   * @param Request $request
   * @return type
   */
  public function inscriptionAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    
    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      // print '<pre>';print_r($valeurs_recu);print '</pre>';die();
      // Gestion des erreurs
      if ($valeurs_recu['adresse'] == '' || $valeurs_recu['cp'] == '' || $valeurs_recu['commune'] == '' || $valeurs_recu['pays'] == '') {
        $this->get('session')->getFlashBag()->add('warning', 'Vous devez saisir une adresse de livraison.');
        return $this->redirectToRoute('plateforme_user_inscription_client');
      }
      if (!isset($valeurs_recu['client_pass']) || $valeurs_recu['client_pass'] == '') {
        $this->get('session')->getFlashBag()->add('warning', 'Vous devez saisir un mot de passe.');
        return $this->redirectToRoute('plateforme_user_inscription_client');
      }
      if ($valeurs_recu['client_pass'] != $valeurs_recu['client_confirm']) {
        $this->get('session')->getFlashBag()->add('warning', 'Votre mot de passe et votre confirmation de mot de passe sont différents.');
        return $this->redirectToRoute('plateforme_user_inscription_client');
      }
      if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#" , $valeurs_recu['client_mail'] ) )
      {
        $this->get('session')->getFlashBag()->add('warning', "Veuillez entrer une adresse mail valide.");
        return $this->redirectToRoute('plateforme_user_inscription_client');
      }
      
      // Test si un utilisateur a déjà cette adresse mail: redirection vers la demande de mot de passe
      $client_existant = $em->getRepository('PlateformeUserBundle:User')->findOneByEmail($valeurs_recu['client_mail']);
      if($client_existant){
        $this->get('session')->getFlashBag()->add('warning', "Compte déjà existant, vous pouvez demander un nouveau mot de passe.");
        return $this->redirectToRoute('fos_user_resetting_request');
      }
      $client = new Client();
      $civilite_select = $em->getRepository('PlateformeCoreBundle:Civilite')->findOneByPrefixName($valeurs_recu['client_civilite']);
      $client->setCivilite($civilite_select);
      $client->setNom($valeurs_recu['client_nom']);
      $client->setPrenom($valeurs_recu['client_prenom']);
      $client->setUsername($valeurs_recu['client_mail']);
      $client->setEmail($valeurs_recu['client_mail']);
      $client->setEmailCanonical($valeurs_recu['client_mail']);
      $client->setEnabled(1);
      $client->setPlainPassword($valeurs_recu['client_pass']);
      $client->setTelephone($valeurs_recu['client_tel']);
      $client->setFax($valeurs_recu['client_fax']);
      if (null === $client->getConfirmationToken()) {
        $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $client->setConfirmationToken($token);
      }
      $em->persist($client);
      // Création des adresses
      $adresse = new Adresse();
      $adresse->setTitre($valeurs_recu['client_prenom'] . ' ' . $valeurs_recu['client_nom']); // Nom prénom / societe
      $adresse->setAdresse($valeurs_recu['adresse']);
      $adresse->setComplement($valeurs_recu['complement']);
      $adresse->setCodePostal($valeurs_recu['cp']);
      $adresse->setCommune($valeurs_recu['commune']);
      $adresse->setPays($valeurs_recu['pays']);
      $adresse->setClient($client);
      $adresse->setLivraison(true);
      $adresse->setFacturation(true);
      $em->persist($adresse);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Merci, vous êtes maintenant inscrit sur notre plateforme.");
    }
    
    $civilites = $em->getRepository('PlateformeCoreBundle:Civilite')->findAll();
    
    return $this->render('PlateformeUserBundle:Client:inscription.html.twig', array(
          'civilites' => $civilites,
          'countries' => Intl::getRegionBundle()->getCountryNames(),
    ));
  }
  /**
   * Gestion des clients
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $clients = $em->getRepository('PlateformeUserBundle:Client')->findAll();
    return $this->render('PlateformeUserBundle:Client:crud.html.twig', array(
          'clients' => $clients,
    ));
  }
  /**
   * Formulaire de création d'un client
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $client = new Client();
    $form = $this->get('form.factory')->create(ClientType::class, $client);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Client créé avec succès");
        return $this->redirectToRoute('plateforme_user_clients_crud');
      }
    }
    return $this->render('PlateformeUserBundle:Client:add.html.twig', array(
          'form' => $form->createView(),
    ));
  }
  /**
   * Formulaire d'édition d'un client
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $client = $em->getRepository('PlateformeUserBundle:Client')->find($id);
    if (null === $client) {
      throw new NotFoundHttpException("Le client ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create(ClientType::class, $client);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Client modifié avec succès");
        return $this->redirectToRoute('plateforme_user_clients_crud');
      }
    }
    return $this->render('PlateformeUserBundle:Client:edit.html.twig', array(
          'client' => $client,
          'form' => $form->createView(),
    ));
  }
  /**
   * Formulaire de suppression d'un client
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('PlateformeUserBundle:User')->find($id);
    if (null === $user) {
      throw new NotFoundHttpException("Le client ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create();
    if ($request->isMethod('POST')) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($user);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Client supprimé avec succès");
      return $this->redirectToRoute('plateforme_user_clients_crud');
    }
    return $this->render('PlateformeUserBundle:Client:delete.html.twig', array(
          'client' => $user,
          'form' => $form->createView(),
    ));
  }
}
