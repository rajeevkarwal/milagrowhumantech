<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.theme.css"/>
<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.core.css"/>
<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.datepicker.css"/>
<script src="/js/jquery/ui/jquery.ui.core.min.js"></script>
<script src="/js/jquery/ui/jquery.ui.datepicker.min.js"></script>
<script src="{$module_dir}demo-back.js"></script>
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
            window.location.href = '{$url}&sl_tab=demoslist&fromDate=' + fromDate + '&toDate=' + toDate + '&page=' + {$previous};
        });

        $('#next-btn').click(function (e) {
            e.preventDefault();
            var fromDate = $('#dateFrom').val();
            var toDate = $('#dateTo').val();
            window.location.href = '{$url}&sl_tab=demoslist&fromDate=' + fromDate + '&toDate=' + toDate + '&page=' + {$next};
        });
    });
</script>
<fieldset style="margin-top:80px;">
    <legend>Demos Overview</legend>
    <form action="{$url}&sl_tab=demoslist" method="post">
        <fieldset id="fieldset_0">
            <legend>
                <img src="../img/admin/pdf.gif" alt="By date"> By date
            </legend>


            <label for="dateFrom">{l s="DateFrom*"}</label>

            <div class="margin-form">
                <input type="text" id="dateFrom" name="fromDate"
                       readonly
                       value="{if isset($fromDate)}{$fromDate|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>


                <sup>*</sup>


                <p class="preference_description">
                    Format: 2011-12-31 (inclusive)
                </p>

            </div>
            <div class="clear"></div>


            <label for="dateTo">{l s="ToDate*"}</label>

            <div class="margin-form">

                <input type="text" id="dateTo" name="toDate"
                       readonly
                       value="{if isset($toDate)}{$toDate|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>

                <sup>*</sup>


                <p class="preference_description">
                    Format: 2012-12-31 (inclusive)
                </p>

            </div>
            <div class="clear"></div>

            <div class="margin-form">
                <button type="submit" class="button">
                    <span><span>Submit</span></span>
            </div>

            <div class="small"><sup>*</sup> Required field</div>
        </fieldset>
    </form>
    {if isset($demosList) && count($demosList)>0}
        <div class="row-fluid" style="margin-bottom: 20px;">
            <table class="table">
                <thead>
                <tr>
                    <th>AMC Id</th>
                    <th>Product</th>
                    <th>Order Id</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Purchase Date</th>
                    <th>Name</th>
                    <th>Transaction No.</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Address</th>
                    <th>ZIP</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Payment Type</th>
                    <th>Special Comments</th>
                    <th>Add Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$demosList key=stores item=i}
                    <tr class="{$i['status']}">

                        <td>{$i['amc_id']}</td>
                        <td>{$i['product_name']}</td>
                        <td>{$i['order_id']}</td>
                        <td>{$i['amount']}</td>
                        <td>{$i['status']}</td>
                        <td>{$i['purchase_date']}</td>
                        <td>{$i['name']}</td>
                        <td>{$i['nb_order_no']}</td>
                        <td>{$i['state']}</td>
                        <td>{$i['city']}</td>
                        <td>{$i['address']}</td>
                        <td>{$i['zip']}</td>
                        <td>{$i['mobile']}</td>
                        <td><a href="mailto:{$i['email']}" target="_top">
                                {$i['email']}</a></td>
                        <td>{$i['payment_type']}</td>
                        <td>{$i['special_comments']}</td>
                        <td>{$i['created_at']}</td>
                        <td>
                            {if $i['status'] eq 'paid' || $i['status'] eq 'Paid'}
                                <a style="text-decoration:underline; color:#0000FF;" title="download receipt"
                                   href="{$url}&sl_tab=download_demo_receipt&demos_id={$i['demos_id']}" target="_blank"><img
                                            src="../img/admin/pdf.gif" alt="By date"></a>
                            {/if}
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
