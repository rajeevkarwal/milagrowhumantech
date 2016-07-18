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

        $('#demoProductForm').submit(function (e) {
            var selectedCategory = $('#category option:selected').val();
            var selectedProduct = $('#product option:selected').val();
            var demoType=$('#demoType option:selected').val();
            var demoText=$('#demoText').val();

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

            if (demoType == '') {
                e.preventDefault();
                alert('Please select type of demo available');
                return;
            }

            if (demoText == '') {
                e.preventDefault();
                alert('Please enter demo text');
                return;
            }

        });
    });


</script>
<fieldset style="margin-top:80px;"><legend>Add DAMC Products</legend>
    
    <form action="#" method="post" id="demoProductForm">

        <ul>
            <li>Please fill the product detail and on next screen associate the cities with the products.</li>
        </ul>
        <p style="color:red">
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
            <label>&nbsp;&nbsp;</label>
            <input type="submit" name="submit" value="submit" class="button"/>
        </div>

    </form>
        <form method="post" enctype='multipart/form-data' action=''>
            <h3>Upload Via Sheet&nbsp;&nbsp;&nbsp;<span style="color:Red">(only csv format acceped)</span></h3>
              <div class="margin-form">
            <label>&nbsp;&nbsp;</label>
              <input type="file" name="uploadCSV" size='100'>
        </div>

            
        
              <div class="margin-form">
            <label>&nbsp;&nbsp;</label>
              <input type="submit" name="submit" value="Import Now">
        </div>
        </form>
      
</fieldset>

