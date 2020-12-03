<?php
/* --------- Main functions of the project ---------- */

/* =======================================================
 * This function will remove the marked zeros and then remove
 * any remaining marks from date and return a clean date and
 * time to the user. */
function strip_zeros_from_date($maked_string="") {
	// first remove the marked zeros
	$no_zeros = str_replace('*0','', $maked_string);
	// then remove any remaining marks
	$cleaned_string = str_replace('*','', $no_zeros);
	return $cleaned_string;
}

/* =========================================================
 * This function will redirect to the specified location which
 * is given while the function has been called. */
function redirect_to( $location = NULL) {
	if($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}

/* ===========================================================
 * This function will output a message which is described by the
 * user for a specific operation. */
function output_message($message="") {
	if(!empty($message)) {
		return "<p class=\"message\">{$message}</p>";
	} else {
		return "";
	}
}

/* ============================================================
 * This function while find the class in the /inc directory by
 * giving the class name as paramaters to the function. */
spl_autoload_register(function($class_name) {
	$class_name = strtolower($class_name);
	$path = "LIB_PATH.DS.{$class_name}.php";
	if(file_exists($path)) {
		require_once($path);
	} else {
		die("The file {$class_name}.php could not be found.");
	}

});

/* ==============================================================
 * This function will create and update the log file which contains
 * all the log files that happens during the application workflow.
 * */
function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
	if($handle = fopen($logfile, 'a')) { // append
		$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message} ".PHP_EOL;
		fwrite($handle, $content);
		fclose($handle);
		if($new) { chmod($logfile, 0755); }
	} else {
		echo "Could not open log file for writing.";
	}
}

/* ============================================================
 * This function will convert the date and time to text for a
 * certain operations. */
function datetime_to_text($datetime="") {
	$unixdatetime = strtotime($datetime);
	return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

/* =============================================================
 * This function will get the current page name and will return
 * it by calling the function only. */
function get_page_name() {
	return basename($_SERVER['PHP_SELF']);
}

/* ==============================================================
 * This function will produce a breadcrumb for the application by
 * getting the page name and checking with the URL so that it will
 * load exact page's breadcrumb. */
function breadcrumb() {
    $page_name = get_page_name();
	$output = '';
	if($page_name == 'index.php') {
    $output	= '<li><a href="index.php">Dashboard</a></li>';
    } else if($page_name == 'user_group.php') {
    $output	= '<li><a href="user_group.php">User Group</a></li>';
    } else if($page_name == 'users.php') {
    $output	= '<li><a href="users.php">Users</a></li>';
    } else if($page_name == 'subject.php') {
    $output	= '<li><a href="subject.php">Subject</a></li>';
    } else if($page_name == 'classes.php') {
    $output	= '<li><a href="classes.php">Class</a></li>';
    } else if($page_name == 'change_password.php') {
    $output	= '<li><a href="change_password.php">Change Password</a></li>';
    } else if($page_name == 'students.php') {
    $output	= '<li><a href="students.php">Students</a></li>';
    } else if($page_name == 'student_profile.php') {
    $output	= '<li><a href="students.php">Students</a> <i class="fa fa-angle-right"></i></li>
				<li><a href="student_profile.php">Student Profile</a></li>';
    } else if($page_name == 'students_update.php') {
    $output	= '<li><a href="students.php">Students</a> <i class="fa fa-angle-right"></i></li>
				<li>Update Student</li>';
    } else if($page_name == 'users_update.php') {
    $output	= '<li><a href="users.php">Users</a> <i class="fa fa-angle-right"></i></li>
				<li>Update User</li>';
    } else if($page_name == 'teachers.php') {
    $output	= '<li><a href="teachers.php">Teachers</a></li>';
    } else if($page_name == 'teachers_update.php') {
    $output	= '<li><a href="teachers.php">Teachers</a> <i class="fa fa-angle-right"></i></li>
				<li>Update Teachers</li>';
    } else if($page_name == 'teacher_profile.php') {
    $output	= '<li><a href="teachers.php">Teachers</a> <i class="fa fa-angle-right"></i></li>
				<li>Teachers Profile</li>';
    } else if($page_name == 'exams.php') {
    $output	= '<li><a href="exams.php">Exams</a></li>';
    } else if($page_name == 'marks.php') {
    $output	= '<li><a href="marks.php">Marks</a></li>';
    } else if($page_name == 'library.php') {
    $output	= '<li><a href="library.php">Library</a></li>';
    } else if($page_name == 'drivers.php') {
	$output	= '<li>Transport <i class="fa fa-angle-right"></i></li>';
    $output	= '<li><a href="drivers.php">Drivers</a></li>';
    } else if($page_name == 'routes.php') {
	$output	= '<li>Transport <i class="fa fa-angle-right"></i></li>';
    $output	= '<li><a href="routes.php">Routes</a></li>';
    } else {
		// Something else
	}
	return $output;
}

/* ============================================================
 * This function will get the public IP address of the user
 * which is checking the application. */
function getIP() {
	$ip = $_SERVER['REMOTE_ADDR'];

	if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	return $ip;
}

?>
