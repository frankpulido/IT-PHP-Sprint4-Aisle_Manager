<!DOCTYPE html>
<html lang="en">

<?php $title = "Orphaned Sections | Manage Sections"; ?>
@include('components.head')

<body>
    @include('components.header')

    <div>
        <h1 class="rajdhani-light">Create Section</h1>
        <p class="rajdhani-light">REMEMBER : There are ORPHANED SECTIONS below are are not yet assigned to any aisle.</p>
    </div>

    <section class="grid-container">
        <!-- Single Nested Grid -->
        <section class="nested-grid-8 rajdhani-light">
            @php
                $totalLayouts = $layouts->count();
            @endphp

            @if ($totalLayouts > 0)
                @foreach ($layouts as $layout)
                    <article class="grid-item">
                        <a href="#" class="aisle-link">
                            {{ $layout->number_products }} PRODUCTS<br>
                            PROCEED
                        </a>

                        <!-- Grid Layout Rendering -->
                        <div class="products">
                            @for ($k = 1; $k <= $layout->number_products; $k++)
                                <div>
                                    <h5 class="rajdhani-light">PRODUCT {{ $k }}</h5>
                                </div>
                            @endfor
                        </div>
                    </article>
                @endforeach
            @else
                <p class="rajdhani-light">No orphaned sections available at the moment.</p>
            @endif
        </section>
    </section>

</body>
</html>
