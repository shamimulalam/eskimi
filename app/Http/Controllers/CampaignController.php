<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignCreative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::orderBy('id','desc')->get();
        return response()->json($campaigns);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'fromDate'      => 'required|date',
            'toDate'        => 'required|date',
            'dailyBudget'   => 'required|numeric',
            'totalBudget'   => 'required|numeric',
            'creatives'     => 'required',
            'creatives.*'   => 'mimes:jpeg,png',
        ]);
        DB::beginTransaction();
        try {
            $campaign               = new Campaign();
            $campaign->name         = $request->name;
            $campaign->from         = $request->fromDate;
            $campaign->to           = $request->toDate;
            $campaign->total_budget = $request->totalBudget;
            $campaign->daily_budget = $request->dailyBudget;
            $campaign->save();

            foreach ($request->file('creatives') as $index => $creative) {
                $campaignCreative               = new CampaignCreative();
                $campaignCreative->campaign_id  = $campaign->id;
                $campaignCreative->path         = Storage::put('campaign/creatives', $creative);
                $campaignCreative->save();
            }

            DB::commit();
            return response('created',201);
        }catch (\Exception $exception) {
            DB::rollBack();
            Log::error('CampaignController@store :: '.$exception->getMessage());
            return response($exception->getMessage(),400);
        }
    }
    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);
        return response()->json($campaign);
    }
    public function update(Request $request,$id)
    {

        $request->validate([
            'name'          => 'required|max:255',
            'from'          => 'required|date',
            'to'            => 'required|date',
            'daily_budget'  => 'required|numeric',
            'total_budget'  => 'required|numeric'
        ]);
        try{
            $campaign               = Campaign::findOrFail($id);
            $campaign->name         = $request->name;
            $campaign->from         = $request->from;
            $campaign->to           = $request->to;
            $campaign->total_budget = $request->total_budget;
            $campaign->daily_budget = $request->daily_budget;
            $campaign->save();

            return response('created',201);
        }catch (\Exception $exception) {
            Log::error("CampaignController@update($id) :: ".$exception->getMessage());
            return response($exception->getMessage(),400);
        }
    }
}
