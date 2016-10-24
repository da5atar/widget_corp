<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
		<ul class="subjects"> <!-- For displaying subjects' menu_name -->
			<?php
				// querying the subjects table
				$query  = "SELECT * ";
				$query .= "FROM subjects ";
				$query .= "WHERE visible = 1 ";
				$query .= "ORDER BY position ASC";
				$subject_set = mysqli_query($connection, $query);
				confirm_query($subject_set);
			?>
		<?php
			// Looping thru the subjects table
			while($subject = mysqli_fetch_assoc($subject_set)) {
		?>
				<li>
					<?php echo $subject["menu_name"]; ?>
					<?php
						//querying the 'pages' table
						$query  = "SELECT * ";
						$query .= "FROM pages ";
						$query .= "WHERE visible = 1 ";
						$query .= "AND subject_id = {$subject["id"]} "; // limits the query to only the pages that belong to current subject
						$query .= "ORDER BY position ASC";
						$page_set = mysqli_query($connection, $query);
						confirm_query($page_set);
						// Notice here $query could be reused but not $result because of the loop
					?>
					<ul class="pages">
						<?php
							while($page = mysqli_fetch_assoc($page_set)) {
						?>
								<li><?php echo $page["menu_name"]; ?></li>
					  <?php
							}
						?> <!-- ends looping through pages table-->
						<?php mysqli_free_result($page_set); ?>
					</ul>
				</li>
	  <?php
			}
		?> <!-- ends looping thru subjects table -->
		<?php mysqli_free_result($subject_set); ?>
		</ul>
  </div>
  <div id="page">
    <h2>Manage Content</h2>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
