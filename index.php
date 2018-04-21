<?php
/**
 * Created by PhpStorm.
 * User: sumo stephane
 * Date: 17/02/2018
 * Time: 15:03
 */
?>

<?php
session_start();
require_once("database.inc.php");
require_once("header.inc.php");
require_once("footer.inc.php");
if(isset($_POST['logout']))
{
    session_unset();
    session_destroy();
    header("Location:index.php?page=1");
}
$header = new header();
$footer = new footer();
$content = "Come discuss about your forum activities!";
$header->display("Welcome to this forum community!", $_SESSION, $content);
?>

<?php
if(!isset($_GET['page'])) { echo "<script> document.location=\"index.php?page=1\";</script>"; exit(); }
$database = new database();
$request = "SELECT * FROM topic ORDER by last_message_date DESC";
$result = $database->select($request);
$topic_per_page = 20;
$max_page = $result[0] / $topic_per_page;
$max_page = ceil($max_page);
if($max_page == 0) { $max_page = 1; }
$pin_request = "SELECT * FROM topic WHERE statut='pin' ORDER by topic_id DESC";
$pin_result = $database->select($pin_request);
if(isset($_GET['page']))
{
    if($_GET['page'] < 1  || $_GET['page'] > $max_page || !is_numeric($_GET['page'])) { echo "<script> document.location=\"index.php?page=1\";</script>"; exit(); }
}
$nbs = [];
for($i = 1; $i <= $result[0]; $i++)
{
    $nb_request = "SELECT response_id FROM response WHERE topic_id='{$result[$i]->topic_id}' ORDER by date DESC";
    $nb_result = $database->select($nb_request);
    $nbs[] = $nb_result[0] - 1;
}
$pin_nbs = [];
for($i = 1; $i <= $pin_result[0]; $i++)
{
    $nb_pin_request = "SELECT response_id FROM response WHERE topic_id='{$pin_result[$i]->topic_id}' ORDER by date DESC";
    $nb_pin_result = $database->select($nb_pin_request);
    $pin_nbs[] = $nb_pin_result[0] - 1;
}
$statut = [];
for($i = 1; $i <= $result[0]; $i++)
{
    $statut_request = "SELECT statut FROM user WHERE pseudo='{$result[$i]->owner}'";
    $statut_result = $database->select($statut_request);
    $statut[] = $statut_result[1]->statut;
}
$pin_statut = [];
for($i = 1; $i <= $pin_result[0]; $i++)
{
    $pin_statut_request = "SELECT statut FROM user WHERE pseudo='{$pin_result[$i]->owner}'";
    $pin_statut_result = $database->select($pin_statut_request);
    $pin_statut[] = $pin_statut_result[1]->statut;
}
?>
<style>
    .sweet-shield{
        display: none;
    }
     #map {
         height: 500px;
         width: 900px;
         display: none;
      }
