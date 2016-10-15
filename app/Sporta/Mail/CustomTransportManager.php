<?php namespace App\Sporta\Mail;

use App\Sporta\Mail\Transport\CustomMailgunTransport;
use Illuminate\Mail\TransportManager;

class CustomTransportManager extends TransportManager
{
    protected function createMailgunDriver()
    {
        $config = $this->app['config']->get('services.mailgun', array());

        return new CustomMailgunTransport($config['secret'], $config['domain']);
    }
}
