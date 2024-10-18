<?php

declare(strict_types=1);

namespace Drupal\bfi_mini_orange\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure settings for this site.
 */
final class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'bfi_mini_orange_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['bfi_mini_orange.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['enable_redirect_user_login'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable user login redirect'),
      '#default_value' => $this->config('bfi_mini_orange.settings')->get('enable_redirect_user_login'),
      '#description' => $this->t('Enables login to redirect to the IdP.'),
    ];

    $form['logout_url'] = [
      '#type' => 'url',
      '#title' => $this->t('Logout URL'),
      '#default_value' => $this->config('bfi_mini_orange.settings')->get('logout_url'),
      '#description' => $this->t('URL to logout from the IdP.'),
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => $this->t('E.g. https://login.microsoftonline.com/[tenant_id]/oauth2/logout'),
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('bfi_mini_orange.settings')
      ->set('enable_redirect_user_login', $form_state->getValue('enable_redirect_user_login'))
      ->set('logout_url', $form_state->getValue('logout_url'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
