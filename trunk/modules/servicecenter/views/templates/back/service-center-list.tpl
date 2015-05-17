<script type="text/javascript">

    function updateCities(stateAndCityMapping, selectedState) {
        var option = '<option value="">Select City</option>';
        if (selectedState) {
            $.each(stateAndCityMapping[selectedState], function (i, el) {
                if (el)
                    option += '<option value="' + el + '">' + el + '</option>'
            });
            $('#city').removeAttr('disabled');
        }
        else {
            var disabledObj = new Object();
            disabledObj.disabled = 'disabled';
            $('#city').attr(disabledObj);
        }
        $('#city')
                .find('option')
                .remove()
                .end()
                .append(option);
    }
    $(document).ready(function () {
        var stateAndCityMapping = {$stateCityMapping};
        console.log(stateAndCityMapping);
        var option = '<option value="">Select State</option>';
        $.each(stateAndCityMapping, function (i, el) {
            option += '<option value="' + i + '">' + i + '</option>'
        });
        $('#state')
                .find('option')
                .remove()
                .end()
                .append(option);

        var disabledObj = new Object();
        disabledObj.disabled = 'disabled';
        $('#city').attr(disabledObj);

        $('#state').change(function () {
            var selectedState = $(this).val();
            updateCities(stateAndCityMapping, selectedState);
        });

        {if isset($selectedState) && !empty($selectedState)}
        $('#state').val('{$selectedState}');
        updateCities(stateAndCityMapping, '{$selectedState}');
        {/if}
        {if isset($selectedCity) && !empty($selectedCity)}
        $('#city').val('{$selectedCity}');
        {/if}

        $('#previous-btn').click(function (e) {
            e.preventDefault();
            var state = $('#state').val();
            var city = $('#city').val();
            window.location.href = '{$url}&sl_tab=servicecenterlist&state=' + state + '&city=' + city + '&page=' + {$previous};
        });

        $('#next-btn').click(function (e) {
            e.preventDefault();
            var state = $('#state').val();
            var city = $('#city').val();
            window.location.href = '{$url}&sl_tab=servicecenterlist&state=' + state + '&city=' + city + '&page=' + {$next};
        });
    });
</script>
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

    .width-10 {
        width: 12% !important;
    }
</style>
<fieldset style="margin-top:80px;">
    <legend>Store Centers Overview</legend>
    {if isset($serviceCentersResults) && count($serviceCentersResults)>0}
        <form action="{$url}&sl_tab=servicecenterlist" method="post">

            <div class="row-fluid">

                <div class="span3">
                    <div class="control-group">
                        <label for="state">{l s="State*"}</label>

                        <div class="controls">
                            <select name="state" id="state">
                                <option value=''>Select State</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="span3">
                    <div class="control-group">
                        <label for="city">{l s="City*"}</label>

                        <div class="controls">
                            <select name="city" id="city">
                                <option value=''>Select City</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="span3">
                    <div class="control-group" id="storeLocator-submit">
                        <label>&nbsp;</label>

                        <div class="controls">
                            <button type="submit" class="button">
                                <span><span>Submit</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row-fluid" style="margin-bottom: 20px;">
            <table class="table">
                <thead>
                <tr>
                    <th>ASC Name</th>
                    <th>Contact Person</th>
                    <th>Contact Number</th>
                    <th>Mobile Number</th>
                    <th>Email Id</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Pin Code</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$serviceCentersResults key=stores item=i}
                    <tr>


                        <td class="width-10">{$i['asc_name']}</td>
                        <td class="width-10">{$i['contact_person']}</td>
                        <td class="width-10">{$i['contact_number']}</td>
                        <td class="width-10">{$i['mobile_number']}</td>
                        <td><a href="mailto:{$i['emailid']}" target="_top">
                                {$i['emailid']}</a></td>
                        <td class="width-10">{$i['state']}</td>
                        <td class="width-10">{$i['city']}</td>
                        <td class="width-10">{$i['pincode']}</td>
                        <td class="width-10">{$i['asp_address']}</td>
                        <td>
                            <a style="text-decoration:underline; color:#0000FF;"
                               href="{$url}'&sl_tab=edit_service_center&id_service_center={$i['id_service_center']}">Edit</a>
                            | <a onclick="return confirm('Are you sure?') ? true : false;"
                                 style="text-decoration:underline; color:#0000FF;"
                                 href="{$url}'&sl_tab=delete_service_center&id_service_center={$i['id_service_center']}">Delete</a>
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
