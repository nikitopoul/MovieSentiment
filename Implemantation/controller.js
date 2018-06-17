//File for dynamic load on submit buttons
//on load ready document
//and handle results for demonstration
$(document).ready(function(e) {

    //var check = false;
    var info = null;
    var idf = null;
    var pid = null;
    $("#x").submit(function(event) {
        event.preventDefault();

        //execute Hadoop analysis
        $.post("exec.php", function(data) {

            pid = data.trim();
            ref();
        });

        var data = $("#x :input").serializeArray();

    });

    $("#x").submit(function() {
        return false;
    });


    function ref() {
        //CONSOLE DEBUGGING
        var datatoserver = "status=true&" + "id=" + encodeURIComponent(pid);
        console.log(datatoserver); //check on console

        $.ajax({
            dataType: "json",
            url: "compare.php",
            data: datatoserver,
            contentType: "application/json; charset=utf-8",
            cache: false,
            success: function(data) {
                //CONSOLE DEBUGGING
                console.log('Data=' + data.error); //check on console

                //If data are ready
                if (data.error == 0) {
                    $("#r1").removeClass("fa fa-apple fa-spin");

                    //Parsing the results
                    var pos = JSON.parse(data.msg1);
                    var neu = JSON.parse(data.msg2);
                    var neg = JSON.parse(data.msg3);

                    f(pos, neu, neg);

                } else {
                    //Loading - Check every 5 seconds if data are ready
                    $("#r1").addClass("fa fa-apple fa-spin");
                    setTimeout(ref, 5000);
                }
            },
            fail: function(data) {
                ref();
            }

        });

    } //end ref

    //preparation of results for the Charts
    function f(info1, info2, info3) {
        console.log(info1);
        var finals = [];
        var finals2 = [];

        finals.push({
            'y': info1,
            'indexLabel': 'Positive'
        });
        finals.push({
            'y': info2,
            'indexLabel': 'Neutral'
        });
        finals.push({
            'y': info3,
            'indexLabel': 'Negative'
        });

        //Pie Chart for the results
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "theme3",
            title: {
                text: "The pie of the movie"
            },
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "{y} - #percent %",
                yValueFormatString: "#,.## Million",
                legendText: "{indexLabel}",
                dataPoints: finals
            }]
        });
        chart.render();

        //Bar Chart for the results
        var chart = new CanvasJS.Chart("chartContainer2", {

            title: {
                text: "Exact Numbers of analysis"
            },
            data: [ //array of dataSeries              
                { //dataSeries object

                    /*** Change type "column" to "bar", "area", "line" or "pie"***/
                    type: "column",
                    dataPoints: [{
                            label: "Positive",
                            y: info1
                        },
                        {
                            label: "Neutral",
                            y: info2
                        },
                        {
                            label: "Negative",
                            y: info3
                        }
                    ]
                }
            ]
        });


        chart.render();
    } //end f

}); //end document load