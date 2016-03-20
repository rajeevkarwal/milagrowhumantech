<script>
    var productList = {$finprolist}
            var amcCount={$productDetail['amcDataCount']};
            function getid(selectedProduct) {
                var e = document.getElementById('category');
                var cate = e.options[e.selectedIndex].value;
                $('#product')
                        .find('option')
                        .remove()
                        .end()
                var check = productList[cate];
                var opt = $('<option value="">--select--</option>');
                $('#product').append(opt);
                var elm = document.getElementById('product'),
                        df = document.createDocumentFragment();
                for (var i = 0; i < check.length; i++) {
                    var option = document.createElement('option');
                    option.value = check[i]['id_product'];
                    option.appendChild(document.createTextNode(" " + check[i]['product_name']));
                    df.appendChild(option)

                }
                elm.appendChild(df);

                if(selectedProduct)
                {
                    $('#product').val(selectedProduct);
                }

            };


    function deletePeriod(periodId)
    {
        var result=confirm('Are you sure want to delete');

        if(result)
        {
            $.ajax({
                url: "/modules/damcproducts/damcajax.php?action=del&secureKey=345768&period_id="+periodId,
                type: "GET",
                success: function(data)
                {
                    if (data=='success')
                    {
                        alert('period deleted');
                        $('#period_row_'+periodId).hide();
                        amcCount=amcCount-1;
                    }
                    else
                    {
                        alert('sorry error occured while deleting');
                    }
                }
            });
        }

    };

    $(document).ready(function () {

        {if $productDetail['categoryID']!=''}
            getid({$productDetail['productID']});
        {/if}


        $('input[name=amc]:checkbox').change(function () {
            if ($(this).is(":checked")) {
                $('.showAMCBlock').show();
            }
            else {
                $('.showAMCBlock').hide();
            }
        });

        $('input[name=student]:checkbox').change(function () {
            if ($(this).is(":checked")) {
                $('.showStudentBlock').show();
            }
            else {
                $('.showStudentBlock').hide();
            }
        });

        $('input[name=senior]:checkbox').change(function () {
            if ($(this).is(":checked")) {
                $('.showSeniorBlock').show();
            }
            else {
                $('.showSeniorBlock').hide();
            }
        });

        $('#damcProductForm').submit(function (e) {
            var selectedCategory = $('#category option:selected').val();
            var selectedProduct = $('#product option:selected').val();
            var seniorState = $('input[name=senior]:checkbox').is(':checked');
            var amcState = $('input[name=amc]:checkbox').is(':checked');
            var studentState = $('input[name=student]:checkbox').is(':checked');

            if (selectedCategory == '') {
                e.preventDefault();
                alert('Please select any category');
                return;
            }
            if (selectedProduct == '') {
                e.preventDefault();
                alert('Please select any product');
                return;
            }
            if (!seniorState && !amcState && !studentState) {
                e.preventDefault();
                alert('Please select at least one form to which this product is active');
                return;
            }

            if (amcState) {
                if(amcCount==0)
                {

                    var selectedPeriod = $('#amcperiod option:selected').val();
                    if (selectedPeriod == '') {
                        e.preventDefault();
                        alert('Please select amc period');
                        return;
                    }
                    var amcPercentage = $('#amcper option:selected').val();
                    if (amcPercentage == '') {
                        e.preventDefault();
                        alert('Please select amc percentage');
                        return;
                    }
                }

            }

            if (seniorState) {
                var senioramt = $('#senioramt option:selected').val();
                if (senioramt == '') {
                    e.preventDefault();
                    alert('Please select senior citizen amount/percentage wise');
                    return;
                }
                var senioramtper = $('#senioramtper').val();
                if (senioramtper == '') {
                    e.preventDefault();
                    alert('Please select senior amount or percentage');
                    return;
                }
            }

            if (studentState) {
                var studentamt = $('#studentamt option:selected').val();
                if (studentamt == '') {
                    e.preventDefault();
                    alert('Please select senior citizen amount/percentage wise');
                    return;
                }
                var studentamtper = $('#studentamtper').val();
                if (studentamtper == '') {
                    e.preventDefault();
                    alert('Please select student amount or percentage');
                    return;
                }
            }

        });
    });


