<!DOCTYPE html>
<html lang="en">

<?php $title = "Section Layouts | Select to Create Section"; ?>
@include('components.head')

<body>
    @include('components.header')

    <div>
        <h1 class="rajdhani-light">Create Section for Aisle {{$aisleId}} | Position {{$position}} -> Click on the "head" of your preferred layout to proceed.</h1>
        <p class="rajdhani-light">SUGGESTION : Check whether there is an ORPHANED SECTION that suits well and nest it in the Aisle.</p>
    </div>

    <section class="grid-container">
        <section class="grid-item">

            <form action="{{ route('section.createBridge') }}" method="POST">
                @csrf
                
                <!-- Aisle ID (aisle_id) from CreateSection -->
                <input type="hidden" name="aisle_id" value="{{ $aisleId }}">
                
                <!-- Position (aisle_order) from createSection -->
                <input type="hidden" name="position" value="{{ $position }}">
                
                <!-- Layout Selection -->
                <label for="grid_id">Select Layout:</label>
                <select name="grid_id" id="grid_id" required>
                    <option value="">-- Select a Layout --</option>
                    @foreach ($layouts as $layout)
                        <option value="{{ $layout->id }}">
                            Layout ID: {{ $layout->id }} ({{ $layout->number_products }} Products)
                        </option>
                    @endforeach
                </select>

                <!-- Kind Selection -->
                <label for="kind">Select Kind:</label>
                <select name="kind" id="kind" required>
                    <option value="">-- Select a Kind --</option>
                    @foreach ($kinds as $kind)
                        <option value="{{ $kind }}">{{ ucfirst($kind) }}</option>
                    @endforeach
                </select>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Create Section</button>
            </form>

        </section>
    </section>

    <section class="grid-container">
        <section class="nested-grid-2 rajdhani-light">
            @php
                $totalLayouts = $layouts->count();
            @endphp

            @if ($totalLayouts > 0)
                @foreach ($layouts as $layout)
                    @php
                        $gridClass = $layout->gridlayoutcss;
                        $numberProducts = $layout->number_products;
                    @endphp
                    <article class="grid-item">

                        <!-- TEST TO REPLACE href BELOW
                        <a href="{{ route('section.edit', [
                                'gridlayoutcss' => $layout->gridlayoutcss,
                                'number_products' => $layout->number_products,
                            ]) }}" class="aisle-link"
                        >
                        -->

                        <a href="#" class="aisle-link">
                            {{ $layout->number_products }} PRODUCTS<br>
                            {{ $gridClass }}<br>
                            PROCEED TO NEST IN AISLE
                        </a>

                        <!-- Grid Layout Rendering -->                        
                        <section>
                            <div class="{{ $gridClass }}">
                                @for ($k = 1; $k <= $layout->number_products; $k++)
                                    <div class="grid-item nth-child-{{ $k }}">
                                        <h5 class="rajdhani-light">PRODUCT {{ $k }}</h5>
                                    </div>
                                @endfor
                            </div>
                        </section>
                    </article>
                @endforeach
            @else
                <p class="rajdhani-light">No Section Grid Layouts found... Run Seeder!!!.</p>
            @endif
        </section>
    </section>

</body>
</html>
