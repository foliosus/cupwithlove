<?php include './includes/top.php' ?>

  <title>Volunteers :: Cup With Love Project</title>
  <meta http-equiv="description" content="The Cup With Love Project donates gifts &mdash; given in cups &mdash; to people fighting cancer in order to restore their sense of hope and empowerment." />

<?php include './includes/middle.php' ?>

<h1>Volunteers</h1>

<h2>Interested in volunteering?</h2>

<img src="/images/preparing_cups.jpg" width="278" height="424" alt="Preparing cups" class="text_wrap" />

<p>Our mission is to enhance the quality of life for those impacted by cancer. It takes an Army of Love so we invite you to become one of our soldiers of love through helping with fund raising activities; collecting tea cups and saucers, coffee mugs, childrens cups, stuff animals, individually wrapped candies, wire ribbon, small gift items such as hotel shampoos, conditioners, soaps, individual wrapped tea bags or hot chocolate, and any small tokens of inspiration that are included in each gift; and assisting in wrapping, shipping and delivering Cups With Love to those traveling the cancer journey.</p>

<p>Thank you for your consideration.</p>

<p>If you are interested in volunteering, please <a href="/contact.php" title="send email to Cup With Love">contact us</a>.</p>

<h3>Student volunteers</h3>

<p>Youth receive community service credits and a Certificate of Recognition for their time, energy and compassion. Volunteer service leaves them with a positive life time experience, knowing that they made a difference in this world through their acts of kindness.</p>

