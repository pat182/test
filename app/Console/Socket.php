<?php

namespace App\Console;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class Socket
{
    public static function BrodCast($data){
        // $client = new Client(new Version2X('http://192.168.1.6:3000'));
        $client = new Client(new Version2X('http://localhost:3000'));
        // dd($msg->payload());
        $client->initialize();
        $client->emit('broadcast', $data);
        $client->close();
    }
}
