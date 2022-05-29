<?php

include "db.php";

$status = $_GET['status'];

if ($status == "addtodo") {
    $sql_insert_todo = $pdo->prepare("INSERT INTO todo_tbl(entry_description,entry_status) VALUES(?,?)");
    $sql_insert_todo->execute([$_POST['myentry'], 0]);
} else if ($status == "loadtodo") {
    $sql_load_todo = $pdo->query("SELECT * FROM todo_tbl ORDER BY list_id DESC");
    while ($rows = $sql_load_todo->fetch()) {
        if ($rows->entry_status == 0) {
?>
            <div class="todo">
                <input type="checkbox" name="todo_entry" id="<?php echo $rows->list_id; ?>" onchange="checkentry(this.id)" hidden>
                <label for="<?php echo $rows->list_id; ?>"><?php echo $rows->entry_description; ?></label>
                <button id="<?php echo $rows->list_id; ?>" onclick="deletefromlist(this.id)">Delete</button>
            </div>
        <?php
        } else {
        ?>
            <div class="todo">
                <input type="checkbox" name="todo_entry" id="<?php echo $rows->list_id; ?>" onchange="checkentry(this.id)" checked hidden>
                <label for="<?php echo $rows->list_id; ?>"><strike><?php echo $rows->entry_description; ?></strike></label>
                <button id="<?php echo $rows->list_id; ?>" onclick="deletefromlist(this.id)">Delete</button>
            </div>
<?php
        }
    }
} else if ($status == "updatetodo") {
    $list_id = $_POST['list_id'];
    $sql_check_entry = $pdo->prepare("SELECT * FROM todo_tbl WHERE list_id = ?");
    $sql_check_entry->execute([$list_id]);
    foreach ($sql_check_entry->fetchAll() as $row) {
        if ($row->entry_status == 1) {
            $sql_update_entry = $pdo->prepare("UPDATE todo_tbl SET entry_status = ? WHERE list_id = ?");
            $sql_update_entry->execute([0, $list_id]);
        } else {
            $sql_update_entry = $pdo->prepare("UPDATE todo_tbl SET entry_status = ? WHERE list_id = ?");
            $sql_update_entry->execute([1, $list_id]);
        }
    }
} else if ($status == "deletefromlist") {
    $list_id = $_POST['list_id'];
    $sql_delete_entry = $pdo->prepare("DELETE FROM todo_tbl WHERE list_id = ?");
    $sql_delete_entry->execute([$list_id]);
} else if ($status == "clearlist") {
    $sql_clear_entry = $pdo->prepare("DELETE FROM todo_tbl");
    $sql_clear_entry->execute();
}


?>