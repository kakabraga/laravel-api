<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_create_product()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => "Teclado RGB",
            'quantity' => 25,
            'weight' => 2.5,
            'price' => 199.90
        ];

        $response = $this->actingAs($user)->postJson('/api/products', $payload);
        $response->assertStatus(201);

        $response->assertJson([
            'success' => true,
            'message' => 'The Product insert with success'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Teclado RGB',
            'user_id' => $user->id
        ]);
    }
    public function test_user_cannot_delete_other_user_product()
    {
        // cria dois usuários
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // cria um produto do user1
        $product = Product::factory()->create([
            'user_id' => $user1->id
        ]);

        // user2 tenta deletar o produto do user1
        $response = $this->actingAs($user2)
            ->deleteJson("/api/products/{$product->id}");

        // espera erro de autorização
        $response->assertStatus(403);

        // garante que o produto ainda existe no banco
        $this->assertDatabaseHas('products', [
            'id' => $product->id
        ]);
    }

}
