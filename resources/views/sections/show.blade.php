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
                <h2 class="rajdhani-light">SECTION {{ $section->id }} | Aisle {{ $section->aisle_id }} - Position {{ $section->aisle_order }}</h2>
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
                                            <h4 class="rajdhani-light">ID: {{ $product->id }}</h4>
                                            <h4 class="rajdhani-light">NAME: {{ $product->name }}</h4>
                                            <h4 class="rajdhani-light">KIND: {{ $product->kind }}</h4>
                                            <h4 class="rajdhani-light">PRICE: ${{ number_format($product->price, 2) }}</h4>
                                            <h4 class="rajdhani-light">12M REVENUES: ${{ $product->revenues_year }}</h4>
                                            <h4 class="rajdhani-light">12M TURNOVER: {{ $product->turnover_year }}</h4>
                                            <h4 class="rajdhani-light">12M STOCKOUTS: {{ $product->stockouts_year }}</h4>
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
                            <button class="product-button assigned"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}" 
                                data-product-kind="{{ $product->kind }}" 
                                data-product-price="{{ $product->price }}"
                                data-product-revenues_year="{{ $product->revenues_year }}" 
                                data-product-turnover_year="{{ $product->turnover_year }}" 
                                data-product-stockouts_year="{{ $product->stockouts_year }}"
                            >
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
                <h2>KPIs | The info should be sent through the API.</h2>
            </article>

        </section>
    </section>
</body>
</html>
