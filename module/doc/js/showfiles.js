$(function()
{
    $('#navbar .nav li').removeClass('active');
    $("#navbar .nav li[data-id=" + type + ']').addClass('active');
});
