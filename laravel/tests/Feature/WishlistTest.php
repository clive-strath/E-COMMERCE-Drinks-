<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_wishlist()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('wishlist.index'));

        $response->assertStatus(200);
        $response->assertViewIs('wishlist.index');
    }

    public function test_user_can_add_product_to_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('wishlist.store'), [
            'product_id' => $product->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_cannot_add_duplicate_product_to_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);

        Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);

        $response = $this->post(route('wishlist.store'), [
            'product_id' => $product->id,
        ]);

        $response->assertRedirect();
        $this->assertCount(1, Wishlist::all());
    }

    public function test_user_can_remove_product_from_wishlist()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $this->actingAs($user);

        $wishlist = Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);

        $response = $this->delete(route('wishlist.destroy', $wishlist));

        $response->assertRedirect();
        $this->assertDatabaseMissing('wishlists', [
            'id' => $wishlist->id,
        ]);
    }

    public function test_guest_cannot_view_wishlist()
    {
        $response = $this->get(route('wishlist.index'));

        $response->assertRedirect(route('login'));
    }
}
