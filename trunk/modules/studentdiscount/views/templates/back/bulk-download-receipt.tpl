<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.theme.css"/>
<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.core.css"/>
<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.datepicker.css"/>
<script src="/js/jquery/ui/jquery.ui.core.min.js"></script>
<script src="/js/jquery/ui/jquery.ui.datepicker.min.js"></script>
<script src="{$module_dir}enquiry-back.js"></script>
<script>
    $(document).ready(function () {
        $('#download_queries').click(function (e) {
            e.preventDefault();
            var fromDate = $('#dateFrom').val();
            var toDate = $('#dateTo').val();
            window.location.href = '{$url}&sd_tab=bulk_download_queries&generateQueries=1&fromDate=' + fromDate + '&toDate=' + toDate;
        });

    });
</script>
<fieldset style="margin-top:80px;">
    <legend>Download Queries</legend>
    <fieldset id="fieldset_0">
        <legend>
            <img src="../img/admin/excel_file.png" alt="By date"> By date
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
            <button type="submit" class="button" id="download_queries" name="generateQueries" value="1">
                Download
            </button>
        </div>

        <div class="small"><sup>*</sup> Required field</div>
    </fieldset>
</fieldset>
