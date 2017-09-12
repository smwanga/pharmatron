<?php

use Illuminate\Support\ViewErrorBag;

if (!function_exists('flash_message')) {
    /**
     * Flash a message into the session.
     *
     * @param string $type
     * @param string $title
     * @param string $message
     */
    function flash_message($type, $title, $message)
    {
        $message = $message ?: trans('messages.success');
        $title = $title ?: trans('messages.success_title');
        $type = $type ?: 'successss';
        switch ($type) {
            case 'success':
                $icon = 'fa fa-check';
                break;
             case 'error':
                $icon = 'fa fa-check';
                break;
             case 'warning':
                $icon = 'fa fa-exclamation-triangle';
                break;
             case 'info':
                $icon = 'fa fa-bell-o';
                break;

            default:
                // code...
                break;
        }
        request()->session()->flash('messages', compact('type', 'title', 'message', 'icon'));
    }
}

if (!function_exists('is_active')) {
    /**
     * Set the active navigation item.
     *
     * @param string $route
     * @param string $class
     *
     * @return null|string
     */
    function is_active(string $route, string $class = 'active')
    {
        $check = function ($route, $class) {
            if (request()->path() == $route) {
                return $class;
            }
            if (request()->is($route)) {
                return $class;
            }
        };
        if (is_array($route)) {
            foreach ($route as $path) {
                if ($check($path, $class) !== null) {
                    return $class;
                }
            }

            return null;
        }

        return $check($route, $path);
    }
}

if (!function_exists('with_info')) {
    /**
     * Redirect back with a message.
     *
     * @param null|string $message
     * @param null|string $type
     * @param null|string $title
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function with_info($message = null, $type = 'success', $title = null)
    {
        flash_message($type, $title, $message);

        return back();
    }
}
if (!function_exists('redirect_with_info')) {
    /**
     * Redirect to a given URL with a message.
     *
     * @param string      $url
     * @param null|string $message
     * @param null|string $type
     * @param null|string $title
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function redirect_with_info(string $url, $message = null, $type = 'success', $title = null)
    {
        flash_message($type, $title, $message);

        return redirect($url);
    }
}
function error($key)
{
    return error_bag()->hasAny($key) ? 'has-error' : '';
}//end error()

function error_msg($key)
{
    return error_bag()->first($key, '<span class="help-block">:message</span>');
}

function error_bag()
{
    return request()->session()->get('errors') ?: new ViewErrorBag();
}
