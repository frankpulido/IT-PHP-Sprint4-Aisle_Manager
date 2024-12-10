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
                        @php $totalRevenue = $section->products->sum('revenues_year'); @endphp
                        <a href="{{ url('section/' . $section->id) }}" class="aisle-link" data-total-revenue="{{ $totalRevenue }}">
                            SECTION ID: {{ $section->id }} | Position: {{ $i }}<br>
                            Kind: {{ $section->kind }}
                        </a>

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
                                                    <h5 class="rajdhani-light">ID: {{ $product->id }}</h5>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                </section>
                            @endif
                        </div>

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
                                        Price: ${{ number_format($product->price, 2) }}
                                    </button>
                                @else
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

    <!-- Scripts -->

    <script>

        /* SECTION BUTTONS */
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.aisle-link').forEach(link => {
                link.addEventListener('mouseenter', function () {
                    const totalRevenue = this.getAttribute('data-total-revenue');
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip rajdhani-light';
                    //tooltip.textContent = `Annual Revenue: $${parseFloat(totalRevenue).toFixed(2)}`;
                    tooltip.textContent = `Annual Revenue: $ ${new Intl.NumberFormat('en-US', {
                        style: 'decimal',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(totalRevenue)}`;
                    tooltip.style.position = 'absolute';
                    tooltip.style.backgroundColor = '#333';
                    tooltip.style.color = '#fff';
                    tooltip.style.padding = '5px';
                    tooltip.style.borderRadius = '5px';
                    tooltip.style.zIndex = '1000'; // NEW
                    
                    /*
                    tooltip.style.top = `${linkRect.top - tooltipRect.height - 10}px`; // Position above the link with spacing
                    tooltip.style.left = `${linkRect.left + (linkRect.width / 2) - (tooltipRect.width / 2)}px`; // Center horizontally
                    */
                    tooltip.style.top = `${this.getBoundingClientRect().top - 30}px`;
                    tooltip.style.left = `${this.getBoundingClientRect().left}px`;

                    tooltip.id = 'tooltip';
                    /*tooltip.style.whiteSpace = 'nowrap'; // NEW : Ensure the text does not wrap*/
                    document.body.appendChild(tooltip);
                });

                /*
                const linkRect = this.getBoundingClientRect();
                const tooltipRect = tooltip.getBoundingClientRect();
                */

                link.addEventListener('mouseleave', function () {
                    const tooltip = document.getElementById('tooltip');
                    if (tooltip) tooltip.remove();
                });
            });
        });

        /* PRODUCTS BUTTONS */
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.product-button').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    const position = this.getAttribute('data-position');

                    if (productId) {
                        const productName = this.getAttribute('data-product-name');
                        const productKind = this.getAttribute('data-product-kind');
                        const productPrice = this.getAttribute('data-product-price');
                        const productRevenue = this.getAttribute('data-product-revenues_year');
                        const productTurnover = this.getAttribute('data-product-turnover_year');
                        const productStockouts = this.getAttribute('data-product-stockouts_year');
                        alert(`Key Performance Indicators :\n` +
                            `Product ID: ${productId}\n` +
                            `Name: ${productName}\n` +
                            `Kind: ${productKind}\n` +
                            `Price: ${parseFloat(productPrice).toFixed(2)}\n` +
                            `Annual Revenue: ${productRevenue}\n` +
                            `Annual Turnover: ${productTurnover}\n` +
                            `Annual Stockouts: ${productStockouts}\n`);
                    } else if (position) {
                        alert(`Unassigned Position: ${position} clicked!`);
                    }
                });
            });
        });
    </script>

</body>
</html>
