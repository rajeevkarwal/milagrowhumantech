<script>
    var productList = {$finprolist}

            function getid() {
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
            }

    $(document).ready(function () {

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

                var amcWarranty = $('#warranty').val();
                if (amcWarranty == '') {
                    e.preventDefault();
                    alert('Please select amc Warranty');
                    return;
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
<fieldset style="margin-top:80px;"><legend>Add DAMC Products</legend>
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
        <input type="checkbox" name="amc" value="1">
    </div>

    <div class="margin-form period showAMCBlock" style="display:none">
        <label> <strong>Period :</strong></label>
        <select name="amcperiod" id="amcperiod">
            <option value="">--Select--</option>
            <option value="1">1 yrs</option>
            <option value="2">2 yrs</option>
            <option value="3">3 yrs</option>
            <option value="4">4 yrs</option>
        </select>
    </div>

    <div class="margin-form amcpercent showAMCBlock" style="display:none">
        <label> <strong>AMC Percentage :</strong></label>
        <select name="amcper" id="amcper">
            <option value="">--Select--</option>
            {for $foo=1 to 40}
                <option value= {$foo}>{$foo}</option>
            {/for}
        </select>
    </div>

    <div class="margin-form warranty showAMCBlock" style="display:none">
        <label> <strong>Warranty :</strong></label>
        <input type="text" name="warranty" id="warranty"> <strong>Yrs.</strong>     
    </div>

    <div class="margin-form">
        <label> <strong> IS Senior Enabled:</strong></label>
        <input type="checkbox" name="senior" value="1">
    </div>

    <div class="margin-form senioramt showSeniorBlock" style="display:none">
        <label> <strong>Senior Discount amt/per:</strong></label>
        <select name="senioramt" id="senioramt">
            <option value="">--Select--</option>
            <option value="1">Amount</option>
            <option value="2">Percentage</option>
        </select>
    </div>

    <div class="margin-form senioramtper showSeniorBlock" style="display: none">
        <label> <strong> Enter amt/per:</strong></label>
        <input type="text" name="senioramtper" id="senioramtper">
    </div>

    <div class="margin-form">
        <label> <strong> IS Student Enabled:</strong></label>
        <input type="checkbox" name="student" value="1">
    </div>

    <div class="margin-form studentamt showStudentBlock" style="display: none">
        <label> <strong>Student Discount amt/per:</strong></label>
        <select name="studentamt" id="studentamt">
            <option value="">--Select--</option>
            <option value="1">Amount</option>
            <option value="2">Percentage</option>
        </select>
    </div>

    <div class="margin-form studentamtper showStudentBlock" style="display:none">
        <label> <strong> Enter amt/per:</strong></label>
        <input type="text" name="studentamtper" id="studentamtper">
    </div>

    <div class="margin-form">
        <label>&nbsp;&nbsp;</label>
        <input type="submit" name="submit" value="submit" class="button"/>
    </div>



</form>
    </fieldset>

