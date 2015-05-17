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
            window.location.href = 'service-center?state=' + state + '&city=' + city + '&page=' + {$previous};
        });

        $('#next-btn').click(function (e) {
            e.preventDefault();
            var state = $('#state').val();
            var city = $('#city').val();
            window.location.href = 'service-center?state=' + state + '&city=' + city + '&page=' + {$next};
        });
    });
</script>
<style>
    #serviceCenter-submit {
        padding-top: 15px;
    }

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

{capture name=path}{l s='Service Center'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<div class="main">
    <div class="main-inner">
        <div class="row-fluid show-grid">
            {if $themesdev.td_siderbar_without=="enable"}
                <div class="col-left sidebar span3">
                    {$HOOK_LEFT_COLUMN}
                    {$themesdev.td_left_sidebar_customhtml|html_entity_decode}

                </div>
            {/if}

            <div class="span9">
                <div class="page-title">
                    <h1>{l s='Service Center'}</h1>
                </div>
                <div class="row-fluid">
                    <form>
                        <div class="row-fluid">

                            <div class="span4">
                                <div class="control-group">
                                    <label for="state">{l s="State*"}</label>

                                    <div class="controls">
                                        <select name="state" id="state">
                                            <option value=''>Select State</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label for="city">{l s="City*"}</label>

                                    <div class="controls">
                                        <select name="city" id="city">
                                            <option value=''>Select City</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="span4">
                                <div class="control-group" id="serviceCenter-submit">

                                    <div class="controls">
                                        <button type="submit" class="button">
                                            <span><span>Submit</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                {if isset($serviceCentersResults) && count($serviceCentersResults)>0}
                    <div class="row-fluid" style="margin-bottom: 20px;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ASC Name</th>
                                <th>Contact Person</th>
                                <th>Contact Number</th>
                                <th>Email Id</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Address</th>

                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$serviceCentersResults key=stores item=i}
                                <tr>


                                    <td class="width-10">{$i['asc_name']}</td>
                                    <td class="width-10">{$i['contact_person']}</td>
                                    <td class="width-10">{$i['contact_number']}</td>
                                    <td><a href="mailto:{$i['emailid']}" target="_top">
                                            {$i['emailid']}</a></td>
                                    <td class="width-10">{$i['state']}</td>
                                    <td class="width-10">{$i['city']}</td>
                                    <td><a href="service-center-detail?id={$i['id_service_center']}">Detail</a></td>


                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                        <div class="page">
                            {if $previous>0}
                                <a class="prevButton" id="previous-btn">Prev</a>
                            {/if}
                            {if $next>0}
                                <a class="nextButton" id="next-btn">Next</a>
                            {/if}
                        </div>
                    </div>
                {/if}

            </div>
        </div>
    </div>
</div>