</script>
<fieldset style="margin-top:80px;"><legend>Edit DAMC Products</legend>
    <form action="#" method="post" id="damcProductForm">

        <p>
            {$messageToShow}
        </p>

        <div class="margin-form">
            {$category}
        </div>

        <div class="margin-form">
            <label> <strong>Product :</strong></label>
            <select name="product" id="product">
                <option value="">Select product</option>
            </select>
        </div>
        <div class="margin-form">
            <label> <strong> IS AMC Enabled:</strong></label>
            <input type="checkbox" name="amc" value="1" {if $productDetail['is_amc_active']==1}
                checked="checked"
                    {/if}>
        </div>

        <div class="margin-form period showAMCBlock" {if $productDetail['is_amc_active']!=1}
             style="display:none"
             {/if} >
            <label> <strong>Period :</strong></label>
            <select name="amcperiod" id="amcperiod">
                <option value="">--Select--</option>
                <option value="1">1 yrs</option>
                <option value="2">2 yrs</option>
                <option value="3">3 yrs</option>
                <option value="4">4 yrs</option>
            </select>
        </div>

        <div class="margin-form amcpercent showAMCBlock" {if $productDetail['is_amc_active']!=1}
            style="display:none"
                {/if}>
            <label> <strong>AMC Percentage :</strong></label>
            <select name="amcper" id="amcper">
                <option value="">--Select--</option>
                {for $foo=1 to 40}
                    <option value= {$foo}>{$foo}</option>
                {/for}
            </select>
        </div>

<div class="margin-form warranty showAMCBlock" {if $productDetail['is_amc_active']!=1} style="display:none"
                {/if}>
        <label> <strong>Warranty :</strong></label>
        <input type="text" name="warranty" id="warranty" value="{$productDetail['warranty']}"> <strong>Yrs.</strong>     
         </div>

        {if $productDetail['amcData']}

        <div class="margin-form">

            <p>Already AMC Periods</p>
            <table class="table" style="margin-left:150px;">
                <thead>
                <tr>
                    <th>Period</th>
                    <th>Percentage</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$productDetail['amcData'] key=stores item=i}
                    <tr class="" id="period_row_{$i['id']}">
                        <td>{$i['period']}</td>
                        <td>{$i['amc_percentage']}</td>
                        <td>
                            <a onClick="deletePeriod({$i['id']})">Delete</a>
                        </td>
                    </tr>
                {/foreach}

                </tbody>
                </table>
        </div>


        {/if}



        <div class="margin-form">
            <label> <strong> IS Senior Enabled:</strong></label>
            <input type="checkbox" name="senior" value="1"

            {if $productDetail['is_senior_active']==1}
            checked="checked"
            {/if}>
        </div>

        <div class="margin-form senioramt showSeniorBlock" {if $productDetail['is_senior_active']!=1}
            style="display:none"
             {/if}>
            <label> <strong>Senior Discount amt/per:</strong></label>
            <select name="senioramt" id="senioramt">
                <option value="" {if $productDetail['is_senior_active']!=1 || $productDetail['is_senioramtper']==''}selected=selected{/if}>--Select--</option>
                <option value="1" {if $productDetail['is_senior_active']==1 && $productDetail['is_senioramtper']==1}selected=selected{/if}>Amount</option>
                <option value="2" {if $productDetail['is_senior_active']==1 && $productDetail['is_senioramtper']==2}selected=selected{/if}>Percentage</option>
            </select>
        </div>

        <div class="margin-form senioramtper showSeniorBlock" {if $productDetail['is_senior_active']!=1}
            style="display:none"
                {/if}>
            <label> <strong> Enter amt/per:</strong></label>
            <input type="text" name="senioramtper" id="senioramtper" value="{$productDetail['senioramt']}">
        </div>

        <div class="margin-form">
            <label> <strong> IS Student Enabled:</strong></label>
            <input type="checkbox" name="student" value="1" {if $productDetail['is_student_active']==1}
                checked="checked"
                    {/if}>
        </div>

        <div class="margin-form studentamt showStudentBlock" style="display: none">
            <label> <strong>Student Discount amt/per:</strong></label>
            <select name="studentamt" id="studentamt">
                <option value="" {if $productDetail['is_student_active']!=1 || $productDetail['is_studentamtper']==''}selected=selected{/if}>--Select--</option>
                <option value="1" {if $productDetail['is_student_active']==1 && $productDetail['is_studentamtper']==1}selected=selected{/if}>Amount</option>
                <option value="2" {if $productDetail['is_student_active']==1 && $productDetail['is_studentamtper']==2}selected=selected{/if}>Percentage</option>
            </select>
        </div>

        <div class="margin-form studentamtper showStudentBlock" {if $productDetail['is_student_active']!=1}
            style="display:none"
                {/if}>
            <label> <strong> Enter amt/per:</strong></label>
            <input type="text" name="studentamtper" id="studentamtper" value="{$productDetail['studentamt']}">
        </div>

        <div class="margin-form">
            <label>&nbsp;&nbsp;</label>
            <input type="submit" name="submit" value="submit" class="button"/>
        </div>



    </form>
</fieldset>

