<?php
if(PAGE !== 'news') {
	return;
}

global $db;
$poll = $db->query('SELECT `id`, `question` FROM `z_polls` WHERE end > ' . time() . ' ORDER BY `end` LIMIT 1');
if($poll->rowCount() > 0) {
	$poll = $poll->fetch(PDO::FETCH_ASSOC);
	$twig->display('rasta_poll.html.twig', array(
		'poll' => $poll
	));
}
