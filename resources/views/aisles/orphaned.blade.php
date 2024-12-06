<!DOCTYPE html>
<html lang="en">

<?php $title = "Orphaned Sections | Manage Sections"; ?>
@include('components.head')

<body>
    @include('components.header')

    <div>
        <h1 class="rajdhani-light">Orphaned Sections</h1>
        <p class="rajdhani-light">[ "DRAFTS" UNDER STUDY ] Below are sections that are not yet assigned to any aisle.</p>
    </div>

    <section class="grid-container">
        <section class="nested-grid-8 rajdhani-light">
            @forelse ($sections as $section)
                <article class="grid-item">
                    <!-- Section Link -->
                    <a href="{{ url('sections/' . $section->id) }}" class="aisle-link">
                        Section ID: {{ $section->id }}<br>
                        Kind: {{ $section->kind }}<br>
                        Capacity: {{ $section->number_products }} Products
                    </a>

                    <!-- Products in the Section -->
                    <div class="products">
                        @php
                            $totalPositions = $section->number_products;
                            $products = $section->products->keyBy('section_order'); // Organize by section_order for quick lookup
                        @endphp

                        @for ($position = 1; $position <= $totalPositions; $position++)
                            @if ($products->has($position))
                                @php $product = $products[$position]; @endphp
                                <!-- Assigned Product Button -->
                                <button class="product-button assigned" data-product-id="{{ $product->id }}">
                                    Product Name: {{ $product->name }}<br>
                                    Kind: {{ $product->kind }}<br>
                                    Price: ${{ number_format($product->price, 2) }}
                                </button>
                            @else
                                <!-- Unassigned Product Button -->
                                <button class="product-button unassigned" data-position="{{ $position }}">
                                    Position: {{ $position }}<br>
                                    Unassigned
                                </button>
                            @endif
                        @endfor
                    </div>
                </article>
            @empty
                <p class="rajdhani-light">No orphaned sections found.</p>
            @endforelse
        </section>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle product button clicks
            document.querySelectorAll('.product-button').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    const position = this.getAttribute('data-position');

                    if (productId) {
                        alert(`Product ID: ${productId} clicked!`);
                        // Logic for assigned product
                    } else if (position) {
                        alert(`Unassigned Position: ${position} clicked!`);
                        // Logic for unassigned position
                    }
                });
            });
        });
    </script>

</body>
</html>