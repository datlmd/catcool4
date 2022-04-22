<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

if ( ! function_exists('_stringify_attributes'))
{
    /**
     * Stringify attributes for use in HTML tags.
     *
     * Helper function used to convert a string, array, or object
     * of attributes to a string.
     *
     * @param	mixed	string, array, object
     * @param	bool
     * @return	string
     */
    function _stringify_attributes($attributes, $js = FALSE)
    {
        $atts = NULL;

        if (empty($attributes))
        {
            return $atts;
        }

        if (is_string($attributes))
        {
            return ' '.$attributes;
        }

        $attributes = (array) $attributes;

        foreach ($attributes as $key => $val)
        {
            $atts .= ($js) ? $key.'='.$val.',' : ' '.$key.'="'.$val.'"';
        }

        return rtrim($atts, ',');
    }
}

if ( ! function_exists('build_path'))
{
    /**
     * This function smartly builds a path using DS
     *
     * @param   mixed   strings or array
     * @return  string  the full path built
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    http://www.bkader.com/
     */
    function build_path()
    {
        // We build the path only if arguments are passed
        if ( ! empty($args = func_get_args())) {
            // Make sure arguments are an array but not a mutidimensional one
            isset($args[0]) && is_array($args[0]) && $args = $args[0];
            return implode(DIRECTORY_SEPARATOR, array_map('rtrim', $args, [DIRECTORY_SEPARATOR])) . DIRECTORY_SEPARATOR;
        }
        return null;
    }
}
