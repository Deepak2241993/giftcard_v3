<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\GiftcardPurchases;
use App\Events\TimelineGiftcardRedeem;
use App\Events\TimelineGiftcardCancel;
use App\Events\ServicePurchases;
use App\Events\ServicePurchasesPayment;
use App\Events\TimelineServiceRedeem;
use App\Events\TimelineServiceCancel;
use App\Events\TimelineServiceRefund;
use App\Events\GiftcardsBuyFromCenter;
use App\Events\EventPatientLogout;
use App\Events\EventPatientCreated;
use App\Events\EventLogin;


use App\Listeners\ListenerGiftcardPurchases;
use App\Listeners\TimelineLinstnerGiftcardRedee;
use App\Listeners\TimelineLinstnerGiftcardCancel;
use App\Listeners\ListenerServicePurchases;
use App\Listeners\ListenerServicePurchasesPayment;
use App\Listeners\TimelineLinstnerServicecardRedeem;
use App\Listeners\TimelineLinstnerServicecardCancel;
use App\Listeners\TimelineLinstnerServicecardRefund;
use App\Listeners\ListenerGiftcardsBuyFromCenter;
use App\Listeners\ListnerPatientLogout;
use App\Listeners\ListenerPatientCreated;
use App\Listeners\ListinerLogin;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        GiftcardPurchases::class => [
            ListenerGiftcardPurchases::class,
        ],
        TimelineGiftcardRedeem::class => [
            TimelineLinstnerGiftcardRedee::class,
        ],
        TimelineGiftcardCancel::class => [
            TimelineLinstnerGiftcardCancel::class,
        ],
        ServicePurchases::class => [
            ListenerServicePurchases::class,
        ],
        ServicePurchasesPayment::class => [
            ListenerServicePurchasesPayment::class,
        ],
        TimelineServiceRedeem::class => [
            TimelineLinstnerServicecardRedeem::class,
        ],
        TimelineServiceCancel::class => [
            TimelineLinstnerServicecardCancel::class,
        ],
        TimelineServiceRefund::class => [
            TimelineLinstnerServicecardRefund::class,
        ],
        GiftcardsBuyFromCenter::class => [
            ListenerGiftcardsBuyFromCenter::class,
        ],
        EventPatientLogout::class => [
            ListnerPatientLogout::class,
        ],
        EventPatientCreated::class => [
            ListenerPatientCreated::class,
        ],
        EventLogin::class => [
            ListinerLogin::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
