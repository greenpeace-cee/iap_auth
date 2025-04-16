<?php

require_once 'iap_auth.civix.php';
$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
  require_once $autoload;
}

use CRM_IapAuth_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function iap_auth_civicrm_config(&$config): void {
  _iap_auth_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function iap_auth_civicrm_install(): void {
  _iap_auth_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function iap_auth_civicrm_enable(): void {
  _iap_auth_civix_civicrm_enable();
}

function iap_auth_civicrm_permission(array &$permissions): void {
  $permissions['authenticate with iap'] = [
    'label' => E::ts('IAP: Authenticate with Identity-Aware Proxy'),
    'description' => E::ts('Authenticate to CiviCRM using the identity provided by Google Cloud Identity-Aware Proxy'),
  ];
  $permissions['bypass iap'] = [
    'label' => E::ts('IAP: Bypass Identity-Aware Proxy Login'),
    'description' => E::ts('Bypass Identity-Aware Proxy to login via CiviCRM (using username and password)'),
  ];
}

function iap_auth_civicrm_container(\Symfony\Component\DependencyInjection\ContainerBuilder $container) {
  $container->register('iap_auth', '\Civi\IapAuth\CheckCredentials')
    ->addTag('kernel.event_subscriber')
    ->setPublic(TRUE);
}