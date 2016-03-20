<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.theme.css"/>
<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.core.css"/>
<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.datepicker.css"/>
<script src="/js/jquery/ui/jquery.ui.core.min.js"></script>
<script src="/js/jquery/ui/jquery.ui.datepicker.min.js"></script>
<script src="{$module_dir}enquiry-back.js"></script>
<style>
    a.nextButton, a.prevButton {
        overflow: visible;
        width: auto;
        border: 0;
        padding: 0;
        margin: 0;
        background: transparent;
        cursor: pointer;
        background: #ffa930;
        color: white;
        padding: 7px;
    }

    a.nextButton:hover, a.prevButton:hover {
        color: white !important;
    }

    .paid {
        background-color: lightgreen;
    }

</style>
<script>
    $(document).ready(function () {
        $('#previous-btn').click(function (e) {
            e.preventDefault();
            var fromDate = $('#dateFrom').val();
            var toDate = $('#dateTo').val();
            window.location.href = '{$url}&sd_tab=querieslist&fromDate=' + fromDate + '&toDate=' + toDate + '&page=' + {$previous};
        });

        $('#next-btn').click(function (e) {
            e.preventDefault();
            var fromDate = $('#dateFrom').val();
            var toDate = $('#dateTo').val();
            window.location.href = '{$url}&sd_tab=querieslist&fromDate=' + fromDate + '&toDate=' + toDate + '&page=' + {$next};
        });
    });
</script>
<fieldset style="margin-top:80px;">
    <legend>DAMC Products List</legend>
    {*<form action="{$url}&sd_tab=querieslist" method="post">*}
        {*<fieldset id="fieldset_0">*}
            {*<legend>*}
                {*<img src="../img/admin/excel_file.png" alt="By date"> By date*}
            {*</legend>*}


            {*<label for="dateFrom">{l s="DateFrom*"}</label>*}

            {*<div class="margin-form">*}
                {*<input type="text" id="dateFrom" name="fromDate"*}
                       {*readonly*}
                       {*value="{if isset($fromDate)}{$fromDate|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>*}


                {*<sup>*</sup>*}


                {*<p class="preference_description">*}
                    {*Format: 2011-12-31 (inclusive)*}
                {*</p>*}

            {*</div>*}
            {*<div class="clear"></div>*}


            {*<label for="dateTo">{l s="ToDate*"}</label>*}

            {*<div class="margin-form">*}

                {*<input type="text" id="dateTo" name="toDate"*}
                       {*readonly*}
                       {*value="{if isset($toDate)}{$toDate|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>*}

                {*<sup>*</sup>*}


                {*<p class="preference_description">*}
                    {*Format: 2012-12-31 (inclusive)*}
                {*</p>*}

            {*</div>*}
            {*<div class="clear"></div>*}

            {*<div class="margin-form">*}
                {*<button type="submit" class="button">*}
                    {*<span><span>Submit</span></span>*}
            {*</div>*}

            {*<div class="small"><sup>*</sup> Required field</div>*}
        {*</fieldset>*}
    {*</form>*}
    {if isset($queriesList) && count($queriesList)>0}
        <div class="row-fluid" style="margin-bottom: 20px;">
            <table class="table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Is Senior Active</th>
                    <th>Is Senior Discount %/Rs. Wise</th>
                    <th>Senior %/Rs.</th>
                    <th>Is Student Active</th>
                    <th>Is Student Discount %/Rs. Wise</th>
                    <th>Student %/Rs.</th>
                    <th>Is AMC Active</th>
                    <th>AMC Details</th>
                    <th>Date</th>

                </tr>
                </thead>
                <tbody>
                {foreach from=$queriesList key=stores item=i}
                    <tr class="">


                        <td>{$i['productName']}</td>
                        <td>{$i['categoryName']}</td>
                        <td>{$i['is_senior_active']}</td>
                        <td>{if $i['is_senioramtper']==1}
                                Amount Wise
                            {else}
                                Percentage Wise
                            {/if}
                        </td>
                        <td>{$i['senioramt']}</td>
                        <td>{$i['is_student_active']}</td>
                        <td>{if $i['is_studentamtper']==1}
                                Amount Wise
                            {else}
                                Percentage Wise
                            {/if}
                        </td>
                        <td>{$i['studentamt']}</td>
                        <td>{$i['is_amc_active']}</td>
                        <td>

                            <table>
                                <tr>
                                    <th>Period</th>
                                    <th>Percentage</th>
                                </tr>
                                {$amcDetail=$i['amcData']}
                                {foreach from=$amcDetail key=amcPeriodId item=j}
                                    <tr>
                                        <td>{$j['period']}</td>
                                        <td>{$j['amc_percentage']}</td>
                                    </tr>
                                {/foreach}
                            </table>

                        </td>
                        <td>{$i['created_at']}</td>
                        <td>
                            {*<a onclick="return confirm('Are you sure?') ? true : false;"*}
                               {*style="text-decoration:underline; color:#0000FF;"*}
                               {*href="{$url}&sd_tab=delete_query&id_query={$i['id_senior_discount']}">Delete</a>*}
                            <a href="{$url}&sd_tab=edit_damc_products&damc_id={$i['id']}">Edit</a>
                        </td>

                    </tr>
                {/foreach}
                </tbody>
            </table>
            <div class="page" style="margin-top: 20px;">
                {if $previous>0}
                    <a class="prevButton" id="previous-btn">Prev</a>
                {/if}
                {if $next>0}
                    <a class="nextButton" id="next-btn">Next</a>
                {/if}
            </div>
        </div>
    {else}
        No Result Found
    {/if}
</fieldset>
