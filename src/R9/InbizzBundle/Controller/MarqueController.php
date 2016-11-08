<?php

namespace R9\InbizzBundle\Controller;

use R9\InbizzBundle\Entity\Marque;
use R9\InbizzBundle\Form\MarqueType;
use R9\InbizzBundle\Entity\Contact;
use R9\InbizzBundle\Form\ContactType;
use R9\InbizzBundle\Form\ContactAcheteurType;
use R9\InbizzBundle\Form\ContactMarqueType;
use R9\InbizzBundle\Form\ContactAllieType;
use R9\InbizzBundle\Entity\Image;
use R9\InbizzBundle\Entity\Marquestatut;
use R9\InbizzBundle\Entity\Marqueetat;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

// use Symfony\Component\Security\Core\Exception\AccessDeniedException;
// use Symfony\Component\Validator\Validation;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
// use Doctrine\ORM\Mapping as ORM;



class MarqueController extends Controller
{
    /**
   * @Security("has_role('ROLE_USER')")
   */
    public function createAction(Request $request)
    {
        $classmode='creation';
        
        /*
        * gestion marque
        */
        
        $marque = new Marque($this->getUser());
        $image = new Image();
        $marque->setImage($image);
        
        $marquestatutrepository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('R9InbizzBundle:Marquestatut')
        ;
        $marquestatut = $marquestatutrepository->findFirst();
        $marque->setMarquestatut($marquestatut);

        $marqueetatrepository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('R9InbizzBundle:Marqueetat')
        ;
        $marqueetat = $marqueetatrepository->findFirst();
        $marque->setMarqueetat($marqueetat);
        
        $form = $this->createForm(MarqueType::class, $marque, array());
        
        /*
        * gestion contact
        */
        
        $formcontactsacheteur = $this->getFormContactList($marque, 'acheteur');
        $formcontactsmarque = $this->getFormContactList($marque, 'marque');
        $formcontactsallie = $this->getFormContactList($marque, 'allie');
                
        /*
        * gestion de la soumission des formulaires
        */
        
        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {
               // $marque = $form->getData();

                $em = $this->getDoctrine()->getManager();
                if ($request->files->get('file') !== null) {
                    $marque->getImage()->setFile($request->files->get('file'));
                }

                $em->persist($marque);
                $em->flush();

                //$request->getSession()->getFlashBag()->add('notice', 'Marque enregistrée.');

                $response = new JsonResponse();
                $response->setData(array(
                        'error' => '',
                        'marqueId' => $marque->getId(),
                    ));
            } else {
               $errors = array();
               foreach ($form->all() as $child) {
                    if (!$child->isValid()) {
                        $errors[] = $child->getName();
                    }
                }
               
               $response = new JsonResponse();
                $response->setData(array(
                        'error' => 'oui',
                        'fields' => $errors,
                        'marqueId' => '',
                    ));
            }
            return $response;
            //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }
        
        return $this->render('R9InbizzBundle:Marque:index.html.twig', array(
            'classmode'=>$classmode,
            'marque' => $marque,
            'form' => $form->createView(),
            'formcontactsacheteur' => $formcontactsacheteur,
            'formcontactsmarque' => $formcontactsmarque,
            'formcontactsallie' => $formcontactsallie,
        ));
    }
    
