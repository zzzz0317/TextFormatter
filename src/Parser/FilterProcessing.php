<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2012 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Parser;

trait FilterProcessing
{
	/**
	* Execute all the attribute preprocessors of given tag
	*
	* @private
	*
	* @param  Tag   $tag       Source tag
	* @param  array $tagConfig Tag's config
	* @return bool             Unconditionally TRUE
	*/
	public static function executeAttributePreprocessors(Tag $tag, array $tagConfig)
	{
		if (!empty($tagConfig['attributePreprocessors']))
		{
			foreach ($tagConfig['attributePreprocessors'] as $attrName => $regexps)
			{
				if (!$tag->hasAttribute($attrName))
				{
					continue;
				}

				$attrValue = $tag->getAttribute($attrName);

				foreach ($regexps as $regexp)
				{
					// If the regexp matches, we remove the source attribute then we add the
					// captured attributes
					if (preg_match($regexp, $attrValue, $m))
					{
						$tag->removeAttribute($attrName);

						foreach ($m as $k => $v)
						{
							if (!is_numeric($k) && !$tag->hasAttribute($k))
							{
								$tag->setAttribute($k, $v);
							}
						}

						// We stop processing this attribute after the first match
						break;
					}
				}
			}
		}

		return true;
	}

	/**
	* Execute a filter
	*
	* @see s9e\TextFormatter\Configurator\Items\ProgrammableCallback
	*
	* @param  array $filter Programmed callback
	* @return mixed         Whatever the callback returns
	*/
	protected static function executeFilter(array $filter, array $vars)
	{
		$callback = $filter['callback'];
		$params   = (isset($filter['params'])) ? $filter['params'] : array();

		$args = array();
		foreach ($params as $k => $v)
		{
			if (is_numeric($k))
			{
				// By-value param
				$args[] = $v;
			}
			elseif (isset($vars[$k]))
			{
				// By-name param using a supplied var
				$args[] = $vars[$k];
			}
			elseif (isset($vars['registeredVars'][$k]))
			{
				// By-name param using a registered vars
				$args[] = $vars['registeredVars'][$k];
			}
			else
			{
				// Unknown param, log it if we have a Logger instance
				if (isset($vars['registeredVars']['logger']))
				{
					$vars['registeredVars']['logger']->err(
						'Unknown callback parameter',
						array('paramName' => $k)
					);
				}

				return false;
			}
		}

		return call_user_func_array($callback, $args);
	}

	/**
	* Filter the attributes of given tag
	*
	* @private
	*
	* @param  Tag    $tag            Tag being checked
	* @param  array  $tagConfig      Tag's config
	* @param  array  $registeredVars Array of registered vars for use in attribute filters
	* @return bool                   Whether the whole attribute set is valid
	*/
	public static function filterAttributes(Tag $tag, array $tagConfig, array $registeredVars)
	{
		if (empty($tagConfig['attributes']))
		{
			$tag->setAttributes(array());

			return true;
		}

		// Generate values for attributes with a generator set
		foreach ($tagConfig['attributes'] as $attrName => $attrConfig)
		{
			if (isset($attrConfig['generator']))
			{
				$tag->setAttribute(
					$attrName,
					self::executeFilter(
						$attrConfig['generator'],
						array(
							'attrName'       => $attrName,
							'registeredVars' => $registeredVars
						)
					)
				);
			}
		}

		$logger = (isset($registeredVars['logger'])) ? $registeredVars['logger'] : false;

		// Filter and remove invalid attributes
		foreach ($tag->getAttributes() as $attrName => $attrValue)
		{
			// Test whether this attribute exists and remove it if it doesn't
			if (!isset($tagConfig['attributes'][$attrName]))
			{
				$tag->removeAttribute($attrName);
				continue;
			}

			$attrConfig = $tagConfig['attributes'][$attrName];

			// Test whether this attribute has a filterChain
			if (!isset($attrConfig['filterChain']))
			{
				continue;
			}

			// Record the name of the attribute being filtered into the logger
			if ($logger)
			{
				$logger->setAttribute($attrName);
			}

			foreach ($attrConfig['filterChain'] as $filter)
			{
				$attrValue = self::executeFilter(
					$filter,
					array(
						'attrName'       => $attrName,
						'attrValue'      => $attrValue,
						'registeredVars' => $registeredVars
					)
				);

				if ($attrValue === false)
				{
					$tag->removeAttribute($attrName);
					break;
				}
			}

			// Update the attribute value if it's valid
			if ($attrValue !== false)
			{
				$tag->setAttribute($attrName, $attrValue);
			}

			// Remove the attribute's name from the logger
			if ($logger)
			{
				$logger->unsetAttribute();
			}
		}

		// Iterate over the attribute definitions to handle missing attributes
		foreach ($tagConfig['attributes'] as $attrName => $attrConfig)
		{
			// Test whether this attribute is missing
			if (!$tag->hasAttribute($attrName))
			{
				if (isset($attrConfig['defaultValue']))
				{
					// Use the attribute's default value
					$tag->setAttribute($attrName, $attrConfig['defaultValue']);
				}
				elseif (!empty($attrConfig['required']))
				{
					// This attribute is missing, has no default value and is required, which means
					// the attribute set is invalid
					return false;
				}
			}
		}

		return true;
	}

	/**
	* Execute given tag's filterChain
	*
	* @param  Tag  $tag Tag to filter
	* @return bool      Whether the tag is valid
	*/
	protected function filterTag(Tag $tag)
	{
		$tagName   = $tag->getName();
		$tagConfig = $this->tagsConfig[$tagName];
		$isValid   = true;

		if (!empty($tagConfig['filterChain']))
		{
			// Record the tag being processed into the logger it can be added to the context of
			// messages logged during the execution
			$this->logger->setTag($tag);

			// Prepare the variables that are accessible to filters
			$vars = array(
				'registeredVars' => $this->registeredVars,
				'tag'            => $tag,
				'tagConfig'      => $tagConfig
			);

			foreach ($tagConfig['filterChain'] as $filter)
			{
				if (!self::executeFilter($filter, $vars))
				{
					$isValid = false;
					break;
				}
			}

			// Remove the tag from the logger
			$this->logger->unsetTag();
		}

		return $isValid;
	}

	/**
	* Set a variable's value for use in filters
	*
	* @param  string $name  Variable's name
	* @param  mixed  $value Value
	* @return void
	*/
	public function registerVar($name, $value)
	{
		$this->registeredVars[$name] = $value;
	}
}