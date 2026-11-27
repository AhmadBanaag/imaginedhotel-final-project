<?php

namespace App\Services;

use App\Models\Room;
use App\Models\RoomType;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class RoomSearchService
{
    /**
     * Reservation statuses that block room availability for overlapping dates.
     */
    public const BLOCKING_STATUSES = [
        'pending',
        'confirmed',
        'checked_in',
        'overstay',
    ];

    public function searchAvailableCategories(
        ?string $checkIn = null,
        ?string $checkOut = null,
        ?string $type = null,
        ?float $budget = null
    ): Collection {
        $types = RoomType::query()
            ->when($budget !== null, fn ($q) => $q->where('PricePerNight', '<=', $budget))
            ->orderBy('PricePerNight')
            ->get();

        return $types
            ->map(function (RoomType $roomType) use ($checkIn, $checkOut) {
                $slug = $this->resolveSlug($roomType->name);
                $meta = $this->presentationMeta($slug, $roomType->name);

                $availableUnits = Room::query()
                    ->where('room_type_id', $roomType->room_type_id)
                    ->where('status', 'available')
                    ->when($checkIn && $checkOut, function ($query) use ($checkIn, $checkOut) {
                        $query->whereDoesntHave('reservations', function ($q) use ($checkIn, $checkOut) {
                            $q->whereIn('status', self::BLOCKING_STATUSES)
                                ->where('check_in_date', '<', $checkOut)
                                ->where('check_out_date', '>', $checkIn);
                        });
                    })
                    ->count();

                return [
                    'room_type_id'    => $roomType->room_type_id,
                    'slug'            => $slug,
                    'name'            => $meta['display_name'],
                    'rate'            => (float) $roomType->PricePerNight,
                    'max_guest'       => (int) $roomType->maxGuest,
                    'available_units' => $availableUnits,
                    'description'     => $meta['description'],
                    'amenities'       => $meta['amenities'],
                    'image_class'     => $meta['image_class'],
                    'is_vip'          => $slug === 'deluxe',
                ];
            })
            ->filter(fn (array $cat) => $cat['available_units'] > 0)
            ->when(filled($type), fn (Collection $col) => $col->where('slug', $type))
            ->values();
    }

    public function calculateNights(?string $checkIn, ?string $checkOut): int
    {
        if (! $checkIn || ! $checkOut) {
            return 1;
        }

        $start = CarbonImmutable::parse($checkIn)->startOfDay();
        $end = CarbonImmutable::parse($checkOut)->startOfDay();

        return $end->greaterThan($start) ? (int) $start->diffInDays($end) : 1;
    }

    public function resolveSlug(string $name): string
    {
        $lower = strtolower($name);

        if (str_contains($lower, 'double')) {
            return 'double';
        }
        if (str_contains($lower, 'family')) {
            return 'family';
        }
        if (str_contains($lower, 'deluxe') || str_contains($lower, 'superior') || str_contains($lower, 'suite')) {
            return 'deluxe';
        }

        return 'single';
    }

    private function presentationMeta(string $slug, string $fallbackName): array
    {
        return match ($slug) {
            'single' => [
                'display_name' => 'Single-bed Room',
                'description'  => 'Single bed, private bathroom with shower & toiletries, flat screen TV, AC.',
                'amenities'    => ['Free WiFi', 'AC', 'TV'],
                'image_class'  => "bg-[url('../assets/images/rooms/single-bed-room.jpg')]",
            ],
            'double' => [
                'display_name' => 'Double-bed Room',
                'description'  => 'Double bed, ample wardrobe storage, air-conditioned, shower & toiletries.',
                'amenities'    => ['Free WiFi', 'AC', 'TV'],
                'image_class'  => "bg-[url('../assets/images/rooms/double-bed-room.jpg')]",
            ],
            'family' => [
                'display_name' => 'Family Room',
                'description'  => '2 Double-beds, 1 Single-large bed, baby crib, shower & toiletries, WiFi.',
                'amenities'    => ['Crib', 'WiFi', 'AC'],
                'image_class'  => "bg-[url('../assets/images/rooms/family-room.jpg')]",
            ],
            'deluxe' => [
                'display_name' => 'Deluxe Room',
                'description'  => 'Massage chairs, private balcony, living room, refrigerator, washer, microwave.',
                'amenities'    => ['Massage Chair', 'Balcony', 'Kitchenette'],
                'image_class'  => "bg-[url('../assets/images/rooms/deluxe-room-1.webp')]",
            ],
            default => [
                'display_name' => $fallbackName,
                'description'  => 'Comfortable hotel room at ImaginedHotel.',
                'amenities'    => ['Free WiFi', 'AC'],
                'image_class'  => "bg-[url('../assets/images/rooms/single-bed-room.jpg')]",
            ],
        };
    }
}