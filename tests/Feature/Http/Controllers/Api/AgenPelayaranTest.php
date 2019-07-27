<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgenPelayaranTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_function_return_default_size_paginated_agen_pelayaran()
    {
        $response = $this->withHeaders([
                            'X-Header' => 'Value',
                        ])
                        ->json('GET', '/api/agen-pelayaran');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [],
                'links' => [],
                'meta' => []
            ]);
    }

    public function test_show_function_return_agen_pelayaran(){
        $response = $this->json('GET', '/api/agen-pelayaran', ['agenPelayaran' => 1]);
        $response->assertStatus(200);
    }

}