<?php
  require_once "code/forms.php";
  require_once "code/emails.php";
  
  $volunteer_activities = array('advertising' => 'Advertising/marketing', 'outreach' => 'Community outreach', 'cup_pick_up' => 'Cup pick-up/delivery', 'cup_wrapping' => 'Cup wrapping', 'db_maintenance' => 'Database maintenance', 'fundraising' => 'Fundraising', 'inventory' => 'Inventory maintenance', 'speaking' => 'Public speaking', 'recruitment' => 'Volunteer recruitment', 'volunteer_lead' => 'Volunteer lead');

  $show_form = true;
  
  if (isset($_POST['submit'])) {
    $validator = new FormValidator();
    $validator->addValidation("name", "req", "Please fill in your name");
    $validator->addValidation("address", "req", "Please fill in your address");
    $validator->addValidation("city", "req", "Please fill in your city");
    $validator->addValidation("state", "req", "Please fill in your state, e.g. CA");
    $validator->addValidation("state", "alpha", "Please fill in your state, e.g. CA");
    $validator->addValidation("zip", "req", "Please fill in your zip");
    $validator->addValidation("zip", "num", "Please verify that your zip code has only numbers (no letters)");
    $validator->addValidation("phone", "regexp=/^[0-9]{3}-?[0-9]{3}-?[0-9]{4}$/", "Please fill in your phone number, e.g. 555-123-4567");
    $validator->addValidation("phone", "req", "Please fill in your phone number");
    $validator->addValidation("best_time", "req", "Please fill in your preferred times to be reached");
    $validator->addValidation("email", "req", "Please fill in your email");
    $validator->addValidation("email", "email", "Please fill in your email, e.g. my_account_name@gmail.com");
    $validator->addValidation("volunteer", "req", "Please indicate your volunteer history with Cup With Love");
    $validator->addValidation("self_description", "req", "Please select a self-description");
    if($_POST['self_description'] != 'Individual') {
      $validator->addValidation("size", "req", "Please fill out a group size");
      $validator->addValidation("size", "num", "Please fill out a group size that is a number");
    }

    if($validator->ValidateForm()) {
      $volunteer_message = "Hi $name,
      Thank you for volunteering your time to Cup With Love. Our mission to give the gift
      of hope to cancer survivors is made possible by people like you.
      
      We will be in touch shortly, by phone or by email, to coordinate with you.
      
      Thank you again for all that you make possible

      -- Staff of Cup With Love";
      
      $cwlp_message = stripslashes($_POST['name']) . " has offered to volunteer via the website:
        Company name: " . stripslashes($_POST['company_name']) . "
        Address: " . stripslashes($_POST['address']) . "
        City: " . stripslashes($_POST['city']) . "
        State: " . stripslashes($_POST['state']) . "
        ZIP: " . stripslashes($_POST['zip']) . "
        Phone: " . stripslashes($_POST['phone']) . "
        Best time to reach: " . stripslashes($_POST['best_time']) . "
        Email: " . stripslashes($_POST['email']) . "
        Volunteer history with CWLP: " . stripslashes($_POST['volunteer']) . "
        Self-description: " . stripslashes($_POST['self_description']) . "
        Size: " . stripslashes($_POST['size']) . "
        Volunteer activities: ";
      $activities = array();
      foreach($volunteer_activities as $key => $text) {
        if($_POST[$key]) {
          $activites[] = $text;
        }
      }
      if($_POST['volunteer_other']) {
        $activities[] = stripslashes($_POST['volunteer_other']);
      }
      $cwlp_message .= implode(', ', $activities);

      mail($replyemail,
      	"[cupwithlove.org] Volunteer offer",
      	$cwlp_message,
      	"From: " . stripslashes($_POST['email']) . "
        Reply-To: " . stripslashes($_POST['email']));
      mail(stripslashes($_POST['email']),
  		  "Thank you for volunteering",
  		  $volunteer_message,
  		  "From: $replyemail
        Reply-To: $replyemail");
			$message_sent = true;
      ?>
        <h2>Thank you!</h2>
        <p class="success">Thank you for offering to volunteer your time.  Someone will be in touch with you shortly by email or by phone.  A confirmation email has been sent to <?= htmlspecialchars($_POST['email']) ?>.</p>
      <?php
      $show_form = false;
    } else {
      echo "<h2>Almost there...</h2>\n";
      echo "<ul class=\"error\">\n";
      $errors = $validator->GetErrors();
      foreach($errors as $name => $error) {
        echo "\t<li>$error</li>\n";
      }
      echo "</ul>\n";
    }
  } else {
    $errors = array();
    echo "<h2>Volunteer now!</h2>";
  }
  
  if ($show_form == true) {
  ?>
  <form action="volunteers.php" method="post">
    <?= text_input('name', '* Full name') ?>
    <?= text_input('company_name', 'Company name', 'Only necessary if you represent a group of volunteers') ?>
    <?= text_input('address', 'Address', null, 60) ?>
    <?= text_input('city', '* City') ?>
    <?= text_input('state', '* State', null, 2) ?>
    <?= text_input('zip', '* ZIP code') ?>
    <?= text_input('phone', '* Phone number', '555-123-4567', 12) ?>
    <?= text_input('best_time', '* Best time to be reached') ?>
    <?= text_input('email', '* Email') ?>
    <?= select_input('volunteer', '* Volunteer history', array('This will be my first time', 2009, 2008, 2007, 2006, 2005), 'Do you have volunteer experience with Cup With Love?  If so, when?'); ?>
    <?= select_input('self_description', '* Which of the following best describes you?', array('Individual', 'Group', 'Organization', 'Non-profit organization', 'Corporate sponsor')) ?>
    <?= text_input('size', '* Size', 'If you are a group, how many in your party are available to donate their time?', 3) ?>

    <p>
      <label for="activities">Activities</label>
      <span class="hint">For which activities are you interested in volunteering?</span>
      <?php
        foreach($volunteer_activities as $name => $text) {
          ?>
            <input type="checkbox" value="<?= $text ?>" name="<?= $name ?>"<?= $_POST[$name] == $text ? ' checked="checked"' : '' ?>> <?= $text ?><br />
          <?php
        }
      ?>
      Other: <input type="text" name="volunteer_other" size="40" maxlength="40" />
    </p>
    <p><input type="submit" name="submit" value="I want to volunteer!"></p>
  </form>
  <?php
  }
?>

<?php include './includes/bottom.php' ?>
