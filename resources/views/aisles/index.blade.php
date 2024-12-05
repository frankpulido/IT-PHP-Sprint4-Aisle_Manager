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
            <article class="grid-item">

                <form method="POST" action="{{ url('aisles') }}">
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

            </article>

            <!-- SWAP SECTIONS -->
            <article class="grid-item">

            <form method="POST" action="{{ url('aisles') }}">
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

            </article>

        </section>
    </section>
    

    <section class="grid-container">
        <section class="nested-grid-8 rajdhani-light">

            @foreach ($aisles as $aisle)
                <article class="grid-item">

                    <a href="{{ url('aisles/' . $aisle->id) }}" class="aisle-link">
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
                                <button class="section-button assigned" data-section-id="{{ $section->id }}">
                                    Position: {{ $position }} nests 
                                    Section {{ $section->id }}<br>
                                    Kind: {{ $section->kind }}<br>
                                    Products: {{ $section->number_products }}
                                </button>
                            @else
                                <button class="section-button unassigned" data-position="{{ $position }}">
                                    Position: {{ $position }}<br>
                                    Unassigned
                                </button>
                            @endif
                        @endfor
                    </div>

                </article>
            @endforeach
            
        </section>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Example JS to handle button clicks
            document.querySelectorAll('.section-button').forEach(button => {
                button.addEventListener('click', function () {
                    const sectionId = this.dataset.sectionId;
                    const position = this.dataset.position;

                    if (sectionId) {
                        alert(`Section ${sectionId} clicked!`);
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