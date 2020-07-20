<?php

namespace AppBundle\Controller;

/*  import this  librairies   */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\User;

use AppBundle\Service\FileUploadService;

/**
 * @Route("/users", name="users_")
 */
class UserController extends Controller
{
    /**
     * @Route("/updateProfile/{user_id}", name="updateProfile", methods={"POST","GET"})
     */
    //  chaque conttollr ando route mteo w prefixe teo
    public function updateProfileAction(Request $httpRequest, $user_id){
        $dataArray = array(
            'state' => 0 
        );

          //avoid crush of the application
        try {
            // appel doctrine
            $entityManager = $this->getDoctrine()->getManager();

            $data = json_decode($httpRequest->getContent(), true) ;

            $user = $entityManager->getRepository(User::class)->findOneById( $user_id ) ;
            // tester si le suser existe et le joboffer existe aussi pour eviter les erreurs 404
            if( 
                $user != null
            ){
                
                $user->setEmail( $data["email"] );

                $user->setName( $data["name"] );
                $user->setPhone( $data["phone"] );
                $user->setAdress( $data["adress"] );
                $user->setMaritalDate( $data["maritalDate"] );
                $user->setNationality( $data["nationalit"] );
                $user->setLinkedin( $data["linkedin"] );
                $user->setSpeciality( $data["speciality"] );

                $entityManager->flush();
            }
           
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }


        return new JsonResponse( $dataArray );
    }
}
