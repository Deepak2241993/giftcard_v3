<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TimelineService;
use Illuminate\Http\Request;

class TimelineEventController extends Controller
{
     public function __construct(private TimelineService $timelineService)
    {
    }

    public function index(Request $request)
    {
        $patientId = $request->user()->id;
        $timeline = $this->timelineService->getPatientTimeline($patientId);
        return response()->json($timeline);
    }
}
