<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use App\Models\Advertiser;
use App\Models\Tag;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::all();
        return AdResource::collection($ads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdRequest $request)
    {
        $ads = Ad::create($request->all());
        return new AdResource($ads);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdRequest  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdRequest $request, Ad $ad)
    {
        $ad->update($request->all());
        return new AdResource($ad);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        try {
            $ad->delete();
            return response()->json([
                'success' => true,
                'message' => 'Ad Deleted Successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => false,
                'errors' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the specified resource from storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show_by_advertiser(Request $request)
    {
        $advertiser_id = Advertiser::where('email', $request->email)->first()->id;
        $ads = Ad::where('advertiser', $advertiser_id)->get();
        return AdResource::collection($ads);
    }

    /**
     * Filter the specified resource by Category from storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter_by_category(Request $request)
    {
        $ads = Ad::where('category', $request->category)->get();
        return AdResource::collection($ads);
    }

    /**
     * Filter the specified resource by Tag from storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter_by_tag(Request $request)
    {
        $tags = Tag::with('ads')->where('id', $request->tag)->first();
        return AdResource::collection($tags->ads);
    }
    
}
