<!DOCTYPE html>
<html lang="en">

<?php $title = "Orphaned Sections | Manage Sections"; ?>
@include('components.head')

<body>
    @include('components.header')

    <div>
        <h1 class="rajdhani-light">Orphaned Sections -> Select Aisle/Position and Click on Section's column "head" to edit and nest in Aisle.</h1>
        <p class="rajdhani-light">ORPHANED SECTIONS below are are not yet assigned to any aisle.</p>
    </div>

    <section class="grid-container">
        <section class="grid-item">

        <!-- Swap Form -->

        <form action="{{ route('aisles.nestOrphaned') }}" method="POST" class="nest-orphaned-form">
            @csrf

            <!-- Dropdown for selecting aisle -->
            <label for="aisle_id">Select Aisle:</label>
            <select name="aisle_id" id="aisle_id" required>
                @foreach ($aisles as $aisle)
                    <option value="{{ $aisle->id }}">
                        Aisle {{ $aisle->id }}: {{ $aisle->name }}
                    </option>
                @endforeach
            </select>

            <!-- Dropdown for selecting position -->
            <label for="aisle_order">Select Position:</label>
            <select name="aisle_order" id="aisle_order" required>
                @foreach (range(1, $aisles->max('number_sections')) as $position)
                    <option value="{{ $position }}">
                        Position {{ $position }}
                    </option>
                @endforeach
            </select>


            <!-- Dropdown for selecting an orphaned section -->
            <label for="orphaned_section_id">Select Orphaned Section:</label>
            <select name="orphaned_section_id" id="orphaned_section_id" required>
                @foreach ($sections as $section)
                    <option value="{{ $section->id }}">
                        Section {{ $section->id }} (Kind: {{ $section->kind }}, Products: {{ $section->number_products }})
                    </option>
                @endforeach
            </select>


            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Nest Section</button>

        </form><!-- Swap Form ENDS -->

        </section>
    </section>


    <section class="grid-container">
        <section class="nested-grid-8 rajdhani-light">
            @forelse ($sections as $section)
                <article class="grid-item">
                    
                    <a href="" class="aisle-link">
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
                                <a href="" class="product-button assigned" data-product-id="{{ $product->id }}">
                                    Product ID: {{ $product->id }} orphaned<br>
                                    Product Name: {{ $product->name }}<br>
                                    Kind: {{ $product->kind }}<br>
                                    Price: ${{ number_format($product->price, 2) }}
                                </a>
                            @else
                                <!-- Unassigned Product Button -->
                                <a href="" class="product-button unassigned" data-position="{{ $position }}">
                                    Position: {{ $position }}<br>
                                    Unassigned
                                </a>
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