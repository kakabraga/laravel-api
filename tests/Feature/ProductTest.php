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

    public function test_user_cannot_update_other_user_product()
    {
        $user_creator = User::factory()->create();
        $user_not_creator = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user_creator->id
        ]);

        $payload = [
            'name' => 'Produto Alterado',
            'quantity' => 99,
            'weight' => 3.5,
            'price' => 999.99
        ];

        $response = $this->actingAs($user_not_creator)
            ->putJson("/api/products/{$product->id}", $payload);
        $response->assertStatus(403);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name
        ]);
    }

    public function test_user_cannot_list_other_user_product()
    {
        $user_creator = User::factory()->create();
        $user_not_creator = User::factory()->create();

        Product::factory()->create([
            'user_id' => $user_creator->id
        ]);

        $response = $this->actingAs($user_not_creator)
            ->getJson("api/products");
        $response->assertStatus(200);

        $response->assertJsonCount(0, 'data');
    }

    public function test_user_can_create_own_product()
    {
        $user = User::factory()->create();
        $payload = [
            'name' => 'Produto Teste',
            'quantity' => 99,
            'weight' => 3.5,
            'price' => 999.99
        ];

        $response = $this->actingAs($user)
            ->postJson("api/products", $payload);
        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => "Produto Teste",
            'user_id' => $user->id
        ]);
    }

    public function test_user_can_delete_own_product()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this->actingAs($user)
            ->deleteJson("api/products/{$product->id}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_user_can_update_own_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $user->id,
            'name' => "Produto Corinthinas"
        ]);

        $payload = [
            'name' => 'Produto Teste',
            'quantity' => 99,
            'weight' => 3.5,
            'price' => 999.99
        ];

        $response = $this->actingAs($user)
            ->putJson("api/products/{$product->id}", $payload);
        $response->assertOk();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => "Produto Teste"
        ]);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
            'name' => "Produto Corinthinas"
        ]);

    }
}
