<head>
    <!--link rel="stylesheet" type="text/css" href="default.css"-->
    <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script-->
    <script type="text/javascript" src="/assets/js/jqplot/src/jquery.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

        <!-- Latest compiled and minified JavaScript -->
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script><!-- Latest compiled and minified CSS -->
      
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">

     <!-- custom css-->
    <link rel="stylesheet" href="/assets/css/default.css">

    <script type="text/javascript" src="/assets/js/jqplot/src/jquery.jqplot.js"></script>
    <script type="text/javascript" src="/assets/js/jqplot/src/plugins/jqplot.canvasTextRenderer.js"></script>
    <script type="text/javascript" src="/assets/js/jqplot/src/plugins/jqplot.canvasAxisLabelRenderer.js"></script>
    <script type="text/javascript" src="/assets/js/jqplot/src/plugins/jqplot.canvasAxisTickRenderer.js"></script>
    <script type="text/javascript" src="/assets/js/jqplot/src/plugins/jqplot.dateAxisRenderer.js"></script>
    <script type="text/javascript" src="/assets/js/jqplot/src/plugins/jqplot.cursor.js"></script>
    <script type="text/javascript" src="/assets/js/jqplot/src/plugins/jqplot.highlighter.js"></script>
    
    <link rel="stylesheet" type="text/css" href="/assets/js/jqplot/src/jquery.jqplot.css" />

    <script type="text/javascript" src="/assets/js/mncindex.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="/assets/js/jquery.marquee.min.js"></script>

    <meta charset='utf-8'/> 

    <script type="text/JavaScript">
      var globalData;
     function initMarquee(){
        $('.marquee').marquee({
        //speed in milliseconds of the marquee
        speed: 60000,
        //gap in pixels between the tickers
        gap: 20,
        //time in milliseconds before the marquee will start animating
        delayBeforeStart: 0,
        //'left' or 'right'
        direction: 'left',
        //true or false - should the marquee be duplicated to show an effect of continues flow
        duplicated: true
      });

      }

      function createClock(){
        var date=new Date();
        $('#clock').html(date.toString());
        setTimeout(function(){createClock()},400);
      }

      $(document).ready(function() {
          var url = '/api/micronations?ref_currency=USD';
        loadTableAndMarquee(url);
        $('#currselect').change(function(){
          var curr = $('#currselect').find(":selected").text();
          url = '/api/micronations?ref_currency=' + curr;
          loadTableAndMarquee(url);
        })
        var date=new Date();
        var refreshId = setInterval(function(){
          loadTableAndMarquee(url);
          
        }, 10000); // Each minute
        createClock();
      });
    </script>

</head>