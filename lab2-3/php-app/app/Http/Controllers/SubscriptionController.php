<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Subscription API", version="1.0")
 */
class SubscriptionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/subscriptions",
     *     summary="Get list of subscriptions",
     *     @OA\Response(response="200", description="List of subscriptions")
     * )
     */
    public function index()
    {
        return Subscription::all();
    }

    /**
     * @OA\Post(
     *     path="/api/subscriptions",
     *     summary="Create a new subscription",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"service","topic","payload","expired_at"},
     *             @OA\Property(property="service", type="string", example="Premium News Service"),
     *             @OA\Property(property="topic", type="string", example="Technology"),
     *             @OA\Property(property="payload", type="object", example={"key": "value"}),
     *             @OA\Property(property="expired_at", type="string", format="date-time", example="2024-12-31T23:59:59")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Subscription created")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'service' => 'required|string',
            'topic' => 'required|string',
            'payload' => 'required|array',
            'expired_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $subscription = Subscription::create($request->all());

        return response()->json($subscription, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/subscriptions/{id}",
     *     summary="Get a subscription by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Subscription found"),
     *     @OA\Response(response="404", description="Subscription not found")
     * )
     */
    public function show($id)
    {
        $subscription = Subscription::findOrFail($id);
        return response()->json($subscription);
    }

    /**
     * @OA\Put(
     *     path="/api/subscriptions/{id}",
     *     summary="Update a subscription by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"service","topic","payload","expired_at"},
     *             @OA\Property(property="service", type="string", example="Updated News Service"),
     *             @OA\Property(property="topic", type="string", example="Science"),
     *             @OA\Property(property="payload", type="object", example={"key": "new_value"}),
     *             @OA\Property(property="expired_at", type="string", format="date-time", example="2025-01-31T23:59:59")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Subscription updated")
     * )
     */
    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update($request->all());

        return response()->json($subscription);
    }

    /**
     * @OA\Delete(
     *     path="/api/subscriptions/{id}",
     *     summary="Delete a subscription by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Subscription deleted")
     * )
     */
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return response()->json(null, 204);
    }
}
