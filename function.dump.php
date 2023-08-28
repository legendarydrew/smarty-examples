<?php
/**
 * Smarty plugin
 * @package    Foley-Engine
 * @subpackage Smarty
 */

/*
 * attributes:
 */
function smarty_function_dump($params, $smarty)
{

	//if (!isset($params['var']))
	//{
		$var = $params['var'];
		if (method_exists($var, 'toArray')) {
			$var = $var->toArray();
		}

		return Debug::dump($var);
	//}
	//else
	/*{
		$smarty->trigger_error('dump: no var specified.');
	}*/

}
