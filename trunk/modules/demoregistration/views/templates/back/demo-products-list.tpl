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
    function changeDemoStatus(demoProductId,action)
    {
        var result=confirm('Are you sure want to change status');

        if(result)
        {
            $.ajax({
                url: "/modules/demoregistration/demoregistrationajax.php?action="+action+"&secureKey=345768&action_type=1&demo_id="+demoProductId,
                type: "GET",
                success: function(data)
                {
                    var result= $.trim(data);
                    if (result=='success')
                    {
                        alert('status changed successfully!!');
                        window.location.reload();
                    }
                    else
                    {
                        alert('sorry error occured while changing the status');
                        window.location.reload();
                    }
                }
            });
        }

    };

    $(document).ready(function () {
        $('#previous-btn').click(function (e) {
            e.preventDefault();
            window.location.href = '{$url}&sl_tab=list_demo_products&page=' + {$previous};
        });

        $('#next-btn').click(function (e) {
            e.preventDefault();
            window.location.href = '{$url}&sl_tab=list_demo_products&page=' + {$next};
        });
    });
</script>
<fieldset style="margin-top:80px;">
    <legend>Demo Products</legend>
    {if isset($demosList) && count($demosList)>0}
        <div class="row-fluid" style="margin-bottom: 20px;">
            <table class="table">
                <thead>
                <tr>
                    <th>Demo Product Id</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$demosList key=stores item=i}
                    <tr class="{$i['status']}">

                        <td>{$i['id']}</td>
                        <td>{$i['product']}</td>
                        <td>{$i['category']}</td>
                        <td>
                            <a style="text-decoration:underline; cursor:pointer; color:#0000FF;"
                               href="{$url}&sl_tab=edit_demo_products&demoproduct_id={$i['id']}">Manage Cities</a>
                            <span>||</span>
                            {if $i['is_active'] eq '1'}
                                <a style="text-decoration:underline;cursor:pointer; color:#0000FF;" onclick="changeDemoStatus({$i['id']},2)">Deactivate</a>
                                {else}
                                <a style="text-decoration:underline;cursor:pointer; color:#0000FF;" onclick="changeDemoStatus({$i['id']},1)">Activate</a>
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
