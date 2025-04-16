<?php

use CRM_IapAuth_ExtensionUtil as E;

return [
  'iap_audience' => [
    'name'        => 'iap_audience',
    'type'        => 'String',
    'html_type'   => 'text',
    'default'     => NULL,
    'add'         => '1.0',
    'title'       => E::ts('IAP: Audience'),
    'description' => E::ts('Expected IAP audience ("aud" JWT field), typically "/projects/PROJECT_NUMBER/global/backendServices/SERVICE_ID"'),
    'is_domain'   => 1,
    'is_contact'  => 0,
  ],
  'iap_token_issuers' => [
    'name'        => 'iap_token_issuers',
    'type'        => 'Array',
    'html_type'   => 'text',
    'default'     => [],
    'add'         => '1.0',
    'title'       => E::ts('IAP: Accepted Token Issuers'),
    'description' => E::ts('Expected token issuer(s) for external identities using format "securetoken.google.com/PROJECT-ID/TENANT-ID"'),
    'is_domain'   => 1,
    'is_contact'  => 0,
  ],
];
