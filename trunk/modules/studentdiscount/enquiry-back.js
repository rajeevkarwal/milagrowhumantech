/**
 * Created with JetBrains PhpStorm.
 * User: hitanshu
 * Date: 15/10/13
 * Time: 12:27 PM
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function () {
    $(function () {
        $('#dateFrom').datepicker(
            {
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "1950:2050",
                maxDate: "+0d"
            });
        $('#dateTo').datepicker(
            {
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "1950:2050",
                maxDate: "+0d"
            });

    });
});