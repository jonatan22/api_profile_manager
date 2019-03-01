<?php

namespace App\Http\Controllers\Api;

use App\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Validator;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Api
 */
class ProfileController extends Controller
{
    /**
     * Create a new profile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertProfile(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:profiles'
        ]);

        if (!$validation->passes()) {
            return response()->json([
                'message' => $validation->errors()->all()
            ]);
        }

        $profile = new Profile();
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->image = URL::to('/') . '/images/blank-head-profile.jpg';
        $profile->save();

        return response()->json([
            'message' => 'Profile created successfully',
            'profileId' => $profile->id
        ]);
    }

    /**
     * Get a profile
     * @param $profileId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile($profileId)
    {

        $profile = Profile::find($profileId);

        if (empty($profile)) {
            return response()->json([
                'message' => "The profile doesn't exist"
            ]);
        }

        return response()->json($profile);
    }

    /**
     * Update a profile
     * @param Request $request
     * @param $profileId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request, $profileId)
    {
        $profile = Profile::find($profileId);

        if (empty($profile)) {
            return response()->json([
                'message' => "The profile doesn't exist"
            ]);
        }

        $rules = ['name' => 'required'];

        if ($profile->email !== $request->email) {
            $rules['email'] = 'required|unique:profiles';
        }

        $validation = Validator::make($request->all(), $rules);

        if (!$validation->passes()) {
            return response()->json([
                'message' => $validation->errors()->all()
            ]);
        }

        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->save();

        return response()->json([
            'message' => 'Profile updated successfully'
        ]);
    }

    /**
     * Delete a profile
     * @param $profileId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProfile($profileId)
    {
        $profile = Profile::find($profileId);

        if (empty($profile)) {
            return response()->json([
                'message' => "The profile doesn't exist"
            ]);
        }

        $profile->delete();

        return response()->json([
            'message' => 'Profile deleted successfully'
        ]);
    }

    /**
     * Upload profile image
     * @param Request $request
     * @param $profileId
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request, $profileId)
    {
        $validation = Validator::make($request->all(), [
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if (!$validation->passes()) {
            return response()->json([
                'message' => $validation->errors()->all()
            ]);
        }

        $profile = Profile::find($profileId);

        if (empty($profile)) {
            return response()->json([
                'message' => "The profile doesn't exist"
            ]);
        }

        $image = $request->file('picture');
        $newName = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $newName);
        $profile->image = URL::to('/') . '/images/' . $newName;
        $profile->save();

        return response()->json([
            'message' => 'Image upload successfully',
            'url' => $profile->image
        ]);
    }
}
