<?php

namespace Tests\Unit;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_get_the_inventory_relations()
    {
        $inventory = Inventory::factory()
            ->has(Item::factory()->count(2))
            ->create();

        $this->assertNotEmpty($inventory->items->toArray());
    }
}
