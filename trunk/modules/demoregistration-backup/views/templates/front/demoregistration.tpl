<link rel="stylesheet" media="all" type="text/css"
      href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
<link rel="stylesheet" media="all" type="text/css" href="/js/jquery/plugins/timepicker/jquery-ui-timepicker-addon.css"/>
<link rel="stylesheet" media="all" type="text/css" href="{$jsSource}demoregistration.css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$jsSource}jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="{$jsSource}demoregistration.js"></script>


<div class="container">
    <div class="contain-size">
        {capture name=path}{l s='Demo Registration' mod='demoregistration'}{/capture}
        {include file="$tpl_dir./breadcrumb.tpl"}
        <div class="main">
            <div class="main-inner">
                <div class="col-main">
                    <div class="page-title">
                        <h3>Request for Pre - Sales Home Demo for Robotic Floor Cleaners</h3>
                    </div>

                    <p>
                        1.Please fill the form below to submit your request for Pre-Sales Home Demo only.
                    </p>

                    <p>
                        2.Demo charges will be Rs. 750/. The same shall be refunded if you buy a Milagrow Floor Cleaning
                        Robot.
                    </p>

                    <p>3.The customer care team will call you with in 24 hrs after the form submission to confirm the
                        demo.</p>

                    <p>4.The engineer will carry a RedHawk for the demo.</p>

                    <p>5.The demo will be for half an hour only.</p>
                    <br/>

                    <div class="col2-set">
                        <div class="col-1 box-in">
                            <div class="content">
                                <form id="demo" action="{$form_action}" method="post" data-ajax="true" novalidate="">

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
                                                        <OPTGROUP LABEL="{$myId}">
                                                            {foreach from=$i key=rowKey item=row}
                                                                <option value="{$row.id_product}">{$row.name}</option>
                                                            {/foreach}
                                                        </OPTGROUP>
                                                    {/foreach}

                                                </select>
                                            </div>
                                        </li>

                                        <li>
                                            <label for="city" class="required"><em>*</em>Select City</label>

                                            <div class="input-box">
                                                <select name="city" id="city">
                                                    <option value="">Select City</option>
                                                    <option value="Banglore">Bangalore</option>
                                                    <option value="Chennai">Chennai</option>
                                                    <option value="Delhi">Delhi/Ncr</option>
                                                </select>
                                            </div>
                                        </li>

                                        <li>
                                            <label for="address" class="required"><em>*</em>Address</label>

                                            <div class="input-box">
                                                <textarea id="address" name="address"></textarea>
                                            </div>
                                        </li>

                                        <li>
                                            <label for="zip" class="required"><em>*</em>Zip Code</label>

                                            <div class="input-box">
                                                <input id="zip" type="text" name="zip"/>
                                            </div>
                                        </li>
                                        <li>
                                            <label for="dateTime" class="required"><em>*</em>Preferred Date and
                                                Time</label>

                                            <div class="input-box">
                                                <input type="text" id="dateTime" name="dateTime"
                                                       placeholder="" readonly/>
                                            </div>
                                        </li>


                                        <li>
                                            <label for="comments">Special Comments</label>

                                            <div class="input-box">
                                                <textarea name="special_comments"></textarea>
                                            </div>
                                        </li>
                                        <input type="hidden" name="demo" value="demo"/>

                                        {*<li>*}
                                        {*<label for="price" class="required"><em>*</em>Price</label>*}

                                        {*<div class="input-box">*}
                                        {*<input type="text" id="price" readonly="readonly" name="price"*}
                                        {*value="{$price}"/>*}
                                        {*</div>*}
                                        {*</li>*}

                                        <li>
                                            <p class="required">*Required Fields</p>
                                            <button type="submit" name="submit" class="button">
                                                <span><span>Submit</span></span>
                                            </button><span id="ajax-loader" style="display: none"><img
                                                        src="{$this_path}loader.gif"
                                                        alt="{l s='loader' mod='demoregistration'}"/></span>

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
