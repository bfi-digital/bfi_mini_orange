<?php

declare(strict_types=1);

namespace Drupal\bfi_mini_orange\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class LogoutSubscriber.
 */
class LogoutSubscriber implements EventSubscriberInterface {
  public function __construct(
    protected RouteMatchInterface $routeMatch,
    protected ConfigFactoryInterface $configFactory
  ) {}

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents(): array {
    // This is set at 30 so that it runs before page caching priority, 27.
    $events[KernelEvents::REQUEST][] = ['onRequest', 30];

    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is dispatched.
   *
   * @param RequestEvent $event
   */
  public function onRequest(RequestEvent $event): void {
    $routeName = $this->routeMatch->getRouteName();

    if (in_array($routeName, ['user.logout', 'user.logout.confirm'])) {
      $config = $this->configFactory->get('bfi_mini_orange.settings');
      $enableRedirect = $config->get('enable_redirect_user_login') ?? FALSE;
      $logoutUrl = $config->get('logout_url') ?? FALSE;

      if ($enableRedirect && $logoutUrl) {
        if ($routeName === 'user.logout.confirm') {
          // If the user visits /user/logout the user is presented with a form to confirm the logout.
          // In this scenario the user won't be presented with the form and so must initiate a Drupal logout.
          user_logout();
        }

        $response = new TrustedRedirectResponse(
          'https://login.microsoftonline.com/6c9453b6-484a-4aa2-ad7e-94a25d4692e5/oauth2/logout'
        );

        $response->send(); 
      }
    }
  }
}