</style>
<div class="col-xs-12">
    <div class="col-md-9" style="padding:20px;"><br/><br/>
        <div id="topics"></div>
        <div class="row">
            <div class="col-md-6" id="btn-div1" style="text-align:left;">
                <button class="btn" id="prev" style="background-color:white;">
                <i class="material-icons">arrow_back</i>
                </button>
            </div>
            <div class="col-md-6" id="btn-div2" style="text-align:right;">
                <button class="btn" id="next" style="background-color:white;">
                    <i class="material-icons">arrow_forward</i>
                </button>
            </div>
        </div>
        <br/>
        <hr style="border-width:2px;">
        <br/><br><br/><br/><br/>
        <h4 style="color:#ce813d">New topic</h4>
        <br/>
         <form action="topic-validation.php" method="post" enctype="application/x-www-form-urlencoded" id="topic-form">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" />
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <select class="custom-select" id="country" name="country"><option value="AF">Afghanistan</option>
    <option value="AX">Åland Islands</option>
    <option value="AL">Albania</option>
    <option value="DZ">Algeria</option>
    <option value="AS">American Samoa</option>
    <option value="AD">Andorra</option>
    <option value="AO">Angola</option>
    <option value="AI">Anguilla</option>
    <option value="AQ">Antarctica</option>
    <option value="AG">Antigua and Barbuda</option>
    <option value="AR">Argentina</option>
    <option value="AM">Armenia</option>
    <option value="AW">Aruba</option>
    <option value="AU">Australia</option>
    <option value="AT">Austria</option>
    <option value="AZ">Azerbaijan</option>
    <option value="BS">Bahamas</option>
    <option value="BH">Bahrain</option>
    <option value="BD">Bangladesh</option>
    <option value="BB">Barbados</option>
    <option value="BY">Belarus</option>
    <option value="BE">Belgium</option>
    <option value="BZ">Belize</option>
    <option value="BJ">Benin</option>
    <option value="BM">Bermuda</option>
    <option value="BT">Bhutan</option>
    <option value="BO">Bolivia, Plurinational State of</option>
    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
    <option value="BA">Bosnia and Herzegovina</option>
    <option value="BW">Botswana</option>
    <option value="BV">Bouvet Island</option>
    <option value="BR">Brazil</option>
    <option value="IO">British Indian Ocean Territory</option>
    <option value="BN">Brunei Darussalam</option>
    <option value="BG">Bulgaria</option>
    <option value="BF">Burkina Faso</option>
    <option value="BI">Burundi</option>
    <option value="KH">Cambodia</option>
    <option value="CM">Cameroon</option>
    <option value="CA">Canada</option>
    <option value="CV">Cape Verde</option>
    <option value="KY">Cayman Islands</option>
    <option value="CF">Central African Republic</option>
    <option value="TD">Chad</option>
    <option value="CL">Chile</option>
    <option value="CN">China</option>
    <option value="CX">Christmas Island</option>
    <option value="CC">Cocos (Keeling) Islands</option>
    <option value="CO">Colombia</option>
    <option value="KM">Comoros</option>
    <option value="CG">Congo</option>
    <option value="CD">Congo, the Democratic Republic of the</option>
    <option value="CK">Cook Islands</option>
    <option value="CR">Costa Rica</option>
    <option value="CI">Côte d'Ivoire</option>
    <option value="HR">Croatia</option>
    <option value="CU">Cuba</option>
    <option value="CW">Curaçao</option>
    <option value="CY">Cyprus</option>
    <option value="CZ">Czech Republic</option>
    <option value="DK">Denmark</option>
    <option value="DJ">Djibouti</option>
    <option value="DM">Dominica</option>
    <option value="DO">Dominican Republic</option>
    <option value="EC">Ecuador</option>
    <option value="EG">Egypt</option>
    <option value="SV">El Salvador</option>
    <option value="GQ">Equatorial Guinea</option>
    <option value="ER">Eritrea</option>
    <option value="EE">Estonia</option>
    <option value="ET">Ethiopia</option>
    <option value="FK">Falkland Islands (Malvinas)</option>
    <option value="FO">Faroe Islands</option>
    <option value="FJ">Fiji</option>
    <option value="FI">Finland</option>
    <option value="FR">France</option>
    <option value="GF">French Guiana</option>
    <option value="PF">French Polynesia</option>
    <option value="TF">French Southern Territories</option>
    <option value="GA">Gabon</option>
    <option value="GM">Gambia</option>
    <option value="GE">Georgia</option>
    <option value="DE">Germany</option>
    <option value="GH">Ghana</option>
    <option value="GI">Gibraltar</option>
    <option value="GR">Greece</option>
    <option value="GL">Greenland</option>
    <option value="GD">Grenada</option>
    <option value="GP">Guadeloupe</option>
    <option value="GU">Guam</option>
    <option value="GT">Guatemala</option>
    <option value="GG">Guernsey</option>
    <option value="GN">Guinea</option>
    <option value="GW">Guinea-Bissau</option>
    <option value="GY">Guyana</option>
    <option value="HT">Haiti</option>
    <option value="HM">Heard Island and McDonald Islands</option>
    <option value="VA">Holy See (Vatican City State)</option>
    <option value="HN">Honduras</option>
    <option value="HK">Hong Kong</option>
    <option value="HU">Hungary</option>
    <option value="IS">Iceland</option>
    <option value="IN">India</option>
    <option value="ID">Indonesia</option>
    <option value="IR">Iran, Islamic Republic of</option>
    <option value="IQ">Iraq</option>
    <option value="IE">Ireland</option>
    <option value="IM">Isle of Man</option>
    <option value="IL">Israel</option>
    <option value="IT">Italy</option>
    <option value="JM">Jamaica</option>
    <option value="JP">Japan</option>
    <option value="JE">Jersey</option>
    <option value="JO">Jordan</option>
    <option value="KZ">Kazakhstan</option>
    <option value="KE">Kenya</option>
    <option value="KI">Kiribati</option>
    <option value="KP">Korea, Democratic People's Republic of</option>
    <option value="KR">Korea, Republic of</option>
    <option value="KW">Kuwait</option>
    <option value="KG">Kyrgyzstan</option>
    <option value="LA">Lao People's Democratic Republic</option>
    <option value="LV">Latvia</option>
    <option value="LB">Lebanon</option>
    <option value="LS">Lesotho</option>
    <option value="LR">Liberia</option>
    <option value="LY">Libya</option>
    <option value="LI">Liechtenstein</option>
    <option value="LT">Lithuania</option>
    <option value="LU">Luxembourg</option>
    <option value="MO">Macao</option>
    <option value="MK">Macedonia, the former Yugoslav Republic of</option>
    <option value="MG">Madagascar</option>
    <option value="MW">Malawi</option>
    <option value="MY">Malaysia</option>
    <option value="MV">Maldives</option>
    <option value="ML">Mali</option>
    <option value="MT">Malta</option>
    <option value="MH">Marshall Islands</option>
    <option value="MQ">Martinique</option>
    <option value="MR">Mauritania</option>
    <option value="MU">Mauritius</option>
    <option value="YT">Mayotte</option>
    <option value="MX">Mexico</option>
    <option value="FM">Micronesia, Federated States of</option>
    <option value="MD">Moldova, Republic of</option>
    <option value="MC">Monaco</option>
    <option value="MN">Mongolia</option>
    <option value="ME">Montenegro</option>
    <option value="MS">Montserrat</option>
    <option value="MA">Morocco</option>
    <option value="MZ">Mozambique</option>
    <option value="MM">Myanmar</option>
    <option value="NA">Namibia</option>
    <option value="NR">Nauru</option>
    <option value="NP">Nepal</option>
    <option value="NL">Netherlands</option>
    <option value="NC">New Caledonia</option>
    <option value="NZ">New Zealand</option>
    <option value="NI">Nicaragua</option>
    <option value="NE">Niger</option>
    <option value="NG">Nigeria</option>
    <option value="NU">Niue</option>
    <option value="NF">Norfolk Island</option>
    <option value="MP">Northern Mariana Islands</option>
    <option value="NO">Norway</option>
    <option value="OM">Oman</option>
    <option value="PK">Pakistan</option>
    <option value="PW">Palau</option>
    <option value="PS">Palestinian Territory, Occupied</option>
    <option value="PA">Panama</option>
    <option value="PG">Papua New Guinea</option>
    <option value="PY">Paraguay</option>
    <option value="PE">Peru</option>
    <option value="PH">Philippines</option>
    <option value="PN">Pitcairn</option>
    <option value="PL">Poland</option>
    <option value="PT">Portugal</option>
    <option value="PR">Puerto Rico</option>
    <option value="QA">Qatar</option>
    <option value="RE">Réunion</option>
    <option value="RO">Romania</option>
    <option value="RU">Russian Federation</option>
    <option value="RW">Rwanda</option>
    <option value="BL">Saint Barthélemy</option>
    <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
    <option value="KN">Saint Kitts and Nevis</option>
    <option value="LC">Saint Lucia</option>
    <option value="MF">Saint Martin (French part)</option>
    <option value="PM">Saint Pierre and Miquelon</option>
    <option value="VC">Saint Vincent and the Grenadines</option>
    <option value="WS">Samoa</option>
    <option value="SM">San Marino</option>
    <option value="ST">Sao Tome and Principe</option>
    <option value="SA">Saudi Arabia</option>
    <option value="SN">Senegal</option>
    <option value="RS">Serbia</option>
    <option value="SC">Seychelles</option>
    <option value="SL">Sierra Leone</option>
    <option value="SG">Singapore</option>
    <option value="SX">Sint Maarten (Dutch part)</option>
    <option value="SK">Slovakia</option>
    <option value="SI">Slovenia</option>
    <option value="SB">Solomon Islands</option>
    <option value="SO">Somalia</option>
    <option value="ZA">South Africa</option>
    <option value="GS">South Georgia and the South Sandwich Islands</option>
    <option value="SS">South Sudan</option>
    <option value="ES">Spain</option>
    <option value="LK">Sri Lanka</option>
    <option value="SD">Sudan</option>
    <option value="SR">Suriname</option>
    <option value="SJ">Svalbard and Jan Mayen</option>
    <option value="SZ">Swaziland</option>
    <option value="SE">Sweden</option>
    <option value="CH">Switzerland</option>
    <option value="SY">Syrian Arab Republic</option>
    <option value="TW">Taiwan, Province of China</option>
    <option value="TJ">Tajikistan</option>
    <option value="TZ">Tanzania, United Republic of</option>
    <option value="TH">Thailand</option>
    <option value="TL">Timor-Leste</option>
    <option value="TG">Togo</option>
    <option value="TK">Tokelau</option>
    <option value="TO">Tonga</option>
    <option value="TT">Trinidad and Tobago</option>
    <option value="TN">Tunisia</option>
    <option value="TR">Turkey</option>
    <option value="TM">Turkmenistan</option>
    <option value="TC">Turks and Caicos Islands</option>
    <option value="TV">Tuvalu</option>
    <option value="UG">Uganda</option>
    <option value="UA">Ukraine</option>
    <option value="AE">United Arab Emirates</option>
    <option value="GB">United Kingdom</option>
    <option value="US">United States</option>
    <option value="UM">United States Minor Outlying Islands</option>
    <option value="UY">Uruguay</option>
    <option value="UZ">Uzbekistan</option>
    <option value="VU">Vanuatu</option>
    <option value="VE">Venezuela, Bolivarian Republic of</option>
    <option value="VN">Viet Nam</option>
    <option value="VG">Virgin Islands, British</option>
    <option value="VI">Virgin Islands, U.S.</option>
    <option value="WF">Wallis and Futuna</option>
    <option value="EH">Western Sahara</option>
    <option value="YE">Yemen</option>
    <option value="ZM">Zambia</option>
    <option value="ZW">Zimbabwe</option></select>
                </div>
                <br/>
                <div class="form-group">
                      <div style="margin-bottom:5px;">
                        <button type="button" class="btn" style="background-color:white;color:#4285F4;border:none;display:inline-flex;" onclick="initMap()"><i class="material-icons">directions</i> Add a route</button>
                        <button type="button" class="btn" style="background-color:white;color:#ea4335;border:none;display:inline-flex;" onclick="display_searchbar()"><i class="material-icons">place</i> Add a place </button>
                        <button type="button" class="btn" style="background-color:white;border:none;" onclick="input_style('bold', '#message')"><b>Bold</b></button>
                        <button type="button" class="btn" style="background-color:white;border:none;" onclick="input_style('italic', '#message')"><i>Italic</i></button>
                        <button type="button" class="btn" style="background-color:white;border:none;" onclick="input_style('quote', '#message')">Quote</button>
                        <button type="button" class="btn" style="background-color:white;border:none;" onclick="input_style('link', '#message')"><u>Link</u></button>
                    </div>
                </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name ="place" id="place" placeholder="Search..." hidden/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name ="map_place" id="map_place" placeholder="Search..." hidden/>
                    </div>
                    <div id="map"></div>
                    <textarea class="form-control" id="message" name="message" rows="10"></textarea>
                    <div class="sweet-shield"><input type="text" name="sweet-shield-input" autocomplete="off"/></div>
                    <input type="text" id="place_input" name="place_input" hidden />
                    <input type="text" id="marker_input" name="marker_input" hidden />
             <br/>
                <button type="button" class="btn" id="submit-btn" style="background-color:#242831;color:#ce813d;border:solid 1px #ce813d">POST</button>
            </form>
    </div>
    <div class="col-md-3" id="pub">
    </div>
