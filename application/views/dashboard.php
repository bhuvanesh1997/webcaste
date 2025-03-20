<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= $this->session->userdata('user')['name'] ?></h1>
    <h2>Upcoming Events</h2>
    <ul>
        <?php foreach ($events as $event): ?>
            <li><?= $event->getSummary() ?> - <?= $event->getStart()->dateTime ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="<?= base_url('auth/logout') ?>">Logout</a>
</body>
</html>