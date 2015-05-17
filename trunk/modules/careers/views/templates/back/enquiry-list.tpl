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
            window.location.href = '{$url}&cc_tab=querieslist&fromDate=' + fromDate + '&toDate=' + toDate + '&page=' + {$previous};
        });

        $('#next-btn').click(function (e) {
            e.preventDefault();
            var fromDate = $('#dateFrom').val();
            var toDate = $('#dateTo').val();
            window.location.href = '{$url}&cc_tab=querieslist&fromDate=' + fromDate + '&toDate=' + toDate + '&page=' + {$next};
        });
    });
</script>
<fieldset style="margin-top:80px;">
    <legend>Queries Overview</legend>
    <form action="{$url}&cc_tab=querieslist" method="post">
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
                <button type="submit" class="button">
                    <span><span>Submit</span></span>
            </div>

            <div class="small"><sup>*</sup> Required field</div>
        </fieldset>
    </form>
    {if isset($queriesList) && count($queriesList)>0}
        <div class="row-fluid" style="margin-bottom: 20px;">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>phone</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Address</th>
                    <th>Department</th>
                    <th>Education</th>
                    <th>Professional</th>
                    <th>Skill</th>
                    <th>Career Highlights</th>
                    <th>Work Experience</th>
                    <th>Date</th>
                    <th>View</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$queriesList key=stores item=i}
                    <tr class="">


                        <td>{$i['name']}</td>
                        <td>{$i['email']}</td>
                        <td>{$i['dob']}</td>
                        <td>{$i['phone']}</td>
                        <td>{$i['city']}</td>
                        <td>{$i['state']}</td>
                        <td>{$i['address']}</td>
                        <td>{$i['department']}</td>
                        <td>{$i['education']}</td>
                        <td>{$i['professional']}</td>
                        <td>{$i['skill']}</td>
                        <td>{$i['career_highlights']}</td>
                        <td>{$i['work_experience']}</td>
                        <td>{$i['created_at']}</td>
                        <td>
                            {if !empty($i['resume_file'])}
                                <a target="_blank" style="text-decoration:underline; color:#0000FF;"
                                   href="/upload/resume/{$i['resume_file']}">
                                    view
                                </a>
                            {/if}
                        </td>
                        <td>
                            <a onclick="return confirm('Are you sure?') ? true : false;"
                               style="text-decoration:underline; color:#0000FF;"
                               href="{$url}&cc_tab=delete_query&id_query={$i['id_careers']}">Delete</a>
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
