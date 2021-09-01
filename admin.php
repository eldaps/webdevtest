<?php
    include_once("db.php");
    $conn = new mysqli($servername, $username, $password, $databasename);
    if($conn->connect_error) {
        echo "Could not connect to database.";
        die();
    }
    $pagesize = 10;
    // Sorting
    $sort = $_GET['sort'] ?? null;
    if($sort == 'name') {
        $sort = 'email';
    } else {
        $sort = 'timestamp';
    }

    // Search
    $search = $_GET["search"] ?? null;
    if($search == null) {
        $search = "%%";
    } else {
        $search = "%$search%";
    }

    // Offset (for pagination)
    $offset = $_GET["offset"] ?? 0;
    $offset = intval($offset);

    $filterbase = $_GET["filter"] ?? null;
    if($filterbase != null && strlen($filterbase) > 0) {
        $filter = "AND email_provider = '$filterbase'";
    } else {
        $filter = "";
        $filterbase = "";
    }

    // SQL 1: Get all unique email providers for filter buttons
    $sql = "SELECT DISTINCT email_provider FROM $tablename";
    if($result = $conn->query($sql)) {
        $providers = $result->fetch_all();
        for($i = 0; $i < count($providers); ++$i) {
            $providers[$i] = $providers[$i][0];
        }
    } else {
        echo "SQL statement failed to execute.";
        echo $sql;
        echo "<br>";
        echo mysqli_error($conn);
    }

    // SQL 2: Get total row count
    $sql = "SELECT COUNT(*) FROM $tablename WHERE email LIKE '$search' $filter;";

    $total_rows = 0;
    if($result = $conn->query($sql)) {
        $total_rows = $result->fetch_all()[0][0];
    } else {
        echo "SQL statement failed to execute.";
        echo $sql;
        echo "<br>";
        echo mysqli_error($conn);
    }
    // Reset offset if it is out of bounds (i.e. due to changing filter)
    if($offset < 0 || $offset >= $total_rows) {
        $offset = 0;
    }
?>
<style>
    table, th, td {
        border: 1px solid #111111;
        border-collapse: collapse;
        padding: 2px 5px;}
</style>
<form action="/admin.php">
<input type="hidden" name="offset" value="<?php echo $offset; // Save offset state ?>">
<input type="hidden" name="filter" value="<?php echo $filterbase; // Preserve filter state ?>">
Filter by e-mail provider (current: <?php echo strlen($filterbase) == 0 ? 'none' : $filterbase ?>):<br>
<button type="submit" name="filter" value="">Clear filter</button><br><br>
<?php
    foreach($providers as $provider) {
        echo '<button type="submit" name="filter" value="' . htmlentities($provider) . '">' . htmlentities($provider) . '</button><br>';
    }
?>
Sort by:<br>
<input type="radio" name="sort" value="time" id="time" <?php if($sort == 'timestamp') {echo 'checked';} ?>><label for="time">Time</label><br>
<input type="radio" name="sort" value="name" id="name" <?php if($sort == 'email') {echo 'checked';} ?>><label for="name">Name</label><br>
<input type="text" name="search" value="<?php echo substr($search, 1, strlen($search)-2) ?>">
<button type="submit" name="offset" value="0">Search</button>
<br>
<br>
<?php if($offset - $pagesize >= 0) {echo '<button type="submit" name="offset" value="' . max(0,$offset-$pagesize) . '">Previous page</button>';}
if($offset + $pagesize < $total_rows) {echo '<button type="submit" name="offset" value="' . $offset + $pagesize . '">Next page</button>';}?>
</form>
<form action="export.php" method="post">
<table>
    <tr>
        <th>E-mail address</th>
        <th>Time of registration</th>
        <th>Select</th>
    </tr>
    <?php
        // SQL 3: Get 10 ($pagesize) entries using given offset, applying filter & search if required
        $sql = "SELECT id, email, timestamp from $tablename WHERE email LIKE '$search' $filter order by $sort asc LIMIT $pagesize OFFSET $offset;";
        if($result = $conn->query($sql)) {
            foreach($result as $row) {
                // htmlentities to encode special chars for XSS safety
                echo '<tr><td>' . htmlentities($row['email']) . '</td><td>' . $row['timestamp'] .'</td><td><input type="checkbox" name="selected[]" value="' . $row['id'] . '"></td></tr>';
            }
        } else {
            echo "SQL statement failed to execute.";
            echo $sql;
            echo "<br>";
            echo mysqli_error($conn);
        }
        $conn->close();
        
    ?>
</table>
<button type="submit" name="export" value="1">Export selected data</button>
<br><br>
<button type="submit" name="delete" value="1">Delete selected data</button>
</form>

