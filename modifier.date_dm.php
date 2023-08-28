<?php
/**
 * Smarty date_dm modifier plugin
 * Converts a date to the Drew Maughan Date Format. The only reason we're using a Smarty modifier is that we want the
 * day value to be padded with zeros.
 *
 * @package     Foley-Engine
 * @subpackage  Smarty
 *
 * @author      Drew Maughan
 * @param       string
 * @return      string
 */
function smarty_modifier_date_dm($timestamp, $with_time = false)
{
  $d    = new DateTime($timestamp);
  $year = $d->format('Y');
  $days = $d->format('z');
  $date = $d->format('D d M');
  $time = $d->format('H:i:s');

  $dmdf = sprintf('%s.%03s %s', $year, $days, $date);
  if ($with_time)
  {
    $dmdf .= ' ' . $time;
  }
  return $dmdf;
}
