<?php

declare(strict_types=1);

namespace Drupal\bfi_mini_orange\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class LoginRedirectSubscriber.
 */
class LoginRedirectSubscriber implements EventSubscriberInterface {
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
    if ($this->routeMatch->getRouteName() === 'user.login') {
      $config = $this->configFactory->get('bfi_mini_orange.settings');
      $enableRedirect = $config->get('enable_redirect_user_login') ?? FALSE;

      if ($enableRedirect) {
        $response = new TrustedRedirectResponse(
          Url::fromRoute('miniorange_oauth_client.moLogin')->toString()
        );

        $response->send();
      }
    }
  }
}
