/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var html = $(".scrolles")[0].outerHTML;
var htmlParent = $(".scrolles").parent();

var top = $(document).height();
$('#footer-not').css({
    "top": $(document).height() + "px;"
});

$(".scrolles").jscroll({
    callback: scrollEnd
});

function scrollEnd()
{
    var top = $(document).height();
    $('#footer-not').css({
        "top": top + "px;"
    });

}

//$(document).live(function() {
//    if ($(window).scrollTop() + $(window).height() == $(document).height()) {
//        alert("bottom!");
//    }
//});



$('#cities').on("change", function(e)
{
    var checked = [];
    $('#cities input:checked').each(function() {
        checked.push($(this).val());
    });

//
    var url = "http://3-doors-down.concertticketsq.com/dev/";
    var params = "?ajax=1";
    console.log(url);

    if (checked.length === 0)
    {
        params += "&offset=0";
    }
    else
    {
        params += "&city=" + checked.toString();
    }

    $.ajax({
        url: url + params
    })
            .done(function(data) {
                if (console && console.log) {
                }
                $(".scrolles").remove();

                $('#venues li').hide();

                $('#table-listing tbody').html('');
                $('#venues input:checkbox').removeAttr('checked');

                $('#table-listing tbody').first().append($('tbody', data).children());
                if (checked.length == 0)
                {
                    $('#venues li').show();
                    htmlParent.append(html);
                    $(".scrolles").jscroll({
                        callback: scrollEnd
                    });
                }
                else
                {
                    $.each(checked, function(index, value)
                    {

                        $('#venues li').filter('[data-city=' + value + ']').show();
                        $('#table-listing tr').filter('[data-city=' + value + ']').show();
                        console.log($('#table-listing tr').filter('[data-city=' + value + ']').text());
                    });
                }
            });



//


    // console.log(checked_performers);
});

$('#venues').on("change", function(e)
{

    $('#table-listing tbody tr').hide();



    var checked = [];
    $('#venues input:checked').each(function() {
        checked.push($(this).val());

        $('#table-listing tr').filter('[data-venue=' + $(this).val() + ']').show();

    });

    if (checked.length == 0)
    {
        $('#table-listing tbody tr').hide();
        if ($('#cities input:checked').length == 0)
        {
            $('#table-listing tbody tr').show();
        }
        else
        {
            $('#cities input:checked').each(function() {

                $('#table-listing tr').filter('[data-city=' + $(this).val() + ']').show();
            });
        }
    }

    console.log(checked);
});


