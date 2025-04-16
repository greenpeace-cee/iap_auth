<?php

use CRM_IapAuth_ExtensionUtil as E;
use Google\Auth\AccessToken;

class CRM_IapAuth_Page_IapStatus extends CRM_Core_Page {

  public function run() {
    echo '<pre>';
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('IapStatus'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));
    $token = new AccessToken();
    $jwt = $token->verify($_SERVER['HTTP_X_GOOG_IAP_JWT_ASSERTION'], [
      'certsLocation' => AccessToken::IAP_CERT_URL
    ]);
    var_dump($jwt);

    if (!$jwt) {
      print('Failed to validate JWT: Invalid JWT');
      return;
    }

    // Validate token by checking issuer and audience fields.
    assert($jwt['iss'] == 'https://cloud.google.com/iap');
    assert($jwt['aud'] == Civi::settings()->get('iap_audience'));

    $jwt = $this->validate_jwt($_SERVER['HTTP_X_GOOG_IAP_JWT_ASSERTION'], Civi::settings()->get('iap_audience'))) {

    die();
    //parent::run();
  }

}
