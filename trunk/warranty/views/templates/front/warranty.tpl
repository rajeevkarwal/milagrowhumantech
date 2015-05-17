<script type="text/javascript" src="{$jsSource}"></script>
<div class="container">
    <div class="contain-size">
        <div class="main">
            <div class="main-inner">
                <div class="col-main">
                    <div class="page-title">
                        <h1>Register Product</h1>
                    </div>
                    <p>
                        Register your product to get fast technical support and better warranty claims
                    </p>

                    <div class="col2-set">
                        <div class="col-1 box-in">
                            <div class="content">
                                <form id="warranty" action="{$form_action}" method="post" data-ajax="true" novalidate="">

                                    <ul class="form-list">
                                        <li>

                                            <label for="name" class="required"><em>*</em>Name</label>

                                            <div class="input-box">
                                                <input type="text" id="name" name="name"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label for="email" class="required"><em>*</em>Email</label>

                                            <div class="input-box">
                                                <input type="email" id="email" name="email"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label for="mobile" class="required"><em>*</em>Mobile</label>

                                            <div class="input-box">
                                                <input type="text" id="mobile" name="mobile"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label for="product" class="required"><em>*</em>Select Product</label>

                                            <div class="input-box">
                                                <select name="product" id="product">
                                                    <option value="">Select Product</option>
                                                    {foreach from=$products key=myId item=i}
                                                        <option value="{$i.id_product}">{$i.name}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </li>

                                        <li>
                                            <label for="productNumber" class="required"><em>*</em>Product Number</label>

                                            <div class="input-box">
                                                <input type="text" id="productNumber" name="productNumber"/>
                                            </div>
                                        </li>

                                        <li>
                                            <label for="date" class="required"><em>*</em>Date of Purchase</label>

                                            <div class="input-box">
                                                <input type="text" id="date" name="date"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label for="storeName" class="required"><em>*</em>Store Name</label>

                                            <div class="input-box">
                                                <input type="text" id="storeName" name="storeName"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label for="address1" class="required"><em>*</em>Address1</label>

                                            <div class="input-box">
                                                <textarea name="address1" id="address1"></textarea>
                                            </div>
                                        </li>

                                        <li>
                                            <label for="address1" class="required"><em>*</em>Address1</label>

                                            <div class="input-box">
                                                <textarea name="address1" id="address1"></textarea>
                                            </div>
                                        </li>

                                        <li>
                                            <label>City</label>

                                            <div class="input-box">
                                                <input type="text" id="city" name="city"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label>State</label>

                                            <div class="input-box">
                                                <input type="text" id="state" name="state"/>
                                            </div>
                                        </li>



                                        <li>
                                            <p class="required">*Required Fields</p>
                                            <button type="submit" name="submit" class="button">
                                                <span><span>Submit</span></span>
                                            </button><span id="ajax-loader" style="display: none"><img
                                                        src="{$this_path}loader.gif" alt="{l s='ajax-loader' mod='warranty'}"/></span>

                                        </li>
                                    </ul>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







{*<h3>{l s='Register Product' mod='warranty'}</h3>*}
{*<form id="warranty" action="{$form_action}" method="post" data-ajax="true" novalidate="">*}
    {*<p>*}
        {*Register your product to get fast technical support and better warranty claims*}

    {*</p>*}

    {*<p>*}
        {*<label for="name">Name</label>*}
        {*</br>*}
        {*<input type="text" id="name" name="name"/>*}
    {*</p>*}

    {*<p>*}
        {*<label>Email</label><br>*}
        {*<input type="email" id="email" name="email"/>*}
    {*</p>*}

    {*<p>*}
        {*<label>Mobile</label><br>*}
        {*<input type="text" id="mobile" name="mobile"/>*}
    {*</p>*}
    {*<p>*}
        {*<label>Select Product</label><br>*}
        {*<select name="product" id="product">*}
            {*<option value="">Select Product</option>*}
            {*{foreach from=$products key=myId item=i}*}
                {*<option value="{$i.id}">{$i.name}</option>*}
            {*{/foreach}*}
            {*<option value="-1">Other</option>*}
        {*</select>*}
    {*</p>*}
    {*<p>*}
        {*<label>Product Number</label><br>*}
        {*<input type="text" id="productNumber" name="productNumber"/>*}
    {*</p>*}
    {*<p>*}
        {*<label>Date of Purchase</label><br>*}
        {*<input type="text" id="date" name="date"/>*}
    {*</p>*}
    {*<p>*}
        {*<label>Store Name</label><br>*}
        {*<input type="text" id="storeName" name="storeName"/>*}
    {*</p>*}
    {*<p>*}
        {*<label>Address1</label><br>*}
        {*<textarea name="address1" id="address1"></textarea>*}

    {*</p>*}
    {*<p>*}
        {*<label>Address2</label><br>*}
        {*<textarea name="address2" id="address2"></textarea>*}

    {*</p>*}
    {*<p>*}
        {*<label>City</label><br>*}
        {*<input type="text" id="city" name="city"/>*}
    {*</p>*}

    {*<p>*}
        {*<label>State</label><br>*}
        {*<input type="text" id="state" name="state"/>*}
    {*</p>*}

    {*<p>*}
        {*<input type="submit" value="warranty" name="warranty"/><span id="ajax-loader" style="display: none"><img*}
                    {*src="{$this_path}loader.gif" alt="{l s='ajax-loader' mod='warranty'}"/></span>*}
    {*</p>*}


{*</form>*}