<?php namespace App\Sporta\Mail\Transport;

use Illuminate\Mail\Transport\MailgunTransport;

class CustomMailgunTransport extends MailgunTransport
{

    public function __construct($key, $domain)
    {
        parent::__construct($key, $domain);
    }

    public function setDomain($domain)
    {
        $this->url = 'https://api.mailgun.net/v3/' . $domain . '/messages.mime';

        return $this->domain = $domain;
    }

}
