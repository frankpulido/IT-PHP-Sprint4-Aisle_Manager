<!DOCTYPE html>
<html lang="en">

<?php $title = "Aisle Manager | Floor Plan"; ?>
@include('components.head')

<body>
    @include('components.header')
    <h1 class="rajdhani-light">FLOORPLAN of the grocery store</h1>
    <?php //echo $aisles ?>

    <!-- Swap Forms -->
    <section class="grid-container">
        <section class="nested-grid-2 rajdhani-light">

            <!-- SWAP AISLES -->
            <section class="grid-item">

                <form method="POST" action="{{ route('aisles.swap') }}">
                    @csrf
                    <label for="aisle1">Select Aisle 1:</label>
                    <select name="aisle1" id="aisle1" class="swap-dropdown">
                        <option value="" disabled selected>Choose Aisle 1</option>
                        @foreach ($aisles as $aisle)
                            <option value="{{ $aisle->id }}">{{ $aisle->name }}</option>
                        @endforeach
                    </select>

                    <label for="aisle2">Select Aisle 2:</label>
                    <select name="aisle2" id="aisle2" class="swap-dropdown">
                        <option value="" disabled selected>Choose Aisle 2</option>
                        @foreach ($aisles as $aisle)
                            <option value="{{ $aisle->id }}">{{ $aisle->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">Swap Aisles</button>
                </form>

            </section>

            <!-- SWAP SECTIONS -->
            <section class="grid-item">

            <form method="POST" action="{{ route('sections.swap') }}">
                @csrf
                <label for="section1">Select Section 1:</label>
                <select name="section1" id="section1" class="swap-dropdown">
                    <option value="" disabled selected>Choose Section 1</option>
                    @foreach ($aisles as $aisle)
                        @foreach ($aisle->sections as $section)
                            <option value="{{ $aisle->id . ',' . $section->aisle_order }}">
                                {{ $aisle->name }} - Position {{ $section->aisle_order }}
                            </option>
                        @endforeach
                    @endforeach
                </select>

                <label for="section2">Select Section 2:</label>
                <select name="section2" id="section2" class="swap-dropdown">
                    <option value="" disabled selected>Choose Section 2</option>
                    @foreach ($aisles as $aisle)
                        @foreach ($aisle->sections as $section)
                            <option value="{{ $aisle->id . ',' . $section->aisle_order }}">
                                {{ $aisle->name }} - Position {{ $section->aisle_order }}
                            </option>
                        @endforeach
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Swap Sections</button>
            </form>

            </section>

        </section>
    </section>


    <section class="grid-container">
        <section class="nested-grid-8 rajdhani-light">

            @foreach ($aisles as $aisle)
                @php
                    // Calculate total revenue for the aisle by summing all section revenues
                    $totalRevenue = $aisle->sections->sum(function ($section) {
                        return $section->products->sum('revenues_year');
                    });
                @endphp 

                <article class="grid-item">

                    <a href="{{ url('aisles/' . $aisle->id) }}" class="aisle-link" data-total-revenue="{{ $totalRevenue }}">
                        AISLE ID : {{ $aisle->id }} | NAME: {{ $aisle->name }}
                    </a>

                    <div class="sections">
                        @php
                            $totalPositions = $aisle->number_sections;
                            $sections = $aisle->sections->keyBy('aisle_order'); // Organize by order for quick lookup
                        @endphp

                        @for ($position = 1; $position <= $totalPositions; $position++)
                            @if ($sections->has($position))
                                @php $section = $sections[$position]; @endphp
                                @php $totalRevenue = $section->products->sum('revenues_year'); @endphp
                                <a href="{{ url('section/' . $section->id) }}" class="section-button assigned" data-total-revenue="{{ $totalRevenue }}">
                                    Section ID: {{ $section->id }} | Position {{ $position }}<br>
                                    Kind: {{ $section->kind }}<br>
                                    Products: {{ $section->number_products }}
                                </a>
                                <!--
                                <button class="section-button assigned" data-section-id="{{ $section->id }}">
                                    Position: {{ $position }} nests 
                                    Section {{ $section->id }}<br>
                                    Kind: {{ $section->kind }}<br>
                                    Products: {{ $section->number_products }}
                                </button>
                                -->
                            @else
                                <a href="#" class="section-button unassigned">
                                    Position: {{ $position }}<br>
                                    Section Unassigned<br>
                                    Products: {{ $section->number_products }}
                                </a>
                                <!--
                                <button class="section-button unassigned" data-position="{{ $position }}">
                                    Position: {{ $position }}<br>
                                    Section Unassigned<br>
                                    Products: {{ $section->number_products }}
                                </button>
                                -->
                            @endif
                        @endfor
                    </div>

                </article>
            @endforeach
            
        </section>
    </section>

    <script>
        /* SECTION BUTTONS */
        document.addEventListener('DOMContentLoaded', function () {
            // Add hover logic for aisle links
            document.querySelectorAll('.aisle-link').forEach(link => {
                link.addEventListener('mouseenter', function () {
                    const totalRevenue = this.getAttribute('data-total-revenue');
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip rajdhani-light';
                    tooltip.textContent = `Total Aisle Revenue: $${new Intl.NumberFormat('en-US', {
                        style: 'decimal',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(totalRevenue)}`;
                    tooltip.style.position = 'absolute';
                    tooltip.style.backgroundColor = '#333';
                    tooltip.style.color = '#fff';
                    tooltip.style.padding = '5px';
                    tooltip.style.borderRadius = '5px';
                    tooltip.style.zIndex = '1000';
                    tooltip.style.top = `${this.getBoundingClientRect().top - 30}px`;
                    tooltip.style.left = `${this.getBoundingClientRect().left}px`;
                    tooltip.id = 'aisle-tooltip';
                    document.body.appendChild(tooltip);
                });

                link.addEventListener('mouseleave', function () {
                    const tooltip = document.getElementById('aisle-tooltip');
                    if (tooltip) tooltip.remove();
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.section-button.assigned').forEach(link => {
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



        document.addEventListener('DOMContentLoaded', function () {
            // Example JS to handle button clicks
            document.querySelectorAll('.section-button').forEach(button => {
                button.addEventListener('click', function () {
                    const sectionId = this.dataset.sectionId;
                    const position = this.dataset.position;

                    if (sectionId) {
                        alert(`Section ${sectionId} clicked!`)
                        // Open assigned section menu (e.g., view, reassign, delete)
                    } else if (position) {
                        alert(`Unassigned position ${position} clicked!`);
                        // Open unassigned section menu (e.g., assign a section)
                    }
                });
            });
        });
    </script>

</body>
</html>