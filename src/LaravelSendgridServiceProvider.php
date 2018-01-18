<?php

namespace TimFeid\LaravelSendgrid;

use Illuminate\Support\Arr;
use TimFeid\LaravelSendgrid\Mailer;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Mail\TransportManager;
use Illuminate\Mail\MailServiceProvider as BaseMailServiceProvider;

class LaravelSendgridServiceProvider extends BaseMailServiceProvider
{
    public function register()
    {
        $this->app->afterResolving(TransportManager::class, function(TransportManager $manager) {
            $this->extendTransportManager($manager);
        });

        parent::register();
    }

    public function extendTransportManager(TransportManager $manager)
    {
        $manager->extend('sendgrid', function() {
            $config = $this->app['config']->get('services.sendgrid', array());
            $client = new HttpClient(Arr::get($config, 'guzzle', []));

            return new SendgridTransport($client, $config['api_key']);
        });
    }

    protected function registerIlluminateMailer()
    {
        $this->app->singleton('mailer', function ($app) {
            $config = $app->make('config')->get('mail');
            // Once we have create the mailer instance, we will set a container instance
            // on the mailer. This allows us to resolve mailer classes via containers
            // for maximum testability on said classes instead of passing Closures.
            $mailer = new Mailer(
                $app['view'], $app['swift.mailer'], $app['events']
            );
            if ($app->bound('queue')) {
                $mailer->setQueue($app['queue']);
            }
            // Next we will set all of the global addresses on this mailer, which allows
            // for easy unification of all "from" addresses as well as easy debugging
            // of sent messages since they get be sent into a single email address.
            foreach (['from', 'reply_to', 'to'] as $type) {
                $this->setGlobalAddress($mailer, $config, $type);
            }
            return $mailer;
        });
    }
}
