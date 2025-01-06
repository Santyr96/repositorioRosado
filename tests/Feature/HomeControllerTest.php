<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /** @test */
    public function it_loads_the_index_view()
    {
      
        $response = $this->get('/');

      
        $response->assertStatus(200);

        $response->assertViewIs('index');
    }

    /** @test */
    public function it_loads_the_about_me_view()
    {
       
        $response = $this->get('/about');

        $response->assertStatus(200);

        $response->assertViewIs('about-me');
    }
}
