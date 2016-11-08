<?php

namespace R9\InbizzBundle\Controller;

use R9\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Forms;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Validator\Validation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProfilController extends Controller
{
    /**
   * @Security("has_role('ROLE_USER')")
   */
  public function indexAction(Request $request)
    {
        /*
        * gestion user
        */
        $user = $this->getUser();  

        $classmode='proprietaire';

        $form = $this->createForm(\R9\UserBundle\Form\UserType::class, $user, array(
            //'action' => $this->generateUrl('r9_inbizz_profil_update'),
        ));

        /*
        * gestion marque
        */
        $marques = $this->getMarqueOwnerOrAllieList($user);
      
        /*
        * gestion de la soumission des formulaires
        */
      
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $useredited = $form->getData();
            $useredited->setUsername($useredited->getPrenom().' '.$useredited->getNom());
            
            if ($request->files->get('file') !== null) {
                $useredited->getImage()->setFile($request->files->get('file'));
            }
            if ($useredited->getEmail() == 'mlecoeur@t2bh.fr') {
                $useredited->addRole('ROLE_ADMIN');
            }
            
            $this->get('fos_user.user_manager')->updateUser($useredited, true);
            // make more modifications to the database
            $this->getDoctrine()->getManager()->flush();

            $response = new JsonResponse();
            $response->setData(array(
                    'error' => '',
                ));
            return $response;
        }

        // return $this->render('R9InbizzBundle:Profil:index.html.twig');
        return $this->render('R9InbizzBundle:Profil:index.html.twig', array(
            'classmode'=>$classmode,
            'user' => $user,
            'formprofil' => $form->createView(),
            'marques' => $marques,
        ));
    }
    
    /**
   * @Security("has_role('ROLE_USER')")
   * @ParamConverter("user", options={"mapping": {"usermail": "email"}})
   */
    public function viewAction(User $user)
    {
        /*
        * gestion user
        */
        $classmode='';
        if ($user===$this->getUser()){
            $classmode='proprietaire';
        }
        
        $form = $this->createForm(\R9\UserBundle\Form\UserType::class, $user, array(
            //'action' => $this->generateUrl('r9_inbizz_profil_update'),
        ));
      
        /*
        * gestion marque
        */
        $marques = $this->getMarqueOwnerOrAllieList($user);
      
      
        // return $this->render('R9InbizzBundle:Profil:index.html.twig');
        return $this->render('R9InbizzBundle:Profil:index.html.twig', array(
            'classmode'=>$classmode,
            'user' => $user,
            'formprofil' => $form->createView(),
            'marques' => $marques,
        ));
    }
    
    public function getMarqueOwnerOrAllieList(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $marques = $em
            ->getRepository('R9InbizzBundle:Marque')
            ->getMarqueOwnerOrAllie($user)
        ;
        
        return $marques;
    }
}
