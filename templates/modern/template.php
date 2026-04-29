<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo template_place_holder('head_start'); ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
	<link rel="stylesheet" href="<?php echo $template_path; ?>/style.css">
	<?php echo template_place_holder('head_end'); ?>
</head>
<body class="bg-dark text-light">
	<?php echo template_place_holder('body_start'); ?>

	<nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
		<div class="container">
			<a class="navbar-brand fw-bold text-success" href="<?php echo getLink('news'); ?>">
				<i class="bi bi-shield-fill"></i> <?php echo $config['lua']['serverName']; ?>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarMain">
				<ul class="navbar-nav me-auto">
					<?php
					$menus = get_template_menus();
					foreach ($config['menu_categories'] as $id => $cat):
						if (($id == MENU_CATEGORY_SHOP && !$config['gifts_system']) || !isset($menus[$id])) continue;
					?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
							<?php echo $cat['name']; ?>
						</a>
						<ul class="dropdown-menu dropdown-menu-dark">
							<?php foreach ($menus[$id] as $link): ?>
							<li><a class="dropdown-item" href="<?php echo $link['link_full']; ?>" <?php echo $link['target_blank']; ?> <?php echo $link['style_color']; ?>><?php echo $link['name']; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</li>
					<?php endforeach; ?>
				</ul>
				<div class="d-flex align-items-center gap-2">
					<?php if ($status['online']): ?>
						<span class="badge bg-success"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Online</span>
						<span class="text-light small"><?php echo $status['players']; ?> / <?php echo $status['playersMax']; ?> players</span>
					<?php else: ?>
						<span class="badge bg-danger"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Offline</span>
					<?php endif; ?>
					<?php if (!$logged): ?>
						<a href="<?php echo getLink('account/manage'); ?>" class="btn btn-outline-light btn-sm">Login</a>
						<a href="<?php echo getLink('account/create'); ?>" class="btn btn-success btn-sm">Register</a>
					<?php else: ?>
						<a href="<?php echo getLink('account/manage'); ?>" class="btn btn-outline-success btn-sm">My Account</a>
						<a href="<?php echo getLink('account/logout'); ?>" class="btn btn-outline-danger btn-sm">Logout</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</nav>

	<?php if ($status['online']): ?>
	<div class="bg-success bg-opacity-10 border-bottom border-success py-1">
		<div class="container">
			<div class="d-flex justify-content-between small text-success">
				<span><i class="bi bi-people-fill"></i> Players: <strong><?php echo $status['players']; ?> / <?php echo $status['playersMax']; ?></strong></span>
				<span><i class="bi bi-virus"></i> Monsters: <strong><?php echo $status['monsters']; ?></strong></span>
				<span><i class="bi bi-clock"></i> Uptime: <strong><?php echo $status['uptimeReadable'] ?? 'Unknown'; ?></strong></span>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<main class="container my-4">
		<div class="mb-3">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo getLink('news'); ?>" class="text-success text-decoration-none"><?php echo $config['lua']['serverName']; ?></a></li>
					<?php if (!empty($title) && $title !== $config['lua']['serverName']): ?>
					<li class="breadcrumb-item active text-light" aria-current="page"><?php echo $title; ?></li>
					<?php endif; ?>
				</ol>
			</nav>
		</div>

		<?php echo tickers(); ?>

		<div class="card bg-dark border-secondary">
			<div class="card-header bg-black border-secondary">
				<h4 class="card-title mb-0 text-success"><i class="bi bi-journal-text"></i> <?php echo $title; ?></h4>
			</div>
			<div class="card-body">
				<?php echo template_place_holder('center_top') . $content; ?>
			</div>
		</div>
	</main>

	<footer class="bg-black border-top border-secondary py-4 mt-auto">
		<div class="container">
			<div class="row">
				<div class="col-md-6 text-center text-md-start">
					<p class="mb-1 small"><?php echo template_footer(); ?></p>
				</div>
				<div class="col-md-6 text-center text-md-end">
					<?php if ($config['template_allow_change']): ?>
						<span class="small text-secondary">Theme:</span>
						<?php echo template_form(); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</footer>

	<?php echo template_place_holder('body_end'); ?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
