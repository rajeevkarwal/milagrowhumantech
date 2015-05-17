<style>

    .serviceCenter-back{
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

    .serviceCenter-back:hover {
        color: white !important;
    }


</style>
{capture name=path}{l s='Service Center Detail'}{/capture}
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
                    <h1>{l s='Service Center Detail'}</h1>
                </div>
                {if isset($serviceCenterDetail) && !empty($serviceCenterDetail)}
                    <div class="row-fluid" style="margin-bottom: 20px;">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Detail</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td><strong>ASC Name</strong></td>
                                <td>{$serviceCenterDetail['asc_name']}</td>
                            </tr>
                            <tr>
                                <td><strong>Contact Person</strong></td>
                                <td>{$serviceCenterDetail['contact_person']}</td>
                            </tr>
                            <tr>
                                <td><strong>ASP Address</strong></td>
                                <td>{$serviceCenterDetail['asp_address']}</td>
                            </tr>
                            <tr>
                                <td><strong>State</strong></td>
                                <td>{$serviceCenterDetail['state']}</td>
                            </tr>
                            <tr>
                                <td><strong>City</strong></td>
                                <td>{$serviceCenterDetail['city']}</td>
                            </tr>
                            <tr>
                                <td><strong>Pin Code</strong></td>
                                <td>{$serviceCenterDetail['pincode']}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone Number</strong></td>
                                <td>{$serviceCenterDetail['contact_number']}</td>
                            </tr>

                            <tr>
                                <td><strong>Mobile Number</strong></td>
                                <td>{$serviceCenterDetail['mobile_number']}</td>
                            </tr>
                            <tr>
                                <td><strong>Email ID</strong></td>
                                <td><a href="mailto:{$serviceCenterDetail['emailid']}" target="_top">
                                        {$serviceCenterDetail['emailid']}</a></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="row-fluid">
                        <FORM><INPUT Type="button" class="serviceCenter-back" VALUE="Back" onClick="history.go(-1);return true;"></FORM>
                    </div>
                {else}
                    <div class="error">
                        <p>Sorry an error occured.Please go back and try again.</p>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>

