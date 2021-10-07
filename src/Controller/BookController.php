<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ChatEntity;
use App\Repository\ChatEntityRepository;
use Symfony\Component\HttpFoundation\Request;


class BookController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManagerInterface;

    /** @var ChatEntityRepository */
    private $chatEntityRepository;

    public function __construct( BookRepository $bookRepository,EntityManagerInterface $entityManagerInterface,ChatEntityRepository $chatEntityRepository) {
       $this->bookRepository=$bookRepository;
       $this->entityManager=$entityManagerInterface;
       $this->chatEntity =$chatEntityRepository;
    }

    /**
     * @Route("/", name="book")
     */
    public function index(): Response
    {    
        $arr=$this->bookRepository->findAll();
        $msgArr= $this->chatEntity->findAll();
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'bookdata' =>$arr,
            'msgArr'=>$msgArr
        ]);
    }
    /**
     * @Route("/user", name="userTab")
     * 
     * @param Request $request
     */
    public function checkUser(Request $request)
    {   
        $data=json_decode($request->getContent(),true); 
        if($data['msg']!="check"){
            $chatUser= new  ChatEntity();
            $chatUser->setMessage($data['msg']);
            $chatUser->setUserId($data['sessionUser']);
            $chatUser->setReciever($data['secondUser']);
            $chatUser->setStatus("new");
            $this->entityManager->persist($chatUser);
            $this->entityManager->flush();
        }
         $arrData=$this->chatEntity->findOneBy(['userId'=>$data['secondUser'],'reciever'=>$data['sessionUser'],'status'=>"new"]);
         if($arrData != null){
            $arrData->setStatus("old");
            $this->entityManager->flush();
            $dataArr=[];
            $retData=[
                     "id"=> "nbeBWdaxxx",
                     "completenessScore"=> 70,
                     "legalForm"=> "GmbH",
                     "lastUpdateDate"=> "2021-02-16T01:23:44Z",
                     "companyName"=> "DocGmbH",
                     "street"=> "Ursulaplatz 1",
                     "streetName"=> "Ursulaplatz",
                     "streetNumber"=> "1",
                     "zip"=> "50668",
                     "location"=> "Köln",
                     "country"=> "Deutschland",
                     "url"=> "http://example.one",
                     "email"=> $arrData->getUserId(),
                     "recieverUser"=>$arrData->getReciever(),
                     'msg'=>$arrData->getMessage(),
                     "phone"=> "+49 2216",
                     "fax"=> "+49 22166",
                     "registerStatus"=> "active",
                     "registerId"=> "HRB88659",
                     "registerLocation"=> "Köln",
                     "nameAlternatives"=> [  "m. Doc GmbH" ],
                      "vatId"=> "DE308xxxx0",
                      "EBID"=> null,
                     "industryCodes"=> [  "62019" ],
                     "foundedYear"=> 2016,
                     "employeeSize"=> "11-100" 
            ];
            $mmArr=[
                "customId"=> "40016",
                "userId"=> "email@example.com"
            ];
            $dataArr['data']=$retData;
            $dataArr['metadata']=$mmArr;
           $retData=json_encode($dataArr);
           return new JsonResponse($retData,200);
         }
         return new JsonResponse("null",200);
    }

    
}


