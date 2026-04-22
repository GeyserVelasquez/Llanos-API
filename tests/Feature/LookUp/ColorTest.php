<?php

namespace LookUp;

use App\Models\Color;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ColorTest extends TestCase
{

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_users_can_get_a_list_of_colors(): void
    {

        Color::factory(3)->create();

        $route = route('colors.index');

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
                ]
            ]
        ]);
    }

    public function test_unauthenticated_users_cannot_access_colors_endpoints(): void
    {
        $color = Color::factory()->create();

        $routeIndex = route('colors.index');
        $responseIndex = $this->getJson($routeIndex);
        $responseIndex->assertStatus(401);

        $routeShow = route('colors.show', $color);
        $responseShow = $this->getJson($routeShow);
        $responseShow->assertStatus(401);

        $storePayload = [
            'code' => 'sh',
            'name' => 'showTest'
        ];
        $routeStore = route('colors.store');
        $responseStore = $this->postJson($routeStore, $storePayload);
        $responseStore->assertStatus(401);
        $this->assertDatabaseMissing('colors', [
            'code' => 'sh'
        ]);


        $updatePayload = [
            'name' => 'test'
        ];
        $routeUpdate = route('colors.update', $color);
        $responseUpdate = $this->putJson($routeUpdate, $updatePayload);
        $responseUpdate->assertStatus(401);

        $routeDestroy = route('colors.destroy', $color);
        $responseDestroy = $this->deleteJson($routeDestroy);
        $responseDestroy->assertStatus(401);
        $this->assertDatabaseMissing('colors', [
            'name' => 'test'
        ]);
    }

    public function test_users_can_get_a_single_color(): void
    {
        $color = Color::factory()->create();

        $route = route('colors.show', $color);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'code' => $color->code,
            'name' => $color->name
        ]);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'code',
                'name',
            ]
        ]);
    }

    public function test_users_can_create_a_new_color(): void
    {
        $payload = [
            'code' => 'HO',
            'name' => 'Holstein'
        ];

        $route = route('colors.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('colors', [
            'code' => 'HO'
        ]);
    }

    public function test_users_cannot_create_a_new_color_with_missing_parameters(): void
    {
        $payload = [
            'name' => 'Holstein'
        ];

        $route = route('colors.store');

        $response = $this->actingAs($this->user)
             ->postJson($route,$payload);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('colors', [
            'name' => 'Holstein'
        ]);
    }

    public function test_users_cannot_create_a_color_with_a_duplicated_code(): void
    {
        $color = Color::factory()->create();

        $payload = [
            'code' => $color->code,
            'name' => 'Modificado'
        ];

        $route = route('colors.store');

        $response = $this->actingAs($this->user)
            ->postJson($route, $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['code']);
    }

    public function test_users_can_update_a_color(): void
    {
        $color = Color::factory()->create();

        $payload = [
            'code' => 'WG',
            'name' => 'Wagyu'
        ];

        $route = route('colors.update', $color);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('colors', [
            'code' => 'WG'
        ]);
    }

    public function test_users_cannot_update_a_color_with_missing_parameters(): void
    {
        $color = Color::factory()->create();

        $payload = [];

        $route = route('colors.update', $color);

        $response = $this->actingAs($this->user)
            ->putJson($route, $payload);

        $response->assertStatus(422);

        $this->assertDatabaseHas($color);
    }

    public function test_users_can_delete_a_color(): void
    {
        $color = Color::factory()->create([
            'code' => 'AN',
            'name' => 'Angus'
        ]);

        $route = route('colors.destroy', $color);

        $response = $this->actingAs($this->user)
            ->deleteJson($route);

        $response->assertStatus(204);

        $this->assertSoftDeleted($color);
    }

    public function test_users_cannot_get_a_soft_deleted_color(): void
    {
        $color = Color::factory()->create();

        $color->delete();

        $route = route('colors.show', $color);

        $response = $this->actingAs($this->user)
            ->getJson($route);

        $response->assertStatus(404);
    }

}
