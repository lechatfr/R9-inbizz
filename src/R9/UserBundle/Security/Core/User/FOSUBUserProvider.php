<?php

// \src\R9\UserBundle\Security\Core\UserFOSUBUserProvider.php

namespace R9\UserBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;

use R9\UserBundle\Entity\User;
use R9\InbizzBundle\Entity\Image;
use R9\UserBundle\Services\SessionManager;

class FOSUBUserProvider extends BaseClass
{
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $service = $response->getResourceOwner()->getName();
        $service_id = ucfirst($service).'Id';
        //Data from Reseau Social response
        $socialID = $response->getUsername(); /* An ID like: 112259658235204980084 */
        $socialEmail = $response->getEmail();
        
        //tester si le user deja en db via Reseau Social
        $user = $this->userManager->findUserBy(array($this->getProperty($response)=>$socialID));
        if (null === $user) {
            //tester si le user deja en db (email)
            $userdb = $this->userManager->findUserBy(array('email' => $socialEmail));
            if (null !== $userdb) {
                //mise a jour des infos en db
                $setter = 'set'.ucfirst($service);
                $setter_id = $setter.'Id';
                $setter_token = $setter.'AccessToken';
                
                //Set some wild random pass since its irrelevant, this is Google login
                global $kernel;
                $encoder = $kernel->getContainer()->get('security.password_encoder');
                $password = $encoder->encodePassword($userdb, md5(uniqid()));
                
//                $socialDatas = array(
//                    'socialID' => $socialID,
//                    'socialToken' => $response->getAccessToken(),
//                    'socialRealName' => $response->getRealName(),
//                    'socialEmail' => $socialEmail,
//                    'socialLastName' => $response->getLastName(),
//                    'socialFirstName' => $response->getFirstName(),
//                    'socialPicture' => $response->getProfilePicture(),
//                    'socialPassword' => $password
//                    );
//                $session =  $kernel->getContainer()->get('r9.session_manager');
//                $session->setData('socialDatas', $socialDatas);
                
                $userdb->$setter_id($socialID);
                $userdb->$setter_token($response->getAccessToken());
                if ('google' == $service) {
                    $userdb->setUsername($response->getRealName());
                    $userdb->setEmail($socialEmail);
                    $userdb->setNom($response->getLastName());
                    $userdb->setPrenom($response->getFirstName());
                    
                    $image = new Image();
                    $image->setAvatar($response->getProfilePicture());
                    $userdb->setImage($image);
                    
                }
                $userdb->setPassword($password);
                $this->userManager->updateUser($userdb);
                
                $user = $userdb;
            }
        }
        
        if (null === $user || null === $socialID) {
            throw new AccountNotLinkedException(sprintf("User '%s' not found.", $socialID));
        }
        return $user;
    }
}