<?php
/**
 * Smarty {fe_field_error} function plugin
 *
 * Type:     function<br>
 * Name:     fe_field_error<br>
 * Date:     November 27, 2008
 * Purpose:  generates an unordered list representing a tree.<br>
 * Input:<br>
 *         - tree = the nested array to use
 *
 * Examples:
 * <pre>
 * {foley_tree tree=$category_tree}
 * </pre>
 * @package Foley Engine
 * @subpackage Smarty
 * @version  1.0
 * @author   Drew Maughan <coder at drewmaughan dot com>
 * @param    array
 * @param    Smarty
 * @return   string
 */

function smarty_block_fe_field_error($params, $content, $template, &$repeat)
{
	static $old_message;    // any previous value of the Smarty variable "message"
	static $this_message;   // any validation message we want to display
	static $nesting;        // used to detect the nested level of the tag.

	// Make sure this tag is not inside another fe_field_error tag.
	if ($repeat)
	{
		if ($nesting > 0)
		{
			$smarty->trigger_error('fe_field_error: tag should not be nested.');
			return;
		}
		else
		{
			$nesting++;
		}
	}

	// Check for the presence of the required parameters: table and field.
	if (!isset($params['table']))
	{
		trigger_error('fe_field_error: missing \'table\' parameter.');
		return;
	}
	if (!isset($params['field']))
	{
		trigger_error('fe_field_error: missing \'field\' parameter.');
		return;
	}

	if ($repeat)
	{
		// When $repeat = true, we can assign stuff to the contents of the block - useful if you want to
		// place Smarty-like tags inside of a block. (Note that this was previously undocumented, or
		// just very well hidden/obfuscated).
		// If there is a validation message for this field, it should be placed where {$message} appears
		// between the fe_field_error tags. We can do this by temporarily unassigning $message from
		// Smarty.

		$table_name   = $params['table'];
		$field_name   = $params['field'];

		// Grab the validation messages from the session.
		$validation   = Session::instance()->get('foley_validation');

		// Store the old value of the "message" Smarty variable (if it exists) temporarily.
		//$old_message  = $smarty->get_template_vars('message');
		$this_message = '';

		// Get the relevant validation message, if it exists.
		if ($validation_list = $validation[$table_name])
		{
			if (array_key_exists($field_name, $validation_list))
			{
				$this_message = implode("\n", $validation_list[$field_name]);
			}
		}

		// Add the message to the contents of the fe_field_error tag, wrapped in a SPAN tag with the
		// error class.
		$span_html = '<span class="error">'.nl2br($this_message).'</span>';
		$template->assign('message', $span_html);
	}
	else
	{
		// When $repeat = false, we render the contents of the block tag to the template.

		// First decrease the nesting level, as we're closing the tag.
		$nesting--;

		// Reset the original Smarty "message" variable.
		if (!is_null($old_message))
		{
			$template->assign('message', $old_message);
		}

		// Return the contents of the tag.
		if ($this_message)
		{
			return $content;
		}
	}
}
