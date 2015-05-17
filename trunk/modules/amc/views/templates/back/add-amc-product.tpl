<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.theme.css"/>
<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.core.css"/>
<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.datepicker.css"/>
<script src="/js/jquery/ui/jquery.ui.core.min.js"></script>
<script src="/js/jquery/ui/jquery.ui.datepicker.min.js"></script>
<script src="{$module_dir}demo-back.js"></script>
<script>
    $(document).ready(function () {
        $('#download_receipts').click(function (e) {
            e.preventDefault();
            var fromDate = $('#dateFrom').val();
            var toDate = $('#dateTo').val();
            window.location.href = '{$url}&sl_tab=bulk_download_receipts&generateReceipts=1&fromDate=' + fromDate + '&toDate=' + toDate;
        });

         $('#category').change(function(){
              var productdata = new Array();
              productdata={$products};

             var selectedCategory = $('#category option:selected').val();

                var products = '';
               products +=  '<option value="">Select Product</option>';
               for(var i=0;i< productdata['id_category'].length;i++){
                 var category = productdata['id_category'];
                 if(category == selectedCategory){
                     products +=  '<option value="' + city[i] + '">' + city[i] + '</option>';
                 }
             }
             $('#product').html(products);

    });
</script>
<fieldset style="margin-top:80px;">
    <legend>Add AMC product</legend>
           <fieldset id="fieldset_0">
            <legend>
                <img src="../img/admin/pdf.gif" alt="By date"> By date
            </legend>
            <label for="category">{l s="Select Category *"}</label>

            <div class="margin-form">
                <select name="category" id="category">
                   {foreach $categories as $category}
                        <option id="{$category.category_id}" value="{$category.category_id}">{$category.category_name}</option>
                   {/foreach}
                </select>
                <sup>*</sup>
           </div>
            <div class="clear"></div>
<pre>{{$products}}<pre>

            <label for="product">{l s="Select Model *"}</label>
            <div class="margin-form">
                   <select name="product" id="product">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                <sup>*</sup>
            </div>
            <div class="clear"></div>

            <label for="maintenanceCost">{l s="Maintenance Cost *"}</label>
            <div class="margin-form">
                <input type="text" id="maintenanceCost" name="maintenanceCost" value="{if isset($toDate)}{$toDate|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                <sup>*</sup>
            </div>
            <div class="clear"></div>

            <label for="duration">{l s="Duration *"}</label>
            <div class="margin-form">
                 <select name="duration">
                        <option>1</option><option>2</option><option>3</option>
                        <option>4</option><option>5</option><option>6</option>
                        <option>7</option><option>8</option><option>9</option><option>10</option>
                 </select> Years
                <sup>*</sup>
            </div>
            <div class="clear"></div>

            <div class="margin-form">
                <button type="submit" class="button" id="Save" name="Save" value="1">Save</button>
            </div>

            <div class="small"><sup>*</sup> Required field</div>
        </fieldset>
</fieldset>
