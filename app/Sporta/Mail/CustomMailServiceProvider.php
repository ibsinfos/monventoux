<?php namespace App\Sporta\Mail;

use App\Sporta\Mail\CustomTransportManager;
use Illuminate\Mail\MailServiceProvider;

class CustomMailServiceProvider extends MailServiceProvider {

    /**
     * Register the Swift Transport instance.
     *
     * @return void
     */
    protected function registerSwiftTransport()
    {
        $this->app['swift.transport'] = $this->app->share(function($app)
        {
            return new CustomTransportManager($app);
        });
    }

}
