<!DOCTYPE html>
<html lang="en">

<?php $title = "Aisle Manager | Sections to allocate"; ?>
@include('components.head')

<body>
    @include('components.header')
    <div>
        <h1 class="rajdhani-light">Orphaned Sections to Allocate</h1>
        <section class="rajdhani-light">

        </section>
    </div>

    <?php // dd($aisle->toArray()); ?>

    <section class="grid-container">
        <section class="nested-grid-8 rajdhani-light">

            @foreach ($aisle->sections as $section)
                <article class="grid-item">
                    <!-- Section Link -->
                    <a href="{{ url('sections/' . $section->id) }}" class="aisle-link">
                        Position {{ $section->aisle_order }} | Section ID: {{ $section->id }}<br>Kind: {{ $section->kind }}
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
            @endforeach

        </section>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select all buttons with the class 'product-button'
            document.querySelectorAll('.product-button').forEach(button => {
                button.addEventListener('click', function () {
                    // Extract the data attributes
                    const productId = this.getAttribute('data-product-id');
                    const position = this.getAttribute('data-position');

                    if (productId) {
                        alert(`Product ID: ${productId} clicked!`);
                        // Add logic for assigned product (e.g., view details, edit, or delete)
                    } else if (position) {
                        alert(`Unassigned Position: ${position} clicked!`);
                        // Add logic for unassigned position (e.g., assign a product)
                    }
                });
            });
        });
    </script>


</body>
</html>