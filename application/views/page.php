<!DOCTYPE html>
<html>
<?php $this->view('head'); ?>
<body ng-app="mncindex">
    <script>
        

        var showMarquee = function (string) {
            $('.marquee').html(string) .marquee({duration: 30000});
        }

        function createClock(){
            var date=new Date();
            $('#clock').html(date.toString());
            setTimeout(function(){createClock()},1000);
        }

        createClock();


    </script>

    <?php $this->view('content'); ?>
    <?php $this->view('modal'); ?>
</body>
</html>