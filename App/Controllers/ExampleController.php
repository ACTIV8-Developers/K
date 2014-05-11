<?php
/**
* Example controller class.
*/
class ExampleController extends Controller
{
	public function index()
	{
		// // Load model
		// $model = $this->model('ExampleModel');
		// // Get data from model
		// $data['content'] = $model->getData();
		// // Load data into view and display it
		// $this->response()->render('ExampleView', $data);

        $_SESSION['dsds'] = 'AAAATestttttdsadt';$_SESSION['array'] = ['name'=>'dssdsd', 'dada'=>'ssssd'];

        

        $sessionPath = sys_get_temp_dir();
        $filename = $sessionPath . '/' . session_name() . '_' . session_id();

        echo "<h1>SecureSession Demo</h1>";
        echo "<br>Session created at <strong>" . date("G:i:s ", $_SESSION['s3ss10nCr3at3d']) . "</strong>";
        echo "<br>Session file: <strong>" . $filename . "</strong>";
        //echo "<br><br>Encrypted content:<br><pre>" . file_get_contents($filename). "</pre>";

        var_dump($_SESSION['dsds']);
        var_dump($_SESSION['array']);
        var_dump(date("G:i:s ", $_SESSION['r3fr3sh']));
        var_dump(session_get_cookie_params());
        echo "<br><strong>Note:</strong> If you reload the page you see the encrypted data change each time";
	}
}