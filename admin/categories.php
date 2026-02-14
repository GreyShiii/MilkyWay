<?php
require_once __DIR__ . '/../helpers/guard.php';
require_once __DIR__ . '/../config/db.php';
requireAdmin();

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Create slug from name
function makeSlug($name) {
  $slug = strtolower(trim($name));
  $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
  $slug = preg_replace('/[\s-]+/', '-', $slug);
  return trim($slug, '-');
}

// Ensure slug is unique (adds -2, -3, ...)
function uniqueSlug($conn, $baseSlug, $ignoreId = 0) {
  $slug = $baseSlug;
  $i = 2;

  while (true) {
    if ($ignoreId > 0) {
      $stmt = $conn->prepare("SELECT category_id FROM categories WHERE category_slug = ? AND category_id != ? LIMIT 1");
      $stmt->bind_param("si", $slug, $ignoreId);
    } else {
      $stmt = $conn->prepare("SELECT category_id FROM categories WHERE category_slug = ? LIMIT 1");
      $stmt->bind_param("s", $slug);
    }

    $stmt->execute();
    $res = $stmt->get_result();
    $exists = $res && $res->fetch_assoc();
    $stmt->close();

    if (!$exists) return $slug;

    $slug = $baseSlug . '-' . $i;
    $i++;
  }
}

// Handle add/update/delete
$action = $_POST['action'] ?? '';

if ($action === 'add') {
  $name = trim($_POST['category_name'] ?? '');
  $sort = trim($_POST['sort_order'] ?? '0');
  $sortOrder = is_numeric($sort) ? (int)$sort : 0;

  if ($name === '') {
    $_SESSION['cat_msg'] = "Category name is required.";
    header("Location: categories.php");
    exit();
  }

  $baseSlug = makeSlug($name);
  if ($baseSlug === '') $baseSlug = 'category';

  $slug = uniqueSlug($conn, $baseSlug);

  $stmt = $conn->prepare("INSERT INTO categories (category_name, category_slug, sort_order) VALUES (?, ?, ?)");
  $stmt->bind_param("ssi", $name, $slug, $sortOrder);
  $stmt->execute();
  $stmt->close();

  $_SESSION['cat_msg'] = "Category added.";
  header("Location: categories.php");
  exit();
}

if ($action === 'update') {
  $id = (int)($_POST['category_id'] ?? 0);
  $name = trim($_POST['category_name'] ?? '');
  $sort = trim($_POST['sort_order'] ?? '0');
  $sortOrder = is_numeric($sort) ? (int)$sort : 0;

  if ($id <= 0 || $name === '') {
    $_SESSION['cat_msg'] = "Invalid update.";
    header("Location: categories.php");
    exit();
  }

  $baseSlug = makeSlug($name);
  if ($baseSlug === '') $baseSlug = 'category';

  $slug = uniqueSlug($conn, $baseSlug, $id);

  $stmt = $conn->prepare("UPDATE categories SET category_name=?, category_slug=?, sort_order=? WHERE category_id=?");
  $stmt->bind_param("ssii", $name, $slug, $sortOrder, $id);
  $stmt->execute();
  $stmt->close();

  $_SESSION['cat_msg'] = "Category updated.";
  header("Location: categories.php");
  exit();
}

if ($action === 'delete') {
  $id = (int)($_POST['category_id'] ?? 0);
  if ($id <= 0) {
    $_SESSION['cat_msg'] = "Invalid delete.";
    header("Location: categories.php");
    exit();
  }

  // WARNING: this will delete related videos if FK ON DELETE CASCADE
  $stmt = $conn->prepare("DELETE FROM categories WHERE category_id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();

  $_SESSION['cat_msg'] = "Category deleted.";
  header("Location: categories.php");
  exit();
}

// Fetch categories
$cats = [];
$res = $conn->query("SELECT category_id, category_name, category_slug, sort_order FROM categories ORDER BY sort_order ASC, category_name ASC");
if ($res) {
  while ($row = $res->fetch_assoc()) $cats[] = $row;
}

$msg = $_SESSION['cat_msg'] ?? '';
unset($_SESSION['cat_msg']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Categories</title>
  <link rel="stylesheet" href="/MILKYWAY/public/css/main.css?v=1">
</head>
<body style="background:#FFE6E6;">
  <div class="admin-wrap">
    <h2 style="margin:0 0 10px;">Categories</h2>
    <div class="small">Admin only. Categories define the Watch &amp; Learn tabs.</div>

    <?php if ($msg): ?>
      <div class="msg"><?= e($msg) ?></div>
    <?php endif; ?>

    <div class="card">
      <h3 style="margin:0 0 10px;">Add Category</h3>
      <form method="POST" class="row">
        <input type="hidden" name="action" value="add">
        <input type="text" name="category_name" placeholder="Category name (e.g., Latch)" required>
        <input type="number" name="sort_order" placeholder="Sort order" value="0" style="width:140px;">
        <button class="btn btn-primary" type="submit">Add</button>
      </form>
    </div>

    <div class="card" style="margin-top:14px;">
      <h3 style="margin:0 0 10px;">Existing Categories</h3>

      <?php if (!$cats): ?>
        <div>No categories yet.</div>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th style="width:70px;">ID</th>
              <th>Name</th>
              <th>Slug</th>
              <th style="width:110px;">Sort</th>
              <th style="width:260px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cats as $c): ?>
              <tr>
                <td><?= (int)$c['category_id'] ?></td>
                <td><?= e($c['category_name']) ?></td>
                <td><?= e($c['category_slug']) ?></td>
                <td><?= e($c['sort_order']) ?></td>
                <td>
                  <!-- Update -->
                  <form method="POST" style="display:inline-flex; gap:8px; align-items:center;">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="category_id" value="<?= (int)$c['category_id'] ?>">
                    <input type="text" name="category_name" value="<?= e($c['category_name']) ?>" style="width:170px;">
                    <input type="number" name="sort_order" value="<?= e($c['sort_order']) ?>" style="width:80px;">
                    <button class="btn btn-gray" type="submit">Save</button>
                  </form>

                  <!-- Delete -->
                  <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this category? Videos under it may also be deleted if cascade is enabled.');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="category_id" value="<?= (int)$c['category_id'] ?>">
                    <button class="btn btn-danger" type="submit">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <div style="margin-top:14px;">
      <a class="btn btn-gray" href="/MILKYWAY/admin/dashboard.php" style="text-decoration:none;display:inline-block;">← Back to Dashboard</a>
    </div>
  </div>
</body>
</html>
