<?php

namespace Civi\IapAuth;

use Google\Auth\AccessToken;

class JwtValidator {
  private string $jwtAssertion;
  private string $expectedAudience;

  /**
   * @throws \Exception
   */
  public function __construct(string $jwtAssertion, string $expectedAudience = NULL) {
    if (empty($jwtAssertion)) {
      throw new \Exception('IAP JWT assertion must not be empty');
    }
    $this->jwtAssertion = $jwtAssertion;
    $this->expectedAudience = $expectedAudience ?? \Civi::settings()->get('iap_audience');
  }

  /**
   * @return array|bool the token payload, if successful, or false if not.
   * @throws \InvalidArgumentException If certs could not be retrieved from a local file.
   * @throws \InvalidArgumentException If received certs are in an invalid format.
   * @throws \InvalidArgumentException If the cert alg is not supported.
   * @throws \RuntimeException If certs could not be retrieved from a remote location.
   * @throws \UnexpectedValueException If the token issuer does not match.
   * @throws \UnexpectedValueException If the token audience does not match.
   */
  public function validateJwt(): array|bool {
    $token = new AccessToken();
    return $token->verify($_SERVER['HTTP_X_GOOG_IAP_JWT_ASSERTION'], [
      'certsLocation' => AccessToken::IAP_CERT_URL,
      'audience' => $this->expectedAudience,
      'issuer' => AccessToken::IAP_ISSUER,
      'throwException' => TRUE,
    ]);
  }
}