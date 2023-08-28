<?php
/**
 * Smarty ascii modifier plugin
 * Converts non-ascii characters in a string to their ASCII equivalents.
 * Was originally used to overcome the potential inclusion of accented characters in a manually-
 * created URL.
 *
 * @package     Foley-Engine
 * @subpackage  Smarty
 *
 * @author      Drew Maughan
 * @param       string
 * @return      string
 */
function smarty_modifier_ascii($string)
{
  return UTF8::transliterate_to_ascii($string);
}
