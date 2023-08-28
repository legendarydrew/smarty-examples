<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {fe_tree} function plugin
 *
 * Type:     function<br>
 * Name:     fe_tree<br>
 * Date:     October 21, 2008
 * Purpose:  generates an unordered list representing a tree.<br>
 * Input:<br>
 *         - tree = the nested array to use
 *
 * Examples:
 * <pre>
 * {fe_tree tree=$category_tree}
 * </pre>
 * @version  1.0
 * @author   Drew Maughan <coder at drewmaughan dot com>
 * @param    array
 * @param    Smarty
 * @return   string
 * @todo      find a way of adding the form contents using [standard] DOMDocument functions
 */

function smarty_block_fe_form($params, $content, $template, &$repeat)
{

	static $form_tags;

	// First check if this fe_form tag is nested in another, which shouldn't happen.
	if ($form_tags > 1)
	{
		trigger_error('fe_form: fe_form tags cannot be nested!');
		return;
	}

	// If we've just opened the tag we increment form_tags, otherwise we create a form and process the
	// contents. form_tags will tell us if we've encountered a previous [unclosed] fe_form tag.
	if ($repeat)
	{
		$form_tags++;
	}
	else
	{
		$method = isset($params['method']) ? $params['method'] : 'post';
		$module = isset($params['module']) ? $params['module'] : null;
		$page   = isset($params['page']) ? $params['page'] : null;
		$action = FE::firstDefined($params['action'], FE::getCurrentAction());
		$upload = (boolean)(isset($params['upload']) && $params['upload'] == true);

		if ($action == 'index') $action = '';

		unset($params['method'], $params['module'], $params['page'], $params['action'], $params['upload']);

		// Create the FORM tag with the method and action (and optional upload) attributes.
		$dom = new DOMDocument();

		$form = $dom->createElement('form');
		$form->setAttribute('method', $method);
		$form->setAttribute('action', FE::getUrl($module, $page, $action));
		if ($upload)
		{
			$form->setAttribute('enctype', 'multipart/form-data');
		}

		// Add any remaining parameters as FORM tag attributes.
		foreach ($params as $attr => $value)
		{
			if (is_scalar($value)) $form->setAttribute($attr, $value); // instance may be an array.
		}
		// Add placeholders for the form contents and the token field.
		$form->appendChild($dom->createTextNode('{form_contents}'));

		// Return the form and 'close' the fe_form tag.
		$dom->appendChild($form);

		$output       = $dom->saveHTML();
		$form_tags--;

		// Add the form contents to the form.
		$output       = str_replace('{form_contents}', "\n".$content, $output);

		return $output;
	}
}