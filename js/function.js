$(function () {
    $("#sidebar-catagory").hide();
    $("#sidebar-catagoryinfo").hide();
    $("#sidebar-assign").hide();
    $("#sidebar-rmassign").hide();
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
function toggleAssign()
{
    $("#sidebar-assign").slideToggle("slow");
}
function toggleAssignrm()
{
    $("#sidebar-rmassign").slideToggle("slow");
}

