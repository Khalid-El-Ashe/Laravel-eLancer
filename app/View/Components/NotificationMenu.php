<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NotificationMenu extends Component
{
    public $notifications;
    public $new;

    /**
     * Create a new component instance.
     */
    public function __construct($count = 10)
    {

        $user = Auth::user();

        /**
         * now in the ($user) variable is have 3 Relation
         * 1)(notifications > is return all notifications if is read or not )
         * 2)(reatNotifications > is return just notifications if is read)
         * 3)(unreatNotifications > is return just notifications if is unRead)
         */
        // $this->notifications = $user->notifications()->take($count)->get(); // is return all notifications but this is not good for perfomance
        // $this->notifications = $user->readNotifications()->take($count)->get(); // is return all notifications but this is not good for perfomance
        $this->notifications = $user->unreadNotifications()->take($count)->get(); // is return all notifications but this is not good for perfomance
        // $this->notifications = $user->notifications; // is return all notifications but this is not good for perfomance

        // $this->notifications = $user ? $user->notifications : collect(); //todo i use this to make safe value if the user is not logined
        $this->new = $user->unreadNotifications()->count();
    }

    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.notification-menu', [
            'notifications' => $this->notifications
        ]);
    }
}
