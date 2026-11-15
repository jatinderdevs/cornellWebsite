<?php

/**
 * Courses Listing Page
 * Displays all courses from dbcourses.php
 */

require_once 'data/dbcourses.php';

// Optional: group by category
$categories = ['Construction','Hospitality'];
foreach ($courses as $key => $course) {
  $cat = $course['category'] ?? 'Other';
  $categories[$cat][$key] = $course;
}
echo $categories[0];
?>