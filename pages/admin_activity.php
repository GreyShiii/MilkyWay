<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/admin.php';
require_once __DIR__ . '/../helpers/activity.php';

require_admin();
$user = auth_user();

if ($user && isset($user['id'])) {
    log_page_visit($conn, (int)$user['id'], 'Visited Admin Activity Dashboard', '/pages/admin_activity.php');
}

$search = trim($_GET['search'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');
$sort = trim($_GET['sort'] ?? 'last_login_desc');
$currentPage = max(1, (int)($_GET['p'] ?? 1));
$perPage = 5;

$where = [];
$params = [];
$types = '';

if ($search !== '') {
    $where[] = "(username LIKE ? OR email LIKE ?)";
    $searchLike = '%' . $search . '%';
    $params[] = $searchLike;
    $params[] = $searchLike;
    $types .= 'ss';
}

$whereSql = '';
if (!empty($where)) {
    $whereSql = 'WHERE ' . implode(' AND ', $where);
}

$orderBy = "ORDER BY last_login DESC";
switch ($sort) {
    case 'visit_count_desc':
        $orderBy = "ORDER BY visit_count DESC";
        break;
    case 'login_count_desc':
        $orderBy = "ORDER BY login_count DESC";
        break;
    case 'last_active_desc':
        $orderBy = "ORDER BY last_active_at DESC";
        break;
    default:
        $orderBy = "ORDER BY last_login DESC";
        break;
}

$sql = "
    SELECT
        id,
        username,
        email,
        role,
        last_login,
        last_active_at,
        login_count,
        visit_count
    FROM users
    $whereSql
    $orderBy
";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$allUsers = [];
while ($row = $result->fetch_assoc()) {
    $allUsers[] = $row;
}
$stmt->close();

function getActivityStatus(array $row): string
{
    $now = time();

    if (!empty($row['last_login'])) {
        $lastLogin = strtotime($row['last_login']);
        if (date('Y-m-d', $lastLogin) === date('Y-m-d', $now)) {
            return 'Logged in today';
        }
    }

    if (!empty($row['last_active_at'])) {
        $lastActive = strtotime($row['last_active_at']);
        if (($now - $lastActive) <= 86400) {
            return 'Recently active';
        }
    }

    return 'Inactive';
}

if ($statusFilter !== '') {
    $allUsers = array_values(array_filter($allUsers, function ($row) use ($statusFilter) {
        return getActivityStatus($row) === $statusFilter;
    }));
}

$totalFilteredUsers = count($allUsers);
$totalPages = max(1, (int)ceil($totalFilteredUsers / $perPage));

if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

$offset = ($currentPage - 1) * $perPage;
$users = array_slice($allUsers, $offset, $perPage);

$totalUsers = 0;
$loggedInToday = 0;
$totalVisits = 0;
$mostActiveUser = '—';
$topVisitCount = -1;

$summaryQuery = $conn->query("
    SELECT id, username, email, last_login, last_active_at, login_count, visit_count
    FROM users
");

while ($row = $summaryQuery->fetch_assoc()) {
    $totalUsers++;
    $totalVisits += (int)$row['visit_count'];

    if (!empty($row['last_login']) && date('Y-m-d', strtotime($row['last_login'])) === date('Y-m-d')) {
        $loggedInToday++;
    }

    if ((int)$row['visit_count'] > $topVisitCount) {
        $topVisitCount = (int)$row['visit_count'];
        $mostActiveUser = $row['username'] ?: $row['email'];
    }
}

$allActivityLogs = [];
$logQuery = $conn->query("
    SELECT
        ual.user_id,
        ual.activity_label,
        ual.page_url,
        ual.created_at,
        u.username,
        u.email
    FROM user_activity_logs ual
    INNER JOIN users u ON u.id = ual.user_id
    ORDER BY ual.created_at DESC
    LIMIT 200
");

while ($row = $logQuery->fetch_assoc()) {
    $allActivityLogs[] = $row;
}

function buildAdminPageLink(int $page): string
{
    $params = $_GET;
    $params['page'] = 'admin_activity';
    $params['p'] = $page;
    return 'index.php?' . http_build_query($params);
}

$startPage = max(1, $currentPage - 1);
$endPage = min($totalPages, $currentPage + 1);

if ($currentPage <= 2) {
    $endPage = min($totalPages, 3);
}
if ($currentPage >= $totalPages - 1) {
    $startPage = max(1, $totalPages - 2);
}
?>

<main class="page admin-activity-page">
    <section class="admin-page-head">
        <div>
            <p class="admin-page-kicker">Admin Monitoring</p>
            <h1>Admin Activity Dashboard</h1>
        </div>

        <div class="admin-head-pill">
            <span class="dot"></span>
            Admin only access
        </div>
    </section>

    <section class="admin-summary-grid">
        <article class="admin-summary-card">
            <p>Total Users</p>
            <h3><?php echo $totalUsers; ?></h3>
        </article>

        <article class="admin-summary-card">
            <p>Logged In Today</p>
            <h3><?php echo $loggedInToday; ?></h3>
        </article>

        <article class="admin-summary-card">
            <p>Total Website Visits</p>
            <h3><?php echo $totalVisits; ?></h3>
        </article>

        <article class="admin-summary-card">
            <p>Most Active User</p>
            <h3><?php echo htmlspecialchars($mostActiveUser); ?></h3>
        </article>
    </section>

    <section class="admin-controls-card">
        <form method="GET" class="admin-controls-form">
            <input type="hidden" name="page" value="admin_activity">

            <div class="admin-control-group">
                <label for="search">Search</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    placeholder="Search email"
                    value="<?php echo htmlspecialchars($search); ?>"
                >
            </div>

            <div class="admin-control-group">
                <label for="status">Filter</label>
                <select id="status" name="status">
                    <option value="">All statuses</option>
                    <option value="Logged in today" <?php echo $statusFilter === 'Logged in today' ? 'selected' : ''; ?>>Logged in today</option>
                    <option value="Recently active" <?php echo $statusFilter === 'Recently active' ? 'selected' : ''; ?>>Recently active</option>
                    <option value="Inactive" <?php echo $statusFilter === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <div class="admin-control-group">
                <label for="sort">Sort</label>
                <select id="sort" name="sort">
                    <option value="last_login_desc" <?php echo $sort === 'last_login_desc' ? 'selected' : ''; ?>>Last login</option>
                    <option value="last_active_desc" <?php echo $sort === 'last_active_desc' ? 'selected' : ''; ?>>Last active</option>
                    <option value="visit_count_desc" <?php echo $sort === 'visit_count_desc' ? 'selected' : ''; ?>>Visit count</option>
                    <option value="login_count_desc" <?php echo $sort === 'login_count_desc' ? 'selected' : ''; ?>>Login count</option>
                </select>
            </div>

            <div class="admin-control-actions">
                <button type="submit" class="admin-btn-primary">Apply</button>
            </div>
        </form>
    </section>

    <section class="admin-users-panel">
        <div class="admin-panel-head">
            <h2>User Activity Monitoring</h2>
            <p><?php echo $totalFilteredUsers; ?> user record(s)</p>
        </div>

        <div class="admin-users-list">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $item): ?>
                    <?php
                    $status = getActivityStatus($item);
                    $displayName = $item['username'] ?: 'No username';
                    $initial = strtoupper(substr($item['username'] ?: $item['email'], 0, 1));

                    $userActivity = array_values(array_filter($allActivityLogs, function ($log) use ($item) {
                        return (int)$log['user_id'] === (int)$item['id'];
                    }));

                    $history = [];
                    foreach ($userActivity as $log) {
                        $history[] = [
                            'label' => $log['activity_label'],
                            'page'  => $log['page_url'] ?: '',
                            'time'  => date('M j, Y • g:i A', strtotime($log['created_at']))
                        ];
                    }
                    ?>
                    <article
                        class="admin-user-row view-activity-trigger"
                        tabindex="0"
                        role="button"
                        data-user-name="<?php echo htmlspecialchars($displayName); ?>"
                        data-user-email="<?php echo htmlspecialchars($item['email']); ?>"
                        data-user-status="<?php echo htmlspecialchars($status); ?>"
                        data-user-id="<?php echo (int)$item['id']; ?>"
                        data-user-login="<?php echo $item['last_login'] ? htmlspecialchars(date('M j, Y • g:i A', strtotime($item['last_login']))) : '—'; ?>"
                        data-user-active="<?php echo $item['last_active_at'] ? htmlspecialchars(date('M j, Y • g:i A', strtotime($item['last_active_at']))) : '—'; ?>"
                        data-user-logins="<?php echo (int)$item['login_count']; ?>"
                        data-user-visits="<?php echo (int)$item['visit_count']; ?>"
                        data-user-history="<?php echo htmlspecialchars(json_encode($history), ENT_QUOTES, 'UTF-8'); ?>"
                    >
                        <div class="admin-user-main">
                            <div class="admin-user-avatar"><?php echo htmlspecialchars($initial); ?></div>

                            <div class="admin-user-identity">
                                <h3><?php echo htmlspecialchars($displayName); ?></h3>
                                <p><?php echo htmlspecialchars($item['email']); ?></p>
                                <span class="admin-user-id">User #<?php echo (int)$item['id']; ?></span>
                            </div>
                        </div>

                        <div class="admin-user-metrics">
                            <div class="admin-mini-stat">
                                <span>Last Login</span>
                                <strong>
                                    <?php echo $item['last_login'] ? htmlspecialchars(date('M j, Y • g:i A', strtotime($item['last_login']))) : '—'; ?>
                                </strong>
                            </div>

                            <div class="admin-mini-stat">
                                <span>Last Active</span>
                                <strong>
                                    <?php echo $item['last_active_at'] ? htmlspecialchars(date('M j, Y • g:i A', strtotime($item['last_active_at']))) : '—'; ?>
                                </strong>
                            </div>

                            <div class="admin-mini-stat">
                                <span>Login Count</span>
                                <strong><?php echo (int)$item['login_count']; ?></strong>
                            </div>

                            <div class="admin-mini-stat">
                                <span>Website Visits</span>
                                <strong><?php echo (int)$item['visit_count']; ?></strong>
                            </div>
                        </div>

                        <div class="admin-user-side">
                            <span class="admin-status-badge status-<?php echo strtolower(str_replace(' ', '-', $status)); ?>">
                                <?php echo htmlspecialchars($status); ?>
                            </span>

                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="admin-empty-state">
                    <p>No matching users found.</p>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="admin-pagination" aria-label="User activity pages">
                <?php if ($currentPage > 1): ?>
                    <a class="admin-page-btn admin-page-arrow" href="<?php echo htmlspecialchars(buildAdminPageLink($currentPage - 1)); ?>" aria-label="Previous page">‹</a>
                <?php else: ?>
                    <span class="admin-page-btn admin-page-arrow is-disabled" aria-hidden="true">‹</span>
                <?php endif; ?>

                <?php for ($pageNum = $startPage; $pageNum <= $endPage; $pageNum++): ?>
                    <?php if ($pageNum === $currentPage): ?>
                        <span class="admin-page-btn is-active"><?php echo $pageNum; ?></span>
                    <?php else: ?>
                        <a class="admin-page-btn" href="<?php echo htmlspecialchars(buildAdminPageLink($pageNum)); ?>">
                            <?php echo $pageNum; ?>
                        </a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a class="admin-page-btn admin-page-arrow" href="<?php echo htmlspecialchars(buildAdminPageLink($currentPage + 1)); ?>" aria-label="Next page">›</a>
                <?php else: ?>
                    <span class="admin-page-btn admin-page-arrow is-disabled" aria-hidden="true">›</span>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    </section>

    <div id="activityOverlay" class="activity-overlay" hidden></div>

    <aside id="activityDrawer" class="activity-drawer" aria-hidden="true">
        <div class="activity-drawer-head">
            <div>
                <p class="activity-drawer-kicker">User Activity</p>
                <h3 id="drawerUserName">User Name</h3>
                <p id="drawerUserEmail" class="activity-drawer-email">email@example.com</p>
            </div>

            <button type="button" id="closeActivityDrawer" class="activity-drawer-close" aria-label="Close">
                ×
            </button>
        </div>

        <div class="activity-drawer-body">
            <div class="activity-detail-grid">
                <div class="activity-detail-card">
                    <span>User ID</span>
                    <strong id="drawerUserId">—</strong>
                </div>

                <div class="activity-detail-card">
                    <span>Status</span>
                    <strong id="drawerUserStatus">—</strong>
                </div>

                <div class="activity-detail-card">
                    <span>Last Login</span>
                    <strong id="drawerUserLogin">—</strong>
                </div>

                <div class="activity-detail-card">
                    <span>Last Active</span>
                    <strong id="drawerUserActive">—</strong>
                </div>

                <div class="activity-detail-card">
                    <span>Login Count</span>
                    <strong id="drawerUserLogins">—</strong>
                </div>

                <div class="activity-detail-card">
                    <span>Website Visits</span>
                    <strong id="drawerUserVisits">—</strong>
                </div>
            </div>

            <div class="activity-history-wrap">
                <h4 class="activity-history-title">Recent Activity</h4>
                <div id="drawerHistoryList" class="activity-history-list"></div>
            </div>
        </div>
    </aside>
</main>

<script src="<?= BASE_URL ?>/public/js/admin_activity.js"></script>