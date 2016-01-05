<?php 
    $title = "Pyramid Charts 2";
    // $plotTargets = array (array('id'=>'chart1', 'width'=>600, 'height'=>400));
?>
<?php include "opener.php"; ?>

<!-- Example scripts go here -->

  <link class="include" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/smoothness/jquery-ui.css" rel="Stylesheet" /> 

    <style type="text/css">
        .chart-container {
            border: 1px solid darkblue;
            padding: 30px;
            width: 600px;
            height: 700px;
        }

        #chart1 {
            width: 96%;
            height: 96%;
        }

        .jqplot-datestamp {
          font-size: 0.8em;
          color: #777;
    /*      margin-top: 1em;
          text-align: right;*/
          font-style: italic;
          position: absolute;
          bottom: 15px;
          right: 15px;
        }

        td.controls li {
            list-style-type: none;
        }

        td.controls ul {
            margin-top: 0.5em;
            padding-left: 0.2em;
        }

        pre.code {
            margin-top: 45px;
            clear: both;
        }

    </style>

    <table class="app">
        <td class="controls">

            <div style="margin-bottom: 15px;">
                Axes:
                <select name="axisPosition">
                    <option value="both">Left &amp; Right</option>
                    <option value = "left">Left</option>
                    <option value = "right">Right</option>
                    <option value = "mid">Mid</option>
                </select>
            </div>

            <div>
                Background Color:
                <ul>
                    <li><input name="backgroundColor" value="white" type="radio" checked />Default</li>
                    <li><input name="backgroundColor" value="#efefef" type="radio" />Gray</li>
                </ul>
            </div>

            <div>
                Pyramid Color:
                <ul>
                    <li><input name="seriesColor" value="green" type="radio" checked />Green</li>
                    <li><input name="seriesColor" value="blue" type="radio" />Blue</li>
                </ul>
            </div>

            <div>
                Grids:
                <ul>
                    <li><input name="gridsVertical" value="vertical" type="checkbox" checked />Vertical</li>
                    <li><input name="gridsHorizontal" value="horizontal" type="checkbox" checked />Horizontal</li>
                    <li><input name="showMinorTicks" value="true" type="checkbox" />Only major</li>
                    <li><input name="plotBands" value="true" type="checkbox" />Plot Bands</li>
                </ul>
            </div>

            <div>
                <ul>
                    <li><input name="barPadding" value="4" type="checkbox" checked />Gap between bars</li>
                    <!-- value for showContour is speed at which to fade lines in/out -->
                    <li><input name="showContour" value="500" type="checkbox" />Comparison Line</li>
                </ul>
            </div>

            <div class="tooltip">
                <table>
                    <tr>
                        <td>Age: </td><td><div class="tooltip-item" id="tooltipAge">&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td>Male: </td><td><div class="tooltip-item"  id="tooltipMale">&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td>Female: </td><td><div class="tooltip-item"  id="tooltipFemale">&nbsp;</div></td>
                    </tr>
                    <tr>
                        <td>Ratio: </td><td><div class="tooltip-item"  id="tooltipRatio">&nbsp;</div></td>
                    </tr>
                </table>
            </div>
        </td>

        <td class="chart">
            <div class="chart-container"> 
                <div id="chart1"></div>
                <div class="jqplot-datestamp"></div>
            </div>
        </td>

    </table>

    <pre class="code brush:js"></pre>
  


    <script class="code" type="text/javascript" language="javascript">
    $(document).ready(function(){

      