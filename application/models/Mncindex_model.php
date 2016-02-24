<?php

class Mncindex_model extends CI_Model {
    public function fetchAndSaveCurrencies () {
      function splitCurrencyNames($source) 
      {
          return array (substr($source, 0, 3), substr($source, 3, 3));
      }
      
      
      function computeRate($rate){
          //return (floatval($rate->Bid) + floatval($rate->Ask)) / 2.0;
          return $rate->Bid;
      }
      $this->load->database();

      $xml = $this->getXML();
      $this->insertCurrencyInDatabase('USD',1.000);
      foreach ($xml->Rate as $rate) {
          $bothCurrencyNames = $rate->attributes()->Symbol;
          list ($firstCurrency, $secondCurrency) = splitCurrencyNames($bothCurrencyNames);
  
          $c_iso_code=null;
          $our_rate=null;
          if($firstCurrency=='USD'){
              $c_iso_code=$secondCurrency;
          }
          if($secondCurrency=='USD'){
              $c_iso_code=$firstCurrency;
          }
          if($this->isCurrencyInDatabase($c_iso_code)){
              $our_rate=computeRate($rate);            
              if($c_iso_code==$secondCurrency){
                  $our_rate=1/floatval($our_rate);
              }
              $this->insertCurrencyInDatabase($c_iso_code,$our_rate);
          }              
      }

      

    }
    public function getMicronations () {
        $this->load->database();
        // $this->db->select('nation_name, currency_name, date_established, website_link, micronation.m_iso_code, c_iso_code, pegged_value, (Select max(datetime) FROM currency_history)');
        // $this->db->from('micronation');
        // $this->db->join('rel_nation_currency', 'micronation.m_iso_code = rel_nation_currency.m_iso_code');    
        // 
        $ref_currency = $this->input->get("ref_currency");
        if (empty($ref_currency)) {$ref_currency = "USD";}

        // Getting this currency's current value to dollar 
        $query = $this->db->query("SELECT * FROM currency_history WHERE c_iso_code = '$ref_currency' ORDER BY datetime desc limit 1");
        $row = $query->row();
        $refCurrencyValueToDollar = $row->value_to_dollar;
        
        $query = $this->db->query("SELECT m.nation_name, m.currency_name,m.date_established,m.website_link,m.m_iso_code, rel.c_iso_code,rel.pegged_value, ((Select value_to_dollar FROM currency_history
     WHERE c_iso_code=rel.c_iso_code AND datetime=max(ch.datetime)) * rel.pegged_value) / $refCurrencyValueToDollar  AS value_to_ref_currency,(Select value_to_dollar FROM currency_history
     WHERE c_iso_code=rel.c_iso_code AND datetime=max(ch.datetime))  AS value_to_dollar,(Select max(datetime) from currency_history) as lastUpdated
        FROM micronation m, currency_history ch, rel_nation_currency rel
        WHERE rel.m_iso_code = m.m_iso_code
        AND rel.c_iso_code = ch.c_iso_code 
        group by m.m_iso_code,m.nation_name,rel.pegged_value ORDER BY m.m_iso_code ASC");

        $micronations = $query->result_array();


        // get all currencies to draw charts in micronation popup
        $currencies = array();
        $query = $this->db->query("SELECT *,(Select value_to_dollar from currency_history ch WHERE ch.c_iso_code=currency.c_iso_code ORDER by datetime desc limit 1) as value_to_dollar FROM currency order by c_iso_code");
        foreach ($query->result_array() as $currency)
        {
            $currencies[$currency['c_iso_code']] = $currency;
        }
    

