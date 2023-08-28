<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {foley_tree} function plugin
 *
 * Type:     function<br>
 * Name:     foley_tree<br>
 * Date:     October 21, 2008
 * Purpose:  generates an unordered list representing a tree.<br>
 * Input:<br>
 *         - tree = the nested array to use
 *
 * Examples:
 * <pre>
 * {foley_tree tree=$category_tree}
 * </pre>
 * @version  1.0
 * @author   Drew Maughan <coder at drewmaughan dot com>
 * @param    array
 * @param    Smarty
 * @return   string
 * @todo      find a way of adding the form contents using [standard] DOMDocument functions
 */

function smarty_block_trim($params, $content, $template, &$repeat)
{

	if (!$repeat)
	{
		return trim($content);
	}
}