<?php

namespace Tests\Unit;

use App\Models\Property;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_property()
    {
        $propertyData = [
            'title' => 'Test Property',
            'description' => 'A test property description',
            'location' => 'Test Location',
            'price' => 250000,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'area_sqft' => 1500,
            'year_built' => 2020,
            'property_type' => 'House',
            'status' => 'For Sale',
        ];

        $property = Property::create($propertyData);

        $this->assertInstanceOf(Property::class, $property);
        $this->assertDatabaseHas('properties', $propertyData);
    }

    public function test_property_relationships()
    {
        $property = Property::factory()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $property->appointments);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $property->transactions);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $property->reviews);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $property->features);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $property->images);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $property->bookings);
    }

    public function test_property_scopes()
    {
        $property = Property::factory()->create([
            'title' => 'Test Property',
            'price' => 200000,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'area_sqft' => 1500,
            'property_type' => 'House',
        ]);

        $this->assertCount(1, Property::search('Test')->get());
        $this->assertCount(1, Property::priceRange(150000, 250000)->get());
        $this->assertCount(1, Property::bedrooms(2, 4)->get());
        $this->assertCount(1, Property::bathrooms(1, 3)->get());
        $this->assertCount(1, Property::areaRange(1000, 2000)->get());
        $this->assertCount(1, Property::propertyType('House')->get());
    }
}