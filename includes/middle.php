  </head>

  <?php
    function link_unless_current($target, $text, $title = '') {
      $output  = "<li class=\"nav_";
      $output .= str_replace('.php', '', str_replace('/', '', $target));
      if($_SERVER['SCRIPT_NAME'] == $target || $_SERVER['REQUEST_URI'] == $target) {
        $output .= " current";
      }
      $output .= "\"><a href=\"$target\" title=\"$title\">$text</a></li>";
      
      return $output;
    }
  ?>

  <body>
    <div id="container">
      <div id="banner">
        <h1>The Cup With Love Project</h1>
        <p class="gift">Giving the gift of hope to cancer fighters</p>
        <p>The Cup With Love Project donates gifts &mdash; given in cups &mdash; to people fighting cancer in order to restore their sense of hope and empowerment.</p>
      </div> <!-- /banner -->

      <ul id="navigation">
        <?= link_unless_current('/index.php', 'Home', 'Cup With Love home page') ?>
        <?= link_unless_current('/about.php', 'About us', 'More about Cup With Love') ?>
        <?= link_unless_current('/events.php', 'Events', 'Save the date') ?>
        <?= link_unless_current('/volunteers.php', 'Volunteers', 'Become a volunteer') ?>
        <?= link_unless_current('/donations.php', 'Donations', 'How to contribute') ?>
        <?= link_unless_current('/sponsors.php', 'Sponsors/Partners', 'Organizations that support the Project') ?>
        <?= link_unless_current('/books.php', 'Books', 'Books that you might like to read') ?>
        <li class="nav_facebook"><a href="http://www.facebook.com/pages/The-Cup-With-Love-Project/168677379810530" title="Find us on Facebook!"><img src="/images/facebook.png" width="32" height="32" alt="Find us on Facebook" /></a></li>
        <?= link_unless_current('http://www.facebook.com/pages/The-Cup-With-Love-Project/168677379810530', 'Facebook', 'Find us on Facebook')?>
        <?= link_unless_current('/contact.php', 'Contact us', 'Contact the Project') ?>
      </ul>
    
      <div id="primary_content">
