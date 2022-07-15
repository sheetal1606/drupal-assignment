<?php

namespace Drupal\custom_location_block\Form;
 
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
 
/**
 * Configure location settings for this site.
 */
class LocationConfigurationForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'location_settings';
  }
 
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom_location_block.settings',
    ];
  }
 
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_location_block.settings');
    $form['country'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
    );
 
    $form['city'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
    );

    $options = [ '' => 'Select', 'America/Chicago' => 'America/Chicago', 'America/New_York' => 'America/New_York', 'Asia/Tokyo' => 'Asia/Tokyo', 'Asia/Dubai' => 'Asia/Dubai', 'Asia/Kolkata' => 'Asia/Kolkata', 'Europe/Amsterdam' => 'Europe/Amsterdam', 'Europe/Oslo' => 'Europe/Oslo', 'Europe/London' => 'Europe/London' ];

    $form['timezone'] = array(
	  '#title' => t('Timezone'),
	  '#type' => 'select',
	  '#description' => 'Select the desired timezone.',
	  '#options' => $options,
	  '#default_value' => $config->get('timezone'),
	);

    return parent::buildForm($form, $form_state);
  }
 
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration and set values
    $this->configFactory->getEditable('custom_location_block.settings')
    	->set('country', $form_state->getValue('country'))
    	->set('city', $form_state->getValue('city'))
    	->set('timezone', $form_state->getValue('timezone'))
    	->save();
 
    parent::submitForm($form, $form_state);
  }
}