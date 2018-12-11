
		<form id="register" method="post" action="https://mayar.abertay.ac.uk/~1800844/login.php" role="form">
			<div class="form-group">
        <input type="hidden" name="regfrm" value="regfrm"/>
				<label for="usr">Username:</label>
				<input type="text" class="form-control" name="rusr">
				<label for="pwd">Password:</label>
				<input type="password" class="form-control" name="rpwd">
				<label for="pwdconf">Confirm Password:</label>
				<input type="password" class="form-control" name="rpwdconf">
				<label for="fname">First Name:</label>
				<input type="text" class="form-control" name="rfname">
				<label for="lname">Last Name:</label>
				<input type="text" class="form-control" name="rlname">
				<input type="submit" class="btn btn-success btn-send" value="Register!">
			</div>
		</form>

        <?php 


$url = 'https://mayar.abertay.ac.uk/~1800840/login.php';


for ($i = 0; $i < 10; $i++)
{
    $user = 'ha ' . $i;
    $data = array(
        'rusr' => $user,
         'rpwd' => 'ha',
         'rpwd' => 'ha',
         'rpwdconf' => 'ha',
         'rfname' => 'ha',
         'rlname' => 'ha',
         'submit' => 'true',
         'regfrm' => 'regfrm'
        );
// use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */ }
    
    var_dump($result);
    echo "lol";
}
