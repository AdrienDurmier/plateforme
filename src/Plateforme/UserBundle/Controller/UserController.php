<?php
// src/Plateforme/UserBundle/Controller/UserController.php

namespace Plateforme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\UserBundle\Entity\Employe;
use Plateforme\UserBundle\Entity\Client;

class UserController extends Controller
{
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      
      // Récupération des utilisateurs
      try{
            $employes = $em->getRepository('PlateformeUserBundle:Employe')->findAll();
            $clients = $em->getRepository('PlateformeUserBundle:Client')->findAll();
            return $this->render('PlateformeUserBundle:User:index.html.twig', array(
              'employes'   => $employes,
              'clients'   => $clients,
            ));
      } catch (Exception $ex) {
          die($ex->getMessage());
      }
    }
    
    public function loginAction()
    {
      return $this->render('PlateformeUserBundle:User:login.html.twig');
    }
}
