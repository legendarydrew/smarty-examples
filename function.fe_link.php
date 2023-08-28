<?php
/**
 * Smarty {fe_link} function plugin
 * Generates a link to controller pages.
 *
 *         - page = the name of the controller to use
 *         - path = (optional) the "module" (or folder) where this controller resides
 *         - action = (optional) any actions to pass to the page (e.g. editing an item)
 *
 * Examples:
 * <pre>
 * {fe_link page="item" module="admin" action="edit"}
 * {fe_link page="statistics" module="admin" action="media"}
 * {fe_link page="index"}
 * {fe_link page="index" module="admin"}
 * </pre>
 * @version  1.0
 * @author   Drew Maughan <coder at drewmaughan dot com>
 * @param    array
 * @param    Smarty
 * @return   string
 */
function smarty_function_fe_link($params, $template)
{
	$module = isset($params['module']) ? $params['module'] : null;
	$page   = isset($params['page'])   ? $params['page']   : null;
	$action = isset($params['action']) ? $params['action'] : null;

	return FE::getUrl($module, $page, $action);
}
