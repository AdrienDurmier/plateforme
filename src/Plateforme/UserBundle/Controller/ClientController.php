<?php
// src/Plateforme/UserBundle/Controller/ClientController.php

namespace Plateforme\UserBundle\Controller;

use Plateforme\UserBundle\Entity\Client;
use Plateforme\UserBundle\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ClientController extends Controller
{
  /**
   * Formulaire d'inscription d'un client
   * @param Request $request
   * @return type
   */
  public function inscriptionAction(Request $request) {
    $client = new Client();
    $form = $this->get('form.factory')->create(ClientType::class, $client);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Inscription OK");
        // Redirection vers page accueil
        $url = $this->generateUrl('plateforme_core_homepage');
        $response = new RedirectResponse($url);
        return $response;
      }
    }
    return $this->render('PlateformeUserBundle:Client:inscription.html.twig', array(
          'form' => $form->createView(),
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
    $client = $em->getRepository('PlateformeUserBundle:Client')->find($id);
    if (null === $client) {
      throw new NotFoundHttpException("Le client ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create();
    if ($request->isMethod('POST')) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($client);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Client supprimé avec succès");
      return $this->redirectToRoute('plateforme_user_clients_crud');
    }
    return $this->render('PlateformeUserBundle:Client:delete.html.twig', array(
          'client' => $client,
          'form' => $form->createView(),
    ));
  }
}
