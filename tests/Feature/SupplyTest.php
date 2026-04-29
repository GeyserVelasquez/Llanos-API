<?php

namespace Tests\Feature;

use App\Models\Supply;
use Tests\TestCase;

class SupplyTest extends TestCase
{
    public function test_users_can_get_a_list_of_supplies(): void
    {
        Supply::factory(3)->create();

        $route = route('supplies.index');

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'code',
                    'name',
                    'attributes',
                    'supply_type_id',
                ]
            ]
        ]);
    }

    public function test_users_can_get_a_single_supply(): void
    {
        $supply = Supply::factory()->create();

        $route = route('supplies.show', $supply);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $supply->code,
            'name' => $supply->name,
            'supply_type_id' => $supply->supply_type_id,
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
                'attributes',
                'supply_type_id',
            ]
        ]);
    }

    public function test_users_can_create_a_new_supply(): void
    {
        $payload = Supply::factory()->raw();
        // Convert attributes to array if factory returns it as such, although raw() handles it.
        
        $route = route('supplies.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('supplies', [
            'code' => $payload['code'],
            'name' => $payload['name'],
            'supply_type_id' => $payload['supply_type_id'],
        ]);
    }

    public function test_users_cannot_create_a_new_supply_with_missing_parameters(): void
    {
        $payload = ['name' => 'Test Supply'];

        $route = route('supplies.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);
    }

    public function test_users_can_update_a_supply(): void
    {
        $supply = Supply::factory()->create();

        $payload = ['name' => 'Updated Supply Name'];

        $route = route('supplies.update', $supply);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('supplies', [
            'id' => $supply->id,
            'name' => 'Updated Supply Name'
        ]);
    }

    public function test_users_can_delete_a_supply(): void
    {
        $supply = Supply::factory()->create();

        $route = route('supplies.destroy', $supply);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($supply);
    }

    public function test_users_cannot_get_a_soft_deleted_supply(): void
    {
        $supply = Supply::factory()->create();

        $supply->delete();

        $route = route('supplies.show', $supply);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }
}
