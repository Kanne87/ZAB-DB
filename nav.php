<?php
/*Navigation Header Anfang*/
echo "
<nav class='navbar navbar-inverse'>
  <div class='container-fluid'>
    <div class='navbar-header'>
      <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>                        
      </button>    
      <a class='navbar-brand' href='#'>ZAB-DB</a>
    </div>
    <div class='collapse navbar-collapse' id='myNavbar'>
      <ul class='nav navbar-nav'>
        <li><a href='index.php'>Home</a></li>
        <li><a href='customer_list.php'>Kunden</a></li>
        <li><a href='analyse.php'>Analysen</a></li>
        <li><a href='kalender.php'>Kalender</a></li>
      </ul>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='user_profile.php'>Profil</a></li>
        <li><a href='#'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
";
/*Navigation Header Ende*/
/*Navigation Links Anfang*/
?>