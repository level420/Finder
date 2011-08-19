<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_finder
 *
 * @copyright   Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * String Behaviors for Finder.
 *
 * @package     Joomla.Site
 * @subpackage  com_finder
 * @since       2.5
 */
class JHtmlString
{
	/**
	 * Method to setup the JavaScript highlight behavior.
	 *
	 * @param   array  $terms  An array of terms to highlight.
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	public static function highlighter($terms)
	{
		// Get the document object.
		$doc = JFactory::getDocument();

		// We only want to highlight text on regular html pages.
		if ($doc->getType() == 'html' && JRequest::getCmd('tmpl') !== 'component')
		{
			// Add the highlighter media.
			JHtml::script('components/com_finder/media/js/highlighter.js', false, false);

			// Add the terms to highlight.
			$doc->addScriptDeclaration("window.highlight = [\"".implode('","', $terms)."\"];");
		}
	}

	/**
	 * Method to format a file size in bytes to a human readable format.
	 *
	 * @param   integer  $bytes      The file size in bytes.
	 * @param   integer  $precision  The number of decimal points to use when rounding.
	 *
	 * @return  string  The formatted file size.
	 *
	 * @since   2.5
	 */
	public static function size($bytes, $precision = 1)
	{
		// Build our array of units.
		$units = array('B', 'KB', 'MB', 'GB', 'TB');

  		// Calculate the largest container.
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

  		// Convert to the proper unit.
		$bytes /= pow(1024, $pow);

  		// Return the formatted size.
		return round($bytes, $precision).' '.$units[$pow];
	}

	/**
	 * Method to gracefully truncate a string to within a certain number of
	 * characters. It is graceful because it does not truncate the text in the
	 * middle of a word, it will search backward to truncate to the last full
	 * word.
	 *
	 * @param   string   $input   The text to truncate.
	 * @param   integer  $length  The maximum length of the text.
	 *
	 * @return  string  The truncated text.
	 *
	 * @since   2.5
	 */
	public static function truncate($input, $length = 0)
	{
		// Truncate the item text if it is too long.
		if ($length > 0 && JString::strlen($input) > $length)
		{
			// Truncate the string to the maximum length.
			$tmp = JString::substr($input, 0, $length);

			// Look for the last space character within string.
			if (JString::strrpos($tmp, ' '))
			{
				// Find the last space within the string.
				$tmp = JString::substr($tmp, 0, JString::strrpos($tmp, ' '));

				// If we don't have 3 characters of room, go to the second to last space.
				if (JString::strlen($tmp) >= $length - 3)
				{
					$tmp = JString::substr($tmp, 0, JString::strrpos($tmp, ' '));
				}
			}

			$input = $tmp.'...';
		}

		return $input;
	}
}
