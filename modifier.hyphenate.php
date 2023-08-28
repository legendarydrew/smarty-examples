<?php
/**
 * Smarty hyphenate modifier plugin
 * Replaces whitespace with hyphens.
 *
 * @package     Foley-Engine
 * @subpackage  Smarty
 *
 * @author      Drew Maughan
 * @param       string  the string to hyphenate.
 * @return      string  the hyphenated string.
 */
function smarty_modifier_hyphenate($string)
{
  return str_replace(' ', '-', $string);
}
