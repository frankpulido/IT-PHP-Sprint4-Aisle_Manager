<!DOCTYPE html>
<html lang="en">

<?php $title = "Aisle Manager | Floor Plan"; ?>
@include('components.head')

<body>
    @include('components.header')
    <h1 class="rajdhani-light">AISLE MANAGER Project</h1>

    <section class="grid-container rajdhani-regular">
        <section class="nested-grid-home">

            <article class="grid-item">
                <h2>DESCRIPTION</h2>
                <h3 class="rajdhani-light">
                The deeper I get into this project the more compelling I find it.<br><br>
                Long ago I had the chance to work for the marketing department of a FMCG category leader supplier. Most of my time was dedicated to the design of push/pull promotions for a temporary turnover boost in any target channel and performing the latter analysis of the marginal contribution of each involved SKU to the operating revenue of my product category… But most factors affecting the outcomes were unknown to us which made the business intelligence a cumulus of assumptions… <br><br>
                In this project I go all the way upstream to the place where the action takes place : The anonymous client taking a cart and pushing it through the aisles layout, grabbing and dropping stuff in it.<br><br>
                The store consists on a layout of Aisles (unlikely to be modified once the store opens to the public), each "Aisle" nesting a collection of "Sections". Each section has its particular arrangement of a set of products of the same "Kind".<br><br>
                The starring actor in this first stage of the Project is the SECTION, seen as a business unit. Objective : boosting its individual annual revenue.<br><br>
                This project stage consists on mapping the grocery store (aisles and sections within aisles) and providing a GUI toolset for the Merchandising Department to study the best allocation of Sections and Products within each section for that purpose. In addition to that, some KPIs will be displayed to help different stockholders keeping track of them.<br><br>
                KPIs : annual revenue, turnover, stockouts.<br><br>
                Stakeholders : Merchandising (Section Managers), Inbound Logistics, Marketing, Stockers, Accounting (LIFO - FIFO).<br><br>
                I only represented one store, but I intend to scale it to have all stores of the chain. The stock levels will be tracked for  backstores (located in each store, where stockers undertake continuous replenishment of shelves) as well as for the central warehouse in the area supplying a set of stores.<br><br>
                To help decision-making :<br><br>
                1- GUI : A FLOORPLAN of the Store mapping Aisles and Sections. Also the allocation of Products on the shelves of each section, allocated shelf height and shelf width.<br><br>
                The content of adjoining sections and location of daily-consumed products (toilet paper, oil, water, coffee) drives shopping trolleys traffic through the store and has an impact of the annual revenue of each Section.<br><br>
                2- <b>VIRTUAL TOURS : </b>A 360 panorama can be opened from any AISLE position within the FLOORPLAN. From his office, an Aisle (or Section) Manager can jump into the store and give a virtual walk through the aisles.<br><br>
                3- To better tracking of the results of each configuration, the order-items table (future development) will store not only a set of product_id’s sold, product_prices’s, and quantities sold but also the exact location of each product in the order for the date it took place (aisle, position of section within aisle, 2D position of product in section).<br><br>
                We will be able to track the daily revenue of each section and the share coming from each of its products.<br><br>
                The project will eventually evolve into a Publisher / Listener model to display different dashboards according to the user (stockholder) profile and send them alerts.<br><br>
                </h3>

                <h2>[ SOME REFERENCES ]</h2>
                <h3><a href="https://www.sciencedirect.com/science/article/abs/pii/S0377221719307520" class="rajdhani-light" target="_blank" style="text-decoration:none; color:inherit;">"A practical approach to the shelf-space allocation and replenishment problem with heterogeneously sized shelves".<br>Authors : Tobias Düsterhöft, Alexander Hübner, Kai Schaal.</a></h3>
                <h3><a href="https://www.relexsolutions.com/resources/automatic-replenishment-optimization/" class="rajdhani-light" target="_blank" style="text-decoration:none; color:inherit;">"Unlock profitability with replenishment optimization".<br>Author : Alex Jobin.</a></h3>
                <h3><a href="https://www.marktpos.com/blog/what-is-a-good-inventory-turnover-rate-for-grocery-stores" class="rajdhani-light" target="_blank" style="text-decoration:none; color:inherit;">"What Is a Good Inventory Turnover Ratio for Grocery Stores?.<br>Source : Markt POS Blog.</a></h3>
                <h3><a href="https://www.breadcrumbdata.com/solutions/supermarkets/trolley-tracking-increase-profits" class="rajdhani-light" target="_blank" style="text-decoration:none; color:inherit;">"Trolley Tracking Increases Profit | Breadcrum".<br>Source : Breadcrum website.</a></h3>
            </article>

            <article class="grid-item">
                <h2>ENTITY RELATIONSHIP DIAGRAM | The shadowed area indicates the scope of this first stage of the Project.</h2>
                <img src="{{asset('images/edr.png')}}" alt="EDR Aisle Manager">
                <br>
                <h2>NAVIGATION</h2>
                <h3 class="rajdhani-light">
                <b>FLOORPLAN (/aisles/index.blade.php) :</b><br><br>
                The best point of start. Represents the layout of the store. The floorplan is unlikely to chang along time and it's built using Aisle Model : an empty scheleton that nests Sections. Each Aisle is displayed in a column with its nested sections below... <br>
                Hover the mouse over an Aisle and its annual revenue is shown (Sections total). Hover it over a Section and its individual annual revenue will be shown. <br>
                Clicking on an Aisle : Opens <b>Aisle View</b> similar view with columns representing each Section and the products displayed in them.<br>
                Clicking on a nested Section : Opens the <b>Section View</b>. Displays Section Layout. Links to <b>Section Edit View</b>.<br>
                Clicking on an available space for a Section : Opens a <b>Create View</b> that leads you to the process of Section Create for that specific position within thas specific Aisle.<br><br>
                <b>AISLE VIEW (/aisles/show.blade.php) :</b><br><br>
                Maps Aisle's collection of nested Sections the same way the FLOORPLAN maps the Aisles. In this view the Sections are column heads with a grid representation of how products are displayed inside it. Below, the list of products pertaining to the section.<br>
                Hover on the Section and get the total annual revenue again (as in the FloorPlan view).<br>
                Click on a product an get relevant product info.<br>
                Click on the Section Column head and go to the <b>Section View</b>.<br><br>
                <b>SECTION VIEW (/sections/show.blade.php) :</b><br><br>
                It has 3 containers on a row. On the left a link to <br>Section Edit<br> and the layout showing how the products are displayed within.In the middle the list of products kith their KPI's. On the right a spaced to be used for displaying <br>Product KPI's INFO<br> when clicking on a Product. (future development) <br>
                </h3>
                <h2>ORPHANED SECTIONS (/sections/orphaned.blade.php)</h2>
                <h3 class="rajdhani-light">
                I consider this is an important tool for the App. It allows the user to explore product allocation possiblities and create sections NOT nested in the Aisles playing with different product layouts... When the user decides for a change the "orphaned" Section is swapped with the existing Section which becomes the "orphaned".
                <br>
                </h3>
                <h2>FUTURE DEVELOPMENT</h2>
                <h3 class="rajdhani-light">
                ORPHANED DUPLICATION : New functionality to duplicate an orphan and make a variant
                TABLE ORDER_ITEMS : 
                SECTION GRIDLAYOUT BUILDER : Product allocation layouts for Section.<br>
                KPIs PANEL IN SECTION VIEW : Fed from API<br>
                PANORAMAS : UPLOADING 360 PHOTOS - VIRTUAL TOUR<br>
                INBOUND LOGISTICS MANAGER (AN APP LINKED TO THIS ONE) : Order Point / Order Quantity -> Based on Delivery Time of Suppliers, Seasonality and Supplier's forecasting (PULL promotions).<br>
                <a href="../../public/images/ERD_Stock_API.png" class="rajdhani-light" target="_blank">CLICK TO OPEN SCHEMA</a><br>
                </h3>
            </article>

        </section>
    </section>
</body>
</html>

