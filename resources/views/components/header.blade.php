<header class="rajdhani-regular">
<section class="header-container">
    <section class="rajdhani-regular">
        <nav class="menu">
            <a href="{{ route('home') }}" class="menu-option">[ HOME ]</a>
            <a href="{{ route('aisles.index') }}" class="menu-option">[ STORE FLOORPLAN ]</a>
        </nav>
        <nav class="menu">
        <a href="{{ route('section.create') }}" class="menu-option">[ NEW SECTION ]</a>
        <a href="{{ route('sections.orphaned') }}" class="menu-option">[ ORPHANED SECTIONS ]</a>
        </nav>
        <nav class="menu">
            <a href="#" class="menu-option">[ SEARCH->UPDATE/CLEAR PRODUCT ]</a>
        </nav>
    </section>
</section>
</header>


<!--

<header class="rajdhani-regular">
    <section class="header-container">
        <section class="rajdhani-light">
            <nav class="menu">
                <a href="#" class="menu-option {{ request()->is('new-aisle') ? 'active' : '' }}">[ NEW AISLE ]</a>
                <a href="#" class="menu-option {{ request()->is('new-section') ? 'active' : '' }}">[ NEW SECTION ]</a>
                <a href="#" class="menu-option {{ request()->is('new-product') ? 'active' : '' }}">[ NEW PRODUCT ]</a>
            </nav>
            <nav class="menu">
                <a href="#" class="menu-option {{ request()->is('search-aisle') ? 'active' : '' }}">[ SEARCH->UPDATE/DELETE AISLE ]</a>
                <a href="#" class="menu-option {{ request()->is('search-aisle-section') ? 'active' : '' }}">[ SEARCH->UPDATE/DELETE AISLE-SECTION ]</a>
                <a href="#" class="menu-option {{ request()->is('search-product') ? 'active' : '' }}">[ SEARCH->UPDATE/DELETE PRODUCT ]</a>
            </nav>
        </section>
    </section>
</header>


-->