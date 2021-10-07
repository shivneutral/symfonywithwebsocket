<?php

namespace App\Controller;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Controller\Chat;


class ChatCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'chat:status:check';

    protected function configure(): void
    { 
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('checking shiv command');

    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = IoServer::factory(
                  new HttpServer( new WsServer( new Chat() ) ),
                  8080
                 );
    
        $server->run();

    }
}
