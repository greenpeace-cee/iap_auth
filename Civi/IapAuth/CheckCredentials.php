<?php

namespace Civi\IapAuth;

class CheckCredentials implements \Symfony\Component\EventDispatcher\EventSubscriberInterface {
  const PRIORITY_IAP_AUTH = 200;

  public static function getSubscribedEvents(): array {
    $events = [];
    $events['civi.authx.checkCredential'][] = ['iapJwt', self::PRIORITY_IAP_AUTH];
    return $events;
  }

  public function bearerSpecialJwt(Civi\Authx\CheckCredentialEvent $checkEvent): void {
    return;
    if ($checkEvent->credFormat === 'Bearer') {
      try {
        $claims = \Civi::service('crypto.jwt')->decode($checkEvent->credValue);

        // Perhaps we require the scope claim to contain something specific
        $scopes = isset($claims['scope']) ? explode(' ', $claims['scope']) : [];
        if (!in_array('somespecialthing', $scopes)) {
          // Not our responsibility. Proceed to check any other token sources.
          return;
        }

        // Maybe a table links external ids to user ids, or they are encoded in the sub somehow
        $userId = someFunctionToGetCmsUserId($claims['sub']);

        if ($userId) {
          $checkEvent->accept(['userId' => $userId, 'credType' => 'jwt', 'jwt' => $claims]);
          return;
        } else {
          // Alternatively, could return, so other token sources can be checked
          $checkEvent->reject('User not found');
        }
      } catch (Civi\Crypto\Exception\CryptoException $e) {
        // Not a valid JWT. Proceed to check any other token sources.
      }
    }
  }
}