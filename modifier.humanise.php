<?php
/**
 * Smarty humanise modifier plugin
 * Turns an underscored term into a sentence with spaces.
 *
 * @package     Foley-Engine
 * @subpackage  Smarty
 *
 * @author      Drew Maughan
 * @param       string
 * @return      string
 */
function smarty_modifier_humanise($string, $lowercase = false)
{
  $string = Inflector::humanize($string);
  return $lowercase? strtolower($string) : ucfirst($string);
}
