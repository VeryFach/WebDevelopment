<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product()
    {
        $data = [
            'name' => 'Laptop',
            'description' => 'Laptop Gaming',
            'price' => 15000000,
            'stock' => 10,
        ];

        $response = $this->post('/products', $data);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', $data);
    }

    public function test_can_read_products()
    {
        $product = Product::factory()->create();

        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();

        $updateData = [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 123456,
            'stock' => 50,
        ];

        $response = $this->put("/products/{$product->id}", $updateData);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', $updateData);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete("/products/{$product->id}");

        $response->assertRedirect('/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}