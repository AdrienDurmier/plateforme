<?php

namespace Plateforme\UserBundle\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginRedirection implements AuthenticationSuccessHandlerInterface {

  protected $router;

  public function __construct(RouterInterface $router) {
    $this->router = $router;
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
    $response = new RedirectResponse($this->router->generate('plateforme_core_homepage'));

    // Si l'url d'expédition de la requête contient 'panier'
    if (!(strpos($request->headers->get('referer'), 'panier') === false)) {
      $response = new RedirectResponse($this->router->generate('plateforme_ecommerce_panier'));
    }
    else {
      $roles = $token->getRoles();
      $rolesTab = array_map(
          function($role) {
        return $role->getRole();
      }, $roles
      );
      if (in_array('ROLE_CLIENT', $rolesTab)) {
        $response = new RedirectResponse($this->router->generate('fos_user_profile_show'));
      }
      if (in_array('ROLE_EMPLOYE', $rolesTab)) {
        $response = new RedirectResponse($this->router->generate('plateforme_core_bo_homepage'));
      }
      if (in_array('ROLE_ADMIN', $rolesTab)) {
        $response = new RedirectResponse($this->router->generate('plateforme_core_bo_homepage'));
      }
      if (in_array('ROLE_SUPER_ADMIN', $rolesTab)) {
        $response = new RedirectResponse($this->router->generate('plateforme_core_bo_homepage'));
      }
    }

    return $response;
  }

}
