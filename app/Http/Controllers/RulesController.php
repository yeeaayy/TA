<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RulesController extends Controller
{
    private $emqxUrl;
    private $authToken;

    public function __construct()
    {
        $this->emqxUrl = 'http://localhost:18083/api/v5/rules';
        $this->authToken = 'Bearer aa79bce7a2e43ef5:CyVtxBosZVxLOESE9AJS6bCztD9CTG59ByhOXLdCAYe9AqF';
    }

    /**
     * Create a new rule in EMQX.
     */
   public function createRule(Request $request)
{
    $validated = $request->validate([
        'rule_name' => 'required|string',
        'rawsql' => 'required|string',
        'actions' => 'required|array',
    ]);

    $response = Http::withHeaders([
        'Authorization' => $this->authToken,
    ])->post($this->emqxUrl, [
        'name' => $validated['rule_name'],
        'rawsql' => $validated['rawsql'], // Contoh: SELECT * FROM "sensor_data"
        'actions' => $validated['actions'],
        'description' => $request->input('description', ''),
        'enabled' => $request->input('enabled', true),
    ]);

    if ($response->successful()) {
        return response()->json([
            'message' => 'Rule created successfully',
            'data' => $response->json(),
        ], 201);
    }

    return response()->json([
        'message' => 'Failed to create rule',
        'error' => $response->json(),
    ], $response->status());
}


    /**
     * Get all rules from EMQX.
     */
    public function getRules()
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authToken,
        ])->get($this->emqxUrl);

        if ($response->successful()) {
            return response()->json([
                'message' => 'Rules retrieved successfully',
                'data' => $response->json(),
            ]);
        }

        return response()->json([
            'message' => 'Failed to retrieve rules',
            'error' => $response->json(),
        ], $response->status());
    }

    /**
     * Delete a rule in EMQX.
     */
    public function deleteRule($ruleId)
    {
        $url = "{$this->emqxUrl}/{$ruleId}";

        $response = Http::withHeaders([
            'Authorization' => $this->authToken,
        ])->delete($url);

        if ($response->successful()) {
            return response()->json([
                'message' => 'Rule deleted successfully',
            ]);
        }

        return response()->json([
            'message' => 'Failed to delete rule',
            'error' => $response->json(),
        ], $response->status());
    }
}
