<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.theme.css"/>
<link rel="stylesheet" href="/js/jquery/ui/themes/base/jquery.ui.core.css"/>

<style>
.table {
margin-top:7%;
}

</style>
        <div class="row-fluid" style="margin-bottom: 20px;">
            <table class="table">
                <thead>
                <tr>
                    <th>Categoy Name</th>
                    <th>Product Name</th>
                    <th>Actions</th>
					<th>AMC</th>
					<th>Senior</th>
					<th>Student</th>
                </tr>
                </thead>
                 <tbody>
                {foreach from=$result key=stores item=i}
                    <tr class="">


                        <td>{$i['cat_name']}</td>
                        <td>{$i['prod_name']}</td>
						
						
						
						{if $i['is_del'] eq 1 }  
						<div class = "active">
						<td>
						 <a onclick="return confirm('Are you sure?') ? true : false;"
                               style="text-decoration:underline; color:#0000FF;"
                               href="{$url}&sd_tab=active_senior&id_active={$i['id']}">Active</a>
                        </td>
						</div>
						{/if}
						
						 {if $i['is_del'] eq 0 }
						<div class = "delete" >
						<td>
                               <a onclick="return confirm('Are you sure?') ? true : false;"
                               style="text-decoration:underline; color:#0000FF;"
                               href="{$url}&sd_tab=delete_senior&id_delete={$i['id']}">Delete</a>
                        </td>
						</div>
						{/if}
						
						<td>{$i['amc']}</td>
						<td>{$i['senior']}</td>
						<td>{$i['student']}</td>
                        </tr>
                {/foreach}
                </tbody>
            </table>
            
				
            </div>
       