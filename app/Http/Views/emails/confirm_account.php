

<div>
Hi <?php echo $user->first_name ?>,
<br /><br  />
Thank you for using <?php echo env( 'SITE_NAME' ) ?>!<br /><br />
Please confirm your email address by clicking on the link below.
We'll communicate with you from time to time via email so it's important that we have an up-to-date
email address on file.
<br /><br  />
Please visit the following link to confirm your account:
<br />
<?php echo url( 's/confirm' ) ?>?uid=<?php echo \Helpers\Text::convertInt( $user->id ) ?>&c=<?php echo $user->confirmation_code ?>
<br /><br />
Thanks,
<?php echo env( 'SITE_NAME' ) ?> Web Team
<br />

</div>