<?php

namespace Civi\IapAuth;

class Authenticator {
  private JwtValidator $jwtValidator;
  private array $permittedTokenIssuers;
  public function __construct(JwtValidator $jwtValidator, array $permittedTokenIssuers = NULL) {
    $this->jwtValidator = $jwtValidator;
    $this->permittedTokenIssuers = $permittedTokenIssuers ?? \Civi::settings()->get('iap_token_issuers');
  }

  public function authenticate(): bool {
    try {
      $identityClaim = $this->jwtValidator->validateJwt();
    } catch (\Exception $e) {
      \Civi::log()->warning("IAP: Failed to validate JWT: {$e->getMessage()}");
    }

  }
}