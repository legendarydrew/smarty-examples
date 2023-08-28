<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {foley_custom} function plugin
 *
 * Type:     function<br>
 * Name:     foley_custom<br>
 * Date:     November 24, 2008
 * Purpose:  generates a form field representing an item's custom field value.<br>
 * Input:<br>
 *         - item = the item instance (required)
 *         - key = the custom field to edit (required)
 *
 * Examples:
 * <pre>
 * {foley_field table="users" field="name"}
 * </pre>
 * @version  1.0
 * @author   Drew Maughan <coder at drewmaughan dot com>
 * @param    array
 * @param    Smarty
 * @return   string
 */

function smarty_function_foley_custom($params, &$smarty)
{

  if (!isset($params['item']))
  {
    $smarty->trigger_error("foley_field: missing 'item' parameter");
    return;
  }
  elseif ($params['item'] instanceof FoleyItem == false)
  {
    $smarty->trigger_error("foley_field: 'item' must be a FoleyItem");
    return;
  }
  
  if (!isset($params['field']))
  {
    $smarty->trigger_error("foley_field: missing 'field' parameter");
    return;
  }
  elseif ($params['field'] instanceof FoleyCustomField == false)
  {
    $smarty->trigger_error("foley_field: 'field' must be a FoleyCustomField, " . get_class($params['field']) . " was given");
    return;
  }

  // Now the fun bit; deciding what to output.
  $item = $params['item'];
  $cf   = $params['field'];

  // Set the parameters for the field.
  $parameters = array();
  $parameters['field_name'] = "custom[{$cf->id}]";
  //$parameters['field_name'] = "custom[{$cf->field_key}]";
  $parameters['default_value'] = $cf->default_value;
  $parameters['attributes'] = isset($params['attributes']) ? $params['attributes'] : null;

  // Here's the tricky part; we use for the value, in order:
  // - the POST value
  // - the currently saved value
  // - the default value for the custom field.
  if (isset($_POST['custom'][$cf->id]))
  {
    $value = $_POST['custom'][$cf->id];
  }
  elseif ($item->exists())
  {
    $value = $item->getCustomField($cf);
  }
  else
  {
    $value = $cf->default_value;
  }
  
  $output = '';
  switch ($cf->type)
  {
    case FoleyCustomFieldTable::FIELD_TEXT_SINGLE :
      $output = FieldRenderer::drawTextField($parameters, $value);
      break;
    case FoleyCustomFieldTable::FIELD_TEXT_MULTI :
      $output = FieldRenderer::drawMultilineField($parameters, $value);
      break;
    case FoleyCustomFieldTable::FIELD_CHECKBOX :
      $output  = self::drawHiddenField($parameters, null);
      $output .= FieldRenderer::drawCheckboxField($parameters, $value);
      break;
    case FoleyCustomFieldTable::FIELD_CHECK_GROUP :
      // TODO: use a separate parameter for ID
      $parameters['field_name'] .= '[]';
      $parameters['label']       = true;
      $values                    = explode("\n", $value);
      foreach ($cf->getLookupValues() as $lookup_value)
      {
        $checked = (in_array($lookup_value, $values)) ? $lookup_value : null;
        $output .= FieldRenderer::drawCheckboxField($parameters, $checked, $lookup_value);
      }
      break;
    case FoleyCustomFieldTable::FIELD_RADIO_GROUP :
      foreach ($cf->getLookupValues() as $lookup_value)
      {
        $checked = (bool)($value == $lookup_value);
        $output .= FieldRenderer::drawRadioField($parameters, $checked, $lookup_value);
      }
      break;
    case FoleyCustomFieldTable::FIELD_DROPDOWN :
      $parameters['select_from'] = $cf->getLookupValues();
      $output = FieldRenderer::drawDropdownField($parameters, $value);
      break;
  }
  
  return $output;
}
