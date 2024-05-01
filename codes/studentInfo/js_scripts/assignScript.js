$(document).ready(function(){
    console.log("it's work");
    $('.form-check').click(function(){
        let curTerm = $('input[name=examTerm]:checked').val();
        let bctId = $('input[name=examTerm]:checked').data('id');
        $.ajax({
            url: "php_function/assignFunction.php",
            type: "POST",
            data: {
                id : bctId,
                term: curTerm,
                action: "teacher"
            },
            success: function(response){
                $("#topRowTable").text("");
                $("#topRowTable").append(response);
            }
        });

        $.ajax({
            url: "php_function/assignFunction.php",
            type: "POST",
            data: {
                id : bctId,
                term: curTerm,
                action: "student"
            },
            success: function(response){
                $("#studentTB").text("");
                $("#studentTB").append(response);
            }
        });
    });
// for changing top row inputs
    $("#topRowTable").on('change', 'input', function(){
    console.log("changed");
    let row = $(this).closest('tr');
    let co1 = Number(row.find('input[name="tco1"]').val());
    let co2 = Number(row.find('input[name="tco2"]').val());
    let co3 = Number(row.find('input[name="tco3"]').val());
    let co4 = Number(row.find('input[name="tco4"]').val());
    let co5 = Number(row.find('input[name="tco5"]').val());

    let total = co1 + co2 + co3 + co4 + co5;

    let bctId = row.find('input[name="tco1"]').data('id');
    let term = row.find('input[name="tTerm"]').data('id');
    
    $.ajax({
        url: "php_function/assignFunction.php",
        type: "POST",
        data : {
            bctId : bctId,
            term : term,
            co1 : co1,
            co2 : co2,
            co3 : co3,
            co4 : co4,
            co5 : co5,
            total : total,
            action : "teacherMarks"
        },
        success : function(response){
            $("#topRowTable").text("");
            $("#topRowTable").append(response);
        }
    });
    });

// for changing student row inputs
    $("#studentTB").on('change', 'input', function(){
        console.log("changed");
        let row = $(this).closest('tr');
        let co1 = Number(row.find('input[name="co1"]').val());
        let co2 = Number(row.find('input[name="co2"]').val());
        let co3 = Number(row.find('input[name="co3"]').val());
        let co4 = Number(row.find('input[name="co4"]').val());
        let co5 = Number(row.find('input[name="co5"]').val());

        // sAId Work on term and bct
        let sAId = row.find('input[name="co1"]').data('id');
        let total = co1 + co2 + co3 + co4 + co5;

        $.ajax({
            url: "php_function/assignFunction.php",
            type: "POST",
            data : {
                id : sAId,
                co1 : co1,
                co2 : co2,
                co3 : co3,
                co4 : co4,
                co5 : co5,
                total : total,
                action : "stuMarks"
            },
            success : function(response){
                row.find('td.sTotal').text(total);
            }
        });

    });
});