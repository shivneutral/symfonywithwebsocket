<?php
namespace App\Controller;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Psr\Container\ContainerInterface;

class Chat extends AbstractController implements MessageComponentInterface {
    protected $clients;

    
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ChatEntityRepository */
    private $chatEntityRepository;

    private $paths;

    public function __construct() {
        $this->clients = [];
        $this->paths = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients[$conn->resourceId] = $conn;
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
            //push data in array   
            $tempArr=$this->paths;
            $reqArr=json_decode($msg,true);
            $tempArr[$from->resourceId]=$reqArr['sessionUser'];
            $this->paths=$tempArr;

            // search in array
            $tempSearch= array_search($reqArr['secondUser'],$this->paths);
            if($tempSearch){
                $val=$tempSearch;
            }else{
                $val=$from->resourceId;
            }

            // curl code 
            $request = "http://localhost:8000/user";
            $header_array = array(
                'Content-Type:application/json',
                'Accept:application/json');
                
     // initiate curl
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $request);
     curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS,$msg);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     $response = curl_exec($ch);
     curl_close($ch);
     $retData=json_decode($response);

     $client = $this->clients[$val];
     $from->send($msg);
       
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        unset($this->clients[$conn->resourceId]);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}