<?php

namespace Plateforme\PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaypalController extends Controller {

  /**
   * Formulaire de paiement paypal
   */
  public function formAction($commande) {
    $em = $this->getDoctrine()->getManager();
    // URL du module de paiement
    $mode = $this->container->getParameter('paypal_mode');
    // URLs de retours
    $paypal_url_return = $this->container->getParameter('paypal_url_return');
    $paypal_url_cancel = $this->container->getParameter('paypal_url_cancel');
    $paypal_url_notify = $this->container->getParameter('paypal_url_notify');
    $paypal_url = null;
    $paypal_mail_vendeur = null;
    switch ($mode) {
      case "sandbox":
        $paypal_url = $this->container->getParameter('paypal_sandbox');
        $paypal_mail_vendeur = $this->container->getParameter('paypal_sandbox_mail');
        break;
      case "production":
        $paypal_url = $this->container->getParameter('paypal_prod');
        $paypal_mail_vendeur = $this->container->getParameter('paypal_prod_mail');
        break;
    }
    
    // Nom du site
    $site_name = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('site_name');
    
    return $this->render('PlateformePaiementBundle:Paypal:form.html.twig', array(
          'paypal_url'        => $paypal_url,
          'paypal_url_return' => $paypal_url_return,
          'paypal_url_cancel' => $paypal_url_cancel,
          'paypal_url_notify' => $paypal_url_notify,
          'paypal_mail'       => $paypal_mail_vendeur,
          'site_name'         => $site_name->getValue(),
          'commande'          => $commande,
    ));
  }
  
  /**
   * Page de retour pour les paiements acceptés
   */
  public function returnAction(Request $request) {
    $session = $request->getSession();
    $session->remove('panier');
    return $this->render('PlateformePaiementBundle:Paypal:retour_ok.html.twig');
  }

  /**
   * Page de retour pour les paiements annulés
   */
  public function cancelAction(Request $request) {
    return $this->render('PlateformePaiementBundle:Paypal:retour_cancel.html.twig');
  }

  /**
   * Page de retour pour les paiements acceptés
   * @see https://github.com/paypal/ipn-code-samples/blob/master/php/PaypalIPN.php
   */
  public function notifyAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();

    // STEP 1: Read POST data
    $raw_post_data = $request->getContent();
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();

    foreach ($raw_post_array as $keyval) {
      $keyval = explode('=', $keyval);
      if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
    }

    $req = 'cmd=_notify-validate';
    if (function_exists('get_magic_quotes_gpc')) {
      $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
      if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
      }
      else {
        $value = urlencode($value);
      }
      $req .= "&$key=$value";
    }

    // STEP 2: Post IPN data back to paypal to validate
    $ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

    if (!($res = curl_exec($ch))) {
      // error_log("Got " . curl_error($ch) . " when processing IPN data");
      curl_close($ch);
      exit;
    }
    curl_close($ch);

    // DEBUG
    $ipn_logs = $this->get('kernel')->getRootDir() . '/../var/logs/ipn/test.log';
    //$ipn_logs = $this->get('kernel')->getRootDir() . '/../var/logs/ipn/'.date('Ymd:h:i:s').'.log';
    file_put_contents($ipn_logs, print_r($valeurs_recu, true));

    $commande = $em->getRepository('PlateformeEcommerceBundle:Commande')->find(133216);

    // STEP 3: Inspect IPN validation result and act accordingly
    if (strcmp($res, "VERIFIED") == 0) {
      $item_name = $valeurs_recu['item_name'];
      $item_number = $valeurs_recu['item_number'];
      $cart_item = $valeurs_recu['num_cart_items'];
      $payment_status = $valeurs_recu['payment_status'];
      $payment_amount = $valeurs_recu['mc_gross'];
      $payment_currency = $valeurs_recu['mc_currency'];
      $txn_id = $valeurs_recu['txn_id'];
      $receiver_email = $valeurs_recu['receiver_email'];
      $payer_email = $valeurs_recu['payer_email'];

      $response = $this->forward('PlateformeEcommerceBundle:Commande:maj', array(
        'datas' => $valeurs_recu,
        'commande' => $commande,
      ));

      return $response;
    }
    else if (strcmp($res, "INVALID") == 0) {
      // TODO error_log
      return new Response("Paypal didn't worked !");
    }
  }

}
