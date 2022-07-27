<?php

namespace Drupal\Booked_Events\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class BookedEventsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'booked_events_form';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('booked_events.settings');
    
    $groupid = $config->get('booked_events.group');
    $group = array();
    foreach($groupid as $key=>$value) {
      $group[] = \Drupal\group\Entity\Group::load($value["target_id"]);
    }
    // group field.
    $form['group'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Group:'),
      '#description' => $this->t('Set the group that booked events will be assigned to.'),
      '#target_type' => 'group',
      '#tags' => TRUE,
      '#default_value' => $group,
    ];

    return $form;
  }
  
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('booked_events.settings');
    $config->set('booked_events.group', $form_state->getValue('group'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }
  
  protected function getEditableConfigNames() {
    return [
      'booked_events.settings',
    ];
  }
}
