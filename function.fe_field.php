<?php
/**
 * Smarty {fe_field} function plugin
 *
 * Type:     function<br>
 * Name:     fe_field<br>
 * Date:     November 11, 2008
 * Purpose:  generates a form field representing a corresponding column in a table.<br>
 * Input:<br>
 *         - table = the table the field is from (required)
 *         - field = the column, or field name, to use (required)
 *
 * Examples:
 * <pre>
 * {fe_field table="users" field="name"}
 * </pre>
 * @version  1.0
 * @author   Drew Maughan <coder at drewmaughan dot com>
 * @param    array
 * @param    Smarty
 * @return   string
 */

function smarty_function_fe_field($params, $template)
{

	if (!isset($params['table']))
	{
		trigger_error("fe_field: missing 'table' parameter.");
		return;
	}

	if (!isset($params['field']))
	{
		trigger_error("fe_field: missing 'field' parameter.");
		return;
	}

	// fe_field tags must be inside a single fe_form tag.
	foreach ($template->_tag_stack as $tag)
	{
		if ($tag[0] == 'fe_form')
		{
			$form = $tag[1];
			break;
		}
	}
	if (!isset($form))
	{
		trigger_error("fe_field: field must appear inside an fe_form tag.");
	}

	// Make sure there's a relevant instance of a record for the specified table name.
	$instance = null;
	if ( isset( $form['instance'][ $params['table'] ] ) )
	{
		$instance_name = 'instance.' . $params['table'];

		// If we're setting an instance from an array, useful when using a single template for multiple tables.
		$instance = $form['instance'][ $params['table'] ];
	}
	else
	{
		$instance_name = $params['table'] . '_instance';

		if (isset($form[$instance_name]))
		{
			$instance = $form[ $instance_name ];
		}
		else
		{
			$instance = new $params['table'];
		}
	}

	// Is the instance a record or collection?
	if ( !($instance instanceof Doctrine_Record || $instance instanceof Doctrine_Collection) )
	{
		dbg( get_class($instance) );
		trigger_error('fe_field: ' . $instance_name . ' is not a valid record.');
		return;
	}

	$validation = Session::instance()->get('foley_validation');

	// Set the necessary parameters and render the field.
	$parameters = array_merge(
		$params, array(
			'table'       => $params['table'],
			'field'       => $params['field'],
			'type'        => isset($params['type']) ? $params['type'] : null,
			'error'       => !is_null($validation[$params['field']]),
			'attributes'  => isset($params['attributes']) ? $params['attributes'] : null,
			'auto_submit' => isset($params['auto_submit']) ? $params['auto_submit'] : false,
			'multiple'    => isset($params['multiple']) ? $params['multiple'] : false,
			'select_from' => isset($params['select_from']) ? $params['select_from'] : null,
			'default'     => isset($params['default']) ? $params['default'] : null,
		)
	);

	return FieldRenderer::render($parameters, $instance);
}
