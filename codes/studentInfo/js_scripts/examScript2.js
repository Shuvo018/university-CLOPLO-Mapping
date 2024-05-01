$(document).ready(function () {
  console.log("it's work !!");
  // changing term
  $("#checkBox1").on("change", "input", function () {
    let curTerm = $("input[name='examTerm']:checked").val();
    let bctId = $("input[name='examTerm']:checked").data("id");
    console.log(curTerm);

    $.ajax({
      url: "php_function/examFunction.php",
      type: "POST",
      data: {
        id: bctId,
        term: curTerm,
        action: "teacher",
      },
      success: function (response) {
        $("#topRowTable").text("");
        $("#topRowTable").append(response);
      },
    });

    $.ajax({
      url: "php_function/examFunction.php",
      type: "POST",
      data: {
        id: bctId,
        term: curTerm,
        action: "student",
      },
      success: function (response) {
        $("#studentTB").text("");
        $("#studentTB").append(response);
        $("#tco1").prop("checked", true);
      },
    });
  });

  // changing clo
  $("#checkBox2").on("change", "input", function () {
    let curCo = $("input[name='tCo']:checked").val();
    let bctId = $("input[name='tCo']").data("id");
    let curTerm = $("input[name='examTerm']:checked").val();

    // console.log(curCo);

    $.ajax({
      url: "php_function/examFunction.php",
      type: "POST",
      data: {
        bctId: bctId,
        co: curCo,
        term: curTerm,
        action: "stuCo",
      },
      success: function (response) {
        $("#studentTB").text("");
        $("#studentTB").append(response);
      },
    });
  });

  // for changing top row inputs
  $("#topRowTable").on("change", "input", function () {
    console.log("changed");
    let row = $(this).closest("tr");
    let co1 = Number(row.find("input[name='co1']").val());
    let co2 = Number(row.find("input[name='co2']").val());
    let co3 = Number(row.find("input[name='co3']").val());
    let co4 = Number(row.find("input[name='co4']").val());
    let co5 = Number(row.find("input[name='co5']").val());

    let bctId = $("input[name='tCo']").data("id");
    let curTerm = $("input[name='examTerm']:checked").val();

    let total = co1 + co2 + co3 + co4 + co5;
    console.log(total);
    $.ajax({
      url: "php_function/examFunction.php",
      type: "POST",
      data: {
        bctId: bctId,
        term: curTerm,
        co1: co1,
        co2: co2,
        co3: co3,
        co4: co4,
        co5: co5,
        total: total,
        action: "teacherMarks",
      },
      success: function (response) {
        $("#topRowTotal").text(total);
      },
    });
  });

  // for changing student row input
  $("#studentTB").on("change", "input", function () {
    // console.log("s changed");
    let row = $(this).closest("tr");
    let sa1 = Number(row.find("input[name='sa1']").val());
    let sb1 = Number(row.find("input[name='sb1']").val());
    let sa2 = Number(row.find("input[name='sa2']").val());
    let sb2 = Number(row.find("input[name='sb2']").val());
    let sa3 = Number(row.find("input[name='sa3']").val());
    let sb3 = Number(row.find("input[name='sb3']").val());
    let sa4 = Number(row.find("input[name='sa4']").val());
    let sb4 = Number(row.find("input[name='sb4']").val());
    let sa5 = Number(row.find("input[name='sa5']").val());
    let sb5 = Number(row.find("input[name='sb5']").val());
    let sa6 = Number(row.find("input[name='sa6']").val());
    let sb6 = Number(row.find("input[name='sb6']").val());
    let sa7 = Number(row.find("input[name='sa7']").val());
    let sb7 = Number(row.find("input[name='sb7']").val());

    let stuMarkId = Number(row.find("input[name='sa1']").data("id"));
    // console.log("stu mark id : ", stuMarkId);
    const scoMarks = [];
    scoMarks[0] = Number(row.find("#sco1").text());
    scoMarks[1] = Number(row.find("#sco2").text());
    scoMarks[2] = Number(row.find("#sco3").text());
    scoMarks[3] = Number(row.find("#sco4").text());
    scoMarks[4] = Number(row.find("#sco5").text());
    // console.log(" sco1 value : ", sco1);

    let scoId = Number(row.find("input[name='scoId']").data("id"));
    console.log(" sco Id : ", scoId);

    // get co & term
    let curCo = $("input[name='tCo']:checked").val();

    console.log("co: ", curCo);
    // we need to update co
    // how get co1, co2....
    // example : row.find("#sco1").text()
    // this way all the work will be done

    let totalMark =
      sa1 +
      sb1 +
      sa2 +
      sb2 +
      sa3 +
      sb3 +
      sa4 +
      sb4 +
      sa5 +
      sb5 +
      sa6 +
      sb6 +
      sa7 +
      sb7;
    console.log("total : ", totalMark);

    $.ajax({
      url: "php_function/examFunction.php",
      type: "POST",
      data: {
        id: stuMarkId,
        sa1: sa1,
        sb1: sb1,
        sa2: sa2,
        sb2: sb2,
        sa3: sa3,
        sb3: sb3,
        sa4: sa4,
        sb4: sb4,
        sa5: sa5,
        sb5: sb5,
        sa6: sa6,
        sb6: sb6,
        sa7: sa7,
        sb7: sb7,
        action: "stuMarks",
      },
      success: function (response) {},
    });
    $.ajax({
      url: "php_function/examFunction.php",
      type: "POST",
      data: {
        id: scoId,
        co: curCo,
        totalMark: totalMark,
        scoMarks: scoMarks,
        action: "updateStuCoMark",
      },
      success: function (response) {
        row.find("#stuCoTotal").text(response);

        if (curCo == "co1") {
          row.find("#sco1").text(totalMark);
        } else if (curCo == "co2") {
          row.find("#sco2").text(totalMark);
        } else if (curCo == "co3") {
          row.find("#sco3").text(totalMark);
        } else if (curCo == "co4") {
          row.find("#sco4").text(totalMark);
        } else if (curCo == "co5") {
          row.find("#sco5").text(totalMark);
        }
      },
    });
  });
});
