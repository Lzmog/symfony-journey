<?php

declare(strict_types=1);

namespace AppBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class UserAgentSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return array|void
     */
    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest'
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (false === $event->isMasterRequest()) {
            return;
        }

        $this->logger->info('Hello world');
        $request = $event->getRequest();

        $userAgent = $request->headers->get('User-Agent');
        $this->logger->info('The user agent is:' . $userAgent);

        $isLinux = stripos($userAgent, 'linux') !== false;

        // QUERY `?isLinux=1`
        if ($request->query->get('notLinux')) {
            $isLinux = false;
        }

        $request->attributes->set('isLinux', $isLinux);

//        $response = new Response('Come back later!');
//        $event->setResponse($response);

//        $request->attributes->set('_controller', function ($id) {
//           return new Response('Welcome ' . $id);
//        });
    }
}
