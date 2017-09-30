<?php
// src/Plateforme/UserBundle/Controller/ClientController.php

namespace Plateforme\UserBundle\Controller;

use Plateforme\UserBundle\Entity\Client;
use Plateforme\UserBundle\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends Controller
{
    public function inscriptionAction(Request $request)
    {
      $client = new Client();
      $form = $this->get('form.factory')->create(ClientType::class, $client);
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($client);
          $em->flush();
          $request->getSession()->getFlashBag()->add('notice', "Inscription OK");
        }
      }
      return $this->render('PlateformeUserBundle:Client:inscription.html.twig', array(
        'form' => $form->createView(),
      ));
    }
}
