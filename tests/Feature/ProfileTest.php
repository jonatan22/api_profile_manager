<?php

namespace Tests\Feature;

use App\Profile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ProfileTest
 * @package Tests\Feature
 */
class ProfileTest extends TestCase
{
    /**
     * Check create profile
     *
     * Return message 'Profile created successfully'
     */
    public function testCreateProfile()
    {
        // Clean profiles tables
        \Illuminate\Support\Facades\DB::statement('DELETE FROM profiles;');

        // Create profile
        $params = [
            "email" => "jonatancruzgarcia@gmail.com",
            "name" => "jonatan"
        ];
        $response = $this->post('/profile/create-profile', $params);

        // Check message
        $response->assertSee('Profile created successfully');
    }

    /**
     * Check that get-profile return data
     *
     * Return profile email
     */
    public function testGetProfileReturnData()
    {
        // Clean profiles tables
        \Illuminate\Support\Facades\DB::statement('DELETE FROM profiles;');

        // Create profile
        $params = [
            "email" => "jonatancruzgarcia@gmail.com",
            "name" => "jonatan"
        ];
        $response = $this->post('/profile/create-profile', $params);
        $response->assertSee('Profile created successfully');

        // Get by query profile created
        $profile = Profile::select('id')
            ->where('email', 'jonatancruzgarcia@gmail.com')
            ->first();

        // Get profile
        $url = '/profile/' . $profile->id . '/get-profile';
        $response = $this->get($url);
        $response->assertSee('jonatancruzgarcia@gmail.com');
    }

    /**
     * Check delete profile
     * Return message 'Profile deleted successfully'
     */
    public function testDeleteProfile()
    {
        // Clean profiles tables
        \Illuminate\Support\Facades\DB::statement('DELETE FROM profiles;');

        // Create profile
        $params = [
            "email" => "jonatancruzgarcia@gmail.com",
            "name" => "jonatan"
        ];
        $response = $this->post('/profile/create-profile', $params);
        $response->assertSee('Profile created successfully');

        // Get by query profile created
        $profile = Profile::select('id')
            ->where('email', 'jonatancruzgarcia@gmail.com')
            ->first();

        // Delete profile
        $url = '/profile/' . $profile->id . '/delete-profile';
        $response = $this->delete($url);
         // Check message
        $response->assertSee('Profile deleted successfully');
    }

    /**
     * Check edit profile
     *
     * Return message 'Profile updated successfully'
     */
    public function testEditProfile()
    {
        // Clean profiles tables
        \Illuminate\Support\Facades\DB::statement('DELETE FROM profiles;');

        // Create profile
        $params = [
            "email" => "jonatancruzgarcia@gmail.com",
            "name" => "jonatan"
        ];
        $response = $this->post('/profile/create-profile', $params);
        $response->assertSee('Profile created successfully');

        // Get profile by query
        $profile = Profile::select('id')
            ->where('email', 'jonatancruzgarcia@gmail.com')
            ->first();

        // Edit profile
        $params = [
            "email" => "jonatancruzgarcia@gmail.com",
            "name" => "daniel"
        ];
        $url = '/profile/' . $profile->id . '/update-profile';
        $response = $this->put($url, $params);

        // Check message
        $response->assertSee('Profile updated successfully');

    }

    /**
     * Check that get-profile don't return data
     *
     * Return message 'The profile doesn't exist'
     */
    public function testProfileNotExist()
    {
        // Clean profiles tables
        \Illuminate\Support\Facades\DB::statement('DELETE FROM profiles;');

        // Get profile with id=50
        $response = $this->get('/profile/50/get-profile');
        $response->assertSee("The profile doesn't exist");
    }

    /**
     * Check that return error when try to create profile
     * with email already exist.
     *
     * Return message 'The email has already been taken.'
     */
    public function testCreateProfileEmailAlreadyExist()
    {
        // Clean profiles tables
        \Illuminate\Support\Facades\DB::statement('DELETE FROM profiles;');

        // Create profile
        $params = [
            "email" => "jonatancruzgarcia@gmail.com",
            "name" => "jonatan"
        ];
        $response = $this->post('/profile/create-profile', $params);
        $response->assertSee('Profile created successfully');

        // Create another profile but set email already created
        $params = [
            "email" => "jonatancruzgarcia@gmail.com",
            "name" => "daniel"
        ];
        $response = $this->post('/profile/create-profile', $params);

        // Check message
        $response->assertSee('The email has already been taken.');
    }

    /**
     * Check that return error when try to create profile
     * without email.
     *
     * Return message 'The email field is required.'
     */
    public function testCreateProfileWithoutEmail()
    {
        // Clean profiles tables
        \Illuminate\Support\Facades\DB::statement('DELETE FROM profiles;');

        // Create profile
        $params = [
            "name" => "jonatan"
        ];
        $response = $this->post('/profile/create-profile', $params);
        $response->assertSee('The email field is required.');
    }
}
