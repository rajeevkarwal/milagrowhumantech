/**
 * Created by hitanshu on 3/1/16.
 */
$(document).ready(function(){
    $('#ccavenue_payment').hide();
    $('#onemi_payment').hide();
    $('#city_payment').hide();
    $('#cheque_payment').hide();
    $('#bankwire_payment').hide();
    $('#cod_payment').hide();

    $("input[name='payment_type']").change(
        function(){
            $('#ccavenue_payment').hide();
            $('#onemi_payment').hide();
            $('#city_payment').hide();
            $('#cheque_payment').hide();
            $('#bankwire_payment').hide();
            $('#cod_payment').hide();
            $('#full_payments_divs').hide();
            $('#emi_payments_divs').hide();
            $('#emi_payment_card_select').val('');
            $('#full_payment_card_select').val('');
            $('#full_payment_card_type_select').empty().hide();
            $('#emi_payment_card_type_select').empty().hide();

            if ($(this).is(':checked') && $(this).val() == '1') {
                $('#full_payments_divs').show();
                //showFullPaymentDropDown();
            }
            else if ($(this).is(':checked') && $(this).val() == '2') {
                //directly show the cod payment option
                $('#cod_payment').show();
            }
            else if ($(this).is(':checked') && $(this).val() == '3') {
                $('#emi_payments_divs').show();
                //showEMIDropDown();
            }
            else if ($(this).is(':checked') && $(this).val() == '4') {
                //directly show the cod payment option
                $('#onemi_payment').show();
            }
            else
            {
                $('#full_payments_divs').hide();

            }
        });

});
var creditCardObj='{"1":{"1":{"name":"VISA","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"2":{"name":"MasterCard","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"3":{"name":"American Express","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"4":{"name":"JCB","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"5":{"name":"Dinners Club","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0}},"2":{"1":{"name":"VISA","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"2":{"name":"CITIBank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"3":{"name":"MasterCard","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"4":{"name":"RuPay","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"5":{"name":"State Bank Of India","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"6":{"name":"Andhra Bank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"7":{"name":"Canara Bank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"8":{"name":"Indian Bank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"9":{"name":"Indian Overseas Bank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"10":{"name":"Punjab National Bank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"11":{"name":"Union Bank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0}},"3":{"1":{"name":"HDFC","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"2":{"name":"ICICI","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"3":{"name":"State Bank of India","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"4":{"name":"Andhra Bank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"5":{"name":"Axis Bank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0}},"4":{"1":{"name":"I Cash Card","showCCA":1,"showONEMI":0,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"2":{"name":"ItzCash","showCCA":1,"showONEMI":0,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"3":{"name":"Oxygen Wallet","showCCA":1,"showONEMI":0,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"4":{"name":"Pay Cash Card","showCCA":1,"showONEMI":0,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0}},"5":{"1":{"name":"IMPS","showCCA":1,"showONEMI":0,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"2":{"name":"Paymate","showCCA":1,"showONEMI":0,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0}},"6":{"1":{"name":"Jana Cash Wallet","showCCA":1,"showONEMI":0,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"2":{"name":"MobiQwik","showCCA":1,"showONEMI":0,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"3":{"name":"Paytm","showCCA":1,"showONEMI":0,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0}}}';
creditCardObj=jQuery.parseJSON(creditCardObj);
var emiCardObj='{"1":{"1":{"name":"Axis","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"2":{"name":"HSBC","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"3":{"name":"ICICI","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"4":{"name":"Indusland","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"5":{"name":"Kotak","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"6":{"name":"Citibank","showCCA":1,"showONEMI":1,"showCOD":0,"showCITY":1,"showCHEQUE":0,"showBANKWIRE":0},"7":{"name":"HDFC","showCCA":0,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"8":{"name":"SBI","showCCA":0,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0},"9":{"name":"Standard Chartered","showCCA":0,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0}},"2":{"1":{"name":"ICICI","showCCA":0,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0}},"3":{"1":{"name":"Bajaj Finserv","showCCA":0,"showONEMI":1,"showCOD":0,"showCITY":0,"showCHEQUE":0,"showBANKWIRE":0}}}';
emiCardObj=jQuery.parseJSON(emiCardObj);

