<?php

namespace Tests\Unit;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_get_the_items_relations()
    {
        $item = Item::factory()
            ->has(Inventory::factory()->count(1))
            ->create();

        $this->assertNotEmpty($item->inventories->toArray());
    }
}
