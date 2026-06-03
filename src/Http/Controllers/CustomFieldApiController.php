<?php

declare(strict_types=1);

namespace HyderKamran\CustomFields\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CustomFieldApiController extends Controller
{
    /**
     * Retrieve all custom fields and values for a given model instance.
     */
    public function getFields(Request $request, string $modelType, string $modelId): JsonResponse
    {
        if (!class_exists($modelType)) {
            return response()->json(['error' => 'Model type not found'], 404);
        }

        $model = $modelType::find($modelId);
        
        if (!$model) {
            return response()->json(['error' => 'Model instance not found'], 404);
        }

        if (!method_exists($model, 'getAllCustomFields')) {
            return response()->json(['error' => 'Model does not support custom fields (missing HasCustomFields trait)'], 400);
        }

        return response()->json([
            'data' => $model->getAllCustomFields()
        ]);
    }

    /**
     * Save custom fields for a model instance.
     */
    public function saveFields(Request $request, string $modelType, string $modelId): JsonResponse
    {
        $request->validate([
            'fields' => 'required|array'
        ]);

        if (!class_exists($modelType)) {
            return response()->json(['error' => 'Model type not found'], 404);
        }

        $model = $modelType::find($modelId);
        
        if (!$model) {
            return response()->json(['error' => 'Model instance not found'], 404);
        }

        if (!method_exists($model, 'setCustomField')) {
            return response()->json(['error' => 'Model does not support custom fields (missing HasCustomFields trait)'], 400);
        }

        foreach ($request->input('fields') as $name => $value) {
            $model->setCustomField($name, $value);
        }

        return response()->json([
            'message' => 'Custom fields saved successfully',
            'data'    => $model->getAllCustomFields()
        ]);
    }
}