function showFullPaymentDropDown()
{
    $('#ccavenue_payment').hide();
    $('#onemi_payment').hide();
    $('#city_payment').hide();
    $('#cheque_payment').hide();
    $('#bankwire_payment').hide();
    $('#cod_payment').hide();
    var selectedVal=$('#full_payment_card_select option:selected').val();

    if(selectedVal=='')
    {
        alert('Please select the method');
        return;
    }

    if(selectedVal==7)
    {
        $('#cheque_payment').show();
        return;
    }

    else if(selectedVal==8)
    {
        $('#bankwire_payment').show();
        return;
    }
    else
    {
        var optionsObj=creditCardObj[selectedVal];

        var optionHtml='<option value="">Select Card Type</option>';
        $.each( optionsObj, function( key, value ) {
            optionHtml+='<option value="'+key+'">'+value.name+'</option>';
        });

        $('#full_payment_card_type_select').empty().append(optionHtml).show();
    }

}

function showEMIDropDown()
{
    $('#ccavenue_payment').hide();
    $('#onemi_payment').hide();
    $('#city_payment').hide();
    $('#cheque_payment').hide();
    $('#bankwire_payment').hide();
    $('#cod_payment').hide();
    var selectedVal=$('#emi_payment_card_select option:selected').val();
    if(selectedVal=='')
    {
        alert('Please select the method');
        return;
    }
    var optionsObj=emiCardObj[selectedVal];

    var optionHtml='<option value="">Select Card Type</option>';
    $.each( optionsObj, function( key, value ) {
        optionHtml+='<option value="'+key+'">'+value.name+'</option>';
    });

    $('#emi_payment_card_type_select').empty().append(optionHtml).show();
}

function EMIShowPaymentDivs()
{
    $('#ccavenue_payment').hide();
    $('#onemi_payment').hide();
    $('#city_payment').hide();
    $('#cheque_payment').hide();
    $('#bankwire_payment').hide();
    $('#cod_payment').hide();
   var cardType=$('#emi_payment_card_select option:selected').val();
   var bankType=$('#emi_payment_card_type_select option:selected').val();
   if(cardType!='' && bankType!='')
   {
       var optionSelected=emiCardObj[cardType][bankType];
       if(optionSelected['showCCA']==1)
       {
           $('#ccavenue_payment').show();
       }
       if(optionSelected['showONEMI']==1)
       {
           $('#onemi_payment').show();
       }
       if(optionSelected['showCOD']==1)
       {
           $('#cod_payment').show();
       }

       if(optionSelected['showCITY']==1)
       {
           $('#city_payment').show();
       }

       if(optionSelected['showCHEQUE']==1)
       {
           $('#cheque_payment').show();
       }

       if(optionSelected['showBANKWIRE']==1)
       {
           $('#bankwire_payment').show();
       }
   }
   else
   {
       alert('Please select card type or bank options');
   }

}

function FULLShowPaymentDivs()
{
    $('#ccavenue_payment').hide();
    $('#onemi_payment').hide();
    $('#city_payment').hide();
    $('#cheque_payment').hide();
    $('#bankwire_payment').hide();
    $('#cod_payment').hide();
    var cardType=$('#full_payment_card_select option:selected').val();
    var bankType=$('#full_payment_card_type_select option:selected').val();
    if(cardType!='' && bankType!='')
    {
        var optionSelected=creditCardObj[cardType][bankType];
        if(optionSelected['showCCA']==1)
        {
            $('#ccavenue_payment').show();
        }
        if(optionSelected['showONEMI']==1)
        {
            $('#onemi_payment').show();
        }
        if(optionSelected['showCOD']==1)
        {
            $('#cod_payment').show();
        }

        if(optionSelected['showCITY']==1)
        {
            $('#city_payment').show();
        }

        if(optionSelected['showCHEQUE']==1)
        {
            $('#cheque_payment').show();
        }

        if(optionSelected['showBANKWIRE']==1)
        {
            $('#bankwire_payment').show();
        }
    }
    else
    {
        alert('Please select card type or bank options');
    }
}




