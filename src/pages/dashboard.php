<?php
$panel->setPageTitle('Status');
$panel->setPageHeader('Status');
$panel->setPageDescription('View Server Status');


$content = <<<EOF

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Players</h3>
  </div>
  <div class="panel-body">

    <div id="canvas-holder">
      <canvas id="online-players-chart-area" width="150" height="150"/>
    </div>
  </div>
</div>

<script>

var pieData = [
    {
      value: 10,
      color:"#F7464A",
      highlight: "#FF5A5E",
      label: "Players Online"
    },
    {
      value: 22,
      color: "#46BFBD",
      highlight: "#5AD3D1",
      label: "Free Slots"
    }

  ];

  window.onload = function(){
    var ctx = document.getElementById("online-players-chart-area").getContext("2d");
    window.myPie = new Chart(ctx).Doughnut(pieData, {
      scaleShowLabels: true,
      legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    });
  };
</script>
EOF;

$panel->setPageContent($content);
?>
