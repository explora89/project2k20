<?php

namespace AppBundle\Controller;

/*  import this  librairies   */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Application;
use AppBundle\Entity\User;
use AppBundle\Entity\JobOffer;

use AppBundle\Service\FileUploadService;

/**
 * @Route("/applications", name="applications_")
 */
class ApplicationController extends Controller
{
     /**
     * @Route("/getApplicattiondByApplicant/{applicant_id}", name="list_application_by_applicant", methods={"GET"})
     */

    // every  controller has his own  route  w prefixe teo
    public function getApplicattiondByApplicantAction(Request $httpRequest, $applicant_id){
        $dataArray = array();

        // appel doctrine
        $entityManager = $this->getDoctrine()->getManager();

        // get user by id 
        $user = $entityManager->getRepository(User::class)->findOneById( $applicant_id );

        // test if user is already exist and number of application > 0
        if( $user != null && sizeof( $user->getApplications() ) > 0 ){
            foreach ($user->getApplications() as $application) {
                $dataArray[] = array(
                    'jobTitle' => $application->getJobOffer()->getTitle(),
                    'date' => $application->getDateApplication()
                );
            }
        }

        return new JsonResponse( $dataArray );
    }

    /**
     * @Route("/getApplicattiondByJobOffer/{jobOffer_id}", name="getApplicattiondByJobOffer", methods={"GET"})
     */

    //  every  controller has his own  route  w prefixe teo
    public function getApplicattiondByJobOffer(Request $httpRequest, $jobOffer_id){
        $dataArray = array();

        // appel doctrine
        $entityManager = $this->getDoctrine()->getManager();

        // get jobOffer by id 
        $jobOffer = $entityManager->getRepository(JobOffer::class)->findOneById( $jobOffer_id );
        
        // test if user is already exist deja and nuber of  application > 0
        if( $jobOffer != null && sizeof( $jobOffer->getApplications() ) > 0 ){
            foreach ($jobOffer->getApplications() as $application) {
                $dataArray[] = array(
                    'applicant' => $application->getUser()->getName(),
                    'date' => $application->getDateApplication()
                );
            }
        }

        return new JsonResponse( $dataArray );
    }

       /**
     * @Route("/updateApplicationsStatus/{application_id}", name="updateApplicationsStatus", methods={"GET"})
     */
    //  every controller has his own route  w prefixe teo
    public function updateApplicationsStatus(Request $httpRequest, $application_id){
        $dataArray = array();

        // appel doctrine
        $entityManager = $this->getDoctrine()->getManager();

        // get application by id 
        $application = $entityManager->getRepository(Application::class)->findOneById( $application_id );
        
        // test if application  is already exist
        if( $application != null ){
            $application->setStatus(1);
            $entityManager->flush();
        }

        return new JsonResponse( array('state' => 1) );
    }



     /**
     * @Route("/createNewApplication", name="createNewApplication", methods={"POST"})
     */
    //  chaque conttollr ando route mteo w prefixe teo
    public function createNewApplicationAction(Request $httpRequest, FileUploadService $fileUploadService){
        $dataArray = array(
            'state' => 0 
        );

          //avoid crush of the application
        try {
            // appel doctrine
            $entityManager = $this->getDoctrine()->getManager();

            $data = json_decode($httpRequest->getContent(), true) ;

            $application = new Application();

            // tester si le suser existe et le joboffer existe aussi pour eviter les erreurs 404
            if( 
                $entityManager->getRepository(User::class)->findOneById( $data['user_id'] ) != null &&
                $entityManager->getRepository(JobOffer::class)->findOneById( $data['jobOffer_id'] ) != null
            ){
                $application->setUser( $entityManager->getRepository(User::class)->findOneById( $data['user_id'] ) );
                $application->setJobOffer( $entityManager->getRepository(JobOffer::class)->findOneById( $data['jobOffer_id'] )  );
                $application->setStatus(0); //mazelit il candidateur pas encore accepté
                
                $application->setDateApplication( new \DateTime("now") );

                if( $httpRequest->files->get('file') != null ){
                    $fileName = $fileUploadService->upload( $httpRequest->files-get('file') );
                    $application->setCvFile( $fileName );
                }
    
                $entityManager->persist( $application );
                $entityManager->flush();
         
                $dataArray["state"] =  1;
            }
           
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }


        return new JsonResponse( $dataArray );
    }


    
}
