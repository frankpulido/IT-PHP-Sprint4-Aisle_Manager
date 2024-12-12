<!DOCTYPE html>
<html lang="en">

<?php $title = "Aisle Manager | Section {{ $section->id }}"; ?>
@include('components.head')

<body>
    @include('components.header')
    <h1 class="rajdhani-light">AISLE MANAGER Project | Section {{ $section->id }}</h1>

    <section class="grid-container rajdhani-regular">
        <section class="nested-grid-3">

            <article class="grid-item">
                <h2 class="rajdhani-light">SECTION {{ $section->id }} | Aisle {{ $section->aisle_id }} - Position {{ $section->aisle_order }}<br>Kind : {{ $section->kind }}</h2>
                <a href="{{ route('section.edit', ['section_id' => $section->id]) }}" class="aisle-link">
                    EDIT SECTION
                </a>
                <h3 class="rajdhani-light">LOCATION Aisle/Position is changed swapping in the FLOORPLAN or swapping with ORPHANED.</h3>

                <!-- Grid Layout Rendering -->
                <div class="products">
                    @php
                        $gridLayout = $section->gridLayout;
                        $gridClass = $gridLayout ? $gridLayout->gridlayoutcss : null;
                        $products = $section->products->keyBy('section_order');
                    @endphp

                    @if ($gridLayout)
                        <section>
                            <div class="{{ $gridClass }}">
                                @for ($k = 1; $k <= $section->number_products; $k++)
                                    <div class="grid-item nth-child-{{ $k }}">
                                        @if ($products->has($k))
                                            @php $product = $products[$k]; @endphp
                                            <h3 class="rajdhani-light">ID: {{ $product->id }}</h3>
                                            <h3 class="rajdhani-light">NAME: {{ $product->name }}</h3>
                                            <h4 class="rajdhani-light">[ Alerts publisher-listener could be here ] <br> use conditional formatting</h4>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </section>
                    @endif
                </div>
            </article>

            <article class="grid-item">
                <h2 class="rajdhani-light">PRODUCTS</h2>
                <!-- Products in the Section -->
                <div class="products">
                    @php
                        $totalProducts = $section->number_products;
                        $products = $section->products->keyBy('section_order'); // Organize products by section_order
                    @endphp                             

                    @for ($j = 1; $j <= $totalProducts; $j++)
                        @if ($products->has($j))
                            @php $product = $products[$j]; @endphp
                            <button class="product-button assigned">
                                Product ID: {{ $product->id }}<br>
                                Product Name: {{ $product->name }}<br>
                                Kind: {{ $product->kind }}<br>
                                Price: ${{ number_format($product->price, 2) }}<br>
                                Annual revenues: ${{ $product->revenues_year }}<br>
                                Annual turnover: {{ $product->turnover_year }}<br>
                                Annual stockouts: {{ $product->stockouts_year }}
                            </button>
                        @else
                            <button class="product-button unassigned" data-position="{{ $j }}">
                                Position: {{ $j }}<br>
                                Unassigned
                            </button>
                        @endif
                    @endfor
                </div>
            </article>

            <article class="grid-item">
                <h2>KPIs | The info should be received through the API. <br> CLICK ON buttons on left</h2>
                <p>SALES FORECAST : Seasonality factor & Supplier's push/pull actions</p>
                <p>CURRENT STOCK : Backstore and central Warehouse</p>
                <p>DELIVERY TIME : Dynamic delivery time calculation</p>
                <p>ORDER POINT : Minimum stock that triggers purchase order</p>
                <p>ORDER QTY : Adjusted by Dynamic delivery time calculation</p>
            </article>

        </section>
    </section>
</body>
</html>
