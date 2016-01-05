<html>
<?php
  $this->load->view('head');
?>
<body>
<form id="input" action="/currencyindex/submitregistrationform" method="post" enctype="multipart/form-data">
  Nation name: <input type="text" name="nname"><br><br>
  Currency name: <input type="text" name="cname"><br><br>
  DDenomination description: <input type="text" name="ddesc"><br><br>
  Prefered <a href="http://en.wikipedia.org/wiki/ISO_4217">ISO 4217 code</a>: <input type="text" name="iso"><br><br/>
  Upload flag: <input type="file" name="file" id="file"><br><br />
  Date established: <input type="date" name="date"><br><br>
  Digital Embassy / Homepage: <input type="text" name="link"><br><br>
  Wiki link: <input type="text" name="wiki"><br><br>
  Other listings: <input type="text" name="other"><br><br>
  Contact person: <input type="text" name="contact"> will not be shown publically on site!<br><br>
  Region description: <input type="text" name="rdesc"><br><br>


    Pegged to currency:
    <select name="pegged_to" id="pegged_to">
<optgroup label="Macronations">
<?php 
  foreach ($macroISOCodes as $code) {
    echo '<option value="' . $code->m_iso_code . '">' . $code->m_iso_code . '</option>';
  } ?>
</optgroup>
<optgroup label="Micronations">
  <?php 
  foreach ($microISOCodes as $code) {
    echo '<option value="' . $code->c_iso_code . '">' . $code->c_iso_code . '</option>';
  } ?>
</optgroup>
<optgroup label="Not listed">
<option value="other">Add your own ...</option>
</optgroup>
    </select>
d
<span id="inputField"></span>
  <!--with value: <input type="number" name="pegged_value"><br>-->

<script>
$(document).ready(function() {
    $('#pegged_to').change(function () {
        var result;
        var label = $('#pegged_to :selected').parent().attr('label');

        if (label == "Not listed") {
            result = 'Link and/or description: <input type="text" name="currency_text"><br>';
        } else {
            result = 'with value: <input type="number" name="pegged_value"><br>';
        }

        $('#inputField').html(result);
    });
});
</script><br><br>
<?php
$this->load->helper('recaptchalib');
$publickey = "6LcQYOwSAAAAAAxy9OVPLRdKTa8G6Eq1KxQQFJdq"; // you got this from the signup page
echo recaptcha_get_html($publickey);
?>

  <input type="submit" value="Submit">
</form>

</body>
</html>