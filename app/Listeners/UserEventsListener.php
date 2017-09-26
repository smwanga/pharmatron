<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Support\Traits\LogsActivity;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Events\Dispatcher;

class UserEventsListener
{
    use LogsActivity;

    /**
     * Subscribe to user events.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Authenticated::class, [$this, 'authenticated']);
        $events->listen('Illuminate\Auth\Events\Login', [$this, 'onUserLogin']);
        $events->listen('Illuminate\Auth\Events\Logout', [$this, 'onUserLogout']);
        $events->listen('Illuminate\Auth\Events\Failed', [$this, 'onFailedLogin']);
        $events->listen('Illuminate\Auth\Events\Registered', [$this, 'onUserRegistered']);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function authenticated(Authenticated $event)
    {
    }

    /**
     * Handle user login events.
     */
    public function onFailedLogin($event)
    {
        if (!is_null($event->user)) {
            $data = [
                    'icon' => 'fa fa-ban',
                    'action' => 'danger',
                    'type' => 'auth',
                    'details' => trans(
                        'messages.loging.failed_login_event',
                        [
                          'time' => Carbon::now(config()->get('app.timezone')),
                          'ip' => request()->server->get('REMOTE_ADDR'),
                         ]
                    ),
                ];
            $this->logActivity($event->user, $data);
        }
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin($event)
    {
        $data = [
             'icon' => 'fa fa-sign-in',
             'action' => 'primary',
             'type' => 'auth',
             'details' => trans(
                 'messages.loging.login_event',
                 [
                    'time' => Carbon::now()->format('d-m-Y H:i'),
                    'ip' => request()->server->get('REMOTE_ADDR'),
                 ]
             ),
            ];
        $this->logActivity($event->user, $data);
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event)
    {
        if ($event->user) {
            $data = [
                 'icon' => 'fa fa-sign-out',
                 'action' => 'info',
                 'type' => 'auth',
                 'details' => trans(
                     'messages.loging.logout_event',
                     [
                      'time' => Carbon::now()->format('d-m-Y H:i'),
                      'ip' => request()->server->get('REMOTE_ADDR'),
                     ]
                 ),
                ];
            $this->logActivity($event->user, $data);
        }
    }

    /**
     * Listen to the creation of a user account.
     *
     * @param object $event User created event
     **/
    public function onUserRegistered($event)
    {
        if ($event->user) {
            $this->logActivity(
                $event->user,
                [
                 'icon' => 'fa fa-user',
                 'type' => 'auth',
                 'action' => 'info',
                 'details' => trans('messages.loging.user_create_event', ['name' => $event->user->name]),
                 'url' => route('users.show', $event->user->id),
                ]
            );
        }
    }
}
