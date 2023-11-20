<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Http\Resources\PlaceResource;
use App\Models\Place;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return PlaceResource
     */
    public function index(Request $request)
    {
        $places = Place::query();

        $filters = [
            'name',
        ];

        foreach ($filters as $filter)
            if ($request->has($filter))
                $places->where($filter, 'like', '%' . $request->$filter . '%');
        
        return PlaceResource::collection($places->get());
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param PlaceRequest $request
     * @return PlaceResource
     */
    public function store(StorePlaceRequest $request)
    {
        $place = Place::create($request->validated());
        
        return new PlaceResource($place);
    }

    /**
     * Display the specified resource.
     *
     * @param Place $place 
     * @return PlaceResource
     */
    public function show(Place $place)
    {
        return new PlaceResource($place);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param PlaceRequest $request
     * @param Place $place
     * @return PlaceResource
     */
    public function update(UpdatePlaceRequest $request, Place $place)
    {
        $place->update($request->validated());

        return new PlaceResource($place);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param Place $place
     * @return Response
     */
    public function destroy(Place $place)
    {
        $place->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
