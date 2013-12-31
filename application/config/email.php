<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// the mail protocol specifies sendmail
$config['mailpath'] = "/usr/sbin/sendmail";
$config['protocol'] = "sendmail";
$config['smtp_host'] = "smtp.live.com";
$config['smtp_user'] = "contact@marijnmartens.be";
$config['smtp_pass'] = "CHEETA@10paren";
$config['smtp_port'] = "25";
$config['mailtype'] = "text/plain";
$config['validate'] = "TRUE";

/* End of file email.php */
/* Location: ./application/config/email.php */