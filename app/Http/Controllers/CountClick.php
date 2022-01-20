<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Klaviyo\Klaviyo;
use Klaviyo\Model\EventModel as KlaviyoEvent;

class CountClick extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Klaviyo $klaviyo)
    {
        $user = $request->user();

        $event = new KlaviyoEvent([
            'event' => 'Button Clicked',
            'customer_properties' => [
                '$email' => $user->email,
                '$first_name' => $user->name,
            ],
            'properties' => [
                'event time' => now(),
            ]
        ]);

        $klaviyo->publicAPI->track($event, true);

        return response()->noContent();
    }
}
