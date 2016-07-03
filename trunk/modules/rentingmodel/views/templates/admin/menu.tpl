<style>

    .inline ul li{
        display: inline-block;
        width: 40px;
        background-color: white;
    }
    .inline ul li a{
        padding:10px;
        color: black;
        text-decoration: none;;
    }
</style>
<div class="container">
    <h2>Rent Products</h2>
    <ul class="nav nav-tabs inline">
        <li class="active " style="display: inline-block;padding: 10px;"><a data-toggle="tab" href="{$url}&tab_name=default">Default</a></li>
        <li style="display: inline-block;padding: 10px;"><a data-toggle="tab" href="{$url}&tab_name=view_app">View Application</a></li>
        <li style="display: inline-block;padding: 10px;"><a data-toggle="tab" href="{$url}&tab_name=add_rental">Add Rental</a></li>
        <li style="display: inline-block;padding: 10px;"><a data-toggle="tab" href="{$url}&tab_name=rental_products">View Products</a></li>
		<li style="display: inline-block;padding: 10px;"><a data-toggle="tab" href="{$url}&tab_name=product_cities">Add Cities</a></li>
    </ul>
</div>