<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductMedia;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $collections = collect([
            ['name' => 'Essentials', 'slug' => 'essentials', 'description' => 'Refined everyday essentials.'],
            ['name' => 'Travel', 'slug' => 'travel', 'description' => 'Premium gear for journeys.'],
            ['name' => 'Workspace', 'slug' => 'workspace', 'description' => 'A curated desk and home essentials range.'],
        ]);

        $collections->each(fn($collection) => Collection::create($collection));

        $product = Product::create([
            'collection_id' => 1,
            'name' => 'Minimalist Leather Backpack',
            'slug' => 'minimalist-leather-backpack',
            'short_description' => 'Premium leather backpack for modern city travel.',
            'description' => 'A premium backpack crafted with full-grain leather, versatile pockets, and ergonomic support for everyday carry.',
            'price' => 149.00,
            'compare_at_price' => 185.00,
            'sku' => 'OMB-001',
            'stock_quantity' => 26,
            'is_active' => true,
            'is_new' => true,
            'is_bestseller' => true,
            'is_sustainable' => true,
            'metadata' => ['materials' => ['full-grain leather', 'nylon lining'], 'highlight' => 'Craft meets minimalism'],
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Black / One Size',
            'sku' => 'OMB-001-BLK',
            'material' => 'Leather + Nylon Lining',
            'color' => 'Black',
            'size' => 'OS',
            'price' => 149.00,
            'compare_at_price' => 185.00,
            'stock_quantity' => 16,
            'image_url' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1200&q=80',
            'metadata' => ['angle' => 'hero', 'type' => 'primary'],
            'is_active' => true,
        ]);

        ProductMedia::insert([
            ['product_id' => $product->id, 'type' => 'image', 'url' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1400&q=80', 'alt_text' => 'Leather backpack hero view', 'position' => 1],
            ['product_id' => $product->id, 'type' => 'image', 'url' => 'https://images.unsplash.com/photo-1515847049296-a281d6401047?auto=format&fit=crop&w=1400&q=80', 'alt_text' => 'Backpack detail closeup', 'position' => 2],
            ['product_id' => $product->id, 'type' => 'video', 'url' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4', 'alt_text' => '360 product film', 'position' => 3],
        ]);

        Review::insert([
            ['product_id' => $product->id, 'user_id' => 1, 'rating' => 5, 'title' => 'Essential piece', 'body' => 'Perfect balance of form and durability.', 'verified_purchase' => true, 'size_rating' => 5, 'fit_rating' => 4, 'images' => json_encode([]), 'metadata' => json_encode(['mood' => 'elevated']), 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => $product->id, 'user_id' => 2, 'rating' => 4, 'title' => 'Premium quality', 'body' => 'Beautiful materials and excellent finish.', 'verified_purchase' => true, 'size_rating' => 4, 'fit_rating' => 5, 'images' => json_encode([]), 'metadata' => json_encode(['review_style' => 'short']), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
