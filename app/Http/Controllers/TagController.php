<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Http\Controllers\MainController as MainController;

class TagController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tags = Tag::all();
            return $this->sendResponse(TagResource::collection($tags), 'Get all tags');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        try {
            $tags = Tag::create($request->all());
            return $this->sendResponse(new TagResource($tags), 'Create new tag');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        try {
            $tag->update($request->all());
            return $this->sendResponse(new TagResource($tag), 'Update tag');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            return $this->sendResponse([], 'Tag deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }
}
