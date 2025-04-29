<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Get user profile with preferred categories
     */
    public function show()
    {
        $user = $this->authUser()->load('preferredCategories');

        return $this->success(new UserResource($user));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'preferred_categories' => ['sometimes', 'array'],
            'preferred_categories.*' => ['exists:categories,id'],
        ]);

        $user = $this->authUser();

        if (isset($validated['preferred_categories'])) {
            $user->preferredCategories()->sync($validated['preferred_categories']);
        }

        $user->load('preferredCategories');

        return $this->success(new UserResource($user), 'Profile updated successfully.');
    }

    /**
     * Get all categories (for selection)
     */
    public function getCategories()
    {
        $categories = Category::all();

        return $this->success(CategoryResource::collection($categories));
    }
}
