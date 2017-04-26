<div>
    Congratulations <?php echo $user->first_name ?>,
    
    <br /><br  />
    You have been accepted as an English Teacher with <?php echo env( 'COMPANY_NAME' ) ?>.
    <br /><br />
    You may login to your account in <?php echo Url( '/login' ); ?> using credentials:
    <br /> Username: <?php echo $user->username ?>

</div>

