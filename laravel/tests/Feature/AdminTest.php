<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        $this->actingAs($admin);

        $response = $this->post(route('admin.products.store'), [
            'name' => 'New Drink',
            'category_id' => $category->id,
            'price' => 10.50,
            'size' => '500ml',
            'stock' => 100,
            'description' => 'Test description',
            'status' => 'available',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'New Drink']);
    }

    public function test_admin_can_create_category_with_products()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create();
        $this->actingAs($admin);

        $response = $this->post(route('admin.categories.store'), [
            'name' => 'New Category',
            'product_ids' => [$product->id],
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
        
        $this->assertEquals('New Category', $product->fresh()->category->name);
    }

    public function test_admin_can_view_orders()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $order = Order::factory()->create(); // Need OrderFactory
        $this->actingAs($admin);

        $response = $this->get(route('admin.orders.index'));

        $response->assertStatus(200);
        $response->assertSee($order->order_number);
    }
}
