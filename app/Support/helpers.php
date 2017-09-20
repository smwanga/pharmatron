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
        $type = $type ?: 'success';
        switch ($type) {
            case 'success':
                $icon = 'fa fa-check fa-lg';
                break;
            case 'error':
                $icon = 'fa fa-times fa-lg';
                break;
            case 'warning':
                $icon = 'fa fa-exclamation-triangle fa-lg';
                break;
            case 'info':
                $icon = 'fa fa-bell-o fa-lg';
                break;

            default:
                $icon = 'fa fa-bell-o fa-lg';
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

        return $check($route, $class);
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
if (!function_exists('optinal')) {
    /**
     * undocumented function.
     *
     * @author
     **/
    function optional($value)
    {
        return new App\Support\Optional($value);
    }
}

if (!function_exists('sale_ribbon')) {
    /**
     * undocumented function.
     *
     * @author
     **/
    function sale_ribbon(int $due, int $total)
    {
        if ($total - $due === 0) {
            return ['message' => trans('main.not_paid'), 'class' => 'danger red'];
        }
        if ($total - $due === $total) {
            return ['message' => trans('main.fully_paid'), 'class' => 'success'];
        } else {
            return ['message' => trans('main.partially_paid'), 'class' => 'primary base'];
        }
    }
}
if (!function_exists('progress_bar')) {
    /**
     * undocumented function.
     *
     * @author
     **/
    function progress_bar(int $max, int $min)
    {
        $value = ($min / $max * 100);

        switch ($value) {
            case $value >= 75:
                $class = 'success';
                break;
            case $value >= 50:
                $class = 'primary';
                break;
            case $value >= 35:
                $class = 'warning';
                break;

            default:
                $class = 'danger';
                break;
        }

        return ['value' => number_format($value, 2), 'class' => $class];
    }
}
