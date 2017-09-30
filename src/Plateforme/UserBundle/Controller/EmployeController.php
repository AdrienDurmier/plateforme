<?php
// src/Plateforme/UserBundle/Controller/EmployeController.php

namespace Plateforme\UserBundle\Controller;

use Plateforme\UserBundle\Entity\Employe;
use Plateforme\UserBundle\Form\EmployeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmployeController extends Controller
{
    public function inscriptionAction(Request $request)
    {
      $employe = new Employe();
      $form = $this->get('form.factory')->create(EmployeType::class, $employe);
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($employe);
          $em->flush();
          $request->getSession()->getFlashBag()->add('notice', "Inscription OK");
        }
      }
      return $this->render('PlateformeUserBundle:Employe:inscription.html.twig', array(
        'form' => $form->createView(),
      ));
    }
}
