$(document).ready(function () {
  const bctId = $("input[name='bct_id']").data("id");
  $.ajax({
    url: "php_function/reportFunction.php",
    type: "POST",
    data: {
      id: bctId,
      action: "stuResult",
    },
    success: function (response) {
      const myObj = response;
      const gradeObj = JSON.parse(myObj);

      // pi chart
      const piechart = $("#pichart");
      new Chart(pichart, {
        type: "pie",
        data: {
          labels: ["A+", "A", "A-", "B+", "B", "B-", "C+", "C", "D", "F"],
          datasets: [
            {
              label: "# of students",
              data: [
                gradeObj["A+"],
                gradeObj["A"],
                gradeObj["A-"],
                gradeObj["B+"],
                gradeObj["B"],
                gradeObj["B-"],
                gradeObj["C+"],
                gradeObj["C"],
                gradeObj["D"],
                gradeObj["F"],
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
        },
      });

      // graph
      const grap = $("#graph");
      new Chart(graph, {
        type: "line",
        data: {
          labels: ["A+", "A", "A-", "B+", "B", "B-", "C+", "C", "D", "F"],
          datasets: [
            {
              label: "# of students",
              data: [
                gradeObj["A+"],
                gradeObj["A"],
                gradeObj["A-"],
                gradeObj["B+"],
                gradeObj["B"],
                gradeObj["B-"],
                gradeObj["C+"],
                gradeObj["C"],
                gradeObj["D"],
                gradeObj["F"],
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
        },
      });
    },
  });
});
