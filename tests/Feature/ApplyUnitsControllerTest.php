<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ApplyUnitsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_apply_items()
    {
        Item::factory(20)->create();
        $quantity = 10;

        $response = $this->json('POST', route('units.apply'), compact('quantity'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'price', 'created_at'],
            ]
        ]);

        $this->assertDatabaseHas('inventories', [
            'quantity' => -$quantity,
            'type' => Inventory::TYPE_APPLICATION,
        ]);

        $this->assertSame($quantity, Item::applied()->count());
    }

    /** @test */
    public function it_should_return_an_error_saying_insufficient_items()
    {
        Item::factory(9)->create();
        $quantity = 10;

        $response = $this->json('POST', route('units.apply'), compact('quantity'));

        $response->assertForbidden();
        $response->assertJson([
            'message' => 'Quantity to be applied exceeds the quantity on hand.',
        ]);
    }

    /** @test */
    public function it_should_not_allow_applying_units_with_zero_quantity_passed()
    {
        Item::factory(9)->create();
        $quantity = 0;

        $response = $this->json('POST', route('units.apply'), compact('quantity'));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson([
            'message' => 'The quantity must be at least 1.',
        ]);
    }
}
