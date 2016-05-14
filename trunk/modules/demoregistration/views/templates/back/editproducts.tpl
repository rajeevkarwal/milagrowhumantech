<script>
    var citiesList={$cities}
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
        //console.log(check);
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


    function getcity(selectedCity) {
        var e = document.getElementById('state');
        var cate = e.options[e.selectedIndex].value;
        $('#city')
                .find('option')
                .remove()
                .end()
        var check = citiesList[cate];
        var opt = $('<option value="">--select--</option>');
        $('#city').append(opt);
        var elm = document.getElementById('city'),
                df = document.createDocumentFragment();
        for (var i = 0; i < check.length; i++) {
            var option = document.createElement('option');
            option.value = check[i]['id'];
            option.appendChild(document.createTextNode(" " + check[i]['city']));
            df.appendChild(option)

        }
        elm.appendChild(df);

        if(selectedCity)
        {
            $('#city').val(selectedCity);
        }

    };


    function deleteCity(democityId)
    {
        var result=confirm('Are you sure want to delete');

        if(result)
        {
            $.ajax({
                url: "/modules/demoregistration/demoregistrationajax.php?action_type=2&secureKey=345768&demo_city_id="+democityId,
                type: "GET",
                success: function(data)
                {
                    if ($.trim(data)=='success')
                    {
                        alert('city removed successfully');
                        $('#city_row_'+democityId).hide();
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



        {if $productDetail['categoryId']!=''}
        $('#category').val({$productDetail['categoryId']});
        getid({$productDetail['productId']});
        {/if}


        $('#damcProductForm').submit(function (e) {
            var selectedCategory = $('#category option:selected').val();
            var selectedProduct = $('#product option:selected').val();
            var selectedState = $('#state option:selected').val();
            var selectedCity = $('#city option:selected').val();
            var demoType = $('#demoType option:selected').val();
            var demoText = $('#demoText').val().trim();
            var demoAmount = $('#demoAmount').val().trim();

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

            if(selectedState!='' || demoType!='' || demoText!='' || demoAmount!='')
            {
                if (selectedState == '') {
                    e.preventDefault();
                    alert('Please select state');
                    return;
                }

                if (selectedCity == '') {
                    e.preventDefault();
                    alert('Please select city');
                    return;
                }

                if (demoType == '') {
                    e.preventDefault();
                    alert('Please select demo type');
                    return;
                }

                if (demoAmount == '') {
                    e.preventDefault();
                    alert('Please enter demo amount');
                    return;
                }

                if (demoText == '') {
                    e.preventDefault();
                    alert('Please enter demo text');
                    return;
                }
            }

        });
    });


</script>
<fieldset style="margin-top:80px;"><legend>Edit Demo Products</legend>


        <p>
            {$messageToShow}
        </p>

    <form method="post" id="damcProductForm">

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

                <h5 style="color:blue;font-size: 18px;">Existing Cities where demo live</h5>
                <table class="table" style="margin-left:150px;">
                    <thead>
                    <tr>
                        <th>State</th>
                        <th>City</th>
                        <th>Demo Type</th>
                        <th>Demo Text</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    {if $productDetail['amcData']}
                    {foreach from=$productDetail['amcData'] key=stores item=i}
                        <tr class="" id="city_row_{$i['iddemocities']}">
                            <td>{$i['statename']}</td>
                            <td>{$i['cityname']}</td>
                            <td>
                                {if $i['demoType']=='1'}
                                    Home Only
                                {elseif $i['demoType']=='2'}
                                    Skype Only
                                {else}
                                    Home & Skype Both
                                {/if}
                            </td>
                            <td>{$i['demoText']}</td>
                            <td>{$i['amount']}</td>
                            <td>
                                <a style="cursor:pointer" onClick="deleteCity({$i['iddemocities']})">Delete</a>
                            </td>
                        </tr>
                    {/foreach}
                    {/if}
                    </tbody>
                </table>
            </div>



        <div class="margin-form">
            <label> <strong>State :</strong></label>
            <select name="state" id="state" onchange="getcity()">
                <option value="">Select state</option>
                {foreach $states as $keyvar=>$itemvar}
                    <option value="{$keyvar}">{$itemvar}</option>
                 {/foreach}
            </select>
        </div>

        <div class="margin-form">
            <label> <strong>City :</strong></label>
            <select name="city" id="city">
                <option value="">Select city</option>
            </select>
        </div>

        <div class="margin-form">
            <label> <strong>Demo Type :</strong></label>
            <select name="demoType" id="demoType">
                <option value="">Select Demo Type</option>
                <option value="1">Home Only</option>
                <option value="2">Skype</option>
                <option value="3">Both Home/Skype</option>
            </select>
        </div>

        <div class="margin-form">
            <label> <strong>Demo Text :</strong></label>
            <input type="text" id="demoText" name="demoText" placeholder="Enter demo text">
        </div>

        <div class="margin-form">
            <label> <strong>Demo Amount :</strong></label>
            <input type="text" id="demoAmount" name="demoAmount" placeholder="Enter demo amount">
        </div>

        <div class="margin-form">
            <label>&nbsp;&nbsp;</label>
            <input type="submit" name="submit" value="submit" class="button"/>
        </div>

    </form>
</fieldset>

