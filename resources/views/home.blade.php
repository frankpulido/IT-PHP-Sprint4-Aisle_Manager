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
                Long ago I had the chance to work for the marketing department of a FMCG category leader supplier. Most of my time was dedicated to the design of push/pull promotions for a temporary turnover boost in any target channel and performing the latter analysis of the marginal contribution of each SKU involved to the operating revenue of my product category… But most factors affecting the outcomes were unknown to us which made the business intelligence a cumulus of assumptions… <br><br>
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
                <h3>ENTITY RELATIONSHIP DIAGRAM | The shadowed area indicates the scope of this first stage of the Project.</h3>
            </article>

        </section>
    </section>
</body>
</html>

