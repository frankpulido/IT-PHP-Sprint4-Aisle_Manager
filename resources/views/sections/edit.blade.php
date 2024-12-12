<!DOCTYPE html>
<html lang="en">

<?php $title = "Edit Section | Section {{ $section->id }}"; ?>
@include('components.head')

<body>
    @include('components.header')

    <h1 class="rajdhani-light">Edit Section {{ $section->id }}</h1>
    <h3 class="rajdhani-light">Aisle: {{ $section->aisle_id }} | Position: {{ $section->aisle_order }} | Kind: {{ $section->kind }}</h3>

    <section class="grid-container rajdhani-regular">
        <section class="nested-grid-3">

            <!-- Left Container: Section Metadata -->
            <article class="grid-item">
                <h2 class="rajdhani-light">SECTION {{ $section->id }} | Aisle {{ $section->aisle_id }} - Position {{ $section->aisle_order }}<br>Kind : {{ $section->kind }}</h2>
                <a href="{{ route('sections.show', ['id' => $section->id]) }}" class="aisle-link">
                    RETURN TO VIEW MODE
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
                                            <h4 class="rajdhani-light">[ Alerts publisher-listener could be here ]</h4>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </section>
                    @endif
                </div>
            </article>



            <!-- Middle Container: Update Products -->
            <article class="grid-item">
                <h2 class="rajdhani-light">UPDATE PRODUCTS</h2>
                <form action="{{ route('section.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="section_id" value="{{ $section->id }}">

                    @if ($gridLayout)
                        <section>
                        <div class="{{ $gridClass }}" style="display: flex; flex-direction: column; gap: 5px;">
                            @for ($k = 1; $k <= $section->number_products; $k++)
                                <div class="grid-item nth-child-{{ $k }}" style="display: flex; flex-direction: column;border: 1px solid #ccc; padding: 10px;">
                                    <label for="product_{{ $k }}">Position {{ $k }}:</label>
                                    @if ($products->has($k))
                                        <p>Current: {{ $products[$k]->name }} (ID: {{ $products[$k]->id }})</p>
                                    @else
                                        <p>Current: None</p>
                                    @endif
                                    <select name="matching_products[{{ $k }}]" id="product_{{ $k }}" style="width: 100%; padding: 5px;">
                                        <option value="">-- Select Product of Section Kind --</option>
                                        @foreach ($matchingProducts as $matchingProduct)
                                            <option value="{{ $matchingProduct->id }}"
                                                {{ $products->has($k) && $products[$k]->id == $matchingProduct->id ? 'selected' : '' }}>
                                                {{ $matchingProduct->name }} (ID: {{ $matchingProduct->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endfor
                        </div>
                        </section>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </article>



            <!-- Right Container: KPIs -->
            <article class="grid-item">
                <h2 class="rajdhani-light">KPIs</h2>
                <p>SALES FORECAST: Seasonality factors & Supplier's push/pull actions</p>
                <p>CURRENT STOCK: Backstore and central warehouse levels</p>
                <p>DELIVERY TIME: Dynamic delivery time calculation</p>
                <p>ORDER POINT: Minimum stock that triggers purchase order</p>
                <p>ORDER QTY: Adjusted by delivery time calculation</p>
            </article>

        </section>
    </section>
</body>
</html>
