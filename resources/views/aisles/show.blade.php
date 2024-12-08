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
                                    <!-- INFO INSIDE BUTTON TAG WILL BE PASSED ON CLICK -->
                                    <button class="product-button assigned"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}" 
                                        data-product-kind="{{ $product->kind }}" 
                                        data-product-price="{{ $product->price }}"
                                    >

                                        <!-- INFO DISPLAYED IN THE BUTTON -->    
                                        Product ID: {{ $product->id }}<br>
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
                        // Extract additional product details from data attributes
                        const productName = this.getAttribute('data-product-name');
                        const productKind = this.getAttribute('data-product-kind');
                        const productPrice = this.getAttribute('data-product-price');
                        //alert(`Product ID: ${productId} clicked!`);
                        // Add logic for assigned product (e.g., view details, edit, or delete)
                        alert(`Key Performance Indicators :\n` +
                            `Product ID: ${productId}\n` +
                            `Name: ${productName}\n` +
                            `Kind: ${productKind}\n` +
                            `Price: $${parseFloat(productPrice).toFixed(2)}`);
                    } else if (position) {
                        alert(`Unassigned Position: ${position} clicked!`);
                        // Add logic for unassigned position (e.g., assign a product)
                    }
                });
            });
        });
    </script>



    <!-- Modal HTML: This will appear as a popup when clicking on a product
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Product Details</h2>
            <p><strong>Name:</strong> <span id="modalProductName"></span></p>
            <p><strong>Kind:</strong> <span id="modalProductKind"></span></p>
            <p><strong>Price:</strong> $<span id="modalProductPrice"></span></p>
        </div>
    </div>

    The script to handle the modal
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the aisle ID from the URL (assuming it's available in the URL)
            const aisleId = window.location.pathname.split('/')[2]; // This extracts the aisleId from the URL like /aisles/2

            // Select all buttons with the class 'product-button'
            document.querySelectorAll('.product-button').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id'); // Get the product ID from the button's data attribute

                    // Fetch the product details from the backend
                    fetch(`/aisles/${aisleId}/products/${productId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Populate the modal with product details
                            document.getElementById('modalProductName').innerText = data.name;  // Set the product name
                            document.getElementById('modalProductKind').innerText = data.kind;  // Set the product kind
                            document.getElementById('modalProductPrice').innerText = data.price;  // Set the product price

                            // Show the modal
                            document.getElementById('productModal').style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Error fetching product data:', error);
                        });
                });
            });

            // Close modal when clicking the close button (X)
            document.querySelector('.close').addEventListener('click', function () {
                document.getElementById('productModal').style.display = 'none';
            });

            // Close modal if clicked outside of it
            window.addEventListener('click', function (event) {
                if (event.target === document.getElementById('productModal')) {
                    document.getElementById('productModal').style.display = 'none';
                }
            });
        });
    </script>
    -->


</body>
</html>
