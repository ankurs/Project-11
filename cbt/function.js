$(function () {
    $(".question").hide();
    $("#1").show();
});
var qNumber=1;
function qShow(num)
{
    // set qNumber to current question
    qNumber = num;
    // hide all questions that are visible
    $(".question:visible").hide("normal");
    // show question with number -> num
    $("#"+num).show("normal"); }
function qNext()
{
    // show the next question
    qShow(qNumber+1);
}
function qPrev()
{
    // check if qNumber is > 1 or not
    if (qNumber>1)
    {
        // show the prev question
        qShow(qNumber-1);
    }
}

function qMarkRed(num)
{
    $(".ql-"+num).css("background-color","red");
}
function qMarkGreen(num)
{
    $(".ql-"+num).css("background-color","green");
}
function qMarkBlue(num)
{
    $(".ql-"+num).css("background-color","blue");
}
function qMarkClear(num)
{
    $(".ql-"+num).css("background-color","");
}
