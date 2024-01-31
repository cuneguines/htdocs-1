<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UploadControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_handle_file_upload()
    {
        // Create a fake file for testing
        $file = UploadedFile::fake()->create('test_file.txt', 1024);

        // Set up any additional data needed for the request
        $data = [
            'files' => [$file],
            // Add other necessary data for your request
        ];

        // Make a POST request to your controller endpoint
        $response = $this->json('POST', '/handleFileUpload', $data);

        // Assert that the response has a successful status code
        $response->assertStatus(200);

        // Optionally, you can assert specific content in the response
        $response->assertJson(['success' => 'Files uploaded successfully']);
    }
}