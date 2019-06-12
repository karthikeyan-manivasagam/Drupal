<?php
//How to alter single taxonomy term overview page 

//Add extra column in taxonomy term overview page

use \Drupal\Core\Url;
use \Drupal\Core\Form\FormStateInterface;


function modulename_form_taxonomy_overview_terms_alter(&$form, FormStateInterface $form_state, $form_id) {

  $path = \Drupal::request()->getpathInfo();
  $arg  = explode('/',$path);
  //manage/vocabulary_name/overview
 if( $arg[5] == "vocabulary_name") {
  if (isset($form['terms']['#header'])) {
    array_splice($form['terms']['#header'], 1, 0, [t('Extra Column')]);
  }

  $position = FALSE;

  foreach (\Drupal\Core\Render\Element::children($form['terms']) as $key) {
    /** @var \Drupal\taxonomy\Entity\Term $term */
    $term = $form['terms'][$key]['#term'];

    // Look for term position to place extra column just after term name.
    if ($position === FALSE) {
      $position = array_search('term', array_keys($form['terms'][$key]));

      if ($position === FALSE) {
        $position = 0;
      }
    }
       $column = [
          '#type' => 'link',
          '#title' => $term->getName() . "custom link". ,
        ];

      $column['#url'] =   Url::fromUserInput('/somecustomview/'.$_tids);

      // Enable to  open page in Modal
      /*$column['#attributes'] = [
        'class' => ['use-ajax', 'button', 'button--small'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode(['width' => 800, "title" => $term->getName()]),
      ];*/
       
    array_splice($form['terms'][$key], $position + 1, 0, ['extra_column' => $column]);
 }
} 
