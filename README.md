# Introduction

This repository contains a module for settings relating to the Drupal contributed module [Mini Orange OAuth & OpenID Connect Login](https://www.drupal.org/project/miniorange_oauth_client). The module currently provides a setting to redirect the Drupal */user/login* path to the SSO login.

## Module configuration
When the module is installed the default setting to redirect is disabled. The redirect can be enabled by going to the following settings path *admin/config/system/settings* or following the menu links *Configuration > System > BFI Mini Orange Settings*.

If local development is disabled, then to maintain the settings on staging and production environments, if enabled, to avoid importing the disabled configuration then there are two possible solutions.

1. The configuration can be added to the config ignore if the [Config Ignore](https://www.drupal.org/project/config_ignore) module is installed. The configuration to ignore is...
```
bfi_mini_orange.settings
```
2. The configuration can be set in the *settings.php* file (requires cache clearing). The configuration to set is...
```php
$config['bfi_mini_orange.settings']['enable_redirect_user_login'] = TRUE;
```

## Module installation with composer

## Mini Orange configuration



