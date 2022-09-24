<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdRequest;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use App\Models\Advertiser;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\MainController as MainController;
use Illuminate\Support\Facades\DB;

class AdController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $ads = Ad::with('advertiser')->with('tags')->with('category')->get();
            $result = [];
            foreach ($ads as $ad) {
                $data = $this->retriveData($ad);
                array_push($result, $data);
            }
            return $this->sendResponse(AdResource::collection($result), 'Get all ads');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdRequest $request)
    {
        try {
            $ads = Ad::create($request->all());
            $tags = json_decode($request->input('tags'));
            if (is_array($tags)) {
                foreach ($tags as $tag) {
                    $data = [
                        'tags_id' => $tag,
                        'ads_id' => $ads['id']
                    ];
                    DB::table('tags_ads')->insert($data);
                }
            } else {
                $data = [
                    'tag_id' => $tags,
                    'ad_id' => $ads['id']
                ];
                DB::table('tags_ads')->insert($data);
            }

            $ads = Ad::with('advertiser')->with('tags')->with('category')
                ->whereId($ads['id'])->first();
            $all_tags = [];
            $cat_name = $ads->getCategoryName($ads->category);
            $advertiser_data = $ads->getAdvertiserName($ads->advertiser);
            foreach ($ads->tags as $tag) {
                array_push($all_tags, $tag->name);
            }

            $data = [
                'id' => $ads->id,
                'title' => $ads->title,
                'description' => $ads->description,
                'start_date' => $ads->start_date,
                'type' => $ads->type,
                'advertiser' => $advertiser_data,
                'category' => $cat_name,
                'tags' => $all_tags,
            ];

            return $this->sendResponse(new AdResource($data), 'Create new ad');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
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
        try {
            $advertiser_id = Advertiser::where('email', $request->email)->first()->id;
            $ads = Ad::with('tags')->with('category')->where('advertiser', $advertiser_id)->get();
            $result = [];
            foreach ($ads as $ad) {
                $data = $this->retriveData($ad);
                array_push($result, $data);
            }
            return $this->sendResponse(AdResource::collection($result), 'Get ads by advertiser');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }

    /**
     * Filter the specified resource by Category from storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter_by_category(Request $request)
    {
        try {
            $ads = Ad::with('tags')->with('advertiser')->with('category')->where('category', $request->category)->get();
            $result = [];
            foreach ($ads as $ad) {
                $data = $this->retriveData($ad);
                array_push($result, $data);
            }
            return $this->sendResponse(AdResource::collection($result), 'Get ads by category');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }

    /**
     * Filter the specified resource by Tag from storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter_by_tag(Request $request)
    {
        try {
            $tag = Tag::with('ads')->whereId($request->tag)->first();
            $result = [];
            foreach ($tag->ads as $ad) {
                $data = $this->retriveData($ad);
                array_push($result, $data);
            }
            return $this->sendResponse(AdResource::collection($result), 'Get ads by tag');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }
}
