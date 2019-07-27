<?php

namespace Tests\Unit\Http\Controllers\Web;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Web\AgenPelayaranController;

class AgenPelayaranControllerTest extends TestCase
{

    /**
     * Test whether index() return the right view
     *
     * @return View agen-pelayaran.index
     */
    public function test_index_function_returns_view(){
        $controller = new AgenPelayaranController();
        $request = new Request();
        $responseView = $controller->index($request);
        $this->assertEquals('agen-pelayaran.index', $responseView->getName());
        $this->assertArrayHasKey('paginatedAgenPelayaran', $responseView->getData());
        $this->assertArrayHasKey('topFiveAgenPelayaranLogs', $responseView->getData());

        // getData() returns all vars attached to the response.
        // $posts = $response->original->getData()['posts'];
        // $this->call('GET', 'posts');
    }

    /**
     * Test whether
     */
    public function test_store_function_returns_redirect_route_with_success_message(){
        $data = [
            'nama' => 'Test Name',
            'logo' => 'Test Logo',
            'alamat' => 'Test Alamat',
            'telepon' => 'Test Telepon',
            'loket' => 'Test Loket'
        ];
        $controller = new AgenPelayaranController();
        $request = new Request($data);
        $response = $controller->store($request);
        // $response = $this->call('POST', '/jadwal', [], [], ['HTTP_REFERER' => 'http://alexsears.com']);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('http://localhost', $response->headers->get('Location'));
        // $this->assertEquals(333, $response->getSession()->get('created'));
    }

    public function test_store_function_returns_errorMessage_when_data_are_invalid(){
        $data = [
            'nama' => 'Test Name',
            'logo' => 'Test Logo',
            'alamat' => 'Test Alamat',
            'telepon' => 'Test Telepon',
            'loket' => 'Test Loket'
        ];

        $controller = new AgenPelayaranController();
        $request = new Request($data);
        $response = $controller->store($request);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        // $this->assertEquals(route(''), $response->headers->get('Location'));
        // $this->assertEquals(333, $response->getSession()->get('created'));
    }
}
