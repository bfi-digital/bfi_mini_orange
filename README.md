# Introduction

This repository contains a module for settings relating to the Drupal contributed module [Mini Orange OAuth & OpenID Connect Login](https://www.drupal.org/project/miniorange_oauth_client). The module currently provides a setting to redirect the Drupal */user/login* path to the SSO login.

## Prerequisite

The environment this module will be deployed on needs SSH access. To do this, the users SSH key from the target environment must have their key added to the [Deploy keys](https://github.com/bfi-digital/bfi_mini_orange/settings/keys) for this repository.

## Installing with composer

To add the module to your Drupal project run the following commands from the root of the application. This will install in the contributed modules.

```shell
composer config repositories.bfi-mini-orange git git@github.com:bfi-digital/bfi_mini_orange.git
```
```shell
composer require bfi-digital/bfi_mini_orange:dev-main#^v1.0.3
```

## Module configuration
When the module is installed the default setting to redirect is disabled. The redirect can be enabled by going to the following settings path */admin/config/system/settings* or following the menu links *Configuration > System > BFI Mini Orange settings*.

If local development redirect is disabled, then to avoid importing the disabled configuration on staging and production environments if redirect is enabled, then there are two possible solutions.

1. The configuration can be added to the config ignore if the [Config Ignore](https://www.drupal.org/project/config_ignore) module is installed. The configuration to ignore is...
```
bfi_mini_orange.settings
```
2. The configuration can be set in the *settings.php* file (requires cache clearing). The configuration to set is...
```php
$config['bfi_mini_orange.settings']['enable_redirect_user_login'] = TRUE;
```

## Mini Orange configuration

The mini orange setup is based on these [instructions](https://plugins.miniorange.com/setup-guide-to-configure-azure-ad-with-drupal-oauth-client).

For each environment IT must be provided with the following:

* An application name (e.g. Core-CMS (staging environment), or, DAM (production environment))
* The callback url that ends with */mo_login* - e.g. https://example.com/mo_login)

IT will furnish you with:

* Tenant uuid (this should be the same for all clients/environments).
* Application/client uuid.
* Application secret value.
* Expiry date - make a note of this.



