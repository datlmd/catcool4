<?php

// @codeCoverageIgnoreStart
if (! function_exists('link_tag'))
{
// @codeCoverageIgnoreEnd
	// generate link css tags
	function link_tag($css)
	{
		return '<link rel="stylesheet" href="' . $css . '" />' . PHP_EOL;
	}
// @codeCoverageIgnoreStart
}

if (! function_exists('script_tag'))
{
// @codeCoverageIgnoreEnd
	// generate js script tags
	function script_tag($js)
	{
		return '<script src="' . $js . '"></script>' . PHP_EOL;
	}
// @codeCoverageIgnoreStart
}

if (! function_exists('validate_ext'))
{
// @codeCoverageIgnoreEnd
	// validate file to have required exyension
	function validate_ext($file, $ext = '.tpl')
	{
		$fileExt  = pathinfo($file, PATHINFO_EXTENSION);
		return empty($fileExt) ? $file . $ext : $file; 
	}
// @codeCoverageIgnoreStart
}

if (! function_exists('theme_url'))
{
// @codeCoverageIgnoreEnd
	// return full path from active theme URL
	function theme_url($path = null)
	{
		$themeVars = App\Libraries\Themes::getData();

		return $themeVars['theme_url'] . (is_string($path) ? $path : '');
	}
// @codeCoverageIgnoreStart
}

if (! function_exists('img_url'))
{
// @codeCoverageIgnoreEnd
	// return full path to image URL in active theme
	function img_url($path = null)
	{
		$themeVars = App\Libraries\Themes::getData();

		return $themeVars['image_url'] . (is_string($path) ? $path : '');
	}
// @codeCoverageIgnoreStart
}

if ( ! function_exists('get_theme_path'))
{
    function get_theme_path($path = null)
    {
        $themeVars = App\Libraries\Themes::getData();

        return $themeVars['theme_path'] . (is_string($path) ? $path : '');
    }
}

if (! function_exists('plugin_url'))
{
// @codeCoverageIgnoreEnd
	// return full path to plugin URL in active theme
	function plugin_url($path = null)
	{
		$themeVars = App\Libraries\Themes::getData();

		return $themeVars['plugin_url'] . (is_string($path) ? $path : '');
	}
// @codeCoverageIgnoreStart
}
// @codeCoverageIgnoreEnd

/**
 * Parse through a JS file and replace language keys with language text values
 *
 * @param string  $file
 * @param mixed[] $langs
 *
 * @return string
 */
function translate(string $file, array $langs = [])
{
	$contents = is_file($file) ? file_get_contents($file) : $file;

	preg_match_all("/\{\{(.*?)\}\}/", $contents, $matches, PREG_PATTERN_ORDER);

	if ($matches)
	{
		foreach ($matches[1] as $match)
		{
			$contents = str_replace("{{{$match}}}", isset($langs[trim($match)]) ? $langs[trim($match)] : lang($match), $contents);
		}
	}

	return $contents;
}

if ( ! function_exists('print_flash_alert'))
{
    /**
     * Prints already stored flashdata messages.
     *
     * @param   string  $view   overrides alert.php view file.
     * @return  string
     */
    function print_flash_alert($view = 'alert')
    {
        if (isset($_SESSION['__ci_flash']) && is_array($_SESSION['__ci_flash']))
        {
            $output = '';
            foreach ($_SESSION['__ci_flash'] as $message)
            {
                $output .= print_alert($message['message'], $message['type'], $view);
            }
            return $output;
        }
        return null;
    }
}