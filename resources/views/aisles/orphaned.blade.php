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
                        SET FOR {{ $section->number_products }} Products
                    </a>

                    <!-- Products in the Section -->
                    <div class="products">
                        @php
                            $totalPositions = $section->number_products;
                            $products = $section->products->keyBy('section_order'); // Organize by section_order for quick lookup
                        @endphp
                        
                        
                        <!-- ******************************************* -->

                        
                        @php
                            // Check if there is a valid grid layout for the section
                            $gridLayout = $section->gridLayout;
                            if ($gridLayout) {
                                // Retrieve the CSS class for the grid layout
                                $gridClass = $gridLayout->gridlayoutcss;
                            }
                        @endphp

                        @if ($gridLayout)
                            <!-- Only render the section if gridLayout exists -->
                            <section>
                                <div class="{{ $gridClass }}">
                                @for ($i = 1; $i <= $section->number_products; $i++)
                                    <div class="grid-item nth-child-{{ $i }}">
                                        @if ($products->has($i))
                                            @php
                                                $product = $products[$i];
                                            @endphp
                                            <h5 class="rajdhani-light">ID: {{ $product->id }}</h5>
                                        @else
                                            <!-- Leave empty if no product exists for this position -->
                                        @endif
                                    </div>
                                @endfor
                                </div>
                            </section>
                        @endif


                        <!-- ******************************************* -->


                        @for ($position = 1; $position <= $totalPositions; $position++)
                            @if ($products->has($position))
                                @php $product = $products[$position]; @endphp
                                <!-- Assigned Product Button -->
                                <button class="product-button assigned" data-product-id="{{ $product->id }}">
                                    Product ID: {{ $product->id }} orphaned<br>
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