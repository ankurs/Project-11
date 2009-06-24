$(function () {
    $("#sidebar-catagory").hide();
    $("#sidebar-catagoryinfo").hide();
    $("#sidebar-admin").hide();
});
function toggleCat()
{
    $("#sidebar-catagory").slideToggle("slow");
}
function toggleAdmin()
{
    $("#sidebar-admin").slideToggle("slow");
}

function toggleCatInfo()
{
    $("#sidebar-catagoryinfo").slideToggle("slow");
}

