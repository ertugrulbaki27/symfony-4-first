<?php


namespace App\EventSubscriber;


use App\Controller\ApiController;
use App\Controller\TokenAuthenticatedController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    private $tokens;

    public function __construct()
    {
        // normally it comes from database
        $this->tokens = [
            'user1' => 'token1',
            'user2' => 'token2',
        ];


    }

    public function beforeController(ControllerEvent $event)
    {
        // , we can get the controller from the controller event, which is passed automatically into the subscriber.
        // middleware code
        // event subscribers trigger on every occurrence of that event,
        $controller = $event->getController();
        // Now, that will return an array of controllers
        if (is_array($controller) && $controller[0] instanceof TokenAuthenticatedController) {
            $token = $event->getRequest()->query->get('token');
            if (!in_array($token, $this->tokens)) {
                throw new AccessDeniedHttpException('this need a valid token'); // denied response
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
          //   the key is the name of the method that we're subscribing to.
          // the value name of the methods that we would like to run
            KernelEvents::CONTROLLER => 'beforeController',
        ];
    }
}