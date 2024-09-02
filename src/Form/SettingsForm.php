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
      '#description' => $this->t('Enables the redirect from the user login path to SSO.'),
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
      ->save();
    parent::submitForm($form, $form_state);
  }

}