    /**
   * @Security("has_role('ROLE_USER')")
   * @ParamConverter("marque", options={"mapping": {"marqueid": "id"}})
   */
    public function viewAction(Marque $marque, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /*
        * gestion marque
        */
        
        $classmode='';
        if ($marque->getUser()===$this->getUser()){
            $classmode='proprietaire';
        }
        
        $form = $this->createForm(MarqueType::class, $marque, array());
        
        /*
        * gestion contact
        */
        
        $formcontactsacheteur = $this->getFormContactList($marque, 'acheteur');
        $formcontactsmarque = $this->getFormContactList($marque, 'marque');
        $formcontactsallie = $this->getFormContactList($marque, 'allie');
        
        /*
        * gestion de la soumission des formulaires
        */
        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request)->isValid()) {
                //$em = $this->getDoctrine()->getManager();

                $marque->getImage()->setFile($request->files->get('file'));

                $em->flush();
                //$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
                $response = new JsonResponse();
                $response->setData(array(
                        'error' => '',
                    ));
            } else {
               $errors = array();
               foreach ($form->all() as $child) {
                    if (!$child->isValid()) {
                        $errors[] = $child->getName();
                    }
                }
               
               $response = new JsonResponse();
                $response->setData(array(
                        'error' => 'oui',
                        'fields' => $errors,
                    ));
            }
            return $response;
            //return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }
        
        return $this->render('R9InbizzBundle:Marque:index.html.twig', array(
            'classmode'=>$classmode,
            'marque' => $marque,
            'form' => $form->createView(),
            'formcontactsacheteur' => $formcontactsacheteur,
            'formcontactsmarque' => $formcontactsmarque,
            'formcontactsallie' => $formcontactsallie,
        ));
    }
    
    public function getFormContactList(Marque $marque, $contacttype)
    {
        $em = $this->getDoctrine()->getManager();
        
        $formcontacts = array();
        //contact acheteur
        $contactone = new Contact($this->getUser(), $marque);
        $contactone->setTypecontact($contacttype);
        
        switch ($contacttype) {
            case 'acheteur':
                if ($marque->getId()) {
                    $formcontactone = $this->createForm(ContactAcheteurType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_acheteur_insert', array('marqueid' => $marque->getId())),
                    ));
                } else {
                    $formcontactone = $this->createForm(ContactAcheteurType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_create').'acheteur/insert',
                    ));
                }
                $formcontacts[] = array($contactone, $formcontactone, $formcontactone->createView());
                break;
            case 'marque':
                if ($marque->getId()) {
                    $formcontactone = $this->createForm(ContactMarqueType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_marque_insert', array('marqueid' => $marque->getId())),
                    ));
                } else {
                    $formcontactone = $this->createForm(ContactMarqueType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_create').'marque/insert',
                    ));
                }
                $formcontacts[] = array($contactone, $formcontactone, $formcontactone->createView());
                break;
            case 'allie':
                if ($marque->getId()) {
                    
                    $userIsAllie = $em
                        ->getRepository('R9InbizzBundle:Contact')
                        ->isMarqueAllie($marque, $this->getUser())
                    ;
                    
                    if ($userIsAllie !== null){
                        $contactone = $userIsAllie;
                        $formcontactone = $this->createForm(ContactAllieType::class, $contactone, array(
                            'action' => $this->generateUrl('r9_inbizz_contact_update', array('contactid' => $userIsAllie->getId())),
                        ));
                    } else {
                        $formcontactone = $this->createForm(ContactAllieType::class, $contactone, array(
                            'action' => $this->generateUrl('r9_inbizz_contact_allie_insert', array('marqueid' => $marque->getId())),
                        ));
                    }
                    $formcontacts[] = array($contactone, $formcontactone, $formcontactone->createView());
                } else {
                    $formcontactone = $this->createForm(ContactAllieType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_create').'allie/insert',
                    ));
                    $formcontacts[] = array($contactone, $formcontactone, $formcontactone->createView());
                }
                break;
            default:

        }
        
        if ($marque->getId()) {
            $contactList = $em
                ->getRepository('R9InbizzBundle:Contact')
                ->getContactlist($marque, $contacttype, $this->getUser())
            ;
            
            $formcontacts = $this->getContactListData($contactList, $formcontacts);
        }
        return $formcontacts;
    }
    
    public function getContactListData($contactList, $formcontacts)
    {
       foreach ($contactList as $contactone){
            $contacttype = $contactone->getTypecontact();
            switch ($contacttype) {
                case 'acheteur':
                    $formcontactone = $this->createForm(ContactAcheteurType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_update', array('contactid' => $contactone->getId())),
                    ));
                    break;
                case 'marque':
                    $formcontactone = $this->createForm(ContactMarqueType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_update', array('contactid' => $contactone->getId())),
                    ));
                    break;
                case 'allie':
                    $formcontactone = $this->createForm(ContactAllieType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_update', array('contactid' => $contactone->getId())),
                    ));
                    break;
                default:

            }
            $formcontacts[] = array($contactone, $formcontactone, $formcontactone->createView());
        }
        return $formcontacts;
    }
}
