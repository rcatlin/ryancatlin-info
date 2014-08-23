<?php

namespace MyProject\Bundle\MainBundle\Controller;

use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginController extends SecurityController
{
    /**
     * @Route("/login", name="fos_user_security_login")
     */
    public function loginAction(Request $request)
    {
        if ($this->isAuthenticatedFully()) {
            return $this->redirect('index');
        }

        return parent::loginAction($request);
    }

    /**
     * {@inheritDoc}
     */
    protected function renderLogin(array $data)
    {
        return $this->container->get('templating')
            ->renderResponse(
                'MainBundle:Login:login.html.twig',
                $data
            )
        ;
    }

    /**
     * @return bool
     */
    protected function isAuthenticatedFully()
    {
        return $this->container->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY')
        ;
    }

    /**
     * @param string $path
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirect($route)
    {
        $router = $this->container->get('router');

        $url = $router->generate(
            $route,
            array(),
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new RedirectResponse($url);
    }
}
