<?php

// @codeCoverageIgnoreStart
if (! function_exists('link_tag')) {
    // @codeCoverageIgnoreEnd
    // generate link css tags
    function link_tag($css)
    {
        return '<link rel="stylesheet" href="' . $css . '" />' . PHP_EOL;
    }
    // @codeCoverageIgnoreStart
}

if (! function_exists('script_tag')) {
    // @codeCoverageIgnoreEnd
    // generate js script tags
    function script_tag($js)
    {
        return '<script src="' . $js . '"></script>' . PHP_EOL;
    }
    // @codeCoverageIgnoreStart
}

if (! function_exists('validate_ext')) {
    // @codeCoverageIgnoreEnd
    // validate file to have required exyension
    function validate_ext($file, $ext = '.tpl')
    {
        $fileExt  = pathinfo($file, PATHINFO_EXTENSION);
        return empty($fileExt) ? $file . $ext : $file;
    }
    // @codeCoverageIgnoreStart
}

if (! function_exists('remove_extension')) {
    function remove_extension($file, $ext = '.css')
    {
        // In case of multiple items
        if (is_array($file)) {
            $file = array_map(function ($f) use ($ext) {
                $f = preg_replace('/'.$ext.'$/', '', $f);
                return $f;
            }, $file);
        }
        // In case of a single element
        else {
            $file = preg_replace('/'.$ext.'$/', '', $file);
        }
        return $file;
    }
}

if (! function_exists('theme_url')) {
    // @codeCoverageIgnoreEnd
    // return full path from active theme URL
    function theme_url($path = null)
    {
        $themeVars = App\Libraries\Themes::getData();

        return $themeVars['theme_url'] . (is_string($path) ? $path : '');
    }
    // @codeCoverageIgnoreStart
}

if (! function_exists('img_url')) {
    // @codeCoverageIgnoreEnd
    // return full path to image URL in active theme
    function img_url($path = null)
    {
        $themeVars = App\Libraries\Themes::getData();

        return $themeVars['image_url'] . (is_string($path) ? $path : '');
    }
    // @codeCoverageIgnoreStart
}

if (! function_exists('get_theme_path')) {
    function get_theme_path($path = null)
    {
        $themeVars = App\Libraries\Themes::getData();

        return $themeVars['theme_path'] . (is_string($path) ? $path : '');
    }
}

if (! function_exists('get_module_path')) {
    function get_module_path($path = null)
    {
        return APPPATH . 'Modules/' . (is_string($path) ? $path : '');
    }
}

if (! function_exists('get_view_path')) {
    function get_view_path($path = null)
    {
        return APPPATH . 'Views/' . (is_string($path) ? $path : '');
    }
}

if (! function_exists('plugin_url')) {
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

    if ($matches) {
        foreach ($matches[1] as $match) {
            $contents = str_replace("{{{$match}}}", isset($langs[trim($match)]) ? $langs[trim($match)] : lang($match), $contents);
        }
    }

    return $contents;
}

if (! function_exists('print_alert')) {
    /**
     * Prints an alert.
     *
     * @param   string  $message    the message to print.
     * @param   string  $type       type of the message.
     * @param   string  $view       by default 'alert' but can be overriden.
     * @return  string
     */
    function print_alert($message = '', $type = 'info', $view = 'alert')
    {
        if (empty($message)) {
            return null;
        }
        return App\Libraries\Themes::partial($view, [
            'type' => $type,
            'message' => $message
        ], true);
    }
}

if (! function_exists('set_alert')) {
    function set_alert($message = '', $type = 'info', $view = 'alert')
    {
        // If not message is set, nothing to do.
        if (empty($message)) {
            return false;
        }
        if (is_array($message)) {
            foreach ($message as $_type => $_message) {
                if (!in_array($_type, ['success','danger','warning','info','light','dark','primary','secondary'])) {
                    $_type = $type;
                }
                $messages[] = ['type' => $_type, 'message' => $_message, 'view' => $view];
            }
        } else {
            $messages[] = ['type' => $type, 'message' => $message, 'view' => $view];
        }

        // Set flashdata.
        session()->setFlashdata('__ci_flash', $messages);
    }
}

if (! function_exists('print_flash_alert')) {
    /**
     * Prints already stored flashdata messages.
     *
     * @param   string  $view   overrides alert.php view file.
     * @return  string
     */
    function print_flash_alert($view = 'alert')
    {
        $alert_list = session('__ci_flash');
        if (!empty($alert_list) && is_array($alert_list)) {
            $output = '';
            foreach ($alert_list as $message) {
                if ($message['view'] == $view) {
                    $output .= print_alert($message['message'], $message['type'], $view);
                }
            }
            return $output;
        }
        return null;
    }
}
if (! function_exists('theme_load')) {
    /**
     * @param null $viewPath
     * @param array $data
     * @return void|null
     */
    function theme_load($viewPath = null, $data = [])
    {
        if (empty($viewPath)) {
            return null;
        }

        return App\Libraries\Themes::load($viewPath, $data);
    }
}

if (! function_exists('theme_var')) {
    function theme_var()
    {
        return ['meta' => App\Libraries\Themes::getVars()];
    }
}

if (! function_exists('reactjs_script')) {
    function reactjs_script()
    {
        helper('filesystem');

        $script = [
            'development' => script_tag(theme_url("reactjs/dist/dev/main.js")),
            'testing' => script_tag(theme_url("reactjs/dist/dev/main.js")),
            'production' => "",
        ];
        $path = get_theme_path('reactjs/dist/static/js');

        $dir_js = directory_map($path);
        foreach ($dir_js as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) != 'js') {
                continue;
            }

            $script['production'] .= script_tag(theme_url("reactjs/dist/static/js/$file"));
        }

        return $script[ENVIRONMENT] ?? "";
    }
}

if (! function_exists('reactjs_css')) {
    function reactjs_css()
    {
        helper('filesystem');

        $style = [
            'development' => link_tag(theme_url("reactjs/dist/dev/main.css")),
            'testing' => link_tag(theme_url("reactjs/dist/dev/main.css")),
            'production' => "",
        ];

        $path = get_theme_path('reactjs/dist/static/css');

        $dir_js = directory_map($path);
        foreach ($dir_js as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) != 'css') {
                continue;
            }
            $style['production'] .= link_tag(theme_url("reactjs/dist/static/css/$file"));
        }

        return $style[ENVIRONMENT] ?? "";
    }
}
