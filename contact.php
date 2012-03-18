<?php include './includes/top.php' ?>

  <title>Contact Us :: Cup With Love Project</title>
  <meta http-equiv="description" content="The Cup With Love Project donates gifts &mdash; given in cups &mdash; to people fighting cancer in order to restore their sense of hope and empowerment." />

<?php include './includes/middle.php' ?>

<h1>Contact Us</h1>

<?php

  require_once "code/emails.php";
  
	/* This page loosely based on PHP Form Mailer from www.TheDemoSite.co.uk with
		additions and changes to remove javascript.  E-mail validation from
		http://www.ilovejackdaniels.com/ without modifications */

$subject_choices = array('Request a cup', 'Volunteering', 'Sponsorships', 'Donations', 'Other');

if (isset($_POST["submit"])) {

	if (!empty ($_POST["name"])) {
		$name = clean_input_4email($_POST["name"]);
	};
	if (!empty ($_POST["email1"])) {
		$email1 = clean_input_4email($_POST["email1"]);
	};
	if (!empty ($_POST["email2"])) {
		$email2 = clean_input_4email($_POST["email2"]);
	};
	if (!empty ($_POST["thesubject"])) {
		$thesubject = clean_input_4email($_POST["thesubject"]);
	};
	if (!empty ($_POST["themessage"])) {
		$themessage = clean_input_4email($_POST["themessage"], false);
	};
	if (!empty ($_POST["humanizer"])) {
		$humanizer = clean_input_4email($_POST["humanizer"], false);
	};
	
	$message_sent = false;
	$flag = "";
	
	if (valid_referer('contact.php') ) {
		/* This page was called from an invalid referrer, probably a hacker; stop processing */
		$notice = "Error &mdash; this page was called from an invalid referrer.  Please use <a href=\"$valid_ref1\" title=\"Cup With Love contact form\">the Cup With Love contact page</a> to send Cup With Love a message.";
	} else {
		if ($name && $email1 && $email2 && $themessage && $humanizer) { /* If all required fields present */
			if ($email1 == $email2) {
				if (check_email_address($email1)) {
					$success  = 'Your message has been successfully sent to us and we will reply as soon as possible.';
					$success .= ' A copy of your query has been sent to you.';
					$success .= ' Thank you for contacting Cup With Love.';
					
					if (!$thesubject) {
						$thesubject = "[blank]";
					};
					
					$replymessage  = 'Hi ' . $name . ',
Thank you for your email regarding "' . $thesubject . '".
We will reply to you as soon as we can.

Below is a copy of the message you submitted:
--------------------------------------------------
Subject: ' . $thesubject .'
' . $themessage . '
--------------------------------------------------
Thank you.

-- Staff of Cup With Love';
					
					mail($replyemail,
						 "[cupwithlove.org] " . stripslashes($thesubject),
						 "Message from " . stripslashes($name). " through cupwithlove.org:

" . stripslashes($themessage),
						 "From: " . $replyemail . "
Reply-To: " . $email1);
					mail($email1,
						 "Receipt: " . stripslashes($thesubject),
						 stripslashes($replymessage),
						 "From: " . $replyemail . "
Reply-To: " . $replyemail);
					$message_sent = true;
					unset($name, $email1, $email2, $thesubject, $themessage, $humanizer);
				} else { /* Else we don't have a valid e-mail address */
					$error = "The e-mail address you provided is not valid.";
					$flag .= "email1";
					$flag .= "email2";
				}; /* End e-mail validity check */
			} else { /* Else we don't have matching e-mails */
				$error = "Your e-mail addresses don't match.";
				$flag .= "email1";
				$flag .= "email2";
			}; /* End e-mail similarity check */
		} else { /* Else we don't have all of the required fields */
			$error = "Please fill in all required fields.";
			if (!($name)) {
				$flag .= "name";
			};
			if (!($email1)) {
				$flag .= "email1";
			};
			if (!($email2)) {
				$flag .= "email2";
			};
			if (!($themessage)) {
				$flag .= "themessage";
			};
			if (!($humanizer) || $humanizer !== 'love') {
			  $flag .= "humanizer";
			};
		}; /* End validation checks */
	}; /* End valid referrer check */	
}; /* End form processing if it was submitted */
?>

<?php
  if (isset($success)) { print "<p class=\"success\">$success</p>"; };
  if (isset($notice)) { print "<p class=\"notice\">$notice</p>"; };
  if (isset($error)) { print "<p class=\"error\">$error</p>"; };
?>

<div id="howto_gift">
  <h2>How to gift a Cup With Love</h2>

  <p>To have a Cup With Love sent to a cancer patient and/or survivor please send us the following information:</p>

  <ul>
    <li>Recipient's name</li>
    <li>Recipient's complete address</li>
    <li>Recipient's approximate age</li>
    <li>Provide a special message</li>
  </ul>

  <p>Send cup requests to the address to the left. A tax-deductible donation to The Cup With Love Project is greatly appreciated, payable to <strong>The Cup With Love Project</strong>.</p>

  <p>Please allow approximately 30 working days for delivery upon request.</p>

  <p>Your tax-deductible donation is greatly appreciated.</p>
</div>

<h2>Mail and phone</h2>

<address>The Cup With Love Project<br />
5050 Laguna Blvd, Suite 112, PMB 614<br />
Elk Grove, CA 95758</address>

<p>Phone: (916) 606-1823</p>

<h2>E-mail</h2>

<form method="post" action="contact.php">
		<p>* indicates a required field</p>
		<p><label for="name"<?php if (strpos($flag, "name") !== false) { print " class=\"error\""; }; ?>>* Name:</label><input size="30" maxlength="30" name="name" id="name" value="<?php print stripslashes($name); ?>"<?php if (strpos($flag, "name") !== false) { print " class=\"error\""; }; ?> /></p>
		<p><label for="email1"<?php if (strpos($flag, "email1") !== false) { print " class=\"error\""; }; ?>>* E-mail:</label><input size="30" maxlength="80" name="email1" id="email1" value="<?php print stripslashes($email1); ?>"<?php if (strpos($flag, "email1") !== false) { print " class=\"error\""; }; ?> /></p>
		<p><label for="email2"<?php if ((strpos($flag, "email2") !== false)) { print " class=\"error\""; }; ?>>* Confirm e-mail:</label><input size="30" maxlength="80" name="email2" id="email2" value="<?php print stripslashes($email2); ?>"<?php if (strpos($flag, "email2") !== false) { print " class=\"error\""; }; ?> /></p>
		<p><label for="thesubject"<?php if (strpos($flag, "subject") !== false) { print " class=\"error\""; }; ?>>Subject:</label>
		    <select name="thesubject" id="thesubject"<?php if (strpos($flag, "thesubject") !== false) { print " class=\"error\""; }; ?>>
	      <?php
	        foreach ($subject_choices as $choice) {
	          echo "<option value=\"$choice\"";
	          if ($choice == $thesubject) {
	            echo " selected=\"selected\"";
	          }
	          echo ">$choice</option>";
	        }
	      ?>
		    </select>
      <!-- <input size="30" maxlength="100" name="thesubject" id="thesubject" value="<?php print stripslashes($thesubject); ?>"<?php if (strpos($flag, "thesubject") !== false) { print " class=\"error\""; }; ?> /></p> -->
		<p><label for="themessage"<?php if (strpos($flag, "message") !== false) { print " class=\"error\""; }; ?>>* Your message:</label><textarea name="themessage" id="themessage" rows="7" cols="30"<?php if (strpos($flag, "themessage") !== false) { print " class=\"error\""; }; ?>><?php print stripslashes($themessage); ?></textarea><br /><span class="form_hint">If you are requesting a cup, please let us know who you are, and who the cup is for</span></p>
		<p><label for="humanizer"<?php if (strpos($flag, "humanizer") !== false) { print " class=\"error\""; }; ?>>* Human check:</label><input size="30" maxlength="5" name="humanizer" id="humanizer" value="<?php print stripslashes($humanizer); ?>"<?php if (strpos($flag, "humanizer") !== false) { print " class=\"error\""; };?> /><br /><span class="form_hint">Enter the word <strong>love</strong> to help us fight spam</span></p>
		<p><label for="submit">Send it:</label><input type="submit" name="submit" id="submit" value="Contact the Cup With Love Project" /></p>
</form>

<h2>Disclaimer <em>re</em> information and services provided by The Cup With Love Project</h2>

<p>The information provided by the Cup With Love Project is supplemental only and not intended to replace the advice and treatment provided by your doctor or other trained medical staff.  In addition, Cup With Love Project support services  are not a replacement for psychological treatment, counseling or therapy. Cup With Love Project recommends that you see your medical or behavioral health professional for specific health-related, medical or emotional concerns and problems.  Medical information provided to the Cup With Love Project will be protected to the extent permitted by law.</p>

<p>Any links found on our website are provided as information only and Cup With Love Project disclaims any responsibility for errors or omissions in the information provided or any consequences resulting from the use of this information.</p>

<?php include './includes/bottom.php' ?>