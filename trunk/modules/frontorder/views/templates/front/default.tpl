<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>FedEx Web Integration Wizard</title> <!-- FWIW Version 1.0.0 -->
    <style type='text/css'>body {
            font-family: Arial;
            font-size: 11px;
            background-color: #FFFFFF;
            color: #333333;
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }

        .Title1 {
            font-size: 14px;
            color: #575659;
            font-weight: bold;
        }

        .Title2 {
            font-size: 14px;
            color: #660099;
            font-weight: bold;
        }

        .Title3 {
            font-size: 13px;
            color: #ffffff;
            font-weight: bold;
        }

        .Title4 {
            font-family: Arial;
            font-size: 11px;
            height: 18px;
        }

        .Title5 {
            font-family: Times New Roman;
            font-size: 32px;
            color: #808080;
            font-weight: bold;
        }

        .Hr1 {
            height: 2px;
            color: #660099;
        }

        .Hr2 {
            height: 1px;
            color: #000000;
        }

        .Hr3 {
            height: 2px;
            color: #000000;
        }

        .Hr4 {
            height: 1px;
            color: #808080;
        }

        .Text1 {
            font-weight: bold;
            font-size: 10px;
            color: #af9999;
        }

        .PanelHeader {
            background-color: #660099;
            font-size: 13px;
            color: #ffffff;
            font-weight: bold;
            height: 25px;
            padding: 6 6 6 6;
        }

        .PanelHeader2 {
            background-color: #DCDCDC;
            font-size: 13px;
            color: #5F5F5F;
            font-weight: bold;
            height: 25px;
        }

        .PanelHeader3 {
            background-color: #999999;
            font-size: 13px;
            color: #ffffff;
            font-weight: bold;
            height: 25px;
        }

        .PanelContent {
            color: #000000;
            background-color: #e6e6e6;
            font-size: 11px;
            height: 30px;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .PanelContent2 {
            color: #999999;
            background-color: #CCCCCC;
            font-size: 10px;
            height: 30px;
        }

        .PanelContent3 {
            background-color: #DCDCDC;
            font-size: 12px;
            color: #5F5F5F;
            height: 25px;
        }

        .Buttons {
            font-size: 13px;
            background-color: #7C1FAA;
            color: #ffffff;
            height: 24px;
            border-right: #7F7F7F 2px solid;
            border-top: #CCCCCC 2px solid;
            border-left: #CCCCCC 2px solid;
            border-bottom: #7F7F7F 2px solid;
        }

        .BackButtons {
            font-size: 13px;
            background-color: #666;
            color: #ffffff;
            height: 24px;
            border-right: #7F7F7F 2px solid;
            border-top: #CCCCCC 2px solid;
            border-left: #CCCCCC 2px solid;
            border-bottom: #7F7F7F 2px solid;
        }

        .Buttons2 {
            background-color: #000000;
            font-size: 13px;
            color: #ffffff;
            height: 24px;
            border-right: #7F7F7F 2px solid;
            border-top: #CCCCCC 2px solid;
            border-left: #CCCCCC 2px solid;
            border-bottom: #7F7F7F 2px solid;
        }

        .TrWhite {
            color: #666666;
            background-color: #fff;
            font-size: 12px;
        }

        .TrGrey {
            color: #666666;
            background-color: #e6e6e6;
            font-size: 12px;
        }

        .TextGrey {
            color: #666666;
            font-size: 12px;
        }

        .FedExLink {
            color: #660099;
        }

        .Intro {
            background: #f5f5f5;
            color: #333333;
            font-size: 11px;
            border-bottom: solid 1px #660099;
            border-left: solid 1px #660099;
            border-right: solid 1px #660099;
            border-top: solid 1px #660099;
        }

        .Intro_BACKUP {
            background: #e6e6e6;
            color: #000000;
            font-size: 11px;
            padding: 10px;
            border-bottom: solid 1px #660099;
            border-left: solid 1px #660099;
            border-right: solid 1px #660099;
            border-top: solid 1px #660099;
        }

        .ResultTable {
            background: #e6e6e6;
            color: #666666;
            font-size: 12px;
            border: solid 1px #660099;
        }

        .CurrentStep {
            color: #FF6600;
            font-weight: bold;
            text-decoration: underline;
            font-size: 18px;
        }

        .CurrentStep {
            color: #000000;
            font-weight: bold;
            text-decoration: none;
            font-size: 12px;
        }

        .FinishedStep {
            font-size: 12px;
            color: #660099;
            font-weight: bold;
            text-decoration: underline;
            border: 0px;
        }

        .UnFinishedStep {
            font-size: 12px;
            color: #999999;
            text-decoration: none;
        }

        .mainheader1 {
            font-size: 18px;
            color: #660099;
            font-weight: normal;
        }

        .mainheader2 {
            font-size: 14px;
            color: #999999;
            font-weight: bold;
        }

        .mainheader3 {
            font-size: 16px;
            color: #660099;
            font-weight: normal;
        }

        .mainheader4 {
            font-size: 14px;
            color: #660099;
            font-weight: bold;
            border-bottom: solid 2px #660099;
            border-left: solid 0px #660099;
            border-right: solid 0px #660099;
            border-top: solid 0px #660099;
            height: 18px;
        }

        .clearSelection {
            font-size: 11px;
            color: #660099;
        }

        .designPreviewBox {
            font-family: Arial;
            font-size: 11px;
            color: #333333;
            border-bottom: solid 1px #868686;
            border-left: solid 1px #868686;
            border-right: solid 1px #868686;
            border-top: solid 1px #868686;
        }

        .textbox {
            font-family: Arial;
            font-size: 11px;
            color: #333333;
            border-bottom: solid 1px #868686;
            border-left: solid 1px #868686;
            border-right: solid 1px #868686;
            border-top: solid 1px #868686;
            width: 165px;
        }

        .dropdown {
            font-family: Arial;
            font-size: 11px;
            color: #333333;
            border-bottom: solid 1px #868686;
            border-left: solid 1px #868686;
            border-right: solid 1px #868686;
            border-top: solid 1px #868686;
        }</style>
    <meta http-equiv="Content-type" content="text/html; charset=utf8"/>
</head>
<script type="text/javascript">function body_onload() {
        UpdateScreenBasedOnRequestType();
        document.getElementById("clientForm").submit();
    }
    function UpdateScreenBasedOnRequestType() {
        var ddlRequestType = FindControl('ddlTrackRequestType');
        if (ddlRequestType != null) {
            for (var i = 0; i < ddlRequestType.length; i++) {
                document.getElementById("txtTrackingIdentifier").value = "";
                document.getElementById("txtShipDate").value = "";
                document.getElementById("txtAccountNo").value = "";
                document.getElementById("ddlCountry").value = "";
                document.getElementById("txtPostalCode").value = "";
                document.getElementById("ddlShipServiceType").value = "";
                document.getElementById("ddlReferenceType").value = "";
                if (ddlRequestType.options[i].selected == true) {
                    if (ddlRequestType.options[i].value == '1') {
                        ShowTrackingNumber();
                    } else {
                        ShowReference();
                        SetReferenceTypeOptions();
                    }
                }
            }
        } else {
            if (FindControl('ddlReferenceType') != null)            SetNewReferenceTypeOptions("-1");
        }
    }
    function FindControl(control) {
        return document.getElementById(control);
    }
    function Show() {
        for (var i = 0; i < arguments.length; i++) {
            FindControl(arguments[i]).style.display = "";
        }
    }
    function Hide() {
        for (var i = 0; i < arguments.length; i++) {
            FindControl(arguments[i]).style.display = "none";
        }
    }
    function ShowTrackingNumber() {
        Show("spTrackingNumber");
        Hide("spReference");
        Hide("trAdditionalInfo");
        Hide("trShipDate");
        Hide("trAccountNo");
        Hide("trCountry");
        Hide("trPostalCode");
        Hide("trShipServiceType");
        Hide("trReferenceType");
    }
    function ShowReference() {
        Hide("spTrackingNumber");
        Show("spReference");
        Show("trAdditionalInfo");
        Show("trShipDate");
        Show("trAccountNo");
        Show("trCountry");
        Show("trPostalCode");
        Show("trShipServiceType");
        Show("trReferenceType");
    }
    function SetReferenceTypeOptions() {
        var ddlServiceType = FindControl('ddlShipServiceType');
        for (var i = 0; i < ddlServiceType.length; i++) {
            if (ddlServiceType.options[i].selected == true) {
                SetNewReferenceTypeOptions(ddlServiceType.options[i].value);
            }
        }
    }
    function SetNewReferenceTypeOptions(serviceType) {
        var ddlReferenceType = FindControl('ddlReferenceType');
        ddlReferenceType.options.length = 1;
        var options = new Array();
        if (serviceType == "-1" || serviceType == "") {
            options[0] = new Option("Shipper Reference", "Shipper Reference");
            options[1] = new Option("Customer Reference", "Customer Reference");
            options[2] = new Option("TCN", "TCN");
            options[3] = new Option("Purchase Order Number", "Purchase Order Number");
            options[4] = new Option("Invoice Number", "Invoice Number");
            options[5] = new Option("Bill of Lading Number", "Bill of Lading Number");
            options[6] = new Option("Partner/Carrier Number", "Partner/Carrier Number");
            options[7] = new Option("Ground Shipment ID", "Ground Shipment ID");
            options[8] = new Option("RMA", "RMA");
            options[9] = new Option("Part Number", "Part Number");
            options[10] = new Option("Authorization Number", "Authorization Number");
            options[11] = new Option("Department Number", "Department Number");
        } else if (serviceType == "FedEx Express") {
            options[0] = new Option("Shipper Reference", "Shipper Reference");
            options[1] = new Option("TCN", "TCN");
            options[2] = new Option("Bill of Lading Number", "Bill of Lading Number");
            options[3] = new Option("RMA", "RMA");
        } else if (serviceType == "FedEx Ground") {
            options[0] = new Option("Customer Reference", "Customer Reference");
            options[1] = new Option("TCN", "TCN");
            options[2] = new Option("Purchase Order Number", "Purchase Order Number");
            options[3] = new Option("Invoice Number", "Invoice Number");
            options[4] = new Option("RMA", "RMA");
            options[5] = new Option("Ground Shipment ID", "Ground Shipment ID");
            options[6] = new Option("Department Number", "Department Number");
        } else if (serviceType == "FedEx Freight") {
            options[0] = new Option("Shipper Reference", "Shipper Reference");
            options[1] = new Option("Purchase Order Number", "Purchase Order Number");
            options[2] = new Option("Bill of Lading Number", "Bill of Lading Number");
            options[3] = new Option("Partner/Carrier Number", "Partner/Carrier Number");
            options[4] = new Option("Authorization Number", "Authorization Number");
        } else if (serviceType == "FedEx Custom Critical") {
            options[0] = new Option("Customer Reference", "Customer Reference");
            options[1] = new Option("Bill of Lading Number", "Bill of Lading Number");
            options[2] = new Option("Part Number", "Part Number");
        } else if (serviceType == "FedEx SmartPost") {
            options[0] = new Option("Customer Reference", "Customer Reference");
            options[1] = new Option("Purchase Order Number", "Purchase Order Number");
            options[2] = new Option("Invoice Number", "Invoice Number");
            options[3] = new Option("RMA", "RMA");
        }
        for (var i = 0; i < options.length; i++) {
            ddlReferenceType.options[i + 1] = options[i];
        }
    }</script>
<body onload="body_onload();">
<center>
    <div style="text-align: center; margin-top: 250px;">

        <img src="/modules/frontorder/loading.gif"/>

        <h3>Please wait.......</h3>
    </div>
    <form method="post" action="https://www.fedex.com/FWIW/Client/Tracking_v9/ClientTrackInit" id="clientForm" style="display: none">
        <table width="100%" border="0" cellpadding="10" style='text-align: left;'>
            <tr>
                <td><img src='http&#58;&#47;&#47;milagrowhumantech&#46;com&#47;fedex&#45;logo&#46;jpg' align='middle'
                         style='border-width: 0px;'/></td>
            </tr>
            <tr>
                <td align="left">
                    <table class="Intro" width="565px" cellspacing="0" cellpadding="0"
                           style="font-family:Arial; text-align: left; color:Black; background-color:White; font-size:11px;border:Red 1px solid;">
                        <tr>
                            <td align="left" class="PanelHeader" style='background-color:Red; color:White'>
                                &nbsp;&nbsp; <span> FedEx Tracking </span></td>
                        </tr>
                    </table>
                    <table class="Intro" width="565px" cellspacing="5"
                           style="font-family:Arial; text-align: left; color:Black; background-color:White; font-size:11px;border:Red 1px solid;">
                        <tr>
                            <td align="left" colspan=3><span> Please enter your tracking information. </span></td>
                        </tr>
                        <tr>
                            <td align="left" colspan=3><span> *Denotes required field </span></td>
                        </tr>
                        <tr style="height: 10px"/>
                        <!-- end trTrackRequestType -->
                        <tr>
                            <td align="left">                                <!-- begin spTrackingNumber --> <span
                                        id="spTrackingNumber"> * Tracking no. or door tag no. </span>
                                <!-- end spTrackingNumber -->
                                <!-- end spReference -->
                            </td>
                            <td><input class="textbox" maxlength="35" id="txtTrackingIdentifier"
                                       name="txtTrackingIdentifier" type="text"
                                       {if isset($trackingCode) && !empty($trackingCode)}value="{$trackingCode}"{/if}
                                       style="width: 160px; border-color:Black; background-color:WhiteSmoke; border-width:1px; border-style:solid; font-family:Helvetica; font-size:11px; color:Black;"
                                       />
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <!-- end Additional Information -->                                     </table>
                    <br>
                    <table width="565px" cellspacing="5" border="0">
                        <tr>
                            <td align="right" colspan=3><input type="submit" value="Track"
                                                               style='border-color:Black; border-style:solid; color:White; background-color:DarkOrange; border-width:1px; font-family:Helvetica; font-size:11px;'/>
                                <input id="hdnQuery" name="hdnQuery" type="hidden"
                                       value="k0LFeHalelmLt36cN0ibgHXxdANHAb4GDZW9KWhdqK6JXTLR0B5kRFDdDbIjOwbrA0pgaWsS83INj6sPQu46u0PWVOVCAivGR+8exwSmAQhYommPxT0vqy5YrYxKRmmfBCdfq/rpKZvBnbIOI4VIvOXvqZRixclDmpSP4/hWM07BcpjboH10WARbsH4d0aXeu86VhYixlx0tjx04YerNKO4I7tzlm7y00hXuZ+TtAcRgI5MX6MS70IOG1WtQS5dGFPVsUxkfC/ObM8WVIh1eHWabwDdrc1VY3NRMZH0xp1qeUYLiK+f/o5U03dNvpyMylQWZHFqXAUvNOTW+D5lfxH7r4b7KXXs9ttTfgSI00m8="/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</center>
</body>
</html>