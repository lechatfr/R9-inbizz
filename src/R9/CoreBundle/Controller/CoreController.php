<?php

namespace R9\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        //si identifier affichage du profil
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
            if (null !== $user) {
                return $this->redirectToRoute('r9_inbizz_profil');
            }
        }
        //affichage de la home
        return $this->render('R9CoreBundle:Core:index.html.twig');
    }
    public function headerAction()
    {
        return $this->render('R9CoreBundle:Core:header.html.twig');
    }
}