</div>

<script>
    function formatting(text)
    {
        var regrex = [/\[bold\](.+)\[\/bold\]/g, /\[italic\](.+)\[\/italic\]/g, /\[quote\](.+)\[\/quote\]/g, /\[link\](.+)\[\/link\]/g];
        var by = ["<b>$1</b>", "<i>$1</i>", "<p style=\"background-color:#f8f9fa;color:gray;padding:10px;\">$1</p>", "<a href=\"$1\" target=\"_black\">$1</a>"];
        
        for(var i = 0; i < regrex.length; i++)
        {
            text = text.replace(regrex[i], by[i]);
        }
        return text;
    }
    var topics = document.querySelector('#topics');
    var div = document.createElement('div');
    topics.appendChild(div);
    var page = <?php echo $_GET['page']; ?>;
    var topic_per_page = <?php echo $topic_per_page; ?>;
    var request_count = <?php echo $result[0]; ?>;
    var max_page = Math.ceil(request_count / topic_per_page);
    var result = JSON.stringify(<?php echo json_encode($result); ?>);
    var obj = JSON.parse(result);
    
    var pin_topic = <?php echo $pin_result[0]; ?>;
    var pin = JSON.stringify(<?php echo json_encode($pin_result); ?>);
    var pin_obj = JSON.parse(pin);
    
    var last_topic_id = page * topic_per_page;
    var first_topic_id = last_topic_id - 19;
    
    var html = '<table class="table table-sm table-hover">'+
                    '<thead>'+
                        '<tr>'+
                            '<th scope="col"><h5>TOPIC</h5></th>'+
                            '<th scope="col"><h5>AUTHOR</h5></th>'+
                            '<th scope="col"><h5>NB</h5></th>'+
                            '<th scope="col"><h5>LAST POST</h5></th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>';
    
    if(pin_topic != 0 && page == 1)
    {
        var pin_nbs = <?php echo json_encode($pin_nbs); ?>;
        var pin_colors = <?php echo json_encode($pin_statut); ?>;
        
        for(var i = 1; i <= pin_topic; i++)
        {
            var p_style;
            if(pin_colors[i - 1]=="admin") { p_style="color:#e32a51;" }
            else { p_style="color:#333;" }
            
            html += '<tr><th scope="row"><span style="display:inline-flex;"><h6 style="color:#3cb371;"><i class=\"material-icons\">public</i>&nbsp;</h6><a href="topic/';
            html += pin_obj[i].topic_id;
            html += '/';
            html += encodeURIComponent(pin_obj[i].title);
            html += '/1';
            html += '">';
            html += '<h6 style="color:#212529">';
            html += pin_obj[i].title;
            html += '</h6></a></span>';
            html += '</th><td>';
            html += '<a href="profil/'+pin_obj[i].owner+'" style="';
            html += p_style;
            html += '"><h6>';
            html += pin_obj[i].owner;
            html += '</h6></a>';
            html += '</td>';
            html += '<td>';
            html += '<h6 style="color:#868e96">'+pin_nbs[i - 1]+'<h6>';
            html += '</td>';
            html += '<td>';
            html += '<span><h6 style="color:#868e96">';
            html += pin_obj[i].last_message_date;
            html += '</h6></span>';
            html += '</td>';
            html+= '</tr>';
        }
    }
    
    if(request_count != 0)
    {
        var nbs = <?php echo json_encode($nbs); ?>;
        var colors = <?php echo json_encode($statut); ?>;
        
        for(var i = first_topic_id; i <= last_topic_id; i++)
        {
            if(i > request_count) { break; }
            if(obj[i].statut == 'pin') { continue; }
            
            var style;
            if(nbs[i -1] >= 20) { style="color:red;"; }
            else { style="color:#ce813d;"; }
            
            var p_style;
            if(colors[i - 1]=="admin") { p_style="color:#e32a51;" }
            else { p_style="color:#333;" }
            
            html += '<tr><th scope="row"><span style="display:inline-flex;';
            html += style;
            html += '">';
            html += '<h6><i class="material-icons">public</i>&nbsp;</h6><a href="topic.php?id=';
            html += obj[i].topic_id;
            html += '&title=';
            html += encodeURIComponent(obj[i].title);
            html += '&topic_page=1';
            html += '">';
            html += '<h6><span style="color:#ce813d">'+ obj[i].tag+' | </span><span style="color:#212529">';
            html += obj[i].title;
            html += '</span></h6></a></span>';
            html += '</th><td>';
            html += '<a href="profil/'+obj[i].owner+'" style="';
            html += p_style;
            html += '"><h6>';
            html += obj[i].owner;
            html += '</h6></a>';
            html += '</td>';
            html += '<td>';
            html += '<h6 style="color:#868e96">'+nbs[i - 1]+'</h6>';
            html += '</td>';
            html += '<td>';
            html += '<h6 style="color:#868e96">';
            html += obj[i].last_message_date;
            html += '</h6>';
            html += '</td>';
            html+= '</tr>';
        
            if(i == request_count)
            {
                html += '</tbody></table>';
                break;
            }
            if(i==last_topic_id)
            {
                html += '</tbody></table>';
            }
        }
    
        div.innerHTML=html;
    }
    
    document.querySelector('#prev').addEventListener('click', function() {
        
        if(page > 1)
        {
            page--;
            document.location.href="index.php?page="+page;
        }
        
    });
    document.querySelector('#next').addEventListener('click', function() {
        
        if(page < max_page)
        {
            page++;
            document.location.href="inex.php?page="+page;
        }
    });
    
    var prev = document.querySelector('#prev');
    var next = document.querySelector('#next');
    var btn_div1 = document.querySelector('#btn-div1');
    var btn_div2 = document.querySelector('#btn-div2');
    
    if(page==1) { btn_div1.removeChild(prev); }
    else { btn_div1.appendChild(prev); }
    if(page==max_page){btn_div2.removeChild(next); }
    else { btn_div2.appendChild(next); }
    
    document.querySelector('#submit-btn').addEventListener('click', function() {
       
        var title = document.querySelector('#title').value;
        var country = document.querySelector('#country').value;
        var message = document.querySelector('#message').value;
        var connected = '<?php if(isset($_SESSION['connected'])) { echo $_SESSION['connected']; } else { echo "false"; } ?>';
        
        if(title!="" && country!="" && message!="" && message.length <=65000 && connected=="true")
        {
            document.querySelector('#topic-form').submit();
        }
        else
        {
            if(connected=="false")
            {
                document.location.href="connexion.php";
            }
        }
        
    });
    
    function input_style(balise, textarea)
    {
        var insert = ' ['+balise+']'+'[/'+balise+'] ';
        document.querySelector(textarea).value += insert;
    }
    
    function display_searchbar()
    {
        document.querySelector('#place').removeAttribute('hidden');
    }
    
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxYgxeranY2Bqj8m6RENMfqJhl36e20tI&libraries=places"></script>

<script type="text/javascript" src="script/autocomple.js"></script>
<script type="text/javascript" src="script/route.js"></script>

<?php
    
$footer->display();
?>