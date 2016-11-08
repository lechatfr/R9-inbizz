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

class RechercheController extends Controller
{
    /**
   * @Security("has_role('ROLE_USER')")
   */
  public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $search = $request->query->get('q');

        if ($request->isMethod('GET') && $search != "") {
            
            /*
            * gestion critere de recherche
            */
            
            $termList = explode(",", $search);
            $trimmedTermList=array_map('trim',$termList);
            
            /*
            * gestion marque
            */
            
            $marques = $em
                ->getRepository('R9InbizzBundle:Marque')
                ->rechercheMarque($trimmedTermList)
            ;
            
            /*
            * gestion contact
            */
            $formcontacts = array();
            
            $contacts = $em
                ->getRepository('R9InbizzBundle:Contact')
                ->rechercheContact($trimmedTermList)
            ;
            
            $formcontacts = $this->getContactListData($contacts, $formcontacts);
            
            /*
            * liste marque si pas result
            */
            $allmarques = array();
            if (count($marques)+count($contacts)==0){
                $allmarques = $em
                    ->getRepository('R9InbizzBundle:Marque')
                    ->allMarque()
                ;
            }
            
        }

        // return $this->render('R9InbizzBundle:Profil:index.html.twig');
        return $this->render('R9InbizzBundle:Recherche:index.html.twig', array(
            'resultlist' => true,
            'search' => $search,
            'marques' => $marques,
            'formcontacts' => $formcontacts,
            'allmarques' => $allmarques,
        ));
    }
    
    private $search;
    private $names;
    
      /**
   * @Security("has_role('ROLE_USER')")
   */
  public function autocompleteAction(Request $request)
    {
        $this->names = array();
        $em = $this->getDoctrine()->getManager();
        $this->search = $request->query->get('q');

        if ($request->isMethod('GET') && $this->search != "") {
            
            $termsMarque = $em
                ->getRepository('R9InbizzBundle:Marque')
                ->autocompleteMarque($this->search)
            ;
            foreach ($termsMarque as $term)
            {
                $this->names[] = $term->getNom();
            }
            $termsContact = $em
                ->getRepository('R9InbizzBundle:Contact')
                ->autocompleteContact($this->search)
            ;
            foreach ($termsContact as $term)
            {
                $this->autocompleteAddName($term->getNom());
                $this->autocompleteAddName($term->getPrenom());
                $tmpNames = explode(",", $term->getProjetlist());
                $trimmedTmpNames=array_map(array($this, 'autocompleteAddName'),$tmpNames);
                if ($term->getUser() !== null) {
                    $tmpNames = explode(",", $term->getUser()->getConnaissancessectorielles());
                    $trimmedTmpNames=array_map(array($this, 'autocompleteAddName'),$tmpNames);
                    $tmpNames = explode(",", $term->getUser()->getCompetencesmetier());
                    $trimmedTmpNames=array_map(array($this, 'autocompleteAddName'),$tmpNames);
                }
            }
        }
        
        $response = new JsonResponse();
        $response->setData($this->names);

        return $response;
    }
    
    public function autocompleteAddName($name)
    {
        $lowname = strtolower($name);
        $lowsearch = strtolower($this->search);
        if (strpos($lowname, $lowsearch) !== false) {
            
            if (!in_array($lowname,$this->names)) {
                $this->names[] = $lowname;
            }
            
        }
    }
    
    public function getContactListData($contactList, $formcontacts)
    {
       $formallies = array();
        foreach ($contactList as $contactone){
            $contacttype = $contactone->getTypecontact();
            switch ($contacttype) {
                case 'acheteur':
                    $formcontactone = $this->createForm(ContactAcheteurType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_update', array('contactid' => $contactone->getId())),
                    ));
                    $formcontacts[] = array($contactone, $formcontactone, $formcontactone->createView());
                    break;
                case 'marque':
                    $formcontactone = $this->createForm(ContactMarqueType::class, $contactone, array(
                        'action' => $this->generateUrl('r9_inbizz_contact_update', array('contactid' => $contactone->getId())),
                    ));
                    $formcontacts[] = array($contactone, $formcontactone, $formcontactone->createView());
                    break;
                case 'allie':
                    if (!in_array($contactone->getUser()->getEmail(), $formallies)) {
                        $formallies[] = $contactone->getUser()->getEmail();
                        $formcontactone = $this->createForm(ContactAllieType::class, $contactone, array(
                            'action' => $this->generateUrl('r9_inbizz_contact_update', array('contactid' => $contactone->getId())),
                        ));
                        $formcontacts[] = array($contactone, $formcontactone, $formcontactone->createView());
                    }
                    break;
                default:

            }
        }
        return $formcontacts;
    }
    
}
