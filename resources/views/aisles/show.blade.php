<!DOCTYPE html>
<html lang="en">

<?php $title = "Aisle Manager | $aisle->name"; ?>
@include('components.head')

<body>
    @include('components.header')

    <div>
        <h1 class="rajdhani-light">Sections of {{ $aisle->name }}</h1>
        <section class="rajdhani-light">
        </section>
    </div>

    <section class="grid-container">
        <section class="nested-grid-8 rajdhani-light">
            @php
                $totalSections = $aisle->number_sections;
                $sections = $aisle->sections->keyBy('aisle_order'); // Organize sections by aisle_order for quick lookup
            @endphp

            @for ($i = 1; $i <= $totalSections; $i++)
                <article class="grid-item">
                    <!-- Section Link -->
                    @if ($sections->has($i))
                        @php $section = $sections[$i]; @endphp
                        <a href="{{ url('sections/' . $section->id) }}" class="aisle-link">
                            Position: {{ $i }} | Section ID: {{ $section->id }}<br>
                            Kind: {{ $section->kind }}
                        </a>

                        <!-- Products in the Section -->
                        <div class="products">
                            @php
                                $totalProducts = $section->number_products;
                                $products = $section->products->keyBy('section_order'); // Organize products by section_order
                            @endphp

                            @for ($j = 1; $j <= $totalProducts; $j++)
                                @if ($products->has($j))
                                    @php $product = $products[$j]; @endphp
                                    <!-- Assigned Product Button -->
                                    <button class="product-button assigned" data-product-id="{{ $product->id }}">
                                        Product Name: {{ $product->name }}<br>
                                        Kind: {{ $product->kind }}<br>
                                        Price: ${{ number_format($product->price, 2) }}
                                    </button>
                                @else
                                    <!-- Unassigned Product Button -->
                                    <button class="product-button unassigned" data-position="{{ $j }}">
                                        Position: {{ $j }}<br>
                                        Unassigned
                                    </button>
                                @endif
                            @endfor
                        </div>
                    @else
                        <a href="#" class="aisle-link">
                            Position: {{ $i }} | Unassigned<br>
                            No Section
                        </a>
                    @endif
                </article>
            @endfor
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
