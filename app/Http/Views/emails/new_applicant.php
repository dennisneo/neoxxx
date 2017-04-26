<div>

    This is to notify you that an applicant had recently registered.
    <br /><br  />
    Applicant details:<br />
    First name: <?php echo $user->first_name ?><br />
    Last name: <?php echo $user->last_name ?><br />
    Email: <?php echo $user->email ?><Br />
    Gender: <?php echo $user->gender ?><br />
    Created At: <?php echo $user->created_at ?>

    <br /><br />
    To view complete applicant data, please go to <?php echo Url('admin/applicant').'/'.$user->id ?>

    <br /><br />
    NEO Web Team

</div>

