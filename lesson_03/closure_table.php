<?php

function fetchDataFromDB() {
    $connect = mysqli_connect("localhost", "root", "mysql", "php_algo");

    $query = "SELECT c.id_category, c.category_name, c.id_direct_parent, cl.child_id, cl.level
    FROM `categories` AS `c`
    INNER JOIN `category_links` AS `cl` ON `c`.`id_category` = `cl`.`child_id`
    WHERE `cl`.`parent_id` = 1";

    $result = mysqli_query($connect, $query);
    $cats = [];

    while ($cat = mysqli_fetch_assoc($result)) {
        $cats[$cat["id_direct_parent"]][$cat["child_id"]] = $cat;
    }

    return $cats;
}

function buildTree($cats, $id_direct_parent) {
    if (is_array($cats) && isset($cats[$id_direct_parent])) {
        $tree = "<ul>";
        foreach ($cats[$id_direct_parent] as $cat) {
			$tree .= "<li>" . $cat["category_name"];
			$tree .= buildTree($cats, $cat["child_id"]);
			$tree .= "</li>";

		}
		$tree .= "</ul>";
		return $tree;
    }
}

$dataFromDB = fetchDataFromDB();
echo buildTree($dataFromDB, 0);