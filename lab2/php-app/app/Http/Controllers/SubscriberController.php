<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Subscriber API", version="1.0")
 */
class SubscriberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/subscribers",
     *     summary="Get list of subscribers",
     *     @OA\Response(response="200", description="List of subscribers")
     * )
     */
    public function index()
    {
        return Subscriber::all();
    }

    /**
     * @OA\Post(
     *     path="/api/subscribers",
     *     summary="Create a new subscriber",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Subscriber created")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:subscribers',
        ]);

        $subscriber = Subscriber::create($request->all());

        return response()->json($subscriber, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/subscribers/{id}",
     *     summary="Get a subscriber by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Subscriber found"),
     *     @OA\Response(response="404", description="Subscriber not found")
     * )
     */
    public function show($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        return response()->json($subscriber);
    }

    /**
     * @OA\Put(
     *     path="/api/subscribers/{id}",
     *     summary="Update a subscriber by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email"},
     *             @OA\Property(property="name", type="string", example="John Updated"),
     *             @OA\Property(property="email", type="string", format="email", example="john.updated@example.com")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Subscriber updated")
     * )
     */
    public function update(Request $request, $id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->update($request->all());

        return response()->json($subscriber);
    }

    /**
     * @OA\Delete(
     *     path="/api/subscribers/{id}",
     *     summary="Delete a subscriber by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Subscriber deleted")
     * )
     */
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return response()->json(null, 204);
    }
}