    // get currency histories 
    $query = $this->db->query("SELECT ch.c_iso_code, DATE(ch.datetime) as date,(Select AVG(ch.value_to_dollar) ) AS value_to_dollar
         FROM currency_history ch
         WHERE 
          ch.datetime > (current_date - interval 1 month)
         group by ch.c_iso_code,YEAR(ch.datetime),MONTH(ch.datetime),DAY(ch.datetime);
         ");
    foreach ($query->result() as $ch) {
        if(! isset($currencies[$ch->c_iso_code]['currency_history'])){
            $currencies[$ch->c_iso_code]['currency_history'] = array();
        }
         array_push($currencies[$ch->c_iso_code]['currency_history'],array($ch->date,floatval($ch->value_to_dollar)));
    }

        return array(
          'micronations' => $micronations,
          'currencies' => $currencies,
          'ref_currency' => $ref_currency);
    }

    public function registerMicronationForm () {
      $this->load->database();
       $this->load->helper('recaptchalib_helper');
      $privatekey = "6LcQYOwSAAAAAE6Gq3QUOVXZWaiwtWffxqx9UZC0";
      $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

      if (!$resp->is_valid) {
        // What happens when the CAPTCHA was entered incorrectly
        die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
      } else {

              echo "OK, Inserting into DB ...";
$iso = $this->db->escape($this->input->post('iso'));
$nname = $this->db->escape($this->input->post('nname'));
$date = $this->db->escape($this->input->post('date'));
$cname = $this->db->escape($this->input->post('cname'));
$ddesc = $this->db->escape($this->input->post('ddesc'));
$link = $this->db->escape($this->input->post('link'));
$wiki = $this->db->escape($this->input->post('wiki'));
$other = $this->db->escape($this->input->post('other'));
$contact = $this->db->escape($this->input->post('contact'));
$rdesc = $this->db->escape($this->input->post('rdesc'));
$accepted = 0;

$pegged_to = $this->db->escape($this->input->post('pegged_to'));
$pegged_value = $this->db->escape($this->input->post('pegged_value'));
$temp_currency_description = "''";


$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 20000000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    $path = $_FILES['file']['name'];
    $ext = pathinfo($path, PATHINFO_EXTENSION);

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      FCPATH . "assets/img/flags_hd/" . $this->input->post('iso') . "." . $ext);
      copy(FCPATH . "assets/img/flags_hd/" . $this->input->post('iso') . "." . $ext, "/Users/einarstubhaug/ci_mncindex/assets/img/flags/" . $this->input->post('iso') . "." . $ext);
      echo "Stored in: " . "img/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }


if (isset($_POST['currency_text'])) {
    $temp_currency_description = $this->db->escape($_POST['currency_text']);
}

$query = "INSERT INTO micronation VALUES ($iso, $nname, $date, $cname, $ddesc, $link, $wiki, $other, $contact, $rdesc, $temp_currency_description, $accepted);";



$this->db->query($query);

if (isset($_POST['pegged_value'])) {
    $query = "INSERT INTO rel_nation_currency VALUES ($iso, $pegged_to, $pegged_value, $accepted);";
    $this->db->query($query);

}

echo " Done";

  }
    }
    private function getXML() 
      {
        return simplexml_load_file("http://rates.fxcm.com/RatesXML");
      }
    private function insertCurrencyInDatabase($name, $rate) 
      {
        $sql="INSERT INTO currency_history(c_iso_code,value_to_dollar,datetime) VALUES ('$name'     ,$rate,NOW());";
          $this->db->query($sql);
      }
    private function isCurrencyInDatabase($name)
      {
          $query = $this->db->query("SELECT c_iso_code FROM currency WHERE c_iso_code='$name';");
                    
      
          if ($query->num_rows()) { return true; }
          else { return false; }    
      
      }

      public function getCurrencies () {
        $this->load->database();
        $query = $this->db->query("Select * FROM currency");
        return $query->result();
      }

      public function getMacroISOCodes () {
        $this->load->database();
        $query = $this->db->query("Select m_iso_code from micronation");
        return $query->result();

      }
      public function getMicroISOCodes () {
        $this->load->database();
        $query = $this->db->query("Select c_iso_code from currency");
        return $query->result();
      }
}
    