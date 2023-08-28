<?php
/**
 * Smarty plugin
 * @package    Foley-Engine
 * @subpackage Smarty
 */

/*
 * attributes:
 * - tag (boolean): true to generate an IMG tag, false for just the URL
 * - path (string): the local URL of the image
 * - null (string): an image to be displayed if the url does not exist
 * - other attributes to be rendered as IMG tag attributes.
 */
function smarty_function_image($params, $template)
{

	if (!isset($params['path']) && !isset($params['src']) && !isset($params['null']))
	{
		trigger_error('image: no PATH or SRC specified.');
	}

	if (!isset($params['tag']))
	{
		$params['tag'] = true;
	}

	$base           = URL::base(true);
	$path           = isset($params['src']) ? $params['src'] : (isset($params['path']) ? $params['path'] : '');
	$image_url      = FE::getImageURL( $path );
	$null_image_url = isset($params['null']) ? FE::getImageURL($params['null']) : null;

	// If the path to the image does not exist, we use the defined "null" image.
	$image_url = FE::firstDefined( $image_url, $null_image_url );

	if ($params['tag'] == false)
	{
		// Output the URL.
		return $image_url;
	}
	else
	{
		// Create a DOMDocument object for generating valid XML.
		$dom = new DOMDocument();

		// Create the field and add the relevant atrributes.
		$image = $dom->createElement('img');
		$image->setAttributeNode(new DOMAttr('src', $image_url));

		// Remove the URL and tag parameters.
		unset($params['path'], $params['src'], $params['null'], $params['tag']);

		// Always generate an alt attribute (for cleanly-coded pages).
		if (is_null($params['alt']))
		{
			$params['alt'] = '';
		}

		// Add the remaining parameters as IMG tag attributes.
		foreach ($params as $key => $value)
		{
			$image->setAttributeNode(new DOMAttr($key, $value));
		}

		// Return only the IMG tag from the DOMDocument object.
		return $dom->saveXML($image);
	}

}
