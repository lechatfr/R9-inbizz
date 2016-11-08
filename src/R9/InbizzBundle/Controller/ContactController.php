<?php

namespace R9\InbizzBundle\Controller;

use R9\InbizzBundle\Entity\Marque;
use R9\InbizzBundle\Entity\Contact;
use R9\InbizzBundle\Form\ContactType;
use R9\InbizzBundle\Form\ContactAcheteurType;
use R9\InbizzBundle\Form\ContactMarqueType;
use R9\InbizzBundle\Form\ContactAllieType;
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



class ContactController extends Controller
{
    /**
   * @Security("has_role('ROLE_USER')")
   */
    public function createAction()
    {
        $response = new JsonResponse();
        $response->setData(array(
                'error' => 'no contact page',
            ));
        return $response;
    }
    
    /**
   * @Security("has_role('ROLE_USER')")
   * @ParamConverter("marque", options={"mapping": {"marqueid": "id"}})
   */
    public function insertAction(Marque $marque, Request $request, $form)
    {
        
        if ($request->isMethod('POST')) {
           if ($form->handleRequest($request)->isValid()) {
            
                $contact = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();

                $response = new JsonResponse();
                $response->setData(array(
                         'error' => '',
                         'contactId' => $contact->getId(),
                         'html' => $this->get('twig')->render('R9InbizzBundle:Contact:index.html.twig', array(
                            'formtype' => $contact->getTypecontact(),
                            'formcontact' => array($contact, $form, $form->createView()),
                    )),
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
        }
        
        $response = new JsonResponse();
        $response->setData(array(
                'error' => 'no insert done',
                'handleRequest' => $form->handleRequest($request)->isValid(),
                'dump' => $type,
            ));
        return $response;
    }
    
    /**
   * @Security("has_role('ROLE_USER')")
   * @ParamConverter("marque", options={"mapping": {"marqueid": "id"}})
   */
    public function insertacheteurAction(Marque $marque, Request $request)
    {
        $contact = new Contact($this->getUser(), $marque);
        
        $form = $this->createForm(ContactAcheteurType::class, $contact, array(
            'action' => $this->generateUrl('r9_inbizz_contact_update_noid'),
        ));
        
        return $this->insertAction($marque, $request, $form);
    }
    
    /**
   * @Security("has_role('ROLE_USER')")
   * @ParamConverter("marque", options={"mapping": {"marqueid": "id"}})
   */
    public function insertmarqueAction(Marque $marque, Request $request)
    {
        $contact = new Contact($this->getUser(), $marque);
        
        $form = $this->createForm(ContactMarqueType::class, $contact, array(
            'action' => $this->generateUrl('r9_inbizz_contact_update_noid'),
        ));
        
        return $this->insertAction($marque, $request, $form);
    }
    
    /**
   * @Security("has_role('ROLE_USER')")
   * @ParamConverter("marque", options={"mapping": {"marqueid": "id"}})
   */
    public function insertallieAction(Marque $marque, Request $request)
    {
        $contact = new Contact($this->getUser(), $marque);
        $contact->setNom($this->getUser()->getNom());
        $contact->setPrenom($this->getUser()->getPrenom());
        
        $form = $this->createForm(ContactAllieType::class, $contact, array(
            'action' => $this->generateUrl('r9_inbizz_contact_update_noid'),
        ));
        
        return $this->insertAction($marque, $request, $form);
    }
    
    /**
   * @Security("has_role('ROLE_USER')")
   * @ParamConverter("contact", options={"mapping": {"contactid": "id"}})
   */
    public function updateAction(Contact $contact, Request $request)
    {
        /*
        * gestion contact
        */
        
        $form = $this->getFormContactByType($contact);
        
        if ($request->isMethod('POST')) {
           if ($form->handleRequest($request)->isValid()) {
            
                $em = $this->getDoctrine()->getManager();

                $em->flush();

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
        }
        
        $response = new JsonResponse();
        $response->setData(array(
                'error' => 'no update done : '.$form->handleRequest($request)->isValid(),
            ));
        return $response;
    }
    
    /**
   * @Security("has_role('ROLE_USER')")
   * @ParamConverter("contact", options={"mapping": {"contactid": "id"}})
   */
    public function removeAction(Contact $contact, Request $request)
    {
        /*
        * gestion contact
        */
        
        $form = $this->getFormContactByType($contact);
        
        if ($request->isMethod('POST')) {
           if ($form->handleRequest($request)->isValid()) {
            
                $marque = $contact->getMarque();

                $em = $this->getDoctrine()->getManager();
                $em->remove($contact);
                $em->flush();

                $response = new JsonResponse();
                $response->setData(array(
                        'error' => '',
                        'urlallieaction' => $this->generateUrl('r9_inbizz_contact_allie_insert',array('marqueid' => $marque->getId())),
                    ));
            } else {
                $response = new JsonResponse();
                $response->setData(array(
                        'error' => 'oui',
                    ));
            }
            return $response;
        }
        
        $response = new JsonResponse();
        $response->setData(array(
                'error' => 'no delete done',
            ));
        return $response;
    }
    
    public function getFormContactByType(Contact $contact)
    {
        switch ($contact->getTypecontact()) {
            case 'acheteur':
                $form = $this->createForm(ContactAcheteurType::class, $contact, array());
                break;
            case 'marque':
                $form = $this->createForm(ContactMarqueType::class, $contact, array());
                break;
            case 'allie':
                $form = $this->createForm(ContactAllieType::class, $contact, array());
                break;
            default:
                $form = $this->createForm(ContactType::class, $contact, array());
        }
        
        return $form;
    }
    
}
