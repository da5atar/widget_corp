<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
	/* Check whether the ID to be deleted is present in the DB */
	$current_subject = find_subject_by_id($_GET["subject"]);
	if (!$current_subject) {
		// subject ID was missing or invalid or 
		// subject couldn't be found in database
		redirect_to("manage_content.php");
	}
	
	/* Making sure we do not delete a subject and create orphaned pages.*/
	$pages_set = find_pages_for_subject($current_subject["id"]);
	if (mysqli_num_rows($pages_set) > 0) {
		$_SESSION["message"] = "Can't delete a subject with pages.";
		redirect_to("manage_content.php?subject={$current_subject["id"]}");
	}
	
	/* finding and deleting */
	$id = $current_subject["id"]; // not necessary step, just for reminder
	$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) == 1) {
		// Success
		$_SESSION["message"] = "Subject deleted.";
		redirect_to("manage_content.php");
	} else {
		// Failure
		$_SESSION["message"] = "Subject deletion failed.";
		redirect_to("manage_content.php?subject={$id}");
	}
	
?>
