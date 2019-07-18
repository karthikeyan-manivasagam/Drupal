<?php

use \Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;


/**  
 * Implements hook_field_widget_WIDGET_TYPE_form_alter().  
 */  
function modulename_field_widget_entity_reference_paragraphs_form_alter(&$element, &$form_state, $context) {
  if ($element['#paragraph_type'] == 'country_select') {
    $form_state->setRebuild(FALSE);

 // Generating Unique id for each state by using parents & delta  
    $gen_id = 'edit-state-';
    foreach ($element['subform']['field_state']['widget']['#parents'] as $value) {
       $gen_id .= is_integer($value) ? "-". $value : "";
    }
    $gen_id .= "-".$element['subform']['field_state']['widget']["#delta"];
    $element['subform']['field_state']['widget']['#attributes']["id"] = $gen_id;

     // Add ajax 
     $element['subform']['field_country']['widget']['#ajax'] = [
          'callback' => 'update_state_dropdown',
          'event' => 'change',
          'method' => 'html',
          'wrapper' => $gen_id,
          'progress' => [
                'type' => 'throbber',
                 'message' => NULL,
                ],
          ];
      / Set default value options for state when the country_select  paragraph is loaded     
      $default_country = $element['subform']['field_country']['widget']['#default_value'];
      if(isset($default_country[0])) {
         $options = get_state_options_by_country($default_country[0]);
        $element['subform']['field_state']['widget']['#options'] = $options;
      }
  }
}
   

function update_state_dropdown(array &$element, FormStateInterface $form_state) {
    $triggeringElement = $form_state->getTriggeringElement();
    $value = $triggeringElement['#value'];
    $options = get_state_options_by_country($value);
    $wrapper_id = $triggeringElement["#ajax"]["wrapper"];
    $renderedField = '';
    foreach ($options as $key => $value) {
      $renderedField .= "<option value='".$key."'>".$value."</option>";
    }
    $response = new AjaxResponse();
    $response->addCommand(new HtmlCommand("#".$wrapper_id, $renderedField));
    return $response;
  }


function get_state_options_by_country($country) {
   /**
    * Add your logic here to get the states by using $country 
    * Add your logic here to get the depenedent dropdown option by using $country  parent 
    * dropdown selected value
    */

   /* $states = ["India" =>[ "Tamil Nadu","Kerala", "Andra Pradesh" , "Telungana", "Karnataka"]];
      $options = $states[$country]; 
	return $options; */
}
