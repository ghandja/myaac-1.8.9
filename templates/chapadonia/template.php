<?php
defined('MYAAC') or die('Direct access not allowed!');

function logo_monster() {
	global $config;
	return isset($config['logo_monster']) ? str_replace(" ", "", trim(strtolower($config['logo_monster']))) : 'dragon';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<?php echo template_place_holder('head_start'); ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
	<link rel="stylesheet" href="<?php echo $template_path; ?>/style.css">
	<?php echo template_place_holder('head_end'); ?>
</head>
<body>
	<?php echo template_place_holder('body_start'); ?>

	<header class="header-top">
		<div class="container-fluid">
			<div class="d-flex justify-content-between align-items-center py-2 px-3 flex-wrap">
				<a href="https://discord.gg/seuconvite" target="_blank" class="btn btn-discord btn-sm">
					<i class="bi bi-discord"></i> Discord
				</a>
				<div class="d-flex align-items-center gap-2">
					<?php if ($status['online']): ?>
						<span class="status-badge online"><span class="status-dot"></span>Online</span>
						<span class="text-light small d-none d-md-inline"><?php echo $status['players']; ?> jogadores</span>
					<?php else: ?>
						<span class="status-badge offline"><span class="status-dot"></span>Offline</span>
					<?php endif; ?>
					<?php if (!$logged): ?>
						<a href="<?php echo getLink('account/manage'); ?>" class="btn btn-outline-light btn-sm d-none d-sm-inline">Entrar</a>
						<a href="<?php echo getLink('account/create'); ?>" class="btn btn-leaf btn-sm">Criar Conta</a>
					<?php else: ?>
						<a href="<?php echo getLink('account/manage'); ?>" class="btn btn-outline-leaf btn-sm d-none d-sm-inline">Minha Conta</a>
						<a href="<?php echo getLink('account/logout'); ?>" class="btn btn-outline-danger btn-sm">Sair</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</header>

	<?php if ($status['online']): ?>
	<div class="status-bar">
		<div class="container-fluid">
			<div class="d-flex justify-content-center gap-3 gap-md-5 small flex-wrap">
				<span><img src="images/items/2991.gif" width="20" height="20" class="status-icon" onerror="this.style.display='none'"> <strong><?php echo $status['players']; ?> / <?php echo $status['playersMax']; ?></strong> Jogadores</span>
				<span><img src="images/items/3114.gif" width="20" height="20" class="status-icon" onerror="this.style.display='none'"> <strong><?php echo $status['monsters']; ?></strong> Monstros</span>
				<span><img src="images/items/9660.gif" width="20" height="20" class="status-icon" onerror="this.style.display='none'"> <strong><?php echo $status['uptimeReadable'] ?? 'Desconhecido'; ?></strong> Uptime</span>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="container-fluid main-container my-3">
		<div class="row g-3">
			<!-- ===== LEFT SIDEBAR: MENUS ===== -->
			<aside class="col-lg-2 col-md-3 order-1">
				<div class="sidebar-left">
					<?php
					$menus = get_template_menus();
					$first = true;
					$catIcons = [
						'news' => 2815,       // letter/scroll
						'account' => 3427,     // shield
						'community' => 3063,  // ring
						'forum' => 2822,      // book
						'library' => 3059,    // spellbook
						'shops' => 3043,      // crystal coin
					];
					foreach ($config['menu_categories'] as $id => $cat):
						if (!isset($menus[$id])) continue;
					?>
					<div class="menu-category">
						<button class="menu-cat-btn <?php echo $first ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#menu-<?php echo $cat['id']; ?>">
							<?php if (isset($catIcons[$cat['id']])): ?>
							<img src="images/items/<?php echo $catIcons[$cat['id']]; ?>.gif" width="18" height="18" class="menu-icon" onerror="this.style.display='none'">
							<?php endif; ?>
							<span><?php echo $cat['name']; ?></span>
							<i class="bi bi-chevron-down ms-auto"></i>
						</button>
						<div class="collapse <?php echo $first ? 'show' : ''; ?>" id="menu-<?php echo $cat['id']; ?>">
							<div class="menu-links">
								<?php foreach ($menus[$id] as $link): ?>
								<a href="<?php echo $link['link_full']; ?>" <?php echo $link['target_blank']; ?> <?php echo $link['style_color']; ?>>
									<?php echo $link['name']; ?>
								</a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<?php $first = false; endforeach; ?>
				</div>
			</aside>

			<!-- ===== CENTER: CONTENT ===== -->
			<main class="col-lg-7 col-md-5 order-2 order-md-2">
				<nav aria-label="breadcrumb" class="mb-3">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
					</ol>
				</nav>

				<?php echo tickers(); ?>

				<div class="card rasta-card">
					<div class="card-body">
						<?php echo template_place_holder('center_top') . $content; ?>
					</div>
				</div>
			</main>

			<!-- ===== RIGHT SIDEBAR: BOSS + PLAYERS ===== -->
			<aside class="col-lg-3 col-md-4 order-3">
				<div class="sidebar-right">
					<!-- Criatura Boostada -->
					<div class="card rasta-card mb-3">
						<div class="card-body text-center p-2">
							<div class="text-white fw-bold mb-2" style="font-size:0.85rem;letter-spacing:0.5px;">Criatura Boostada</div>
							<a href="<?php echo getLink('monsters'); ?>">
								<img src="images/monsters/<?php echo logo_monster(); ?>.gif"
								     alt="<?php echo $config['logo_monster'] ?? 'Monster'; ?>"
								     class="img-fluid boss-img"
								     onerror="this.src='images/monsters/dragon.gif'">
							</a>
							<div class="mt-1 text-leaf fw-bold small">
								<?php echo $config['logo_monster'] ?? 'Dragon'; ?>
							</div>
						</div>
					</div>

					<!-- Caixas Dinâmicas (Highscores, Poll, Gallery) -->
					<?php
					if(isset($config['boxes'])) {
						$config['boxes'] = is_array($config['boxes']) ? $config['boxes'] : explode(",", $config['boxes']);
						$twig_loader->prependPath(__DIR__ . '/boxes/templates');
						foreach($config['boxes'] as $box) {
							$box = trim($box);
							$file = __DIR__ . '/boxes/' . $box . '.php';
							if(file_exists($file)) {
								include($file);
							}
						}
					}
					?>

					</div>
			</aside>
		</div>
	</div>

	<footer>
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-12 text-center">
					<p class="mb-0 small"><?php echo $config['lua']['serverName']; ?> / ADM Ghandja</p>
			</div>
		</div>
	</footer>

	<?php echo template_place_holder('body_end'); ?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
