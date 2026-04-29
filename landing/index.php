<?php
require('../common.php');
require_once(SYSTEM . 'functions.php');
require_once(SYSTEM . 'init.php');
require_once(SYSTEM . 'status.php');

$configLanding = require PLUGINS . 'landing-page/config.php';
setcookie($configLanding['cookie_name'], '1', time() + ($configLanding['cookie_ttl']), '/');

$serverName = $config['lua']['serverName'];
$version = $config['client'] / 100;
$ip = str_replace('/', '', str_replace(array('http://', 'https://'), '', $config['lua']['url'] ?? '127.0.0.1'));
$port = $config['lua']['loginProtocolPort'] ?? $config['lua']['loginPort'] ?? 7171;
$online = $status['online'];
$players = $status['players'] ?? 0;
$playersMax = $status['playersMax'] ?? 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $serverName ?> - Servidor de Tibia</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body {
			background: #060a06;
			background-image:
				radial-gradient(ellipse at 30% 40%, rgba(46,204,113,0.05) 0%, transparent 50%),
				radial-gradient(ellipse at 70% 60%, rgba(241,196,15,0.03) 0%, transparent 50%);
			color: #e8ede8;
			font-family: 'Poppins', sans-serif;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.container-landing {
			text-align: center;
			max-width: 500px;
			padding: 2rem;
		}
		.logo-leaf {
			font-size: 4rem;
			animation: floatLeaf 3s infinite ease-in-out;
			display: inline-block;
		}
		@keyframes floatLeaf {
			0%, 100% { transform: translateY(0) rotate(0deg); }
			50% { transform: translateY(-10px) rotate(5deg); }
		}
		h1 {
			font-size: 2.2rem;
			font-weight: 700;
			color: #5af590;
			text-shadow: 0 0 30px rgba(46,204,113,0.4);
			margin: 0.5rem 0;
		}
		.server-card {
			background: linear-gradient(160deg, #111811, #0f140f);
			border: 1px solid #2a402a;
			border-radius: 16px;
			padding: 2rem;
			margin-top: 1.5rem;
			box-shadow: 0 8px 32px rgba(0,0,0,0.5);
		}
		.server-info {
			display: flex;
			flex-direction: column;
			gap: 0.8rem;
		}
		.info-row {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 0.6rem 1rem;
			background: rgba(255,255,255,0.03);
			border-radius: 8px;
			border: 1px solid #1e2e1e;
		}
		.info-label {
			color: #9aaa9a;
			font-weight: 500;
			font-size: 0.9rem;
		}
		.info-value {
			color: #fff;
			font-weight: 600;
			font-size: 0.95rem;
		}
		.status-badge {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			padding: 3px 12px;
			border-radius: 20px;
			font-size: 0.85rem;
			font-weight: 600;
		}
		.status-online {
			background: rgba(46,204,113,0.2);
			color: #5af590;
			border: 1px solid rgba(46,204,113,0.4);
		}
		.status-offline {
			background: rgba(255,68,68,0.2);
			color: #ff6666;
			border: 1px solid rgba(255,68,68,0.4);
		}
		.status-dot {
			width: 8px; height: 8px;
			border-radius: 50%;
			display: inline-block;
		}
		.status-online .status-dot {
			background: #5af590;
			box-shadow: 0 0 6px #2ecc71;
			animation: pulse 2s infinite;
		}
		.status-offline .status-dot {
			background: #ff6666;
			box-shadow: 0 0 6px #ff4444;
		}
		@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
		.btn-enter {
			display: inline-block;
			margin-top: 1.5rem;
			padding: 0.8rem 2.5rem;
			background: linear-gradient(135deg, #1a5c34, #27ae60);
			color: #fff;
			font-weight: 700;
			font-size: 1.1rem;
			text-decoration: none;
			border-radius: 50px;
			text-transform: uppercase;
			letter-spacing: 1px;
			transition: all 0.3s;
			border: none;
			cursor: pointer;
		}
		.btn-enter:hover {
			background: linear-gradient(135deg, #27ae60, #2ecc71);
			box-shadow: 0 6px 25px rgba(46,204,113,0.4);
			transform: translateY(-2px);
			color: #fff;
		}
		.btn-skip {
			display: block;
			margin-top: 0.8rem;
			color: #5a7a5a;
			font-size: 0.8rem;
		}
		.btn-skip:hover { color: #7a9a7a; }
		footer {
			margin-top: 2rem;
			font-size: 0.75rem;
			color: #3a4a3a;
		}
	</style>
</head>
<body>
	<div class="container-landing">
		<div class="server-card">
			<div class="server-info">
				<div class="info-row">
					<span class="info-label"><i class="bi bi-activity"></i> Status</span>
					<span class="info-value">
						<?php if ($online): ?>
						<span class="status-badge status-online"><span class="status-dot"></span> Online</span>
						<?php else: ?>
						<span class="status-badge status-offline"><span class="status-dot"></span> Offline</span>
						<?php endif; ?>
					</span>
				</div>
			</div>
		</div>

		<a href="<?= getLink('news') ?>" class="btn-enter">Jogar <i class="bi bi-arrow-right"></i></a>
		<a href="<?= getLink('downloads') ?>" class="btn-skip">Download do Jogo</a>

		<footer>
			<?= $serverName ?> / ADM Ghandja
		</footer>
	</div>
</body>
</html>
