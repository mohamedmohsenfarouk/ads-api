<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'code' => 200,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'code' => 400,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function retriveData($ad)
    {
        $all_tags = [];
        $cat_name = $ad->getCategoryName($ad->category);
        $advertiser_data = $ad->getAdvertiserName($ad->advertiser);
        foreach ($ad->tags as $tag) {
            array_push($all_tags, $tag->name);
        }

        $data = [
            'id' => $ad->id,
            'title' => $ad->title,
            'description' => $ad->description,
            'start_date' => $ad->start_date,
            'type' => $ad->type,
            'advertiser' => $advertiser_data,
            'category' => $cat_name,
            'tags' => $all_tags,
        ];
        return $data;
    }
}
